<?php
/**
 * Plugin Name: Área do Cliente
 * Description: Sistema completo de área do cliente para entregas
 * Version: 1.0.0
 * Author: TrendPro
 * Text Domain: area-cliente
 */

// Prevenir acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes
define('AREA_CLIENTE_VERSION', '1.0.0');
define('AREA_CLIENTE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AREA_CLIENTE_PLUGIN_PATH', plugin_dir_path(__FILE__));

class AreaCliente {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('wp_head', array($this, 'add_noindex_meta'));
        add_action('template_redirect', array($this, 'handle_password_protection'));
        add_action('wp_head', array($this, 'add_security_headers'));
        add_action('wp_login', array($this, 'validate_password_nonce'), 10, 2);
        
        // Flush rewrite rules na ativação
        register_activation_hook(__FILE__, array($this, 'flush_rewrite_rules'));
    }
    
    /**
     * Registrar Custom Post Type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => 'Área do Cliente',
            'singular_name'         => 'Cliente',
            'menu_name'             => 'Área do Cliente',
            'name_admin_bar'        => 'Cliente',
            'archives'              => 'Arquivo de Clientes',
            'attributes'            => 'Atributos do Cliente',
            'parent_item_colon'     => 'Cliente Pai:',
            'all_items'             => 'Todos os Clientes',
            'add_new_item'          => 'Adicionar Novo Cliente',
            'add_new'               => 'Adicionar Novo',
            'new_item'              => 'Novo Cliente',
            'edit_item'             => 'Editar Cliente',
            'update_item'           => 'Atualizar Cliente',
            'view_item'             => 'Ver Cliente',
            'view_items'            => 'Ver Clientes',
            'search_items'          => 'Buscar Clientes',
            'not_found'             => 'Não encontrado',
            'not_found_in_trash'    => 'Não encontrado na lixeira',
            'featured_image'        => 'Logo do Cliente',
            'set_featured_image'    => 'Definir logo',
            'remove_featured_image' => 'Remover logo',
            'use_featured_image'    => 'Usar como logo',
            'insert_into_item'      => 'Inserir no cliente',
            'uploaded_to_this_item' => 'Enviado para este cliente',
            'items_list'            => 'Lista de clientes',
            'items_list_navigation' => 'Navegação da lista',
            'filter_items_list'     => 'Filtrar lista',
        );

        $args = array(
            'label'                 => 'Cliente',
            'description'           => 'Área do cliente para entregas',
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'password'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-businessman',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'rewrite'               => array(
                'slug' => 'cliente',
                'with_front' => false
            ),
            'show_in_rest'          => true,
        );

        register_post_type('area_cliente', $args);
    }
    
    
    /**
     * Adicionar meta robots noindex/nofollow
     */
    public function add_noindex_meta() {
        if (is_singular('area_cliente')) {
            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
        }
    }
    
    /**
     * Verificar proteção por senha
     */
    public function handle_password_protection() {
        if (is_singular('area_cliente') && post_password_required()) {
            // O template será responsável por mostrar o formulário de senha
            return;
        }
    }
    
    /**
     * Adicionar headers de segurança
     */
    public function add_security_headers() {
        if (is_singular('area_cliente')) {
            // Prevenir clickjacking
            echo '<meta http-equiv="X-Frame-Options" content="DENY">' . "\n";
            // Prevenir MIME type sniffing
            echo '<meta http-equiv="X-Content-Type-Options" content="nosniff">' . "\n";
            // XSS Protection
            echo '<meta http-equiv="X-XSS-Protection" content="1; mode=block">' . "\n";
        }
    }
    
    
    /**
     * Validar nonce para senha de área do cliente
     */
    public function validate_password_nonce($user_login, $user) {
        if (isset($_POST['area_cliente_nonce']) && isset($_POST['post_id'])) {
            $post_id = intval($_POST['post_id']);
            $nonce = sanitize_text_field($_POST['area_cliente_nonce']);
            
            if (!wp_verify_nonce($nonce, 'area_cliente_password_' . $post_id)) {
                wp_redirect(add_query_arg('nonce_error', '1', get_permalink($post_id)));
                exit;
            }
        }
    }
    
    /**
     * Flush rewrite rules na ativação
     */
    public function flush_rewrite_rules() {
        $this->register_post_type();
        flush_rewrite_rules();
    }
}

// Inicializar o plugin
new AreaCliente();
