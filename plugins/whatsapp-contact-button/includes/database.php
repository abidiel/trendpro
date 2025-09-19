<?php
/**
 * Database operations for WhatsApp Contact Button
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WCB_Database {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Database operations are handled via static methods
    }
    
    /**
     * Create database tables
     */
    public static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Create contacts table
        $contacts_table = $wpdb->prefix . 'whatsapp_contacts';
        $contacts_sql = "CREATE TABLE $contacts_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            phone varchar(50) NOT NULL,
            email varchar(255) NOT NULL,
            consent tinyint(1) NOT NULL DEFAULT 1,
            page_title varchar(255) NOT NULL,
            page_url text NOT NULL,
            page_slug varchar(255) NOT NULL,
            device_type varchar(50) NOT NULL,
            user_agent text NOT NULL,
            click_time datetime DEFAULT NULL,
            submit_time datetime NOT NULL,
            whatsapp_redirect_time datetime DEFAULT NULL,
            status varchar(50) NOT NULL DEFAULT 'Novo',
            admin_notes text,
            form_data text,
            created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY page_slug (page_slug),
            KEY status (status),
            KEY submit_time (submit_time)
        ) $charset_collate;";
        
        // Create analytics table
        $analytics_table = $wpdb->prefix . 'whatsapp_analytics';
        $analytics_sql = "CREATE TABLE $analytics_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            event_type varchar(50) NOT NULL,
            page_slug varchar(255) NOT NULL,
            page_title varchar(255) NOT NULL,
            page_url text NOT NULL,
            device_type varchar(50) NOT NULL,
            user_agent text NOT NULL,
            session_id varchar(255) NOT NULL,
            contact_id int(11) DEFAULT NULL,
            timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY event_type (event_type),
            KEY page_slug (page_slug),
            KEY session_id (session_id),
            KEY timestamp (timestamp),
            KEY contact_id (contact_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($contacts_sql);
        dbDelta($analytics_sql);
        
        // Update database version
        update_option('wcb_db_version', '1.0.0');
    }
    
    /**
     * Drop database tables
     */
    public static function drop_tables() {
        global $wpdb;
        
        $contacts_table = $wpdb->prefix . 'whatsapp_contacts';
        $analytics_table = $wpdb->prefix . 'whatsapp_analytics';
        
        $wpdb->query("DROP TABLE IF EXISTS $contacts_table");
        $wpdb->query("DROP TABLE IF EXISTS $analytics_table");
        
        delete_option('wcb_db_version');
    }
    
    /**
     * Insert contact
     */
    public static function insert_contact($data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        
        $defaults = array(
            'name' => '',
            'phone' => '',
            'email' => '',
            'consent' => 1,
            'page_title' => '',
            'page_url' => '',
            'page_slug' => '',
            'device_type' => '',
            'user_agent' => '',
            'click_time' => null,
            'submit_time' => current_time('mysql'),
            'whatsapp_redirect_time' => null,
            'status' => 'Novo',
            'admin_notes' => '',
            'form_data' => ''
        );
        
        $data = wp_parse_args($data, $defaults);
        
        // Sanitize data
        $data['name'] = sanitize_text_field($data['name']);
        $data['phone'] = sanitize_text_field($data['phone']);
        $data['email'] = sanitize_email($data['email']);
        $data['page_title'] = sanitize_text_field($data['page_title']);
        $data['page_url'] = esc_url_raw($data['page_url']);
        $data['page_slug'] = sanitize_title($data['page_slug']);
        $data['device_type'] = sanitize_text_field($data['device_type']);
        $data['user_agent'] = sanitize_text_field($data['user_agent']);
        $data['status'] = sanitize_text_field($data['status']);
        $data['admin_notes'] = sanitize_textarea_field($data['admin_notes']);
        $data['form_data'] = sanitize_textarea_field($data['form_data']);
        
        $result = $wpdb->insert($table, $data);
        
        if ($result !== false) {
            return $wpdb->insert_id;
        }
        
        return false;
    }
    
    /**
     * Update contact
     */
    public static function update_contact($id, $data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        
        // Sanitize data
        if (isset($data['name'])) $data['name'] = sanitize_text_field($data['name']);
        if (isset($data['phone'])) $data['phone'] = sanitize_text_field($data['phone']);
        if (isset($data['email'])) $data['email'] = sanitize_email($data['email']);
        if (isset($data['status'])) $data['status'] = sanitize_text_field($data['status']);
        if (isset($data['admin_notes'])) $data['admin_notes'] = sanitize_textarea_field($data['admin_notes']);
        
        return $wpdb->update($table, $data, array('id' => intval($id)));
    }
    
    /**
     * Get contact by ID
     */
    public static function get_contact($id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", intval($id)));
    }
    
    /**
     * Get contacts with filters
     */
    public static function get_contacts($args = array()) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        
        $defaults = array(
            'limit' => 20,
            'offset' => 0,
            'orderby' => 'submit_time',
            'order' => 'DESC',
            'status' => '',
            'page_slug' => '',
            'date_from' => '',
            'date_to' => '',
            'search' => ''
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $where = array('1=1');
        $where_values = array();
        
        if (!empty($args['status'])) {
            $where[] = 'status = %s';
            $where_values[] = $args['status'];
        }
        
        if (!empty($args['page_slug'])) {
            $where[] = 'page_slug = %s';
            $where_values[] = $args['page_slug'];
        }
        
        if (!empty($args['date_from'])) {
            $where[] = 'submit_time >= %s';
            $where_values[] = $args['date_from'] . ' 00:00:00';
        }
        
        if (!empty($args['date_to'])) {
            $where[] = 'submit_time <= %s';
            $where_values[] = $args['date_to'] . ' 23:59:59';
        }
        
        if (!empty($args['search'])) {
            $where[] = '(name LIKE %s OR email LIKE %s OR phone LIKE %s)';
            $search_term = '%' . $wpdb->esc_like($args['search']) . '%';
            $where_values[] = $search_term;
            $where_values[] = $search_term;
            $where_values[] = $search_term;
        }
        
        $where_clause = implode(' AND ', $where);
        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);
        $limit = intval($args['limit']);
        $offset = intval($args['offset']);
        
        $sql = "SELECT * FROM $table WHERE $where_clause ORDER BY $orderby LIMIT $limit OFFSET $offset";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get contacts count with filters
     */
    public static function get_contacts_count($args = array()) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        
        $defaults = array(
            'status' => '',
            'page_slug' => '',
            'date_from' => '',
            'date_to' => '',
            'search' => ''
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $where = array('1=1');
        $where_values = array();
        
        if (!empty($args['status'])) {
            $where[] = 'status = %s';
            $where_values[] = $args['status'];
        }
        
        if (!empty($args['page_slug'])) {
            $where[] = 'page_slug = %s';
            $where_values[] = $args['page_slug'];
        }
        
        if (!empty($args['date_from'])) {
            $where[] = 'submit_time >= %s';
            $where_values[] = $args['date_from'] . ' 00:00:00';
        }
        
        if (!empty($args['date_to'])) {
            $where[] = 'submit_time <= %s';
            $where_values[] = $args['date_to'] . ' 23:59:59';
        }
        
        if (!empty($args['search'])) {
            $where[] = '(name LIKE %s OR email LIKE %s OR phone LIKE %s)';
            $search_term = '%' . $wpdb->esc_like($args['search']) . '%';
            $where_values[] = $search_term;
            $where_values[] = $search_term;
            $where_values[] = $search_term;
        }
        
        $where_clause = implode(' AND ', $where);
        $sql = "SELECT COUNT(*) FROM $table WHERE $where_clause";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_var($sql);
    }
    
    /**
     * Delete contact
     */
    public static function delete_contact($id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        
        return $wpdb->delete($table, array('id' => intval($id)));
    }
    
    /**
     * Delete multiple contacts
     */
    public static function delete_contacts($ids) {
        global $wpdb;
        
        if (empty($ids) || !is_array($ids)) {
            return false;
        }
        
        $table = $wpdb->prefix . 'whatsapp_contacts';
        $ids = array_map('intval', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));
        
        return $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id IN ($placeholders)", $ids));
    }
    
    /**
     * Insert analytics event
     */
    public static function insert_analytics($data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_analytics';
        
        $defaults = array(
            'event_type' => '',
            'page_slug' => '',
            'page_title' => '',
            'page_url' => '',
            'device_type' => '',
            'user_agent' => '',
            'session_id' => '',
            'contact_id' => null,
            'timestamp' => current_time('mysql')
        );
        
        $data = wp_parse_args($data, $defaults);
        
        // Sanitize data
        $data['event_type'] = sanitize_text_field($data['event_type']);
        $data['page_slug'] = sanitize_title($data['page_slug']);
        $data['page_title'] = sanitize_text_field($data['page_title']);
        $data['page_url'] = esc_url_raw($data['page_url']);
        $data['device_type'] = sanitize_text_field($data['device_type']);
        $data['user_agent'] = sanitize_text_field($data['user_agent']);
        $data['session_id'] = sanitize_text_field($data['session_id']);
        
        $result = $wpdb->insert($table, $data);
        
        if ($result !== false) {
            return $wpdb->insert_id;
        }
        
        return false;
    }
    
    /**
     * Get analytics data
     */
    public static function get_analytics($args = array()) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'whatsapp_analytics';
        
        $defaults = array(
            'event_type' => '',
            'page_slug' => '',
            'date_from' => '',
            'date_to' => '',
            'limit' => 100,
            'offset' => 0
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $where = array('1=1');
        $where_values = array();
        
        if (!empty($args['event_type'])) {
            $where[] = 'event_type = %s';
            $where_values[] = $args['event_type'];
        }
        
        if (!empty($args['page_slug'])) {
            $where[] = 'page_slug = %s';
            $where_values[] = $args['page_slug'];
        }
        
        if (!empty($args['date_from'])) {
            $where[] = 'timestamp >= %s';
            $where_values[] = $args['date_from'] . ' 00:00:00';
        }
        
        if (!empty($args['date_to'])) {
            $where[] = 'timestamp <= %s';
            $where_values[] = $args['date_to'] . ' 23:59:59';
        }
        
        $where_clause = implode(' AND ', $where);
        $limit = intval($args['limit']);
        $offset = intval($args['offset']);
        
        $sql = "SELECT * FROM $table WHERE $where_clause ORDER BY timestamp DESC LIMIT $limit OFFSET $offset";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get analytics summary
     */
    public static function get_analytics_summary($date_from = '', $date_to = '') {
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
                    event_type,
                    COUNT(*) as count
                FROM $table 
                WHERE $where_clause 
                GROUP BY event_type";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get top pages by analytics
     */
    public static function get_top_pages($date_from = '', $date_to = '', $limit = 10) {
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
        $limit = intval($limit);
        
        $sql = "SELECT 
                    page_slug,
                    page_title,
                    COUNT(*) as total_events,
                    SUM(CASE WHEN event_type = 'click' THEN 1 ELSE 0 END) as clicks,
                    SUM(CASE WHEN event_type = 'submit' THEN 1 ELSE 0 END) as submits,
                    SUM(CASE WHEN event_type = 'redirect' THEN 1 ELSE 0 END) as redirects
                FROM $table 
                WHERE $where_clause 
                GROUP BY page_slug, page_title 
                ORDER BY total_events DESC 
                LIMIT $limit";
        
        if (!empty($where_values)) {
            $sql = $wpdb->prepare($sql, $where_values);
        }
        
        return $wpdb->get_results($sql);
    }
}

