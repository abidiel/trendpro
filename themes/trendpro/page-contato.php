<?php
/* Template Name: Contato */

get_header();
if (function_exists('wpcf7_enqueue_scripts')) {
    wpcf7_enqueue_scripts();
}
if (function_exists('wpcf7_enqueue_styles')) {
    wpcf7_enqueue_styles();
}
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<!-- start section -->
<section class="position-relative z-index-9 lg-pb-50px">
    <div class="container">
        <div class="row">
            <?php if (get_field('titulo_contato_heading')) : ?>
                <div class="col-lg-6 md-mb-40px sm-mb-20px" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 300, "staggervalue": 300, "easing": "easeInQuad" }'>
                    <h1 class="fs-80 lg-fs-80 sm-fs-60 alt-font text-white text-shadow-extra-large ls-minus-3px lg-ls-minus-2px m-0"><?php echo esc_html(get_field('titulo_contato_heading')); ?></h1>
                </div>
            <?php endif; ?>

            <?php if (get_field('subtitulo_contato_heading')) : ?>
                <div class="col-xl-5 col-lg-6 offset-xl-1" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="fs-18">
                        <?php echo wp_kses_post(get_field('subtitulo_contato_heading')); ?>
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>
</section>

<!-- end section -->

<!-- start section -->
<?php if (get_field('imagem_contato_heading')) : ?>
    <section class="p-0 mt-minus-50px lg-mt-0">
        <div class="container-fluid position-relative py-0">
            <div class="row">
                <div class="col-12">
                    <div class="one-third-screen sm-small-screen" data-parallax-background-ratio="0.5" style="background-image: url(<?php echo esc_url(get_field('imagem_contato_heading')['sizes']['banner_imagem']); ?>)"></div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>


<!-- end section -->


<!-- start section -->
<section>
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-3 row-cols-sm-2 justify-content-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <div class="col md-mb-30px text-center text-sm-start">
                <span class="d-block">E-mail</span>
                <?php if (get_field('email', 'option')) : ?>
                    <a href="mailto:<?php echo esc_attr(get_field('email', 'option')); ?>" class="fs-22 ls-minus-05px text-white btn btn-link-gradient expand text-transform-none">
                        <?php echo esc_html(get_field('email', 'option')); ?>
                        <span class="bg-white"></span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="col md-mb-30px text-center text-sm-start">
                <span class="d-block">WhatsApp</span>
                <?php if (get_field('whatsapp', 'option')) : ?>
                    <a href="https://api.whatsapp.com/send?l=pt&phone=55<?php echo str_replace(array('(', ')', ' ', '-'), array('', '', '', ''), get_field('whatsapp', 'option')); ?>&text=Gostaria%20de%20saber%20mais%20sobre%20os%20servi%C3%A7os%20da%20Trend%20Pro." target="_blank" class="fs-22 ls-minus-05px text-white btn btn-link-gradient expand text-transform-none">
                        <?php echo esc_html(get_field('whatsapp', 'option')); ?>
                        <span class="bg-white"></span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="col text-center text-sm-start">
                <span class="d-block">Localização</span>
                <?php if (get_field('cidade', 'option')) : ?>
                    <span class="fs-22 ls-minus-05px text-white btn btn-link-gradient expand text-transform-none">
                        <?php echo esc_html(get_field('cidade', 'option')); ?>
                        <span class="bg-white"></span>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- end section -->


<!-- start section -->
<section class="pt-2 pb-0">
    <div class="container">
        <div class="row">
            
            <div class="col-xl-5 col-lg-6">
                <?php if (get_field('titulo_contato_formulario')) : ?>
                    <h2 class="text-white alt-font mb-10 lg-mb-50px sm-mb-30px ls-minus-1px" data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'><?php echo esc_html(get_field('titulo_contato_formulario')); ?></h2>
                <?php endif; ?>

                <?php if (get_field('subtitulo_contato_formulario')) : ?>
                    <div class="lg-mb-50px" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <?php echo wp_kses_post(get_field('subtitulo_contato_formulario')); ?>
                    </div>
                <?php endif; ?>


                <div class="elements-social social-icon-style-09" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <ul class="small-icon light">
                        <?php if (get_field('instagram', 'option')) : ?>
                            <li><a class="instagram" href="<?php echo esc_url(get_field('instagram', 'option')); ?>" target="_blank"><i class="fa-brands fa-instagram"></i><span></span></a></li>
                        <?php endif; ?>

                        <?php if (get_field('youtube', 'option')) : ?>
                            <li><a class="youtube" href="<?php echo esc_url(get_field('youtube', 'option')); ?>" target="_blank"><i class="fa-brands fa-youtube"></i><span></span></a></li>
                        <?php endif; ?>

                        <?php if (get_field('linkedin', 'option')) : ?>
                            <li><a class="linkedin" href="<?php echo esc_url(get_field('linkedin', 'option')); ?>" target="_blank"><i class="fa-brands fa-linkedin"></i><span></span></a></li>
                        <?php endif; ?>

                        <?php if (get_field('facebook', 'option')) : ?>
                            <li><a class="facebook" href="<?php echo esc_url(get_field('facebook', 'option')); ?>" target="_blank"><i class="fa-brands fa-facebook"></i><span></span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>


            </div>



            <div class="col-lg-5 offset-lg-1 contact-form-style-03" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <?php if (get_field('titulo_formulario_contato')) : ?>
                    <h6 class="text-white mb-20px ls-minus-05px"><?php echo esc_html(get_field('titulo_formulario_contato')); ?></h6>
                <?php endif; ?>

                <?php echo do_shortcode('[contact-form-7 id="dc199ee" title="Formulário de contato 1" html_class="contact-form-style-03"]'); ?>
            </div>



        </div>
    </div>
</section>
<!-- end section -->

<?php
get_footer();
?>