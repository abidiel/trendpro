<?php get_header();
// Status: Ok, pronto.

get_template_part('template-parts/breadcrumbs');

?>


<!-- start section - AJUSTAR LOOP -->
<section class="bg-dark-gray background-position-center-top big-section overlap-height" style="background-image: url('images/demo-architecture-dotted-pattern.svg')">

    <div class="container">
        <div class="row">
            <div class="col-12 filter-content">
                <ul class="portfolio-boxed portfolio-wrapper grid-loading grid grid-3col grid-3col xxl-grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center">
                    <li class="grid-sizer"></li>


                    <?php
                    if (have_posts()) {
                        while (have_posts()) : the_post();
                            get_post_format();
                            get_template_part('template-parts/list-projetos', get_post_format());
                        endwhile;
                    }
                    wp_reset_query(); ?>



                </ul>
            </div>
        </div>
    </div>

</section>
<!-- end section -->





<?php get_footer(); ?>