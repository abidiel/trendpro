<?php
/* Template Name: Página inicial */
get_header();


/**
 * Template para exibir o banner de vídeo usando o CPT Banners
 */

// Argumentos para buscar o banner mais recente
$args = array(
    'post_type'      => 'banners',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC'
);

// Consulta para obter o banner
$banner_query = new WP_Query($args);

// Verifica se encontrou algum banner
if ($banner_query->have_posts()) :
    while ($banner_query->have_posts()) : $banner_query->the_post();
        $post_id = get_the_ID();

        // Busca os campos do ACF para este banner com sanitização adequada
        $banner_image = get_field('banner_image', $post_id);
        $banner_video_mp4 = esc_url(get_field('banner_video_mp4', $post_id));
        $banner_image_mobile = get_field('banner_image_mobile', $post_id);
        $banner_video_mp4_mobile = esc_url(get_field('banner_video_mp4_mobile', $post_id));
        $banner_text = wp_kses_post(get_field('banner_text', $post_id));
        $banner_text_subtitle = wp_kses_post(get_field('banner_text_subtitle', $post_id));

        // Define a URL da imagem de fundo (poster) com sanitização
        $poster_url = '';
        if ($banner_image && isset($banner_image['url'])) {
            $poster_url = esc_url($banner_image['url']);
        }
?>
        <!-- start page title -->
        <section
            class="page-title-background-video position-relative overflow-hidden full-screen d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center h-100">
                    <div class="col-xl-7 col-lg-8 col-md-10 position-relative text-white text-center text-md-start"
                        data-anime='{ "el": "childs", "translateX": [100, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div>
                            <span class="fs-20 opacity-6 mb-25px sm-mb-15px d-inline-block fw-300"><?php echo $banner_text_subtitle; ?></span>
                        </div>
                        <h1 class="alt-font xl-w-100 text-shadow-double-large ls-minus-2px fs-60"><?php echo $banner_text; ?></h1>

                        <a href="https://api.whatsapp.com/send?phone=55<?php echo esc_attr(str_replace(array('(', ')', ' ', '-'), array('', '', '', ''), get_field('whatsapp', 'option'))); ?>&text=Gostaria%20de%20saber%20mais%20sobre%20os%20servi%C3%A7os%20da%20Trend%20Pro."
                            target="_blank"
                            class="btn border-1 btn-transparent-base-color border-color-white btn-extra-large btn-rounded with-rounded mt-20px sm-mt-0 text-white">Falar
                            com Especialista testee A<span class="icon-extra-medium"><i
                                    class="fa-brands fa-whatsapp"></i></span></a>
                    </div>
                </div>
            </div>

            <?php if (!empty($banner_video_mp4)): ?>
                <video loop autoplay playsinline muted class="html-video" poster="<?php echo esc_attr($poster_url); ?>" id="dynamic-video">
                    <source id="video-source" type="video/mp4" src="<?php echo $banner_video_mp4; ?>" />
                </video>
            <?php elseif (!empty($poster_url)): ?>
                <!-- Se não houver vídeo, exibe apenas a imagem de fundo -->
                <div class="background-image" style="background-image: url('<?php echo esc_attr($poster_url); ?>');"></div>
            <?php endif; ?>
        </section>
        <!-- end page title -->
<?php
    endwhile;
    wp_reset_postdata(); // Restaura os dados originais do post
endif;
?>




<!-- start section - Clientes -->
<section class="bg-dark-gray background-position-center-top pb-0"
    style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/dotted-pattern.svg')">
    <div class="container-fluid">
        <div class="row position-relative clients-style-08 d-flex" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

            <?php
            $client_logos = get_field('client_logos');
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
<!-- end section -->

<!-- start section - Quem somos-->
<section class="bg-dark-gray background-position-center-top overlap-height"
    style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/dotted-pattern.svg')" id="sobre">
    <div class="container overlap-gap-section">
        <div class="row mb-7 sm-mb-0">
            <div class="col-lg-4 md-mb-50px xs-mb-30px"
                data-anime='{ "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block"><?php echo esc_html(get_field('conheca_titulo_secao')); ?></span>
                <h4 class="text-white mb-30px pb-5px fw-600"><?php echo esc_html(get_field('conheca_titulo_principal')); ?></h4>
                <div class="text-white mb-20px fw-300 pb-5px">
                    <?php echo wp_kses_post(get_field('conheca_descricao_1')); ?>
                </div>
                <span>
                    <span class="btn-text text-white fs-20"><?php echo esc_html(get_field('conheca_texto_cta')); ?></span>
                    <span class="btn-icon text-base-color"><i class="fa-solid fa-arrow-right fs-20 ps-"></i></span>
                </span>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="row row-cols-auto row-cols-sm-2"
                    data-anime='{ "el": "childs", "rotateZ": [5, 0], "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>

                    <?php
                    if (have_rows('conheca_etapas')):
                        $i = 0;
                        while (have_rows('conheca_etapas')): the_row();
                            $i++;
                    ?>

                            <!-- start features box item -->
                            <div class="col mb-30px">
                                <div class="feature-box text-start ps-30px pe-30px">
                                    <div class="feature-box-icon position-absolute left-0px top-0px">
                                        <h1 class="fs-110 text-outline opacity-6 fw-800"><?php echo esc_html(get_sub_field('etapa_numero')); ?></h1>
                                    </div>
                                    <div
                                        class="feature-box-content last-paragraph-no-margin pt-30 md-pt-24 sm-pt-30 xs-pt-55px">
                                        <span
                                            class="text-white d-inline-block fs-19 fw-700 mb-5px position-relative">A<?php echo esc_html(get_sub_field('etapa_titulo')); ?></span>
                                        <p class="text-white fw-100"><?php echo esc_html(get_sub_field('etapa_descricao')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end features box item -->

                    <?php
                        endwhile;
                    endif;
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- start section - Video manifesto -->
<section class="p-0 bg-dark-gray background-position-center-top overflow-hidden"
    style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/dotted-pattern.svg')">
    <div class="container-fluid p-0">
        <div class="row g-0 align-items-center h-500px md-h-450px sm-h-auto"
            data-bottom-top="transform: translate3d(-30px, 0px, 0px);"
            data-top-bottom="transform: translate3d(-110px, 0px, 0px);">
            <div class="col-md-6 cover-background h-100 sm-h-400px xs-h-350px"
                style="background-image: url('<?php echo esc_url(get_field('eventcover_image')); ?>')">
            </div>
            <div class="col-lg-4 col-md-6 position-relative bg-nero-grey h-100 sm-h-350px sm-pb-8 overflow-hidden">
                <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                    <a href="<?php echo esc_url(get_field('eventcover_video')); ?>"
                        target="_blank"
                        class="position-relative border border-2 border-color-base-color d-inline-block text-center rounded-circle video-icon-box video-icon-large mb-10px popup-youtube">
                        <span>
                            <span class="video-icon">
                                <i class="fa-solid fa-play text-base-color"></i>
                            </span>
                        </span>
                    </a>
                    <h2 class="fs-32 alt-font text-center w-50 xl-w-80 ls-minus-2px"><?php echo esc_html(get_field('eventcover_title')); ?> <span
                            class="text-white fw-500"><?php echo esc_html(get_field('eventcover_subtitle')); ?></span></h2>
                    <div class="position-absolute bottom-minus-20px left-0px right-0px text-center w-100 fs-100 sm-fs-100 xs-fs-110 ls-minus-3px opacity-2 word-break-normal text-outline text-outline-color-white alt-font fw-700"
                        data-bottom-top="transform:scale(1.6, 1.6)" data-top-bottom="transform:scale(1, 1)">
                        Trend Pro</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- start section - Serviços -->
<section class="bg-dark-gray background-position-center-top overflow-hidden" id="servicos">
    <div class="container">
        <div class="row align-items-end mb-6">
            <div class="col-md-6 sm-mb-20px"
                data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block"><?php echo esc_html(get_field('services_subtitle', 41)); ?></span>
                <h3 class="text-white fw-600 mb-0"><?php echo esc_html(get_field('services_title', 41)); ?></h3>
            </div>
            <div class="col-md-5 offset-md-1 last-paragraph-no-margin"
                data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <p class="w-80 xl-w-85 lg-w-100 text-white fw-300"><?php echo esc_html(get_field('services_description', 41)); ?></p>
            </div>
        </div>
        <div class="row align-items-center mb-9">
            <div class="col-md-12 position-relative"
                data-anime='{ "translateX": [150, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <div class="outside-box-right-30 sm-outside-box-right-0">
                    <div class="swiper slider-three-slide" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 35, "loop": true, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "pagination": { "el": ".slider-four-slide-pagination-1", "clickable": true, "dynamicBullets": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 3 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>


                        <?php
                        $args = array(
                            'post_type' => 'servicos',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );

                        $services_query = new WP_Query($args);

                        // Primeiro, construa um array com todos os serviços
                        if ($services_query->have_posts()) {
                            while ($services_query->have_posts()) {
                                $services_query->the_post();

                                $services_array[] = array(
                                    'id' => get_the_ID(),
                                    'title' => get_the_title(),
                                    'icon' => get_field('service_icon'),
                                    'description' => get_field('service_short_description'),
                                    'permalink' => get_permalink()
                                );
                            }
                            wp_reset_postdata();
                        }
                        ?>

                        <div class="swiper-wrapper">
                            <?php
                            // Primeira passagem pelos serviços
                            if ($services_query->have_posts()) :
                                while ($services_query->have_posts()) : $services_query->the_post();
                            ?>

                                    <!-- start content carousal item -->
                                    <div class="swiper-slide">
                                        <a href="<?php the_permalink(); ?>" class="banner-link-wrap">
                                            <div class="interactive-banner-style-06">
                                                <div class="interactive-banners-image">
                                                    <?php if (get_field('service_featured_image')) : ?>
                                                        <img src="<?php echo esc_url(get_field('service_featured_image')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                    <?php else : ?>
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                    <?php endif; ?>

                                                    <div class="overlay-bg bg-gradient-dark-transparent opacity-light"></div>
                                                    <span class="banners-icon text-white icon-hover-base-color position-absolute top-60px left-60px lg-top-30px lg-left-30px">
                                                        <?php echo wp_kses_post(get_field('service_icon')); ?>
                                                    </span>
                                                </div>
                                                <div class="interactive-banners-content p-60px lg-p-30px">
                                                    <div class="h-100 w-100 last-paragraph-no-margin">
                                                        <span class="fs-22 d-block text-white mb-10px fw-500"><?php echo esc_html(get_the_title()); ?></span>
                                                        <p class="interactive-banners-content-text w-95 lg-w-100 text-white fw-300">
                                                            <?php echo esc_html(get_field('service_short_description')); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="box-overlay bg-gradient-dark-transparent"></div>
                                                <a href="<?php the_permalink(); ?>" class="box-link"></a>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- end content carousal item -->



                                <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;

                            // Segunda passagem pelos serviços (resetando a query)
                            $services_query->rewind_posts();

                            if ($services_query->have_posts()) :
                                while ($services_query->have_posts()) : $services_query->the_post();
                                ?>
                                    <!-- start content carousal item -->
                                    <div class="swiper-slide">
                                        <a href="<?php the_permalink(); ?>" class="banner-link-wrap">
                                            <div class="interactive-banner-style-06">
                                                <div class="interactive-banners-image">
                                                    <?php if (get_field('service_featured_image')) : ?>
                                                        <img src="<?php echo esc_url(get_field('service_featured_image')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                    <?php else : ?>
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                    <?php endif; ?>

                                                    <div class="overlay-bg bg-gradient-dark-transparent opacity-light"></div>
                                                    <span class="banners-icon text-white icon-hover-base-color position-absolute top-60px left-60px lg-top-30px lg-left-30px">
                                                        <?php echo wp_kses_post(get_field('service_icon')); ?>
                                                    </span>
                                                </div>
                                                <div class="interactive-banners-content p-60px lg-p-30px">
                                                    <div class="h-100 w-100 last-paragraph-no-margin">
                                                        <span class="fs-22 d-block text-white mb-10px fw-500"><?php echo esc_html(get_the_title()); ?></span>
                                                        <p class="interactive-banners-content-text w-95 lg-w-100 text-white fw-300">
                                                            <?php echo esc_html(get_field('service_short_description')); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="box-overlay bg-gradient-dark-transparent"></div>
                                                <a href="<?php the_permalink(); ?>" class="box-link"></a>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- end content carousal item -->
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>




                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- end section -->


<!-- start section - Cases Titulo -->
<section class="bg-nero-grey overlap-height background-position-center-top"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/dotted-pattern.svg')" id="cases">
    <div class="container overlap-gap-section">
        <div class="row align-items-end mb-6">
            <div class="col-md-5 last-paragraph-no-margin"
                data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <p class="w-80 xl-w-85 lg-w-100 text-white fw-300"><?php echo wp_kses_post(get_field('projetos_descricao')); ?></p>
            </div>
            <div class="col-md-6 sm-mb-20px text-right offset-md-1"
                data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block"><?php echo esc_html(get_field('projetos_titulo')); ?></span>
                <h3 class="text-white fw-600 mb-0 fs-30"><?php echo esc_html(get_field('projetos_subtitulo')); ?></h3>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- start section - Cases lista e depoimentos -->
<section class="bg-dark-gray background-position-center-top pb-0"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/dotted-pattern.svg')">
    <div class="container">
        <div class="row mb-8 xs-mb-10 overlap-section">
            <div class="col-12 position-relative">
                <div
                    class="vertical-title-center align-items-center position-absolute top-0px left-15px bg-base-color p-10px xs-p-5px h-270px sm-h-190px z-index-9 w-50px xs-w-40px">
                    <div class="title fs-14 ls-2px text-dark-gray fw-700 text-uppercase">Projetos Recentes</div>
                </div>
                <div class="swiper position-relative text-slider-style-04" data-slider-options='{ "autoHeight": true, "loop": true, "allowTouchMove": true, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "effect": "fade" }'>
                    <div class="swiper-wrapper">

                        <?php

                        $args = array(
                            'post_type' => 'projetos',
                            'showposts' => 3,
                            'post_status' => 'publish'
                        );

                        // query
                        $the_query = new WP_Query($args);


                        if ($the_query->have_posts()) :
                            while ($the_query->have_posts()) : $the_query->the_post();
                                get_template_part('template-parts/list-projetos-home');
                            endwhile;
                        else :

                        endif; ?>

                    </div>
                    <!-- start slider navigation -->
                    <div class="slider-one-slide-prev-1 icon-small swiper-button-prev slider-navigation-style-07 bg-dark-gray text-white box-shadow-small"><i class="bi bi-arrow-down-left"></i></div>
                    <div class="slider-one-slide-next-1 icon-small swiper-button-next slider-navigation-style-07 bg-dark-gray text-white box-shadow-small"><i class="bi bi-arrow-up-right"></i></div>
                    <!-- end slider navigation -->
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10 testimonials-style-10 position-relative ps-4 pe-4 swiper-number-pagination-progress"
                data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="swiper magic-cursor pt-9 pb-6"
                    data-slider-options='{"slidesPerView": 1, "loop": true, "keyboard": { "enabled": true, "onlyInViewport": true }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "pagination": { "el": ".swiper-number-line-pagination", "clickable": true }, "navigation": { "nextEl": ".swiper-button-next-nav", "prevEl": ".swiper-button-previous-nav", "effect": "fade" } }'
                    data-swiper-number-pagination-progress="true">
                    <div class="swiper-wrapper">


                        <?php

                        $args = array(
                            'post_type' => 'depoimentos',
                            'showposts' => -1,
                            'post_status' => 'publish'
                        );

                        // query
                        $the_query = new WP_Query($args);


                        if ($the_query->have_posts()) :
                            while ($the_query->have_posts()) : $the_query->the_post();
                                get_template_part('template-parts/list-depoimentos-home');
                            endwhile;
                        else :

                        endif; ?>


                    </div>
                </div>
                <!-- start slider pagination -->
                <div class="swiper-pagination-wrapper d-flex align-items-center justify-content-center">
                    <div class="number-prev fs-15 fw-600"></div>
                    <div class="swiper-pagination-progress bg-medium-gray">
                        <span class="swiper-progress"></span>
                    </div>
                    <div class="number-next fs-15 fw-600"></div>
                </div>
                <!-- end slider pagination -->
                <!-- start slider navigation -->
                <div class="swiper-button-previous-nav swiper-button-prev icon-extra-medium left-0px"><i
                        class="bi bi-arrow-left icon-extra-medium text-white"></i></div>
                <div class="swiper-button-next-nav swiper-button-next icon-extra-medium right-0px"><i
                        class="bi bi-arrow-right icon-extra-medium text-white"></i></div>
                <!-- end slider pagination -->
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- start section - Frase -->
<section class="half-section bg-dark-gray background-position-center-top overflow-hidden position-relative"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/dotted-pattern.svg')">
    <!-- start marquees -->
    <div class="fw-600 alt-font fs-180 md-fs-150 sm-fs-130 xs-fs-100 text-charcoal ls-minus-7px md-ls-minus-5px xs-ls-minus-2px text-nowrap text-center mb-20px"
        data-bottom-top="transform: translate3d(-170px, 0px, 0px) scale(0.8, 0.8);"
        data-top-bottom="transform: translate3d(-200px, 0px, 0px) scale(1.8, 1.8);">
        <span class="text-outline opacity-6">conteúdo</span> que <span class="text-outline opacity-6">gera</span>
        resultado
    </div>
    <!-- end marquees -->
    <!-- <div class="position-absolute right-18 md-right-0 top-minus-50px sm-top-minus-20px sm-w-220px xs-w-190px z-index-9" data-anime='{ "translateY": [0, 0], "scale": [0.8, 1], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <img src="images/demo-architecture-home-11.png" class="animation-rotation" alt="">
                <div class="absolute-middle-center w-100 z-index-minus-1"><img src="images/demo-architecture-home-12.png" alt=""></div> 
            </div> -->
</section>
<!-- end section -->

<!-- start section - Equipe -->
<section class="bg-dark-gray background-position-center-top position-relative pt-0 align-items-center"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/dotted-pattern.svg')" id="equipe">
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
    <div
        class="position-absolute bottom-minus-50px md-bottom-minus-30px sm-bottom-minus-25px xs-bottom-minus-15px left-0px right-0px text-center w-100 fs-200 lg-fs-160 md-fs-140 sm-fs-120 xs-fs-90 fw-600 text-nero-grey ls-minus-4px">
        trend pro</div>
</section>
<!-- end section -->

<!-- start section -->
<section class="bg-nero-grey background-position-center-top position-relative" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/dotted-pattern.svg')">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center mb-2 sm-mb-5">
            <div class="col-md-6" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase d-inline-block"><?php echo esc_html(get_field('paragrafo_sessao_blog', 7)); ?></span>
                <h4 class="text-white fw-600"><?php echo esc_html(get_field('titulo_sessao_blog', 7)); ?></h4>
            </div>
        </div>
        <div class="row blog-metro mb-6">
            <div class="col-12">
                <ul class="blog-metro blog-wrapper grid-loading blog-grid grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <li class="grid-sizer"></li>

                    <?php

                    $args = array(
                        'post_type' => 'post',
                        'showposts' => 3,
                        'post_status' => 'publish'
                    );

                    // query
                    $the_query = new WP_Query($args);


                    if ($the_query->have_posts()) :
                        while ($the_query->have_posts()) : $the_query->the_post();
                            get_template_part('template-parts/list-blog');
                        endwhile;
                    else :

                    endif; ?>



                </ul>
            </div>
            <div class="text-center">
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn btn-large btn-base-color text-light btn-hover-animation-switch btn-round-edge btn-box-shadow mt-3">Ver todos os artigos</a>
            </div>
        </div>
    </div>

</section>
<!-- end section -->


<?php get_footer(); ?>