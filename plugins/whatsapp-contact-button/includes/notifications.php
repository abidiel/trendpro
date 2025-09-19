<?php
/**
 * Notifications functionality for WhatsApp Contact Button
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WCB_Notifications {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wcb_new_contact', array($this, 'send_new_contact_notification'), 10, 2);
        add_action('wp_ajax_wcb_test_notification', array($this, 'ajax_test_notification'));
    }
    
    /**
     * Send new contact notification
     */
    public function send_new_contact_notification($contact_id, $contact_data) {
        $notification_emails = WhatsAppContactButton::get_option('wcb_notification_emails', array());
        
        if (empty($notification_emails)) {
            return false;
        }
        
        $subject = $this->get_notification_subject($contact_data);
        $message = $this->get_notification_message($contact_id, $contact_data);
        $headers = $this->get_notification_headers();
        
        $sent = false;
        
        foreach ($notification_emails as $email) {
            if (is_email($email)) {
                $result = wp_mail($email, $subject, $message, $headers);
                if ($result) {
                    $sent = true;
                }
            }
        }
        
        return $sent;
    }
    
    /**
     * Get notification subject
     */
    private function get_notification_subject($contact_data) {
        $site_name = get_bloginfo('name');
        
        return sprintf(
            __('[%s] Novo contato WhatsApp - %s', 'whatsapp-contact-button'),
            $site_name,
            $contact_data['name']
        );
    }
    
    /**
     * Get notification message
     */
    private function get_notification_message($contact_id, $contact_data) {
        $site_name = get_bloginfo('name');
        $admin_url = admin_url('admin.php?page=whatsapp-contacts');
        
        $message = sprintf(
            __("Olá!\n\n" .
               "Um novo contato foi recebido através do botão WhatsApp em %s:\n\n" .
               "📋 DADOS DO CONTATO:\n" .
               "Nome: %s\n" .
               "Email: %s\n" .
               "Telefone: %s\n\n" .
               "📍 ORIGEM:\n" .
               "Página: %s\n" .
               "URL: %s\n" .
               "Dispositivo: %s\n\n" .
               "🕒 INFORMAÇÕES ADICIONAIS:\n" .
               "Data/Hora: %s\n" .
               "ID do Contato: #%d\n\n" .
               "🔗 AÇÕES:\n" .
               "Visualizar no painel: %s\n" .
               "Contatar via WhatsApp: https://wa.me/%s\n\n" .
               "---\n" .
               "Esta é uma notificação automática do plugin WhatsApp Contact Button.\n" .
               "Para alterar as configurações de notificação, acesse o painel administrativo.", 'whatsapp-contact-button'),
            $site_name,
            $contact_data['name'],
            $contact_data['email'],
            $contact_data['phone'],
            $contact_data['page_title'],
            $contact_data['page_url'],
            ucfirst($contact_data['device_type']),
            date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($contact_data['submit_time'])),
            $contact_id,
            $admin_url,
            WhatsAppContactButton::clean_whatsapp_number($contact_data['phone'])
        );
        
        return $message;
    }
    
    /**
     * Get notification headers
     */
    private function get_notification_headers() {
        $from_email = get_option('admin_email');
        $from_name = get_bloginfo('name');
        
        return array(
            'Content-Type: text/plain; charset=UTF-8',
            sprintf('From: %s <%s>', $from_name, $from_email),
            sprintf('Reply-To: %s', $from_email)
        );
    }
    
    /**
     * Send daily summary notification
     */
    public static function send_daily_summary() {
        $notification_emails = WhatsAppContactButton::get_option('wcb_notification_emails', array());
        
        if (empty($notification_emails)) {
            return false;
        }
        
        // Get yesterday's data
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        
        // Get contacts from yesterday
        $contacts = WCB_Database::get_contacts(array(
            'date_from' => $yesterday,
            'date_to' => $yesterday,
            'limit' => 100
        ));
        
        // Get analytics summary
        $analytics = WCB_Analytics::get_dashboard_summary($yesterday, $yesterday);
        
        if (empty($contacts) && $analytics['clicks'] == 0) {
            return false; // No activity to report
        }
        
        $subject = sprintf(
            __('[%s] Resumo diário WhatsApp - %s', 'whatsapp-contact-button'),
            get_bloginfo('name'),
            date_i18n(get_option('date_format'), strtotime($yesterday))
        );
        
        $message = self::get_daily_summary_message($yesterday, $contacts, $analytics);
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        $sent = false;
        
        foreach ($notification_emails as $email) {
            if (is_email($email)) {
                $result = wp_mail($email, $subject, $message, $headers);
                if ($result) {
                    $sent = true;
                }
            }
        }
        
        return $sent;
    }
    
    /**
     * Get daily summary message
     */
    private static function get_daily_summary_message($date, $contacts, $analytics) {
        $site_name = get_bloginfo('name');
        $admin_url = admin_url('admin.php?page=whatsapp-contacts&tab=analytics');
        $formatted_date = date_i18n(get_option('date_format'), strtotime($date));
        
        $message = sprintf(
            __("Resumo de atividade do WhatsApp Contact Button\n" .
               "Site: %s\n" .
               "Data: %s\n\n" .
               "📊 ESTATÍSTICAS DO DIA:\n" .
               "Cliques no botão: %d\n" .
               "Formulários enviados: %d\n" .
               "Redirecionamentos WhatsApp: %d\n" .
               "Taxa de conversão: %s%%\n\n", 'whatsapp-contact-button'),
            $site_name,
            $formatted_date,
            $analytics['clicks'],
            $analytics['submits'],
            $analytics['redirects'],
            $analytics['conversion_rate']
        );
        
        if (!empty($contacts)) {
            $message .= sprintf(__("👥 NOVOS CONTATOS (%d):\n", 'whatsapp-contact-button'), count($contacts));
            
            foreach ($contacts as $contact) {
                $message .= sprintf(
                    __("• %s (%s) - %s\n", 'whatsapp-contact-button'),
                    $contact->name,
                    $contact->phone,
                    $contact->page_title
                );
            }
            
            $message .= "\n";
        }
        
        $message .= sprintf(
            __("🔗 Ver relatório completo: %s\n\n" .
               "---\n" .
               "Esta é uma notificação automática do plugin WhatsApp Contact Button.", 'whatsapp-contact-button'),
            $admin_url
        );
        
        return $message;
    }
    
    /**
     * Send weekly summary notification
     */
    public static function send_weekly_summary() {
        $notification_emails = WhatsAppContactButton::get_option('wcb_notification_emails', array());
        
        if (empty($notification_emails)) {
            return false;
        }
        
        // Get last week's data
        $week_start = date('Y-m-d', strtotime('-7 days'));
        $week_end = date('Y-m-d', strtotime('-1 day'));
        
        // Get contacts from last week
        $contacts = WCB_Database::get_contacts(array(
            'date_from' => $week_start,
            'date_to' => $week_end,
            'limit' => 1000
        ));
        
        // Get analytics summary
        $analytics = WCB_Analytics::get_dashboard_summary($week_start, $week_end);
        
        // Get top pages
        $top_pages = WCB_Database::get_top_pages($week_start, $week_end, 5);
        
        if (empty($contacts) && $analytics['clicks'] == 0) {
            return false; // No activity to report
        }
        
        $subject = sprintf(
            __('[%s] Resumo semanal WhatsApp - %s a %s', 'whatsapp-contact-button'),
            get_bloginfo('name'),
            date_i18n(get_option('date_format'), strtotime($week_start)),
            date_i18n(get_option('date_format'), strtotime($week_end))
        );
        
        $message = self::get_weekly_summary_message($week_start, $week_end, $contacts, $analytics, $top_pages);
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        $sent = false;
        
        foreach ($notification_emails as $email) {
            if (is_email($email)) {
                $result = wp_mail($email, $subject, $message, $headers);
                if ($result) {
                    $sent = true;
                }
            }
        }
        
        return $sent;
    }
    
    /**
     * Get weekly summary message
     */
    private static function get_weekly_summary_message($week_start, $week_end, $contacts, $analytics, $top_pages) {
        $site_name = get_bloginfo('name');
        $admin_url = admin_url('admin.php?page=whatsapp-contacts&tab=analytics');
        
        $message = sprintf(
            __("Resumo semanal do WhatsApp Contact Button\n" .
               "Site: %s\n" .
               "Período: %s a %s\n\n" .
               "📊 ESTATÍSTICAS DA SEMANA:\n" .
               "Cliques no botão: %d\n" .
               "Formulários enviados: %d\n" .
               "Redirecionamentos WhatsApp: %d\n" .
               "Taxa de conversão: %s%%\n" .
               "Total de contatos: %d\n\n", 'whatsapp-contact-button'),
            $site_name,
            date_i18n(get_option('date_format'), strtotime($week_start)),
            date_i18n(get_option('date_format'), strtotime($week_end)),
            $analytics['clicks'],
            $analytics['submits'],
            $analytics['redirects'],
            $analytics['conversion_rate'],
            count($contacts)
        );
        
        if (!empty($top_pages)) {
            $message .= __("🏆 TOP PÁGINAS GERADORAS DE LEADS:\n", 'whatsapp-contact-button');
            
            foreach ($top_pages as $index => $page) {
                $conversion_rate = $page->clicks > 0 ? round(($page->submits / $page->clicks) * 100, 2) : 0;
                $message .= sprintf(
                    __("%d. %s - %d envios (%s%% conversão)\n", 'whatsapp-contact-button'),
                    $index + 1,
                    $page->page_title,
                    $page->submits,
                    $conversion_rate
                );
            }
            
            $message .= "\n";
        }
        
        $message .= sprintf(
            __("🔗 Ver relatório completo: %s\n\n" .
               "---\n" .
               "Esta é uma notificação automática do plugin WhatsApp Contact Button.", 'whatsapp-contact-button'),
            $admin_url
        );
        
        return $message;
    }
    
    /**
     * AJAX: Test notification
     */
    public function ajax_test_notification() {
        check_ajax_referer('wcb_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('Permissão negada.', 'whatsapp-contact-button'));
        }
        
        $test_contact_data = array(
            'name' => __('João Silva (Teste)', 'whatsapp-contact-button'),
            'email' => 'joao@exemplo.com',
            'phone' => '(11) 99999-9999',
            'page_title' => __('Página de Teste', 'whatsapp-contact-button'),
            'page_url' => home_url('/teste'),
            'device_type' => 'desktop',
            'submit_time' => current_time('mysql')
        );
        
        $result = $this->send_new_contact_notification(0, $test_contact_data);
        
        if ($result) {
            wp_send_json_success(array('message' => __('Email de teste enviado com sucesso!', 'whatsapp-contact-button')));
        } else {
            wp_send_json_error(array('message' => __('Erro ao enviar email de teste.', 'whatsapp-contact-button')));
        }
    }
    
    /**
     * Schedule daily summary (to be called by cron)
     */
    public static function schedule_daily_summary() {
        if (!wp_next_scheduled('wcb_daily_summary')) {
            wp_schedule_event(strtotime('tomorrow 8:00'), 'daily', 'wcb_daily_summary');
        }
    }
    
    /**
     * Schedule weekly summary (to be called by cron)
     */
    public static function schedule_weekly_summary() {
        if (!wp_next_scheduled('wcb_weekly_summary')) {
            wp_schedule_event(strtotime('next monday 9:00'), 'weekly', 'wcb_weekly_summary');
        }
    }
    
    /**
     * Clear scheduled notifications
     */
    public static function clear_scheduled_notifications() {
        wp_clear_scheduled_hook('wcb_daily_summary');
        wp_clear_scheduled_hook('wcb_weekly_summary');
    }
}

