<?php 
/*
Plugin Name:    Projetos
Plugin URI:     
Description:    Cadastro de Projetos
Version:        1.0
Author:         Trend Pro
Author URI:     https://www.trendpro.com.br
License:        Null
*/

// Cria o registro Custom Post type
add_action( 'init', 'criar_projetos' );
function criar_projetos() {
  register_post_type( 'projetos',
    array(
        'labels' => array(
          'name' => 'Projetos',
          'singular_name' => 'Projetos',
          'add_new' => 'Adicionar',
          'add_new_item' => 'Adicionar',
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
        'public' => true,
        'menu_position' => 20,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('projetos-categoria'),
        'menu_icon' => 'dashicons-tag',
        'has_archive' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'projetos'),
    )
  );
  register_taxonomy(
    'projetos-categoria',
    'projetos',
    array(
      'labels' => array(
        'name' => 'Categorias',
        'add_new_item' => 'Adicionar Nova Categoria',
        'new_item_name' => "Nova Categoria"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'show_in_rest' => true,
      'public' => true
    )
  );
}
// para remover o link permanente
//'public' => false,
//'show_ui' => true,
// para manter o link permanente
//'public' => true,

add_theme_support('post-thumbnails', array('projetos'));

function add_produtos_css() {
  wp_enqueue_style('css', plugins_url('/assets/css/css.css', __FILE__ ));
}
add_action('admin_print_styles', 'add_produtos_css');

?>