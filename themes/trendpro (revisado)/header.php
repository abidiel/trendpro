<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title>Teste - <?php wp_title(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#ff2a9f">
    <meta name="msapplication-navbutton-color" content="#ff2a9f">
    <meta name="apple-mobile-web-app-status-bar-style" content="#ff2a9f">

    <!-- google fonts preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>
<?php flush(); ?>

<body <?php body_class('bg-dark-gray'); ?> data-mobile-nav-style="classic">



    <!-- start header -->
    <header>
        <!-- start navigation -->
        <nav class="navbar navbar-expand-lg header-dark header-transparent bg-transparent header-reverse-back-scroll glass-effect">
            <div class="container-fluid">
                <div class="col-auto col-lg-2 me-lg-0 me-auto d-none d-lg-flex">
                    <div class="header-icon">
                        <div class="header-social-icon icon social-text-style-01">
                            <?php if (get_field('youtube', 'option')): ?>
                                <a class="instagram" href="<?php echo esc_url(get_field('youtube', 'option')); ?>" target="_blank"><i
                                        class="fa-brands fa-instagram icon-extra-medium text-white"></i></a>
                            <?php endif; ?>

                            <?php if (get_field('instagram', 'option')): ?>
                                <a class="youtube" href="<?php echo esc_url(get_field('instagram', 'option')); ?>" target="_blank"><i
                                        class="fa-brands fa-youtube icon-extra-medium text-white"></i></a>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="col-auto">

                    <?php if (get_field('logo_topo', 'option')) :

                        $attachment_id = get_field('logo_topo', 'option');
                        $size = "logo_topo"; // (thumbnail, medium, large, full or custom size)
                        $logo_topo = wp_get_attachment_image_src($attachment_id, $size); ?>

                        <a class="navbar-brand" href="<?php echo site_url(); ?>">
                            <img src="<?php echo $logo_topo[0]; ?>" alt="Logo" class="default-logo">
                            <img src="<?php echo $logo_topo[0]; ?>" alt="Logo" class="mobile-logo">
                        </a>

                    <?php else : ?>
                        <span class="logo-default"><?php echo get_bloginfo('name'); ?></span>
                    <?php endif; ?>

                </div>
                <div class="col-auto col-lg-2 text-end">
                    <div class="header-icon header-push-button hamburger-push-button icon">
                        <div class="push-button">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end navigation -->
        <!-- start hamburger menu -->
        <div class="push-menu hamburger-nav hamburger-menu-simple header-dark bg-dark-gray background-position-center-top"
            >
            <span class="close-menu text-dark-gray text-dark-gray-hover bg-white"><i
                    class="fa-solid fa-xmark"></i></span>
            <div class="container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-lg-8 col-md-6 order-2 order-md-1 d-none d-md-inline-block">
                        <a class="hamburger-logo d-inline-block" href="https://trendpro.com.br/">
                            <img src="<?php echo $logo_topo[0]; ?>"
                                class="w-auto" alt="">
                        </a>
                        <div class="row mt-22 md-mt-30px sm-mt-25px align-items-start">
                            <div class="col-lg-10 text-center text-sm-start order-2 order-sm-1">
                                <h6 class="fw-200 text-white d-inline-block align-middle mb-0">Vamos construir juntos o
                                    sucesso do <span class="text-white fw-700">seu negócio?</span></h6>
                            </div>
                            <div class="col-lg-7 order-1 order-sm-2 xs-mb-15px mt-20px">
                                <a href="https://api.whatsapp.com/send?phone=55<?php echo str_replace(array('(', ')', ' ', '-'), array('', '', '', ''), get_field('whatsapp', 'option')); ?>&text=Gostaria%20de%20saber%20mais%20sobre%20os%20servi%C3%A7os%20da%20Trend%20Pro."
                                    target="_blank"
                                    class="btn border-1 btn-transparent-base-color border-color-white btn-extra-large btn-rounded with-rounded mt-20px sm-mt-0 text-white">Falar
                                    com Especialista<span class="icon-extra-medium"><i
                                            class="fa-brands fa-whatsapp"></i></span></a>
                            </div>
                            <!-- start column -->
                            <!-- end column -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 offset-md-1 order-1 order-md-2 text-center text-md-start">
                        <div class="hamburger-menu menu-list-wrapper" data-scroll-options='{ "theme": "light" }'>
                            <ul class="menu-item-list alt-font ls-minus-05px p-0">

                                <li class="menu-item"><a href="<?php the_permalink('7'); ?>" class="nav-link">Início</a>
                                <li>
                                <li class="menu-item"><a href="<?php the_permalink('37'); ?>" class="nav-link">Sobre</a></li>
                                <li class="menu-item"><a href="<?php the_permalink('41'); ?>" class="nav-link">Serviços</a></li>
                                <li class="menu-item"><a href="<?php the_permalink('39'); ?>" class="nav-link">Cases</a></li>
                                <li class="menu-item"><a href="<?php the_permalink('43'); ?>" class="nav-link">Blog</a></li>
                                <li class="menu-item"><a href="<?php the_permalink('46'); ?>" class="nav-link">Contato</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-12 menu-text border-top border-color-transparent-white-light d-none d-md-inline-block text-center pt-3 pb-3 order-3"> 
                            <h6 class="fw-400 d-inline-block align-middle mb-0">Let's build something <span class="text-white">great together</span></h6>
                            <div class="separator-line-1px d-inline-block align-middle ms-20px me-20px mt-5px w-70px bg-base-color"></div>
                            <a href="mailto:hello@crafto.com" class="text-base-color fs-26 fw-500 d-inline-block align-middle">hello@crafto.com</a>
                        </div> -->
                </div>
            </div>
        </div>
        <!-- end hamburger menu -->
    </header>
    <!-- end header -->