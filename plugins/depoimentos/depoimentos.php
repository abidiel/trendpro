<?php 
/*
Plugin Name:    Depoimentos
Plugin URI:     
Description:    Cadastro de depoimentos
Version:        1.0
Author:         Trend Pro
Author URI:     https://www.trendpro.com.br
License:        Null
*/

// Cria o registro Custom Post type
add_action( 'init', 'criar_depoimentos' );
function criar_depoimentos() {
  register_post_type( 'depoimentos',
    array(
        'labels' => array(
            'name' => 'Depoimentos',
            'singular_name' => 'Depoimentos',
            'add_new' => 'Novo depoimento',
            'add_new_item' => 'Novo depoimento',
            'edit' => 'Editar',
            'edit_item' => 'Editar',
            'new_item' => 'Novo',
            'view' => 'Ver',
            'view_item' => 'Ver',
            'search_items' => 'Pesquisar',
            'not_found' => 'Nada encontrado',
            'not_found_in_trash' => 
            'Nada encontado na lixeira',
            'parent' => 'Pai'                    
        ),
        'public' => false,
        'show_ui' => true,
        'menu_position' => 20,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array( '' ),
        'menu_icon' => 'dashicons-format-chat',
        'has_archive' => true
    )
  );
}
// para remover o link permanente
//'public' => false,
//'show_ui' => true,
// para manter o link permanente
//'public' => true,

add_theme_support('post-thumbnails', array('depoimentos'));

function add_depoimentos_css() {
  wp_enqueue_style('css', plugins_url('/css/css.css', __FILE__ ));
}
add_action('admin_print_styles', 'add_depoimentos_css');

?>