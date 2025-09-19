<?php

/**
 * Contact Form 7 integration for WhatsApp Contact Button
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WCB_CF7_Integration
{

    /**
     * Constructor
     */
    public function __construct()
    {
        // Only initialize if CF7 is active
        if (WhatsAppContactButton::is_cf7_active()) {
            add_action('wpcf7_mail_sent', array($this, 'handle_form_submission'));
            add_action('wp_ajax_wcb_process_cf7_submission', array($this, 'ajax_process_submission'));
            add_action('wp_ajax_nopriv_wcb_process_cf7_submission', array($this, 'ajax_process_submission'));
            add_filter('wpcf7_form_elements', array($this, 'add_hidden_fields'));
        }
    }

    /**
     * Handle CF7 form submission
     */
    public function handle_form_submission($contact_form)
    {
        $submission = WPCF7_Submission::get_instance();

        if (!$submission) {
            return;
        }

        $posted_data = $submission->get_posted_data();

        // Check if this is a WhatsApp form submission
        if (!isset($posted_data['wcb_whatsapp_form']) || $posted_data['wcb_whatsapp_form'] !== '1') {
            return;
        }

        // Extract contact data
        $contact_data = $this->extract_contact_data($posted_data);

        if (!$contact_data) {
            return;
        }

        // Insert contact into database
        $contact_id = WCB_Database::insert_contact($contact_data);

        if ($contact_id) {
            // Send notification email
            $this->send_notification_email($contact_data, $contact_id);

            // Store contact ID for JavaScript redirect
            $this->store_contact_for_redirect($contact_id, $contact_data);
        }
    }

    /**
     * Extract contact data from CF7 submission
     */
    private function extract_contact_data($posted_data)
    {
        // Try to find name field
        $name = '';
        $name_fields = array('your-name', 'name', 'nome', 'first-name', 'firstname');
        foreach ($name_fields as $field) {
            if (isset($posted_data[$field]) && !empty($posted_data[$field])) {
                $name = sanitize_text_field($posted_data[$field]);
                break;
            }
        }

        // Try to find email field
        $email = '';
        $email_fields = array('your-email', 'email', 'e-mail');
        foreach ($email_fields as $field) {
            if (isset($posted_data[$field]) && !empty($posted_data[$field])) {
                $email = sanitize_email($posted_data[$field]);
                break;
            }
        }

        // Try to find phone field
        $phone = '';
        $phone_fields = array('your-phone', 'phone', 'telefone', 'tel', 'celular', 'whatsapp');
        foreach ($phone_fields as $field) {
            if (isset($posted_data[$field]) && !empty($posted_data[$field])) {
                $phone = sanitize_text_field($posted_data[$field]);
                break;
            }
        }

        // Check for consent
        $consent = true; // Default to true
        $consent_fields = array('consent', 'aceito', 'terms', 'privacy', 'lgpd');
        foreach ($consent_fields as $field) {
            if (isset($posted_data[$field])) {
                $consent = !empty($posted_data[$field]);
                break;
            }
        }

        // Validate required fields
        if (empty($name) || empty($email) || empty($phone)) {
            return false;
        }

        // Get page data
        $page_data = $this->get_page_data_from_submission($posted_data);

        // Get device and user agent
        $device_type = $this->get_device_type();
        $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);

        return array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'consent' => $consent,
            'page_title' => $page_data['title'],
            'page_url' => $page_data['url'],
            'page_slug' => $page_data['slug'],
            'device_type' => $device_type,
            'user_agent' => $user_agent,
            'submit_time' => current_time('mysql'),
            'form_data' => json_encode($posted_data)
        );
    }

    /**
     * Get page data from submission
     */
    private function get_page_data_from_submission($posted_data)
    {
        $default_data = array(
            'title' => get_bloginfo('name'), // Fallback para nome do site
            'url' => home_url('/'),
            'slug' => 'unknown'
        );

        // Tentar dados dos campos ocultos primeiro
        if (isset($posted_data['wcb_page_title']) && !empty($posted_data['wcb_page_title'])) {
            $default_data['title'] = sanitize_text_field($posted_data['wcb_page_title']);
        }

        if (isset($posted_data['wcb_page_url']) && !empty($posted_data['wcb_page_url'])) {
            $default_data['url'] = esc_url_raw($posted_data['wcb_page_url']);
        }

        if (isset($posted_data['wcb_page_slug']) && !empty($posted_data['wcb_page_slug'])) {
            $default_data['slug'] = sanitize_title($posted_data['wcb_page_slug']);
        }

        // Fallback: tentar detectar página atual
        if (empty($default_data['title']) || $default_data['title'] === get_bloginfo('name')) {
            if (is_front_page()) {
                $default_data['title'] = 'Página Inicial';
                $default_data['slug'] = 'front-page';
            } elseif (is_home()) {
                $default_data['title'] = get_bloginfo('name') . ' - Blog';
                $default_data['slug'] = 'blog-home';
            } elseif (isset($posted_data['wcb_page_url'])) {
                // Tentar extrair título da URL usando slug
                $slug = $this->extract_slug_from_url($posted_data['wcb_page_url']);
                if ($slug && $slug !== 'unknown') {
                    $default_data['slug'] = $slug;
                    $default_data['title'] = ucwords(str_replace(['-', '_'], ' ', $slug));
                }
            }
        }

        // Debug log
        error_log('WCB: Page data extracted: ' . print_r($default_data, true));
        error_log('WCB: Posted data keys: ' . print_r(array_keys($posted_data), true));

        return $default_data;
    }
    
    /**
     * Get device type
     */
    private function get_device_type()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (preg_match('/tablet|ipad|playbook|silk/i', $user_agent)) {
            return 'tablet';
        } elseif (preg_match('/mobile|iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i', $user_agent)) {
            return 'mobile';
        } else {
            return 'desktop';
        }
    }

    /**
     * Send notification email
     */
    private function send_notification_email($contact_data, $contact_id)
    {
        $notification_emails = WhatsAppContactButton::get_option('wcb_notification_emails', array());

        if (empty($notification_emails)) {
            return;
        }

        $subject = sprintf(__('[%s] Novo contato WhatsApp', 'whatsapp-contact-button'), get_bloginfo('name'));

        $message = sprintf(
            __("Novo contato recebido através do botão WhatsApp:\n\n" .
                "Nome: %s\n" .
                "Email: %s\n" .
                "Telefone: %s\n" .
                "Página: %s (%s)\n" .
                "Dispositivo: %s\n" .
                "Data: %s\n\n" .
                "Visualizar no painel: %s", 'whatsapp-contact-button'),
            $contact_data['name'],
            $contact_data['email'],
            $contact_data['phone'],
            $contact_data['page_title'],
            $contact_data['page_url'],
            $contact_data['device_type'],
            $contact_data['submit_time'],
            admin_url('admin.php?page=whatsapp-contacts')
        );

        $headers = array('Content-Type: text/plain; charset=UTF-8');

        foreach ($notification_emails as $email) {
            wp_mail($email, $subject, $message, $headers);
        }
    }

    /**
     * Store contact for redirect
     */
    private function store_contact_for_redirect($contact_id, $contact_data)
    {
        // Store in session or transient for JavaScript to pick up
        if (!session_id()) {
            session_start();
        }

        $_SESSION['wcb_last_contact'] = array(
            'id' => $contact_id,
            'name' => $contact_data['name'],
            'email' => $contact_data['email'],
            'phone' => $contact_data['phone'],
            'page_title' => $contact_data['page_title'],
            'page_url' => $contact_data['page_url'],
            'device_type' => $contact_data['device_type']
        );
    }

    /**
     * AJAX: Process CF7 submission for redirect
     */
    public function ajax_process_submission()
    {
        check_ajax_referer('wcb_frontend_nonce', 'nonce');

        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION['wcb_last_contact'])) {
            wp_send_json_error(array('message' => __('Nenhum contato encontrado para redirecionamento.', 'whatsapp-contact-button')));
        }

        $contact_data = $_SESSION['wcb_last_contact'];

        // Generate WhatsApp URL
        $whatsapp_url = $this->generate_whatsapp_url($contact_data);

        // Update contact with redirect time
        WCB_Database::update_contact($contact_data['id'], array(
            'whatsapp_redirect_time' => current_time('mysql')
        ));

        // Clear session data
        unset($_SESSION['wcb_last_contact']);

        wp_send_json_success(array(
            'whatsapp_url' => $whatsapp_url,
            'contact_id' => $contact_data['id']
        ));
    }

    /**
     * Replace variables in WhatsApp message
     */
    private function replace_message_variables($message, $contact_data)
    {
        $replacements = array(
            '{nome_usuario}' => $contact_data['name'] ?? '',
            '{email_usuario}' => $contact_data['email'] ?? '',
            '{telefone_usuario}' => $contact_data['phone'] ?? '',
            '{titulo_pagina}' => $contact_data['page_title'] ?? '',
            '{url_pagina}' => $contact_data['page_url'] ?? '',
            '{data_atual}' => date_i18n(get_option('date_format')),
            '{hora_atual}' => date_i18n(get_option('time_format')),
            '{dispositivo}' => ucfirst($contact_data['device_type'] ?? 'unknown')
        );

        return str_replace(array_keys($replacements), array_values($replacements), $message);
    }


    /**
     * Extract slug from URL
     */
    private function extract_slug_from_url($url)
    {
        $parsed_url = parse_url($url);
        $path = trim($parsed_url['path'] ?? '', '/');

        if (empty($path)) {
            return 'front-page';
        }

        $segments = explode('/', $path);
        return end($segments);
    }


    /**
     * Generate WhatsApp URL
     */
    private function generate_whatsapp_url($contact_data)
    {
        $whatsapp_number = WhatsAppContactButton::get_whatsapp_number();

        if (empty($whatsapp_number)) {
            return '#';
        }

        // Extrair slug da URL se não foi capturado
        $page_slug = !empty($contact_data['page_slug']) ? $contact_data['page_slug'] : $this->extract_slug_from_url($contact_data['page_url']);

        // Buscar mensagem específica
        $form_mappings = WhatsAppContactButton::get_option('wcb_form_mappings', array());
        $specific_message = '';

        foreach ($form_mappings as $mapping) {
            if ($mapping['type'] === 'slug' && $mapping['value'] === $page_slug) {
                $specific_message = $mapping['whatsapp_message'] ?? '';
                break;
            }
        }

        if (empty($specific_message)) {
            $frontend = new WCB_Frontend();
            $specific_message = $frontend->get_whatsapp_message_with_priority();
        }

        // Substituir variáveis na mensagem
        $message = $this->replace_message_variables($specific_message, $contact_data);

        $encoded_message = urlencode($message);

        return "https://wa.me/{$whatsapp_number}?text={$encoded_message}";
    }

    /**
     * Add hidden fields to CF7 forms
     */
    /**
     * Add hidden fields to CF7 forms
     */
    public function add_hidden_fields($form)
    {
        // Verificar se já tem os campos para evitar duplicação
        if (strpos($form, 'wcb_whatsapp_form') !== false) {
            return $form; // Já tem os campos
        }

        // Adicionar campos ocultos apenas se for contexto do WhatsApp
        if ($this->is_whatsapp_form_context()) {
            $hidden_fields = '
        <input type="hidden" name="wcb_whatsapp_form" value="1">
        <input type="hidden" name="wcb_page_title" value="" class="wcb-page-title">
        <input type="hidden" name="wcb_page_url" value="" class="wcb-page-url">
        <input type="hidden" name="wcb_page_slug" value="" class="wcb-page-slug">
        ';

            return $form . $hidden_fields;
        }

        return $form;
    }

    private function is_whatsapp_form_context()
    {
        // Verificar se estamos no contexto do modal WhatsApp
        return (
            (defined('DOING_AJAX') && DOING_AJAX && isset($_POST['action']) && $_POST['action'] === 'wpcf7_submit') ||
            (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'wcb-modal') !== false) ||
            (isset($_POST['wcb_whatsapp_form']) && $_POST['wcb_whatsapp_form'] === '1')
        );
    }



    /**
     * Get available CF7 forms
     */
    public static function get_available_forms()
    {
        if (!WhatsAppContactButton::is_cf7_active()) {
            return array();
        }

        $forms = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        $form_options = array();

        foreach ($forms as $form) {
            $form_options[$form->ID] = $form->post_title;
        }

        return $form_options;
    }

    /**
     * Get form shortcode by ID
     */
    public static function get_form_shortcode($form_id)
    {
        if (!WhatsAppContactButton::is_cf7_active() || empty($form_id)) {
            return '';
        }

        return '[contact-form-7 id="' . intval($form_id) . '" class="wcb-whatsapp-form"]';
    }

    /**
     * Validate form fields
     */
    public static function validate_form_fields($form_id)
    {
        if (!WhatsAppContactButton::is_cf7_active() || empty($form_id)) {
            return false;
        }

        $contact_form = wpcf7_contact_form($form_id);

        if (!$contact_form) {
            return false;
        }

        $form_fields = $contact_form->scan_form_tags();
        $required_fields = array('name', 'email', 'phone');
        $found_fields = array();

        foreach ($form_fields as $field) {
            $field_name = $field['name'];

            // Check for name fields
            if (preg_match('/name|nome/i', $field_name)) {
                $found_fields[] = 'name';
            }

            // Check for email fields
            if (preg_match('/email|e-mail/i', $field_name)) {
                $found_fields[] = 'email';
            }

            // Check for phone fields
            if (preg_match('/phone|telefone|tel|celular|whatsapp/i', $field_name)) {
                $found_fields[] = 'phone';
            }
        }

        // Check if all required fields are present
        $missing_fields = array_diff($required_fields, $found_fields);

        return empty($missing_fields);
    }
}
