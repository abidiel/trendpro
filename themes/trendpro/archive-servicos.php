<?php get_header(); ?>

<!-- start page title -->
<?php
$attachment_breadcrumb_id = get_field('imagem_breadcrumb', 'option');
$size_breadcrumb = "img_breadcrumb"; // (thumbnail, medium, large, full or custom size)
$imagem_breadcrumb = wp_get_attachment_image_src($attachment_breadcrumb_id, $size_breadcrumb);
?>


<section class="ipad-top-space-margin page-title-big-typography bg-dark-gray cover-background background-position-center-bottom p-0" style="background-image: url(<?php echo $imagem_breadcrumb[0]; ?>)">
    <div class="container">
        <div class="row align-items-end justify-content-center small-screen md-small-screen sm-extra-small-screen pb-9">
            <div class="col-lg-6 col-md-8 position-relative page-title-extra-small text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <h4 class="mb-20px alt-font text-white fw-700">Serviços</h4>
                <!-- <h2 class="text-white mb-0 text-uppercase ls-3px fw-600">Conheça</h2> -->
            </div>
        </div>
        <div class="row d-flex justify-content-center breadcrumb text-center text-white pb-9" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <?php if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<ul class="breadcrumbs text-center">', '</ul>');
            } ?>
        </div>
    </div>
</section>
<!-- end page title -->


<!-- start section - Serviços -->
<section class="bg-dark-gray background-position-center-top overflow-hidden" id="servicos">
    <div class="container">
        <div class="row align-items-end mb-6">
            <div class="col-md-6 sm-mb-20px"
                data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block"><?php echo esc_html(get_field('services_subtitle', 41),); ?></span>
                <h3 class="text-white fw-600 mb-0"><?php echo esc_html(get_field('services_title', 41)); ?></h3>
            </div>
            <div class="col-md-5 offset-md-1 last-paragraph-no-margin"
                data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <p class="w-80 xl-w-85 lg-w-100 text-white fw-300"><?php echo esc_html(get_field('services_description', 41)); ?></p>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="col-12 filter-content">
            <ul class="portfolio-classic portfolio-wrapper grid-loading grid grid-4col xxl-grid-4col xl-grid-4col lg-grid-4col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center">
                <li class="grid-sizer"></li>

                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post();
                        get_post_format();
                        get_template_part('template-parts/list-servicos', null, array('post_id' => get_the_ID()));
                    endwhile; ?>
                <?php endif; ?>

            </ul>
        </div>
    </div>


</section>
<!-- end section -->



<?php get_footer(); ?>