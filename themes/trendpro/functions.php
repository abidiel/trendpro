<?php
ob_start();
/**************************************
 *  THEME SUPORT
 **************************************/
function add_suport_theme()
{
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'add_suport_theme');


/**************************************
 *  SCRIPTS / CSS
 **************************************/
function wp_responsivo_scripts()
{
  // Obtém a versão atual do tema
  $theme = wp_get_theme();
  $theme_version = $theme->get('Version');

  /************************************** Carregando CSS header **************************************/
  // Css do front
  wp_enqueue_style('vendors', get_template_directory_uri() . '/assets/css/vendors.min.css', array(), $theme_version);
  wp_enqueue_style('icon', get_template_directory_uri() . '/assets/css/icon.min.css', array(), $theme_version);
  wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), $theme_version);
  wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), $theme_version);
  wp_enqueue_style('trendpro', get_template_directory_uri() . '/assets/css/trendpro.css', array(), $theme_version);

  // Remove o jQuery padrão do WordPress
  wp_deregister_script('jquery');

  /************************************** Carregando no footer **************************************/

  wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), $theme_version, true);
  wp_enqueue_script('vendors', get_template_directory_uri() . '/assets/js/vendors.min.js', array('jquery'), $theme_version, true);
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('vendors'), $theme_version, true);
  wp_enqueue_script('trendpro-js', get_template_directory_uri() . '/assets/js/trendpro.js', array('main'), $theme_version, true);

  wp_localize_script('trendpro-js', 'trendproData', array(
    'themeUrl' => get_template_directory_uri(),
  ));

  wp_enqueue_script('jquerymask', get_template_directory_uri() . '/assets/js/jquery.mask.js', array('jquery'), $theme_version, true);
  wp_enqueue_script('custom-mask', get_template_directory_uri() . '/assets/js/custom-mask.js', array('jquerymask'), $theme_version, true);
}
add_action('wp_enqueue_scripts', 'wp_responsivo_scripts');


/**************************************
 *  Remover carregamento do css e js do contact form 7
Para carregar na página quae vai ser usado o form colocar esse código
abaixo do get_header();
if (function_exists('wpcf7_enqueue_scripts')) {
  wpcf7_enqueue_scripts();
}
if (function_exists('wpcf7_enqueue_styles')) {
  wpcf7_enqueue_styles();
} 
 **************************************/
add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');


/**************************************
 * Ativa formatos de posts
 **************************************/
// add_theme_support( 'post-formats', array( 'audio', 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );


/**************************************
 * Registro Menu Personalizado
 **************************************/
add_theme_support('menus');
register_nav_menus(array(
  // 'primary' => __('Menu topo', 'menu-topo'),
  // 'secondary' => __('Menu rodapé', 'menu-rodape'),
  // 'third' => __('Menu responsivo', 'menu-responsivo')
));


/************************************** 
Admin
 **************************************/
require_once get_template_directory() . '/core/painel/admin.php';


/************************************** 
Svg
 **************************************/
// require_once get_template_directory().'/inc/svg.php';

/************************************** 
Allow Svg
 **************************************/
/**
 * Allow SVG uploads for administrator users.
 *
 * @param array $upload_mimes Allowed mime types.
 *
 * @return mixed
 */
add_filter(
  'upload_mimes',
  function ($upload_mimes) {
    // By default, only administrator users are allowed to add SVGs.
    // To enable more user types edit or comment the lines below but beware of
    // the security risks if you allow any user to upload SVG files.
    if (! current_user_can('administrator')) {
      return $upload_mimes;
    }

    $upload_mimes['svg']  = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';

    return $upload_mimes;
  }
);

/**
 * Add SVG files mime check.
 *
 * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
 * @param string       $file Full path to the file.
 * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
 * @param string[]     $mimes Array of mime types keyed by their file extension regex.
 * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
 */
add_filter(
  'wp_check_filetype_and_ext',
  function ($wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime) {

    if (! $wp_check_filetype_and_ext['type']) {

      $check_filetype  = wp_check_filetype($filename, $mimes);
      $ext             = $check_filetype['ext'];
      $type            = $check_filetype['type'];
      $proper_filename = $filename;

      if ($type && 0 === strpos($type, 'image/') && 'svg' !== $ext) {
        $ext  = false;
        $type = false;
      }

      $wp_check_filetype_and_ext = compact('ext', 'type', 'proper_filename');
    }

    return $wp_check_filetype_and_ext;
  },
  10,
  5
);

/**************************************
// cortes de imagens
add_imagem_size('nome_do_corte0','width',height, array('center','center'));
 **************************************/
function configura_tamanho_imagens()
{
  add_image_size('logo_topo', 9999, 58, false);
  add_image_size('logo_rodape', 230, 9999, false);
  add_image_size('banner_imagem', 1920, 1280, array('center', 'center'));
  add_image_size('img_breadcrumb', 1920, 400, array('center', 'center'));
  add_image_size('principal_blog', 815, 9999, false, array('center', 'center'));
  add_image_size('blog_lista', 800, 1145, array('center', 'center'));
  add_image_size('img_destacada_projeto_square', 400, 300, array('center', 'center'));
  add_image_size('img_destacada_projeto_full', 1190, 700, array('center', 'center'));
  add_image_size('equipe', 480, 605, true);
  add_image_size('sobre-heading', 1149, 800, true);
  add_image_size('sobre-imagem', 500, 614, true);
  add_image_size('cliente-imagem', 200, 200, false);
  add_image_size('cliente-logo-depoimento', 211, 42, false);
  add_image_size('video-principal-bg', 1920, 865, true);
  add_image_size('servico-imagem', 620, 720, true);
}
add_action('after_setup_theme', 'configura_tamanho_imagens');



/************************************** 
Limita caracteres
<?php echo LimitarCaracteres(passar o texto, passar o limita que deseja);?>
 **************************************/
function LimitarCaracteres($frase, $quantidade)
{
  $frase = strip_tags($frase);
  // $frase = ereg_replace('[[:space:]]+', ' ', $frase);
  if (strlen($frase) >= $quantidade) {
    $frase = substr($frase, 0, strrpos(substr($frase, 0, $quantidade), ' ')) . '...';
  }
  return $frase;
}

/************************************** 
Limita pela quantidade de palavras do texto excerpt
<?php echo excerpt(passar o limite);?>
 **************************************/
function excerpt($limit)
{
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt) >= $limit) {
    array_pop($excerpt);
    $excerpt = implode(" ", $excerpt) . '...';
  } else {
    $excerpt = implode(" ", $excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
  return $excerpt;
}

/************************************** 
Limita pela quantidade de palavras do texto content
<?php echo content(passar o limite);?>
 **************************************/
function content($limit)
{
  $content = explode(' ', get_the_content(), $limit);
  if (count($content) >= $limit) {
    array_pop($content);
    $content = implode(" ", $content) . '...';
  } else {
    $content = implode(" ", $content);
  }
  $content = preg_replace('/[.+]/', '', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]>', $content);
  return $content;
}


/************************************** 
Paginção bootstrap
 **************************************/
require_once get_template_directory() . '/inc/wp_bootstrap_pagination.php';


/**************************************
 * Remove All Yoast HTML Comments
 * https://gist.github.com/paulcollett/4c81c4f6eb85334ba076
 **************************************/
add_action('wp_head', function () {
  ob_start(function ($o) {
    return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi', '', $o);
  });
}, ~PHP_INT_MAX);






/**************************************
 * Adiciona meta tags na header
 * Pop-up conscentimento de cookies
 **************************************/
// function add_meta_tags() {
//   echo '<script>
//   window.addEventListener("load", function(){
//   window.cookieconsent.initialise({
//     "palette": {
//       "popup": {
//         "background": "#edeff5",
//         "text": "#393939"
//       },
//       "button": {
//         "background": "#000"
//       }
//     },
//     "theme": "classic",
//     "position": "bottom-right",
//     "content": {
//       "message": "Usamos cookies para garantir que você obtenha a melhor experiência no nosso site.",
//       "dismiss": "Entendi!",
//       "link": "Leia mais…",
//       "href": "http://localhost/wordpress_base/www/politica-de-privacidade/"
//     }
//   })});
//   </script>';
//   }
//   add_action('wp_head', 'add_meta_tags');



/**************************************
 * Registro de sidebar
 **************************************/

if (function_exists('register_sidebar'))
  register_sidebar(array(
    'name'          => 'Sidebar Blog',
    'id'            => 'sidebar-blog',
    'description'   => 'Sidebar mostrada no blog',
    'class'         => '',
    // 'before_widget' => '<li id="%1$s" class="widget %2$s">',
    // 'after_widget'  => '</li>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>'
  ));


ob_end_clean();


/**************************************
 * Oculta barra adm


function hide_admin_bar() {
  // Oculta a barra de admin para usuários específicos ou em condições específicas
  return false;
}
add_filter('show_admin_bar', 'hide_admin_bar');
 **************************************/




/**************************************
  Usar wp_localize_script no functions.php para passar os dados para o JS
 **************************************/
function trendpro_enqueue_banner_script()
{
  if (is_front_page()) {
    wp_enqueue_script('trendpro-banner', get_template_directory_uri() . '/assets/js/banner.js', array('jquery'), '1.0', true);

    // Buscar o banner mais recente
    $args = array(
      'post_type'      => 'banners',
      'posts_per_page' => 1,
      'orderby'        => 'date',
      'order'          => 'DESC'
    );

    $banner_query = new WP_Query($args);

    $banner_data = array(
      'video_desktop' => '',
      'poster_desktop' => '',
      'video_mobile' => '',
      'poster_mobile' => '',
    );

    if ($banner_query->have_posts()) {
      while ($banner_query->have_posts()) {
        $banner_query->the_post();
        $post_id = get_the_ID();

        $banner_image = get_field('banner_image', $post_id);
        $banner_video_mp4 = get_field('banner_video_mp4', $post_id);
        $banner_image_mobile = get_field('banner_image_mobile', $post_id);
        $banner_video_mp4_mobile = get_field('banner_video_mp4_mobile', $post_id);

        $banner_data = array(
          'video_desktop' => !empty($banner_video_mp4) ? esc_url($banner_video_mp4) : '',
          'poster_desktop' => $banner_image && isset($banner_image['url']) ? esc_url($banner_image['url']) : '',
          'video_mobile' => !empty($banner_video_mp4_mobile) ? esc_url($banner_video_mp4_mobile) : '',
          'poster_mobile' => $banner_image_mobile && isset($banner_image_mobile['url']) ? esc_url($banner_image_mobile['url']) : '',
        );
      }
      wp_reset_postdata();
    }

    wp_localize_script('trendpro-banner', 'bannerData', $banner_data);
  }
}
add_action('wp_enqueue_scripts', 'trendpro_enqueue_banner_script');



// Este código define onde os arquivos JSON do ACF (Advanced Custom Fields) serão salvos e carregados no tema.
// Ele faz com que os campos personalizados exportados pelo ACF sejam armazenados na pasta 'acf-json' do tema,
// facilitando o versionamento e a portabilidade das configurações de campos personalizados.
// Filtro para definir o diretório de salvamento dos arquivos JSON do ACF
add_filter('acf/settings/save_json', function () {
  return get_stylesheet_directory() . '/acf-json/';
});

add_filter('acf/settings/load_json', function ($paths) {
  $paths[] = get_stylesheet_directory() . '/acf-json/';
  return $paths;
});


/**
 * Corrige URL da home nos breadcrumbs do Yoast SEO
 * 
 * Fix para problema onde o breadcrumb da home estava apontando para /backend/
 * ao invés da URL correta da home.
 */
function fix_breadcrumb_home_url($links)
{
  if (!is_array($links)) {
    return $links;
  }

  foreach ($links as $key => $link) {
    if (isset($link['url']) && strpos($link['url'], '/backend/') !== false) {
      $links[$key]['url'] = str_replace('/backend/', '/', $link['url']);
    }
  }

  return $links;
}
add_filter('wpseo_breadcrumb_links', 'fix_breadcrumb_home_url');


/**
 * Detectar senha incorreta e redirecionar com parâmetro
 * 
 * Na página de senha protegida, se a senha estiver incorreta, redireciona para a página com o parâmetro pwd_error=1
 */
function crafto_password_error_redirect()
{
  if (isset($_POST['post_password'])) {
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : 0;

    // Se não tem post_id, pega do referer
    if (!$post_id) {
      $referer = wp_get_referer();
      if (preg_match('/[?&]p=(\d+)/', $referer, $matches)) {
        $post_id = $matches[1];
      } else {
        // Pega ID da URL do referer
        $post_id = url_to_postid($referer);
      }
    }

    if ($post_id) {
      $post = get_post($post_id);
      $entered_password = $_POST['post_password'];

      // Verifica se a senha está correta
      if (!hash_equals($post->post_password, $entered_password)) {
        // Senha incorreta - redireciona com erro
        $redirect_url = add_query_arg('pwd_error', '1', get_permalink($post_id));
        wp_redirect($redirect_url);
        exit;
      }
    }
  }
}
add_action('login_form_postpass', 'crafto_password_error_redirect', 1);

/**
 * Sistema de Breadcrumbs Específicos por Página
 * 
 * Esta função verifica a prioridade das imagens de breadcrumb:
 * 1. Imagem específica da página (imagem_breadcrumb_pagina)
 * 2. Imagem destacada da página (post_thumbnail)
 * 3. Imagem padrão das opções do tema (imagem_breadcrumb)
 * 4. Fallback: imagem preta para tema dark
 */
function get_breadcrumb_image_url() {
    // Verificar se o ACF está ativo
    if (!function_exists('get_field')) {
        return '';
    }
    
    $breadcrumb_url = '';
    
    // 1. Verificar se existe imagem específica para a página atual
    if (is_singular()) {
        // Para posts, páginas e custom post types
        $page_specific_image = get_field('imagem_breadcrumb_pagina');
        if (!empty($page_specific_image)) {
            $size_breadcrumb = "img_breadcrumb";
            $imagem_breadcrumb = wp_get_attachment_image_src($page_specific_image, $size_breadcrumb);
            if (!empty($imagem_breadcrumb) && is_array($imagem_breadcrumb)) {
                $breadcrumb_url = esc_url($imagem_breadcrumb[0]);
            }
        }
    } elseif (is_tax() || is_category() || is_tag()) {
        // Para taxonomias, categorias e tags
        $term_id = get_queried_object_id();
        $page_specific_image = get_field('imagem_breadcrumb_pagina', 'term_' . $term_id);
        if (!empty($page_specific_image)) {
            $size_breadcrumb = "img_breadcrumb";
            $imagem_breadcrumb = wp_get_attachment_image_src($page_specific_image, $size_breadcrumb);
            if (!empty($imagem_breadcrumb) && is_array($imagem_breadcrumb)) {
                $breadcrumb_url = esc_url($imagem_breadcrumb[0]);
            }
        }
    } elseif (is_author()) {
        // Para páginas de autor
        $author_id = get_queried_object_id();
        $page_specific_image = get_field('imagem_breadcrumb_pagina', 'user_' . $author_id);
        if (!empty($page_specific_image)) {
            $size_breadcrumb = "img_breadcrumb";
            $imagem_breadcrumb = wp_get_attachment_image_src($page_specific_image, $size_breadcrumb);
            if (!empty($imagem_breadcrumb) && is_array($imagem_breadcrumb)) {
                $breadcrumb_url = esc_url($imagem_breadcrumb[0]);
            }
        }
    }
    
    // 2. Se não encontrou imagem específica, verificar imagem destacada (apenas para singular)
    if (empty($breadcrumb_url) && is_singular() && has_post_thumbnail()) {
        $breadcrumb_url = get_the_post_thumbnail_url(get_the_ID(), 'img_breadcrumb');
    }
    
    // 3. Se não encontrou imagem destacada, usar a padrão das opções do tema
    if (empty($breadcrumb_url)) {
        $attachment_breadcrumb_id = get_field('imagem_breadcrumb', 'option');
        if (!empty($attachment_breadcrumb_id)) {
            $size_breadcrumb = "img_breadcrumb";
            $imagem_breadcrumb = wp_get_attachment_image_src($attachment_breadcrumb_id, $size_breadcrumb);
            if (!empty($imagem_breadcrumb) && is_array($imagem_breadcrumb)) {
                $breadcrumb_url = esc_url($imagem_breadcrumb[0]);
            }
        }
    }
    
    // 4. Fallback final: imagem preta para tema dark
    if (empty($breadcrumb_url)) {
        $breadcrumb_url = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="1920" height="400" viewBox="0 0 1920 400"><rect width="1920" height="400" fill="#000000"/></svg>');
    }
    
    return $breadcrumb_url;
}