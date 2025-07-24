<?php get_header();

get_template_part('template-parts/breadcrumbs'); ?>

<!-- Page Content -->
<section id="page-content" class="bg-dark-gray">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading-text heading-section">
                    <?php echo wp_kses_post(get_the_content()); ?>    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end: Page Content -->


<?php get_footer(); ?>