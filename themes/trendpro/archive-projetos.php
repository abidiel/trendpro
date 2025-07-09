<?php
/* Template Name: Projetos */

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
                <h4 class="mb-20px alt-font text-white fw-700">Projetos</h4>
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
<section class="bg-dark-gray background-position-center-top big-section overlap-height">
    <div class="container">
        <div class="row align-items-end mb-6">
            <div class="col-md-6 sm-mb-20px"
                data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block"><?php echo esc_html(get_field('cases_subtitle', 39)); ?></span>
                <h3 class="text-white fw-600 mb-0"><?php echo esc_html(get_field('cases_title', 39) ); ?></h3>
            </div>
            <div class="col-md-5 offset-md-1 last-paragraph-no-margin"
                data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <p class="w-80 xl-w-85 lg-w-100 text-white fw-300"><?php echo esc_html(get_field('cases_description', 39)); ?></p>
            </div>
        </div>
    </div>


    <div class="container" id="projetos">
        <div class="row">
            <div class="col-12 text-center">
                <!-- filter navigation -->
                <ul class="portfolio-filter nav nav-tabs text-start border-0 fw-500 pb-5">
                    <li class="nav active"><a data-filter="*" href="#">Ver tudo</a></li>
                    <?php
                    $terms = get_terms(
                        array(
                            'taxonomy' => 'projetos-categoria',
                            'hide_empty' => true,
                            'orderby'   => 'menu_order',
                            'order' => 'ASC',
                            'parent' => 0,
                            'showposts' => 30
                        )
                    );
                    foreach ($terms as $term) {
                        $class = (is_category($term->name)) ? 'active' : ''; // assign this class if we're on the same category page as $term->name
                        echo '<li class="nav ' . $class . '"> <a data-filter=".' . $term->slug . '" href="#">' . $term->name . '</li>';
                    }
                    ?>
                </ul>
                <!-- end filter navigation -->

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 filter-content">
                <ul class="portfolio-boxed portfolio-wrapper grid-loading grid grid-4col xxl-grid-4col xl-grid-4col lg-grid-4col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center">
                    <li class="grid-sizer"></li>

                    <?php
                    $args = array(
                        'posts_per_page' => -1,
                        'orderby'   => 'menu_order',
                        'order' => 'ASC',
                        'post_type' => array( // (string / array) - use post types. Retrieves posts by Post Types, default value is 'post';
                            'projetos', // - Custom Post Types (e.g. movies)
                        ),
                    );

                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()) {

                        while ($the_query->have_posts()) : $the_query->the_post();
                            get_post_format();
                            get_template_part('template-parts/list-projetos', get_post_format());
                        endwhile;
                    }
                    wp_reset_postdata();
                    wp_reset_query(); ?>


                </ul>
            </div>
        </div>
    </div>

</section>
<!-- end section -->


<?php
get_footer();
?>