<?php
// Lógica para definir a imagem do breadcrumb
$imagem_breadcrumb_url = '';

// Se estiver em single post/CPT ou página e tiver imagem destacada
if ((is_single() || is_page()) && has_post_thumbnail()) {
    $imagem_breadcrumb_url = get_the_post_thumbnail_url(get_the_ID(), 'img_breadcrumb');
}
// Fallback para imagem padrão das opções do tema
else {
    $attachment_breadcrumb_id = get_field('imagem_breadcrumb', 'option');
    $size_breadcrumb = "img_breadcrumb";
    $imagem_breadcrumb = wp_get_attachment_image_src($attachment_breadcrumb_id, $size_breadcrumb);
    $imagem_breadcrumb_url = $imagem_breadcrumb[0] ?? '';
}

// Lógica para definir o título do breadcrumb
$titulo_breadcrumb = '';

if (is_front_page()) {
    $titulo_breadcrumb = get_bloginfo('name');
} elseif (is_home()) {
    $titulo_breadcrumb = 'Artigos recentes';
} elseif (is_single()) {
    $titulo_breadcrumb = get_the_title();
} elseif (is_page()) {
    $titulo_breadcrumb = get_the_title();
} elseif (is_post_type_archive('projetos')) {
    $titulo_breadcrumb = 'Cases de Sucesso';
} elseif (is_post_type_archive('servicos')) {
    $titulo_breadcrumb = 'Serviços';
} elseif (is_post_type_archive()) {
    $post_type = get_post_type();
    $post_type_object = get_post_type_object($post_type);
    $titulo_breadcrumb = $post_type_object->labels->name ?? 'Arquivo';
} elseif (is_category()) {
    $titulo_breadcrumb = single_cat_title('', false);
} elseif (is_tag()) {
    $titulo_breadcrumb = single_tag_title('', false);
} elseif (is_tax()) {
    $titulo_breadcrumb = single_term_title('', false);
} elseif (is_author()) {
    $titulo_breadcrumb = wp_title('', false);
} elseif (is_search()) {
    $titulo_breadcrumb = 'Você buscou "' . get_search_query() . '"';
} elseif (is_404()) {
    $titulo_breadcrumb = 'Página não encontrada';
} else {
    $titulo_breadcrumb = wp_title('', false);
}
?>

<section class="page-title-big-typography bg-dark-gray cover-background p-4" style="background-image: url(<?php echo esc_url($imagem_breadcrumb_url); ?>)">
    <div class="opacity-extra-medium bg-black"></div>

    <div class="container h-200px">
        <div class="row d-flex justify-content-center breadcrumb-normal position-relative text-center text-white pt-60px" data-anime='{ "el": "childs", "translateY": [20, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
            <div class="col-12">
                <?php if (function_exists('yoast_breadcrumb')) : ?>
                    <div class="breadcrumb-wrapper">
                        <?php yoast_breadcrumb('<nav class="breadcrumb-nav" aria-label="Navegação">', '</nav>'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row align-items-center justify-content-center mb-30px mt-10px">
            <div class="col-lg-6 col-md-8 position-relative page-title-extra-small text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <h4 class="primary-font text-white fw-700"><?php echo esc_html($titulo_breadcrumb); ?></h4>
            </div>
        </div>
    </div>
</section>