<?php get_header();

get_template_part('template-parts/breadcrumbs'); ?>

<!-- start section -->
<section class="pb-0 ficha-tecnica">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-5 col-xl-7 col-lg-10 text-center">

                <?php if (get_field('imagem_introducao')) : ?>
                    <img class="mb-30px" src="<?php echo esc_url(get_field('imagem_introducao')['sizes']['cliente-imagem']); ?>" alt="">
                <?php endif; ?>



                <?php if (get_field('texto_introducao')) : ?>
                    <span class="fw-300 mb-7 fs-26 w-90 sm-w-100 mx-auto d-inline-block"><?php echo wp_kses_post(get_field('texto_introducao')); ?></span>
                <?php endif; ?>

                <div class="row row-cols-1 row-cols-sm-3 align-items-center text-center">

                    <div class="col border-end xs-border-end-0 xs-pb-25px border-color-transparent-white-light">
                        <span class="text-uppercase fs-15 text-base-color fw-600">Cliente</span>
                        <span class="d-block text-white lh-24"><?php echo esc_html(get_the_title()); ?></span>
                    </div>

                    <?php
                    $term_list = wp_get_post_terms(get_the_ID(), 'projetos-categoria', array("fields" => "all"));
                    if (!empty($term_list) && !is_wp_error($term_list)) :
                        $first_term = $term_list[0]; ?>
                        <div class="col border-end xs-border-end-0 xs-pb-25px border-color-transparent-white-light">
                            <span class="text-uppercase fs-15 text-base-color fw-600">Categoria</span>
                            <a href="<?php echo esc_url(get_term_link($first_term)); ?>" class="d-block text-white lh-24">
                                <?php echo esc_html($first_term->name); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (have_rows('caracteristicas_do_projeto')) : ?>
                        <?php while (have_rows('caracteristicas_do_projeto')) : the_row(); ?>

                            <div class="col border-end xs-border-end-0 xs-pb-25px border-color-transparent-white-light">

                                <?php if (get_sub_field('titulo_caracteristicas_do_projeto')) : ?>
                                    <span class="text-uppercase fs-15 text-base-color fw-600"><?php echo esc_html(get_sub_field('titulo_caracteristicas_do_projeto')); ?></span>
                                <?php endif; ?>

                                <?php if (get_sub_field('descricao_caracteristicas_do_projeto')) : ?>
                                    <span class="d-block text-white lh-24"><?php echo esc_html(get_sub_field('descricao_caracteristicas_do_projeto')); ?></span>
                                <?php endif; ?>

                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<?php
$link_youtube = get_field('link_youtube');
$link_youtube_vertical = get_field('link_youtube_vertical');

if ($link_youtube || $link_youtube_vertical) :
?>
    <!-- start section -->
    <section>
        <div class="row align-items-center justify-content-center">
            <div class="col-12 position-relative h-750px md-h-600px sm-h-350px border-radius-6px border border-color-transparent position-relative" data-parallax-background-ratio="0.5" style="background-image: url('<?php if (get_field('imagem_background_video')) : ?><?php echo esc_url(get_field('imagem_background_video')['sizes']['video-principal-bg']); ?><?php endif; ?>');">
                <div class="absolute-middle-center z-index-9">
                    <a href="<?php echo esc_url($link_youtube); ?>"
                        class="video-link text-center bg-white rounded-circle video-icon-box video-icon-extra-large popup-youtube slide-up-animation"
                        data-desktop="<?php echo esc_url($link_youtube); ?>"
                        data-mobile="<?php echo esc_url($link_youtube_vertical); ?>">
                        <span>
                            <span class="video-icon bg-base-color">
                                <i class="feather icon-feather-play text-white"></i>
                                <span class="video-icon-sonar">
                                    <span class="video-icon-sonar-bfr bg-white"></span>
                                </span>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
<?php endif; ?>


<?php
$content = get_the_content();
$content = trim($content);
if (!empty($content)) :
?>
    <!-- start section -->
    <section class="bg-dark-gray background-position-center-top overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="servico-content text-white">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
<?php endif; ?>

<!-- start section -->
<?php
$featured_posts = get_field('depoimento_do_projeto');
if ($featured_posts) : ?>
    <section class="bg-dark-gray background-position-center-top overlap-height overflow-visible pt-0">
        <div class="container">

            <div class="row overlap-gap-section justify-content-center">

                <div class="col-10">

                    <ul>
                        <?php foreach ($featured_posts as $post) :

                            // Setup this post for WP functions (variable must be named $post).
                            setup_postdata($post);

                            get_template_part('template-parts/list-depoimentos');

                        ?>

                        <?php endforeach; ?>
                    </ul>

                </div>

            </div>
        </div>
    </section>

    <?php
    // Reset the global post object so that the rest of the page works correctly.
    wp_reset_postdata(); ?>
<?php endif; ?>
<!-- end section -->

<?php
// Pegar a categoria do projeto atual
$current_categories = wp_get_post_terms(get_the_ID(), 'projetos-categoria', array("fields" => "slugs"));

if (!empty($current_categories)) {
    // Query para buscar projetos relacionados
    $args = array(
        'post_type' => 'projetos',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'projetos-categoria',
                'field' => 'slug',
                'terms' => $current_categories[0] // Pega a primeira categoria
            )
        )
    );

    $related_projects = new WP_Query($args);

    if ($related_projects->have_posts()) :
        $project_count = $related_projects->found_posts;

        // Define offset para centralizar quando há menos de 3 projetos
        if ($project_count == 1) {
            $offset_class = 'offset-lg-4'; // Centraliza 1 card (4 colunas de cada lado em grid de 12)
        } elseif ($project_count == 2) {
            $offset_class = 'offset-lg-2'; // Centraliza 2 cards (2 colunas de cada lado)
        } else {
            $offset_class = '';
        }
?>
        <section class="bg-nero-grey overlap-height background-position-center-top">
            <div class="container">
                <div class="row justify-content-center mb-1 sm-mb-7">
                    <div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase d-inline-block">Você pode gostar também</span>
                        <h4 class="text-white fw-600">Projetos relacionados</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 <?php echo $offset_class; ?>">
                        <ul class="portfolio-boxed portfolio-wrapper grid-loading grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                            <li class="grid-sizer"></li>

                            <?php
                            while ($related_projects->have_posts()) : $related_projects->the_post();
                                get_template_part('template-parts/list-projetos');
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
<?php
        wp_reset_postdata();
    endif;
}
?>


<?php
get_footer(); ?>