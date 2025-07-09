<?php get_header();
// Status: Ok, pronto.

get_template_part('template-parts/breadcrumbs'); ?>


<!-- start section -->
<section class="position-relative overflow-hidden section-dark">
    <div class="container text-white">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6">
                <?php if (get_field('servico_imagem_principal')) : ?>
                    <img src="<?php echo esc_url(get_field('servico_imagem_principal')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php endif; ?>
            </div>
            <div class="col-lg-5 offset-lg-1 z-index-9 md-mt-35px" data-anime='{ "el": "childs", "translateX": [15, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <h3 class="fw-600 mb-40px md-mb-25px outside-box-left-15 md-outside-box-left-0 ls-minus-3px word-break-normal">
                    <?php if (get_field('servico_titulo')) : ?>
                        <?php echo esc_html(get_field('servico_titulo')); ?>
                    <?php endif; ?>
                </h3>
                <p class="lh-34 w-95 mb-30px lg-w-100">
                    <?php if (get_field('servico_paragrafo')) : ?>
                        <?php echo esc_html(get_field('servico_paragrafo')); ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- end section -->


<?php 
$content = get_the_content();
$content = trim($content);
if (!empty($content)) : 
?>
    <!-- start section -->
    <section class="bg-dark-gray background-position-center-top overflow-hidden"
        style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/demo-architecture-dotted-pattern.svg')">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="servico-content text-white">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
<?php endif; ?>


<?php get_footer(); ?>