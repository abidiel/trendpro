<?php 
/**
 * Plugin Name:  Serviços
 * Plugin URI: https://trendpro.com.br
 * Description: Plugin para gerenciar serviços da TrendPro
 * Version: 1.0.0
 * Author: TrendPro
 * Author URI: https://trendpro.com.br
 * Text Domain: trend-pro-servicos
 * Domain Path: /languages
 */

// Se este arquivo é chamado diretamente, aborta.
if (!defined('WPINC')) {
    die;
}

// Define constantes do plugin
define('TREND_PRO_SERVICOS_VERSION', '1.0.0');
define('TREND_PRO_SERVICOS_PATH', plugin_dir_path(__FILE__));
define('TREND_PRO_SERVICOS_URL', plugin_dir_url(__FILE__));



/**
 * Registra o Custom Post Type Serviços
 */
function register_services_post_type() {
    $labels = array(
        'name'               => 'Serviços',
        'singular_name'      => 'Serviço',
        'menu_name'          => 'Serviços',
        'name_admin_bar'     => 'Serviço',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Serviço',
        'new_item'           => 'Novo Serviço',
        'edit_item'          => 'Editar Serviço',
        'view_item'          => 'Ver Serviço',
        'all_items'          => 'Todos os Serviços',
        'search_items'       => 'Procurar Serviços',
        'parent_item_colon'  => 'Serviços Pai:',
        'not_found'          => 'Nenhum serviço encontrado.',
        'not_found_in_trash' => 'Nenhum serviço encontrado na lixeira.'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'servicos'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true, // Habilita o editor Gutenberg
    );

    register_post_type('servicos', $args);
}
add_action('init', 'register_services_post_type');

/**
 * Flush rewrite rules na ativação do plugin
 */
function flush_rewrite_rules_on_activation() {
    register_services_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');

?>
