<?php 
/*
Plugin Name:    Banners
Plugin URI:     
Description:    Cadastro de banner
Version:        1.0
Author:         Trend Pro
Author URI:     https://www.trendpro.com.br
License:        Null
*/

// Cria o registro Custom Post type
add_action( 'init', 'criar_banners' );
function criar_banners() {
  register_post_type( 'banners',
    array(
        'labels' => array(
            'name' => 'Banners',
            'singular_name' => 'Banners',
            'add_new' => 'Novo banner',
            'add_new_item' => 'Novo banner',
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
        'supports' => array('title', 'thumbnail'),
        'taxonomies' => array( '' ),
        'menu_icon' => 'dashicons-image-flip-horizontal',
        'has_archive' => true
    )
  );
}
// para remover o link permanente
//'public' => false,
//'show_ui' => true,
// para manter o link permanente
//'public' => true,

add_theme_support('post-thumbnails', array('banners'));

function add_banners_css() {
  wp_enqueue_style('css', plugins_url('/css/css.css', __FILE__ ));
}
add_action('admin_print_styles', 'add_banners_css');

?>