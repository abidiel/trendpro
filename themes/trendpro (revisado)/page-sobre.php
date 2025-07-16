<?php get_header();
/* Template Name: Sobre */

get_template_part('template-parts/breadcrumbs'); ?>

<!-- start banner -->
<?php if (get_field('ativo_sobre_secao_1')): ?> 
<section class="p-0 position-relative overflow-hidden bg-dark-gray pt-5">
    <div class="container-fluid p-0 h-100 position-relative">
        <div class="row g-0">
            <div class="col-xl-4 col-lg-5 d-flex justify-content-center align-items-center ps-10 xxl-ps-6 xl-ps-4 md-ps-4 sm-ps-0 position-relative order-2 order-lg-1" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="vertical-title-center align-items-center justify-content-center flex-shrink-0 w-75px sm-w-50px">
                    <h1 class="title fs-15 alt-font text-white fw-700 text-uppercase ls-1px text-uppercase d-flex w-auto align-items-center m-0" data-fancy-text='{ "opacity": [0, 1], "translateY": [50, 0], "filter": ["blur(20px)", "blur(0px)"], "string": ["<?php echo esc_html(get_field('sobre_secao1_mini_titulo', 37)); ?>"], "duration": 400, "delay": 0, "speed": 50, "easing": "easeOutQuad" }'></h1>
                </div>
                <div class="border-start border-color-extra-medium-gray ps-40px sm-ps-20px position-relative z-index-9">
                    <h2 class="text-white fw-600 alt-font outside-box-right-10 xl-outside-box-right-15 lg-outside-box-right-20 md-me-0 sm-mb-0 ls-minus-3px"><?php echo esc_html(get_field('sobre_secao1_titulo', 37)); ?></h2>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 position-relative one-half-screen order-1 order-lg-2 md-mb-50px">
                <div class="overflow-hidden position-relative">
                    <div class="w-100" data-anime='{ "effect": "slide", "direction": "lr", "color": "#000", "duration": 1000, "delay": 0 }'>
                        <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('sobre_secao1_imagem', 37)['ID'], 'sobre-heading')); ?>" alt="" class="w-100 liquid-parallax" data-parallax-liquid="true" data-parallax-position="top" data-parallax-scale="1.05">
                        <!-- Overlay escuro adicionado aqui -->
                        <div class="position-absolute w-100 h-100 top-0px left-0px bg-black-transparent opacity-full-dark"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- end banner -->

<!-- start section  -->
<?php if (get_field('ativo_sobre_secao_2')): ?> 
<section class="bg-dark-gray">
    <div class="container">
        <div class="row mb-6 sm-mb-50px">
            <div class="col-md-12 text-center text-md-start" data-anime='{"opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="fs-140 xxl-fs-100 sm-fs-60 fw-600 text-white alt-font ls-minus-8px sm-ls-minus-2px" data-bottom-top="transform: translate3d(-50px, 0px, 0px);" data-top-bottom="transform: translate3d(50px, 0px, 0px);"><?php echo esc_html(get_field('sobre_sessao2_palavras_destaque_1', 37)); ?></div>
            </div>
            <div class="col-12">
                <div class="row align-items-center align-items-lg-end" data-bottom-top="transform: translate3d(-30px, 0px, 0px);" data-top-bottom="transform: translate3d(30px, 0px, 0px);">
                    <div class="col-lg-7 col-md-6 text-center text-md-start" data-anime='{"opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="fs-120 xxl-fs-100 sm-fs-60 fw-600 text-white alt-font ls-minus-8px sm-ls-minus-2px"><?php echo esc_html(get_field('sobre_sessao2_palavras_destaque_2', 37)); ?></div>
                    </div>
                    <div class="col-lg-5 last-paragraph-no-margin md-mt-30px" data-anime='{"opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <p class="w-95 md-w-80 mx-auto text-center text-lg-start sm-w-100"><?php echo esc_html(get_field('sobre_sessao2_paragrafo', 37)); ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<?php endif; ?>
<!-- end section -->

<!-- start section -->
<?php if (get_field('ativo_sobre_secao_3')): ?> 
<section class="pt-0 bg-dark-gray">
    <div class="container">
        <div class="row mb-17 sm-mb-30px">
            <div class="col-lg-6 position-relative">
                <div class="row align-items-center position-relative md-mb-15" data-anime='{ "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="col-md-5 sm-mb-30px" data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                        <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('sobre_secao3_imagem_1', 37)['ID'], 'full')); ?>" alt="<?php echo esc_attr(get_field('sobre_secao3_imagem_1', 37)['alt']); ?>" alt="" />
                    </div>
                    <div class="col-lg-7 col-md-7 sm-mb-30px text-end" data-bottom-top="transform: translateY(-30px)" data-top-bottom="transform: translateY(30px)">
                        <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('sobre_secao3_imagem_3', 37)['ID'], 'full')); ?>" alt="<?php echo esc_attr(get_field('sobre_secao3_imagem_2', 37)['alt']); ?>" alt="" class="box-shadow-quadruple-large md-w-80 sm-w-100" />
                    </div>
                    <div class="w-50 sm-w-100 overflow-hidden position-absolute sm-position-relative left-140px bottom-minus-200px sm-bottom-0px sm-left-0px p-0 sm-ps-15px sm-pe-15px" data-shadow-animation="true" data-animation-delay="100" data-bottom-top="transform: translateY(20px)" data-top-bottom="transform: translateY(-20px)">
                        <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('sobre_secao3_imagem_2', 37)['ID'], 'full')); ?>" alt="<?php echo esc_attr(get_field('sobre_secao3_imagem_3', 37)['alt']); ?>" alt="" class="box-shadow-quadruple-large w-100" />
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 offset-xl-1 md-mt-20 sm-mt-0" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="mb-10px">
                    <span class="w-25px h-1px d-inline-block bg-base-color me-5px align-middle"></span>
                    <span class="text-gradient-base-color fs-15 alt-font fw-700 ls-05px text-uppercase d-inline-block align-middle"><?php echo esc_html(get_field('sobre_secao3_mini_titulo', 37)); ?></span>
                </div>
                <h4 class="text-white alt-font fw-600 ls-minus-2px mb-20px"><?php echo esc_html(get_field('sobre_secao3_titulo', 37)); ?></h4>
                <p class="w-90 md-w-100 mb-35px sm-mb-20px"><?php echo wp_kses_post(get_field('sobre_secao3_texto', 37)); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row position-relative clients-style-08 d-flex" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

            <?php
            $client_logos = get_field('client_logos', 7);
            if ($client_logos): ?>
                <div class="col swiper text-center feather-shadow" data-slider-options='{ "slidesPerView": 2, "spaceBetween":0, "speed": 3000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": true, "autoplay": { "delay":0, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 6 }, "992": { "slidesPerView": 4 }, "768": { "slidesPerView": 3 } }, "effect": "slide" }'>
                    <div class="swiper-wrapper marquee-slide align-items-center align-content-center">
                        <?php foreach ($client_logos as $logo): ?>
                            <div class="swiper-slide d-flex justify-content-center align-items-center">
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt'] ? $logo['alt'] : 'Logo do Cliente'); ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
<?php endif; ?>
<!-- end section -->

<!-- start section -->
<?php if (get_field('ativo_sobre_secao_4')): ?> 
<section class="pb-0 bg-dark-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 md-mb-20px sm-mb-0" data-anime='{ "el": "childs", "translateY": [15, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <h3 class="text-white fw-600 ls-minus-2px alt-font"><?php echo esc_html(get_field('sobre_secao4_titulo', 37)); ?></h3>
            </div>
            <div class="col-lg-7" data-anime='{ "el": "childs", "translateY": [15, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>

                <?php if (have_rows('sobre_secao4_topicos', 37)) : ?>
                    <?php while (have_rows('sobre_secao4_topicos', 37)) : the_row(); ?>
                        <div class="row topico-item">
                            <div class="col-md-5">
                                <div class="fs-19 fw-600 text-white w-90 xl-w-100 sm-mb-10px">
                                    <?php echo esc_html(get_sub_field('field_65660cf08f7d4')); ?>
                                </div>
                            </div>
                            <div class="col-md-7 last-paragraph-no-margin">
                                <p><?php echo esc_html(get_sub_field('field_65660d048f7d5')); ?></p>
                            </div>
                        </div>
                        <div class="separator-line-1px border-bottom border-color-extra-medium-gray mt-35px mb-35px"></div>
                    <?php endwhile; ?>
                <?php endif; ?>





            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- end section -->

<!-- start section -->
<?php if (get_field('ativo_sobre_secao_5')): ?> 
<section class="bg-nero-grey">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center mb-3 sm-mb-6">
            <div class="col-md-6"
                data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase d-inline-block"><?php echo esc_html(get_field('equipe_titulo', 37)); ?></span>
                <h4 class="text-white fw-600">Time Trend Pro</h4>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 mb-7 align-items-center justify-content-center"
            data-anime='{ "el": "childs", "perspective": [1200,1200], "scale": [1.05, 1], "rotateX": [30, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>



            <?php
            // Obtém o ID da página Quem Somos
            $quem_somos_id = get_page_by_path('sobre')->ID;

            if (have_rows('equipe_membros', $quem_somos_id)) : ?>
                <?php while (have_rows('equipe_membros', $quem_somos_id)) : the_row(); ?>


                    <!-- start team member item -->
                    <div class="col team-style-08 border-radius-6px md-mb-30px">
                        <figure class="mb-0 position-relative overflow-hidden">
                            <?php
                            $foto = get_sub_field('foto');
                            if ($foto) :
                                echo wp_get_attachment_image($foto['ID'], 'equipe', false, array(
                                    'class' => 'img-fluid w-100 mb-15px',
                                    'loading' => 'lazy'
                                ));
                            endif;
                            ?>
                            <figcaption
                                class="w-100 h-100 d-flex align-items-end p-13 lg-p-8 bg-gradient-dark-gray-transparent">
                                <div class="w-100">
                                    <span class="team-member-name fs-17 fw-500 text-white d-block"><?php echo esc_html(get_sub_field('nome')); ?></span>
                                    <span class="member-designation fs-14 lh-20 text-white d-block"><?php echo wp_kses_post(get_sub_field('cargo')); ?></span>
                                </div>
                                <div class="social-icon d-flex flex-column flex-shrink-1">
                                    <a href="<?php echo esc_url(get_sub_field('instagram')); ?>" target="_blank"
                                        class="text-dark-gray"><i
                                            class="fa-brands fa-instagram icon-small text-base-color"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                    <!-- end team member item -->



                <?php endwhile; ?>
            <?php endif; ?>



        </div>

    </div>
</section>
<?php endif; ?>
<!-- end section -->







<?php get_footer(); ?>