<?php

/**
 * Frontend functionality for WhatsApp Contact Button
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WCB_Frontend
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'render_button_and_modal'));
        add_action('wp_ajax_wcb_track_event', array($this, 'ajax_track_event'));
        add_action('wp_ajax_nopriv_wcb_track_event', array($this, 'ajax_track_event'));
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts()
    {
        if (!WhatsAppContactButton::get_option('wcb_enabled', true)) {
            return;
        }

        wp_enqueue_style('wcb-style', WCB_PLUGIN_URL . 'assets/css/style.css', array(), WCB_PLUGIN_VERSION);
        wp_enqueue_script('wcb-script', WCB_PLUGIN_URL . 'assets/js/script.js', array('jquery'), WCB_PLUGIN_VERSION, true);

        // Localize script with data
        $button_mode = WhatsAppContactButton::get_option('wcb_button_mode', 'form');
        $localized_data = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wcb_frontend_nonce'),
            'whatsapp_number' => WhatsAppContactButton::get_whatsapp_number(),
            'button_mode' => $button_mode, // NOVO: Modo de operação
            'direct_message' => $button_mode === 'direct' ? $this->get_direct_message() : '', // NOVO: Mensagem modo direto
            'track_direct_clicks' => WhatsAppContactButton::get_option('wcb_track_direct_clicks', true), // NOVO: Rastrear cliques
            'base_message' => $this->get_whatsapp_message_with_priority(),
            'specific_message' => $this->get_specific_whatsapp_message(),
            'popup_text' => $this->get_popup_text_with_priority(),
            'button_position' => WhatsAppContactButton::get_option('wcb_button_position', 'bottom-right'),
            'page_data' => self::get_current_page_data(),
            'form_shortcode' => $this->get_form_shortcode_for_current_page(),
            'strings' => array(
                'loading' => __('Carregando...', 'whatsapp-contact-button'),
                'error' => __('Ocorreu um erro. Tente novamente.', 'whatsapp-contact-button'),
                'outside_hours' => __('No momento estamos fora do horário de atendimento. Deixe sua mensagem que retornaremos em breve!', 'whatsapp-contact-button'),
                'form_required' => __('Por favor, preencha o formulário antes de continuar.', 'whatsapp-contact-button'),
                'redirecting' => __('Redirecionando para o WhatsApp...', 'whatsapp-contact-button')
            )
        );

        wp_localize_script('wcb-script', 'wcb_data', $localized_data);
    }

    /**
     * Render button and modal in footer
     */
    public function render_button_and_modal()
    {
        if (!WhatsAppContactButton::get_option('wcb_enabled', true)) {
            return;
        }

        $button_position = WhatsAppContactButton::get_option('wcb_button_position', 'bottom-right');
        $button_mode = WhatsAppContactButton::get_option('wcb_button_mode', 'form');
        $popup_text = $this->get_popup_text_with_priority();
        $form_shortcode = $this->get_form_shortcode_for_current_page();

?>
        <!-- WhatsApp Contact Button -->
        <div id="wcb-whatsapp-button" class="wcb-button wcb-position-<?php echo esc_attr($button_position); ?>" style="display: none;">
            <div class="wcb-button-icon">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.893 3.506" />
                </svg>
            </div>
        </div>

        <?php if ($button_mode === 'form'): ?>
        <!-- WhatsApp Modal (apenas no modo formulário) -->
        <div id="wcb-modal" class="wcb-modal">
            <div class="wcb-modal-overlay"></div>
            <div class="wcb-modal-content">
                <div class="wcb-modal-header">
                    <h3><?php _e('Entre em contato conosco', 'whatsapp-contact-button'); ?></h3>
                    <button class="wcb-modal-close" type="button">
                        <svg viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                        </svg>
                    </button>
                </div>

                <div class="wcb-modal-body">
                    <div class="wcb-popup-text">
                        <?php echo wp_kses_post($popup_text); ?>
                    </div>

                    <div class="wcb-form-container">
                        <?php if ($form_shortcode): ?>
                            <?php echo do_shortcode($form_shortcode); ?>
                        <?php else: ?>
                            <div class="wcb-no-form">
                                <p><?php _e('Nenhum formulário configurado para esta página.', 'whatsapp-contact-button'); ?></p>
                                <a href="https://wa.me/<?php echo esc_attr(WhatsAppContactButton::get_whatsapp_number()); ?>" target="_blank" class="wcb-direct-whatsapp">
                                    <?php _e('Falar diretamente no WhatsApp', 'whatsapp-contact-button'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <!-- Garantir campos ocultos sempre presentes -->
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                // Adicionar campos ocultos se não existirem
                                function wcbEnsureHiddenFields() {
                                    if ($('.wcb-page-title').length === 0) {
                                        $('.wcb-form-container form').append('<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">');
                                    }
                                    if ($('.wcb-page-url').length === 0) {
                                        $('.wcb-form-container form').append('<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">');
                                    }
                                    if ($('.wcb-page-slug').length === 0) {
                                        $('.wcb-form-container form').append('<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">');
                                    }
                                    if ($('input[name="wcb_whatsapp_form"]').length === 0) {
                                        $('.wcb-form-container form').append('<input type="hidden" name="wcb_whatsapp_form" value="1">');
                                    }
                                }

                                // Executar quando modal abrir
                                $(document).on('click', '#wcb-whatsapp-button', function() {
                                    setTimeout(wcbEnsureHiddenFields, 200);
                                });
                            });
                        </script>
                    </div>

                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Loading overlay -->
        <div id="wcb-loading" class="wcb-loading" style="display: none;">
            <div class="wcb-loading-spinner"></div>
            <p><?php _e('Redirecionando para o WhatsApp...', 'whatsapp-contact-button'); ?></p>
        </div>
<?php
    }

    /**
     * Get form shortcode for current page with improved logic
     * Priority: Specific mapping > Default form > Direct WhatsApp
     */
    private function get_form_shortcode_for_current_page()
    {
        // 1. First, try to get specific mapping for current page
        $specific_form_id = $this->get_specific_form_for_page();
        if ($specific_form_id) {
            return '[contact-form-7 id="' . intval($specific_form_id) . '"]';
        }

        // 2. Fallback to default form
        $default_form_id = WhatsAppContactButton::get_option('wcb_default_form_id', '');
        if (!empty($default_form_id)) {
            return '[contact-form-7 id="' . intval($default_form_id) . '"]';
        }

        // 3. No form configured - will show direct WhatsApp link
        return '';
    }

    /**
     * Get specific form ID for current page based on mappings
     * ORDEM DE PRIORIDADE: slug > category > page_template > post_type
     */
    private function get_specific_form_for_page()
    {
        $form_mappings = WhatsAppContactButton::get_option('wcb_form_mappings', array());

        if (empty($form_mappings)) {
            return false;
        }

        $current_page_data = $this->get_current_page_context();

        // NOVA ORDEM: Mais específico para menos específico
        $priority_order = array('slug', 'category', 'page_template', 'post_type');

        foreach ($priority_order as $priority_type) {
            foreach ($form_mappings as $mapping) {
                if ($mapping['type'] !== $priority_type) {
                    continue;
                }

                switch ($mapping['type']) {
                    case 'slug':
                        if ($mapping['value'] === $current_page_data['slug']) {
                            error_log('WCB: Using SLUG mapping: ' . $mapping['value']);
                            return $mapping['form_id'];
                        }
                        break;

                    case 'category':
                        if (in_array($mapping['value'], $current_page_data['categories'])) {
                            error_log('WCB: Using CATEGORY mapping: ' . $mapping['value']);
                            return $mapping['form_id'];
                        }
                        break;

                    case 'page_template':
                        if ($mapping['value'] === $current_page_data['template']) {
                            error_log('WCB: Using TEMPLATE mapping: ' . $mapping['value']);
                            return $mapping['form_id'];
                        }
                        break;

                    case 'post_type':
                        if ($mapping['value'] === $current_page_data['post_type']) {
                            error_log('WCB: Using POST_TYPE mapping: ' . $mapping['value']);
                            return $mapping['form_id'];
                        }
                        break;
                }
            }
        }

        return false;
    }


    /**
     * Get current page context for mapping
     */
    private function get_current_page_context()
    {
        global $post;

        $context = array(
            'slug' => '',
            'post_type' => '',
            'categories' => array(),
            'template' => '',
            'is_front_page' => false,
            'is_home' => false
        );

        // Handle different page types
        if (is_front_page()) {
            $context['slug'] = 'front-page';
            $context['post_type'] = 'front-page';
            $context['is_front_page'] = true;
        } elseif (is_home()) {
            $context['slug'] = 'blog-home';
            $context['post_type'] = 'blog-home';
            $context['is_home'] = true;
        } elseif (is_page() || is_single()) {
            if ($post) {
                $context['slug'] = $post->post_name;
                $context['post_type'] = $post->post_type;

                // CORRIGIDO: Get ALL taxonomies for any post type
                $taxonomies = get_object_taxonomies($post->post_type, 'names');

                if (!empty($taxonomies)) {
                    foreach ($taxonomies as $taxonomy) {
                        // Skip unwanted taxonomies
                        if (in_array($taxonomy, array('post_format', 'nav_menu'))) {
                            continue;
                        }

                        $terms = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'slugs'));

                        if (!is_wp_error($terms) && !empty($terms)) {
                            $context['categories'] = array_merge($context['categories'], $terms);
                        }
                    }

                    // Remove duplicates
                    $context['categories'] = array_unique($context['categories']);
                }

                // Get page template
                if (is_page()) {
                    $template = get_page_template_slug($post->ID);
                    $context['template'] = $template ? basename($template, '.php') : 'page';
                }
            }
        } elseif (is_category()) {
            $category = get_queried_object();
            if ($category) {
                $context['slug'] = 'category-' . $category->slug;
                $context['post_type'] = 'category';
                $context['categories'] = array($category->slug);
            }
        } elseif (is_tag()) {
            $tag = get_queried_object();
            if ($tag) {
                $context['slug'] = 'tag-' . $tag->slug;
                $context['post_type'] = 'tag';
            }
        } elseif (is_tax()) {
            // Handle custom taxonomy archives
            $term = get_queried_object();
            if ($term) {
                $context['slug'] = $term->taxonomy . '-' . $term->slug;
                $context['post_type'] = $term->taxonomy;
                $context['categories'] = array($term->slug);
            }
        } elseif (is_archive()) {
            $context['slug'] = 'archive';
            $context['post_type'] = 'archive';

            // Check if it's a CPT archive
            if (is_post_type_archive()) {
                $post_type = get_query_var('post_type');
                if ($post_type) {
                    $context['post_type'] = $post_type;
                    $context['slug'] = 'archive-' . $post_type;
                }
            }
        } else {
            $context['slug'] = 'other';
            $context['post_type'] = 'other';
        }

        return $context;
    }

    /**
     * AJAX: Track event
     */
    public function ajax_track_event()
    {
        error_log("WCB: ajax_track_event called.");

        if (!check_ajax_referer("wcb_frontend_nonce", "nonce", false)) {
            error_log("WCB: Nonce verification failed!");
            wp_send_json_error(array("message" => __("Nonce verification failed.", "whatsapp-contact-button")));
            return;
        }

        error_log("WCB: Nonce verification successful.");

        $event_type = sanitize_text_field($_POST['event_type'] ?? '');
        $page_title = sanitize_text_field($_POST['page_title'] ?? '');
        $page_url = esc_url_raw($_POST['page_url'] ?? '');
        $page_slug = sanitize_title($_POST['page_slug'] ?? '');
        $session_id = sanitize_text_field($_POST['session_id'] ?? '');
        $contact_id = isset($_POST['contact_id']) ? intval($_POST['contact_id']) : null;

        // Validate required fields
        if (empty($event_type)) {
            wp_send_json_error(array('message' => __('Tipo de evento é obrigatório.', 'whatsapp-contact-button')));
            return;
        }

        // Get device type
        $device_type = $this->get_device_type();
        $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? '');

        // Insert analytics event
        $analytics_data = array(
            'event_type' => $event_type,
            'page_title' => $page_title,
            'page_url' => $page_url,
            'page_slug' => $page_slug,
            'device_type' => $device_type,
            'user_agent' => $user_agent,
            'session_id' => $session_id,
            'contact_id' => $contact_id
        );

        $result = WCB_Database::insert_analytics($analytics_data);

        if ($result) {
            wp_send_json_success(array('analytics_id' => $result));
        } else {
            wp_send_json_error(array('message' => __('Erro ao registrar evento.', 'whatsapp-contact-button')));
        }
    }


    /**
     * Get device type from user agent
     */
    private function get_device_type()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (preg_match('/tablet|ipad|playbook|silk/i', $user_agent)) {
            return 'tablet';
        } elseif (preg_match('/mobile|iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i', $user_agent)) {
            return 'mobile';
        } else {
            return 'desktop';
        }
    }

    /**
     * Generate session ID
     */
    public static function generate_session_id()
    {
        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION['wcb_session_id'])) {
            $_SESSION['wcb_session_id'] = uniqid('wcb_', true);
        }

        return $_SESSION['wcb_session_id'];
    }

    /**
     * Get current page data
     */
    public static function get_current_page_data()
    {
        global $post;

        $data = array(
            'title' => '',
            'url' => '',
            'slug' => ''
        );

        if (is_front_page()) {
            $data['title'] = get_bloginfo('name');
            $data['url'] = home_url('/');
            $data['slug'] = 'front-page';
        } elseif (is_home()) {
            $data['title'] = get_bloginfo('name') . ' - Blog';
            $data['url'] = get_permalink(get_option('page_for_posts'));
            $data['slug'] = 'blog-home';
        } elseif (is_page() || is_single()) {
            $data['title'] = get_the_title();
            $data['url'] = get_permalink();
            $data['slug'] = $post->post_name;
        } elseif (is_category()) {
            $category = get_queried_object();
            $data['title'] = $category->name;
            $data['url'] = get_category_link($category->term_id);
            $data['slug'] = 'category-' . $category->slug;
        } elseif (is_tag()) {
            $tag = get_queried_object();
            $data['title'] = $tag->name;
            $data['url'] = get_tag_link($tag->term_id);
            $data['slug'] = 'tag-' . $tag->slug;
        } elseif (is_archive()) {
            $data['title'] = get_the_archive_title();
            $data['url'] = get_permalink();
            $data['slug'] = 'archive';
        } else {
            $data['title'] = get_the_title();
            $data['url'] = get_permalink();
            $data['slug'] = 'other';
        }

        return $data;
    }

    /**
     * Get popup text with priority logic
     */
    public function get_popup_text_with_priority()
    {
        // 1. Específico da página (mapeamento)
        $specific_text = $this->get_specific_popup_text();
        if (!empty($specific_text)) {
            return $specific_text;
        }

        // 2. Padrão do plugin
        $plugin_default = WhatsAppContactButton::get_option('wcb_default_popup_text', '');
        if (!empty($plugin_default)) {
            return $plugin_default;
        }

        // 3. ACF tema (fallback)
        return WhatsAppContactButton::get_popup_text();
    }

    /**
     * Get WhatsApp message with priority logic
     */
    public function get_whatsapp_message_with_priority()
    {
        // 1. Específico da página (mapeamento)
        $specific_message = $this->get_specific_whatsapp_message();
        if (!empty($specific_message)) {
            return $specific_message;
        }

        // 2. Padrão do plugin
        $plugin_default = WhatsAppContactButton::get_option('wcb_default_whatsapp_message', '');
        if (!empty($plugin_default)) {
            return $plugin_default;
        }

        // 3. ACF tema (fallback)
        return WhatsAppContactButton::get_base_message();
    }

    /**
     * Get direct mode message with variable replacement
     */
    public function get_direct_message()
    {
        $direct_message = WhatsAppContactButton::get_option('wcb_direct_message', '');
        
        if (empty($direct_message)) {
            return '';
        }

        // Replace variables in the message
        return $this->replace_message_variables($direct_message);
    }

    /**
     * Replace variables in message text
     */
    private function replace_message_variables($message)
    {
        $page_data = self::get_current_page_data();
        $device_type = $this->get_device_type();

        $variables = array(
            '{titulo_pagina}' => $page_data['title'],
            '{url_pagina}' => $page_data['url'],
            '{data_atual}' => date_i18n(get_option('date_format')),
            '{hora_atual}' => date_i18n(get_option('time_format')),
            '{dispositivo}' => ucfirst($device_type)
        );

        return str_replace(array_keys($variables), array_values($variables), $message);
    }

    /**
     * Get specific popup text from mappings - COM PRIORIDADE
     */
    public function get_specific_popup_text()
    {
        $form_mappings = WhatsAppContactButton::get_option('wcb_form_mappings', array());

        if (empty($form_mappings)) {
            return '';
        }

        $current_context = $this->get_current_page_context();

        // Mesma ordem de prioridade
        $priority_order = array('slug', 'category', 'page_template', 'post_type');

        foreach ($priority_order as $priority_type) {
            foreach ($form_mappings as $mapping) {
                if ($mapping['type'] === $priority_type && $this->matches_page_context($mapping, $current_context)) {
                    return $mapping['popup_text'] ?? '';
                }
            }
        }

        return '';
    }

    /**
     * Get specific WhatsApp message from mappings - COM PRIORIDADE  
     */
    public function get_specific_whatsapp_message()
    {
        $form_mappings = WhatsAppContactButton::get_option('wcb_form_mappings', array());

        if (empty($form_mappings)) {
            return '';
        }

        $current_context = $this->get_current_page_context();

        // Mesma ordem de prioridade
        $priority_order = array('slug', 'category', 'page_template', 'post_type');

        foreach ($priority_order as $priority_type) {
            foreach ($form_mappings as $mapping) {
                if ($mapping['type'] === $priority_type && $this->matches_page_context($mapping, $current_context)) {
                    return $mapping['whatsapp_message'] ?? '';
                }
            }
        }

        return '';
    }


    /**
     * Check if mapping matches current page context
     */
    public function matches_page_context($mapping, $context)
    {
        switch ($mapping['type']) {
            case 'slug':
                return $mapping['value'] === $context['slug'];
            case 'category':
                return in_array($mapping['value'], $context['categories']);
            case 'post_type':
                return $mapping['value'] === $context['post_type'];
            case 'page_template':
                return $mapping['value'] === $context['template'];
        }
        return false;
    }
}
