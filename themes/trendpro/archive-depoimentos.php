<?php
/* Template Name: Depoimentos */

get_header();
?>


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
                <h4 class="mb-20px alt-font text-white fw-500">Depoimentos</h4>
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


<!-- start section -->
<section class="bg-dark-gray background-position-center-top big-section overlap-height" style="background-image: url('images/demo-architecture-dotted-pattern.svg')">
    <div class="container overlap-gap-section">
        <div class="row mb-11">
            <?php
            $image_depoimentos = get_field('imagem_depoimentos');
            if (!empty($image_depoimentos)) : ?>
                <div class="col-lg-7 position-relative">
                    <div class="row align-items-center position-relative">
                        <div class="text-center sm-mb-30px" data-shadow-animation="true">
                            <img class="sm-w-100" src="<?php echo esc_url($image_depoimentos['url']); ?>" alt="<?php echo esc_attr($image_depoimentos['alt']); ?>" />
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-lg-5 md-mt-13 sm-mt-10 align-content-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-10px d-block"><?php the_field('subtitulo_depoimentos'); ?></span>
                <h4 class="text-white fw-600"><?php the_field('titulo_depoimentos'); ?></h4>
                <p class="w-90 md-w-100"><?php the_field('texto_depoimentos'); ?></p>

            </div>
        </div>
    </div>

    <div class="container" id="depoimentos">
        <div class="row">
            <div class="position-relative appear anime-complete text-center" data-anime="{ &quot;opacity&quot;: [0,1], &quot;duration&quot;: 600, &quot;delay&quot;: 0, &quot;staggervalue&quot;: 300, &quot;easing&quot;: &quot;easeOutQuad&quot; }" style="">
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block">O que falam sobre nós</span>
                <h4 class="text-white fw-600 mb-20px">Depoimentos</h4>
            </div>
        </div>

        <?php
        $args = array(
            'posts_per_page' => -1,
            'orderby'   => 'menu_order',
            'order' => 'ASC',
            'post_type' => array( // (string / array) - use post types. Retrieves posts by Post Types, default value is 'post';
                'depoimentos', // - Custom Post Types (e.g. movies)
            ),
        );

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {

            while ($the_query->have_posts()) : $the_query->the_post();
                get_post_format();
                get_template_part('template-parts/list-depoimentos', get_post_format());
            endwhile;
        }
        wp_reset_postdata();
        wp_reset_query(); ?>


    </div>

</section>
<!-- end section -->


<?php
get_footer();
?>