<?php
/**
 * Analytics functionality for WhatsApp Contact Button
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WCB_Analytics {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_ajax_wcb_get_analytics_data', array($this, 'ajax_get_analytics_data'));
        add_action('wp_ajax_wcb_track_click', array($this, 'ajax_track_click'));
        add_action('wp_ajax_nopriv_wcb_track_click', array($this, 'ajax_track_click'));
        add_action('wp_ajax_wcb_track_submit', array($this, 'ajax_track_submit'));
        add_action('wp_ajax_nopriv_wcb_track_submit', array($this, 'ajax_track_submit'));
        add_action('wp_ajax_wcb_track_redirect', array($this, 'ajax_track_redirect'));
        add_action('wp_ajax_nopriv_wcb_track_redirect', array($this, 'ajax_track_redirect'));
    }
    
    /**
     * Track button click
     */
    public static function track_click($page_data, $session_id) {
        $analytics_data = array(
            'event_type' => 'click',
            'page_title' => $page_data['title'],
            'page_url' => $page_data['url'],
            'page_slug' => $page_data['slug'],
            'device_type' => self::get_device_type(),
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT']),
            'session_id' => $session_id
        );
        
        return WCB_Database::insert_analytics($analytics_data);
    }
    
    /**
     * Track form submission
     */
    public static function track_submit($page_data, $session_id, $contact_id = null) {
        $analytics_data = array(
            'event_type' => 'submit',
            'page_title' => $page_data['title'],
            'page_url' => $page_data['url'],
            'page_slug' => $page_data['slug'],
            'device_type' => self::get_device_type(),
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT']),
            'session_id' => $session_id,
            'contact_id' => $contact_id
        );
        
        return WCB_Database::insert_analytics($analytics_data);
    }
    
    /**
     * Track WhatsApp redirect
     */
    public static function track_redirect($page_data, $session_id, $contact_id = null) {
        $analytics_data = array(
            'event_type' => 'redirect',
            'page_title' => $page_data['title'],
            'page_url' => $page_data['url'],
            'page_slug' => $page_data['slug'],
            'device_type' => self::get_device_type(),
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT']),
            'session_id' => $session_id,
            'contact_id' => $contact_id
        );
        
        return WCB_Database::insert_analytics($analytics_data);
    }
    
    /**
     * Get device type
     */
    private static function get_device_type() {
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
     * Get analytics summary for dashboard
     */
    public static function get_dashboard_summary($date_from = '', $date_to = '') {
        if (empty($date_from)) {
            $date_from = date('Y-m-d', strtotime('-30 days'));
        }
        
        if (empty($date_to)) {
            $date_to = date('Y-m-d');
        }
        
        $summary = WCB_Database::get_analytics_summary($date_from, $date_to);
        
        $data = array(
            'clicks' => 0,
            'submits' => 0,
            'redirects' => 0,
            'conversion_rate' => 0,
            'redirect_rate' => 0
        );
        
        foreach ($summary as $item) {
            if (isset($data[$item->event_type])) {
                $data[$item->event_type] = intval($item->count);
            }
        }
        
        // Calculate conversion rates
        if ($data['clicks'] > 0) {
            $data['conversion_rate'] = round(($data['submits'] / $data['clicks']) * 100, 2);
        }
        
        if ($data['submits'] > 0) {
            $data['redirect_rate'] = round(($data['redirects'] / $data['submits']) * 100, 2);
        }
        
        return $data;
    }
    
    /**
     * Get hourly analytics data
     */
    public static function get_hourly_data($date_from = '', $date_to = '') {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_analytics';
        
        $where = array('1=1');
        $where_values = array();
        
        if (!empty($date_from)) {
            $where[] = 'timestamp >= %s';
            $where_values[] = $date_from . ' 00:00:00';
        }
        
        if (!empty($date_to)) {
            $where[] = 'timestamp <= %s';
            $where_values[] = $date_to . ' 23:59:59';
        }
        
        $where_clause = implode(' AND ', $where);
        
        $sql = "SELECT 
                    HOUR(timestamp) as hour,
                    event_type,
                    COUNT(*) as count
                FROM $table 
                WHERE $where_clause 
                GROUP BY HOUR(timestamp), event_type 
                ORDER BY hour ASC";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get daily analytics data
     */
    public static function get_daily_data($date_from = '', $date_to = '') {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_analytics';
        
        $where = array('1=1');
        $where_values = array();
        
        if (!empty($date_from)) {
            $where[] = 'timestamp >= %s';
            $where_values[] = $date_from . ' 00:00:00';
        }
        
        if (!empty($date_to)) {
            $where[] = 'timestamp <= %s';
            $where_values[] = $date_to . ' 23:59:59';
        }
        
        $where_clause = implode(' AND ', $where);
        
        $sql = "SELECT 
                    DATE(timestamp) as date,
                    event_type,
                    COUNT(*) as count
                FROM $table 
                WHERE $where_clause 
                GROUP BY DATE(timestamp), event_type 
                ORDER BY date ASC";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get device analytics
     */
    public static function get_device_analytics($date_from = '', $date_to = '') {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_analytics';
        
        $where = array('1=1');
        $where_values = array();
        
        if (!empty($date_from)) {
            $where[] = 'timestamp >= %s';
            $where_values[] = $date_from . ' 00:00:00';
        }
        
        if (!empty($date_to)) {
            $where[] = 'timestamp <= %s';
            $where_values[] = $date_to . ' 23:59:59';
        }
        
        $where_clause = implode(' AND ', $where);
        
        $sql = "SELECT 
                    device_type,
                    event_type,
                    COUNT(*) as count
                FROM $table 
                WHERE $where_clause 
                GROUP BY device_type, event_type 
                ORDER BY count DESC";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get conversion funnel data
     */
    public static function get_conversion_funnel($date_from = '', $date_to = '') {
        $summary = self::get_dashboard_summary($date_from, $date_to);
        
        return array(
            array(
                'step' => __('Cliques no Botão', 'whatsapp-contact-button'),
                'count' => $summary['clicks'],
                'percentage' => 100
            ),
            array(
                'step' => __('Formulários Enviados', 'whatsapp-contact-button'),
                'count' => $summary['submits'],
                'percentage' => $summary['clicks'] > 0 ? round(($summary['submits'] / $summary['clicks']) * 100, 2) : 0
            ),
            array(
                'step' => __('Redirecionamentos WhatsApp', 'whatsapp-contact-button'),
                'count' => $summary['redirects'],
                'percentage' => $summary['clicks'] > 0 ? round(($summary['redirects'] / $summary['clicks']) * 100, 2) : 0
            )
        );
    }
    
    /**
     * AJAX: Get analytics data
     */
    public function ajax_get_analytics_data() {
        check_ajax_referer('wcb_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('Permissão negada.', 'whatsapp-contact-button'));
        }
        
        $type = sanitize_text_field($_POST['type']);
        $date_from = sanitize_text_field($_POST['date_from']);
        $date_to = sanitize_text_field($_POST['date_to']);
        
        $data = array();
        
        switch ($type) {
            case 'summary':
                $data = self::get_dashboard_summary($date_from, $date_to);
                break;
                
            case 'hourly':
                $data = self::get_hourly_data($date_from, $date_to);
                break;
                
            case 'daily':
                $data = self::get_daily_data($date_from, $date_to);
                break;
                
            case 'device':
                $data = self::get_device_analytics($date_from, $date_to);
                break;
                
            case 'funnel':
                $data = self::get_conversion_funnel($date_from, $date_to);
                break;
                
            case 'top_pages':
                $data = WCB_Database::get_top_pages($date_from, $date_to, 10);
                break;
        }
        
        wp_send_json_success($data);
    }
    
    /**
     * AJAX: Track click
     */
    public function ajax_track_click() {
        check_ajax_referer('wcb_frontend_nonce', 'nonce');
        
        $page_data = array(
            'title' => sanitize_text_field($_POST['page_title']),
            'url' => esc_url_raw($_POST['page_url']),
            'slug' => sanitize_title($_POST['page_slug'])
        );
        
        $session_id = sanitize_text_field($_POST['session_id']);
        
        $result = self::track_click($page_data, $session_id);
        
        if ($result) {
            wp_send_json_success(array('analytics_id' => $result));
        } else {
            wp_send_json_error(array('message' => __('Erro ao registrar clique.', 'whatsapp-contact-button')));
        }
    }
    
    /**
     * AJAX: Track submit
     */
    public function ajax_track_submit() {
        check_ajax_referer('wcb_frontend_nonce', 'nonce');
        
        $page_data = array(
            'title' => sanitize_text_field($_POST['page_title']),
            'url' => esc_url_raw($_POST['page_url']),
            'slug' => sanitize_title($_POST['page_slug'])
        );
        
        $session_id = sanitize_text_field($_POST['session_id']);
        $contact_id = isset($_POST['contact_id']) ? intval($_POST['contact_id']) : null;
        
        $result = self::track_submit($page_data, $session_id, $contact_id);
        
        if ($result) {
            wp_send_json_success(array('analytics_id' => $result));
        } else {
            wp_send_json_error(array('message' => __('Erro ao registrar envio.', 'whatsapp-contact-button')));
        }
    }
    
    /**
     * AJAX: Track redirect
     */
    public function ajax_track_redirect() {
        check_ajax_referer('wcb_frontend_nonce', 'nonce');
        
        $page_data = array(
            'title' => sanitize_text_field($_POST['page_title']),
            'url' => esc_url_raw($_POST['page_url']),
            'slug' => sanitize_title($_POST['page_slug'])
        );
        
        $session_id = sanitize_text_field($_POST['session_id']);
        $contact_id = isset($_POST['contact_id']) ? intval($_POST['contact_id']) : null;
        
        $result = self::track_redirect($page_data, $session_id, $contact_id);
        
        if ($result) {
            wp_send_json_success(array('analytics_id' => $result));
        } else {
            wp_send_json_error(array('message' => __('Erro ao registrar redirecionamento.', 'whatsapp-contact-button')));
        }
    }
    
    /**
     * Clean old analytics data
     */
    public static function clean_old_data($days = 90) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_analytics';
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE timestamp < %s", $cutoff_date));
    }
    
    /**
     * Get analytics export data
     */
    public static function get_export_data($date_from = '', $date_to = '') {
        $args = array(
            'limit' => 10000
        );
        
        if (!empty($date_from)) {
            $args['date_from'] = $date_from;
        }
        
        if (!empty($date_to)) {
            $args['date_to'] = $date_to;
        }
        
        return WCB_Database::get_analytics($args);
    }
}

