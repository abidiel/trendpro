<?php
/**************************************
Modificações feitas no admin
**************************************/
/**************************************
* Custom admin scripts.
**************************************/
function admin_scripts() {
	wp_enqueue_style('inc-admin', get_template_directory_uri() . '/core/painel/assets/css/custom-admin.css');
}
add_action('admin_enqueue_scripts', 'admin_scripts');
add_action('login_enqueue_scripts', 'admin_scripts');


/**************************************
* Remove logo da barra do topo.
**************************************/
function admin_adminbar_remove_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wp-logo' );
}
add_action('wp_before_admin_bar_render', 'admin_adminbar_remove_logo');



/**************************************
* Remover barra painel topo site
**************************************/
// function admin_function_admin_bar(){
//   return false;
// }
// add_filter('show_admin_bar' , 'admin_function_admin_bar');


/**************************************
* Adiciona assinartura no rodapé
**************************************/
function admin_remove_footer_admin() {
  echo '<span id="footer-thankyou"><a href="https://trendpro.com.br" target="_blank">Trend Pro</a></span>';
}
add_filter('admin_footer_text', 'admin_remove_footer_admin');


/**************************************
* Desabilita editor de códigos no painel
**************************************/
define('DISALLOW_FILE_EDIT', true);


/**************************************
* Remover versão do wordpress generator
**************************************/
remove_action('wp_head', 'wp_generator');


/**************************************
* Link logo painel para a pagina incial
**************************************/
function admin_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'admin_logo_url' );


/**************************************
* Muda o title do link.
**************************************/
function admin_logo_title() {
	return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'admin_logo_title' );


/****************************************
* Remove emoji's
***************************************/
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
  return $urls;
}


/****************************************
* Remove Welcome Panel.
***************************************/
remove_action('welcome_panel', 'wp_welcome_panel');

