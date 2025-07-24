<?php get_header();
// Status: Ok, pronto.

get_template_part('template-parts/breadcrumbs'); ?>



<!-- start section -->
<?php if (get_field('ativo_servico_single_secao_1')): ?>
    <section class="bg-dark-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 position-relative">
                    <div class="row align-items-center position-relative md-mb-15" data-anime='{ "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="col-md-5 sm-mb-30px" data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                            <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('servico_secao1_imagem_1')['ID'], 'full')); ?>" alt="<?php echo esc_attr(get_field('servico_secao1_imagem_1')['alt']); ?>" />
                        </div>
                        <div class="col-xl-5 offset-xl-2 col-lg-5 offset-lg-2 col-md-7 sm-mb-30px text-end" data-bottom-top="transform: translateY(-30px)" data-top-bottom="transform: translateY(30px)">
                            <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('servico_secao1_imagem_3')['ID'], 'full')); ?>" alt="<?php echo esc_attr(get_field('servico_secao1_imagem_3')['alt']); ?>" class="box-shadow-quadruple-large md-w-80 sm-w-100" />
                        </div>
                        <div class="w-50 sm-w-100 overflow-hidden position-absolute sm-position-relative left-140px bottom-minus-200px sm-bottom-0px sm-left-0px p-0 sm-ps-15px sm-pe-15px" data-shadow-animation="true" data-animation-delay="100" data-bottom-top="transform: translateY(20px)" data-top-bottom="transform: translateY(-20px)">
                            <img src="<?php echo esc_url(wp_get_attachment_image_url(get_field('servico_secao1_imagem_2')['ID'], 'full')); ?>" alt="<?php echo esc_attr(get_field('servico_secao1_imagem_2')['alt']); ?>" class="box-shadow-quadruple-large w-100" />
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 offset-xl-1 md-mt-20 sm-mt-0" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="mb-10px">
                        <span class="w-25px h-1px d-inline-block bg-base-color me-5px align-middle"></span>
                        <span class="text-gradient-trendpro fs-15 alt-font fw-700 ls-05px text-uppercase d-inline-block align-middle"><?php echo esc_html(get_field('servico_secao1_mini_titulo')); ?></span>
                    </div>
                    <h4 class="text-white alt-font fw-600 ls-minus-2px mb-20px"><?php echo esc_html(get_field('servico_secao1_titulo')); ?></h4>
                    <p class="w-90 md-w-100 mb-35px sm-mb-20px"><?php echo wp_kses_post(get_field('servico_secao1_texto')); ?>
                    </p>
                    <a href="<?php the_permalink('46'); ?>" class="btn btn-large btn-base-color btn-switch-text btn-box-shadow border-1 left-icon me-10px sm-mb-15px sm-mt-15px">
                        <span>
                            <span><i class="feather icon-feather-edit text-white"></i></span>
                            <span class="btn-double-text text-white fw-600" data-text="Entrar em contato">Entrar em contato</span>
                        </span>
                    </a>
                    <a href="<?php the_permalink('41'); ?>" class="btn btn-large btn-transparent-light-gray border-1 btn-switch-text left-icon sm-mb-15px sm-mt-15px">
                        <span>
                            <span><i class="feather icon-feather-briefcase text-white"></i></span>
                            <span class="btn-double-text text-white" data-text="Mais serviços">Mais serviços</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- end section -->


<!-- start section -->
<?php if (get_field('ativo_servico_single_secao_2')): ?>
    <section class="cover-background">
        <div class="container">
            <div class="row justify-content-center mb-3">
                <div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="alt-font text-gradient-trendpro fw-600 d-inline-block ls-1px"><?php echo esc_html(get_field('servico_secao2_mini_titulo')); ?></span>
                    <h3 class="alt-font text-white fw-600 ls-minus-1px shadow-none" data-shadow-animation="true" data-animation-delay="1000"><?php echo esc_html(get_field('servico_secao2_titulo')); ?></h3>
                </div>
            </div>

            <?php if (have_rows('servico_secao2_cards')): ?>
                <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center" data-anime='{ "el": "childs", "rotateZ": [5, 0], "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <?php while (have_rows('servico_secao2_cards')): the_row(); ?>

                        <!-- start features box item -->
                        <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                            <div class="feature-box bg-black box-shadow-quadruple-large box-shadow-quadruple-large-hover justify-content-start overflow-hidden pt-18 pb-18 ps-14 pe-14 lg-p-12 h-100 last-paragraph-no-margin">
                                <!-- Ícone SVG -->
                                <?php
                                $icone_svg = get_sub_field('icone_svg');
                                if ($icone_svg):
                                ?>

                                    <div class="feature-box-icon">
                                        <img src="<?php echo esc_url($icone_svg['url']); ?>" alt="<?php echo esc_attr($icone_svg['alt']); ?>" class="w-50px mb-20px">
                                    </div>
                                <?php endif; ?>

                                <div class="feature-box-content">
                                    <span class="d-inline-block alt-font text-gradient-trendpro fw-700 mb-5px fs-18"><?php echo esc_html(get_sub_field('titulo')); ?></span>
                                    <p class="text-white"><?php echo wp_kses_post(get_sub_field('texto')); ?></p>
                                </div>
                                <div class="feature-box-overlay"></div>
                            </div>
                        </div>
                        <!-- end features box item -->
                    <?php endwhile; ?>
                <?php endif; ?>

                </div>
        </div>
    </section>
<?php endif; ?>
<!-- end section -->

<!-- start section -->
<?php if (get_field('ativo_servico_single_secao_3')): ?>
    <section>
        <div class="box-layout">
            <section class="p-0 bg-very-light-gray border-radius-6px position-relative overflow-hidden">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6 p-8 lg-p-5 sm-pt-30px sm-pb-30px sm-ps-20px sm-pe-20px position-relative" data-anime='{ "el": "childs", "translateY": [0, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-servico-1.svg" class="position-absolute top-minus-30px left-minus-40px w-160px opacity-case-destaque" alt="" style="z-index: 999;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-servico-2.svg" class="position-absolute bottom-40px right-minus-40px w-160px opacity-case-destaque" alt="" style="z-index: 999;">
                            <span class="ls-2px text-uppercase text-gradient-trendpro fw-500 lh-22 mb-15px d-block">Case em <span class="d-inline-block border-2 border-bottom border-color-transparent-base-color fw-800">destaque</span></span>

                            <?php
                            // Buscar o projeto relacionado para o título
                            $projeto_relacionado = get_field('projeto_relacionado');

                            if ($projeto_relacionado) :
                                // Verificar se é array ou objeto
                                if (is_array($projeto_relacionado)) {
                                    $projeto_id = $projeto_relacionado[0]->ID; // Primeiro item se for array
                                } else {
                                    $projeto_id = $projeto_relacionado->ID; // Se for objeto único
                                }
                            ?>
                                <h3 class="fw-600 text-dark alt-font ls-minus-1px w-90 xxl-w-100 mb-20px">
                                    <?php echo esc_html(get_the_title($projeto_id)); ?>
                                </h3>
                            <?php endif; ?>

                            <?php
                            // Campo local da seção 3 - Texto Projeto Destaque
                            if (get_field('texto_projeto_destaque')) : ?>
                                <p class="w-70 xl-w-100"><?php echo wp_kses_post(get_field('texto_projeto_destaque')); ?></p>
                            <?php endif; ?>

                            <a href="<?php echo esc_url(get_permalink($projeto_id)); ?>" class="btn btn-large btn-base-color btn-switch-text btn-box-shadow border-1 left-icon me-10px sm-mb-15px sm-mt-15px" style="">
                                <span>
                                    <span><i class="fa-solid fa-angles-right icon-small text-white"></i></span>
                                    <span class="btn-double-text text-white fw-600" data-text="Ver case completo">Ver case completo</span>
                                </span>
                            </a>


                        </div>

                        <?php
                        // Buscar dados do projeto relacionado para a imagem e links
                        if ($projeto_relacionado) :
                            // Verificar se é array ou objeto e obter o ID correto
                            if (is_array($projeto_relacionado)) {
                                $projeto_id = $projeto_relacionado[0]->ID; // Primeiro item se for array
                            } else {
                                $projeto_id = $projeto_relacionado->ID; // Se for objeto único
                            }

                            $imagem_background = get_field('imagem_background_video', $projeto_id);
                            $link_youtube = get_field('link_youtube', $projeto_id);
                            $link_youtube_vertical = get_field('link_youtube_vertical', $projeto_id);

                            // URL da imagem de background
                            $background_url = $imagem_background ? esc_url($imagem_background['url']) : 'https://placehold.co/785x620';
                        ?>

                            <div class="col-12 col-md-6 cover-background sm-h-400px position-relative" style="background-image: url(<?php echo $background_url; ?>); z-index: 1;">
                                <?php if ($link_youtube && $link_youtube_vertical) : ?>
                                    <a href="<?php echo esc_url($link_youtube); ?>"
                                        class="absolute-middle-center text-center rounded-circle video-icon-box video-icon-extra-large popup-youtube"
                                        data-desktop="<?php echo esc_url($link_youtube); ?>"
                                        data-mobile="<?php echo esc_url($link_youtube_vertical); ?>"
                                        id="video-link">
                                        <span>
                                            <span class="video-icon bg-white">
                                                <i class="fa-solid fa-play text-dark-gray"></i>
                                                <span class="video-icon-sonar">
                                                    <span class="video-icon-sonar-bfr border border-2 border-color-white"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>
                                <?php elseif ($link_youtube) : ?>
                                    <a href="<?php echo esc_url($link_youtube); ?>" class="absolute-middle-center text-center rounded-circle video-icon-box video-icon-extra-large popup-youtube">
                                        <span>
                                            <span class="video-icon bg-white">
                                                <i class="fa-solid fa-play text-dark-gray"></i>
                                                <span class="video-icon-sonar">
                                                    <span class="video-icon-sonar-bfr border border-2 border-color-white"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>

                        <?php endif; ?>

                    </div>
                </div>
            </section>
        </div>
    </section>

<?php endif; ?>
<!-- end section -->

<!-- start section -->
<?php if (get_field('ativo_servico_single_secao_4')): ?>
    <section>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <?php
                $servico_s4_imagem = get_field('servico_s4_imagem');
                if ($servico_s4_imagem):
                    $imagem_url = wp_get_attachment_image_url($servico_s4_imagem['ID'], 'servico-imagem');
                ?>
                    <div class="col-lg-6 md-mb-50px position-relative" data-anime='{ "effect": "slide", "color": "#262b35", "direction":"lr", "easing": "easeOutQuad", "delay":50}'>
                        <figure class="position-relative mb-0 overflow-hidden border-radius-6px">
                            <img src="<?php echo esc_url($imagem_url); ?>"
                                alt="<?php echo esc_attr($servico_s4_imagem['alt']); ?>"
                                class="w-100"
                                loading="lazy">
                        </figure>
                    </div>

                <?php endif; ?>

                <div class="col-xl-5 offset-xl-1 col-lg-6" data-anime='{ "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <?php if (get_field('servico_s4_mini_titulo')): ?>
                        <span class="fs-20 d-inline-block mb-15px text-base-color"><?php echo esc_html(get_field('servico_s4_mini_titulo')); ?></span>
                    <?php endif; ?>

                    <?php if (!empty(get_field('servico_s4_titulo'))): ?>
                        <h2 class="alt-font fw-500 text-white ls-minus-1px shadow-none sm-w-85" data-shadow-animation="true" data-animation-delay="700"><?php echo wp_kses_post(get_field('servico_s4_titulo')); ?></span></h2>
                    <?php endif; ?>

                    <?php if (!empty(get_field('servico_s4_texto'))): ?>
                        <p class="w-80 md-w-100"><?php echo wp_kses_post(get_field('servico_s4_texto')); ?></p>

                    <?php endif; ?>


                    <div class="mb-35px">
                        <?php
                        $servico_s4_link = get_field('servico_s4_link');
                        if ($servico_s4_link):
                        ?>
                            <a href="<?php echo esc_url($servico_s4_link['url']); ?>"
                                target="<?php echo esc_attr($servico_s4_link['target']); ?>"
                                class="btn btn-small btn-transparent-light-gray border-1 btn-switch-text left-icon sm-mb-15px sm-mt-15px">
                                <span>
                                    <span><i class="feather icon-feather-arrow-right text-white"></i></span>
                                    <span class="btn-double-text text-white" data-text="<?php echo esc_attr($servico_s4_link['title']); ?>"><?php echo esc_html($servico_s4_link['title']); ?></span>
                                </span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php the_permalink('46'); ?>" class="btn btn-small btn-base-color btn-switch-text btn-box-shadow border-1 left-icon me-10px sm-mb-15px sm-mt-15px">
                            <span>
                                <span><i class="feather icon-feather-edit text-white"></i></span>
                                <span class="btn-double-text text-white fw-600" data-text="Entrar em contato">Entrar em contato</span>
                            </span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- end section -->





<?php
$content = get_the_content();
$content = trim($content);
if (!empty($content)) :
?>
    <!-- start section -->
    <section class="bg-dark-gray background-position-center-top overflow-hidden d-none"
        style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/demo-architecture-dotted-pattern.svg')">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="servico-content text-white">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
<?php endif; ?>



<?php if (get_field('ativo_servico_single_secao_5')): ?>
    <?php
    // Pegar o slug do serviço atual para buscar projetos da categoria correspondente
    $current_service_slug = get_post_field('post_name', get_the_ID());

    // Query para buscar projetos da categoria com o mesmo slug do serviço
    $args = array(
        'post_type' => 'projetos',
        'posts_per_page' => 3,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'projetos-categoria',
                'field' => 'slug',
                'terms' => $current_service_slug
            )
        )
    );

    $related_projects = new WP_Query($args);

    if ($related_projects->have_posts()) :
        $project_count = $related_projects->found_posts;

        // Define offset para centralizar quando há menos de 3 projetos
        if ($project_count == 1) {
            $offset_class = 'offset-lg-4'; // Centraliza 1 card
        } elseif ($project_count == 2) {
            $offset_class = 'offset-lg-2'; // Centraliza 2 cards
        } else {
            $offset_class = '';
        }
    ?>
        <section class="bg-nero-grey overlap-height background-position-center-top">
            <div class="container">
                <div class="row justify-content-center mb-1 sm-mb-7">
                    <div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase d-inline-block">Confira nossos trabalhos</span>
                        <h4 class="text-white fw-600">Projetos de <?php the_title(); ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 <?php echo $offset_class; ?>">
                        <ul class="portfolio-boxed portfolio-wrapper grid-loading grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                            <li class="grid-sizer"></li>

                            <?php
                            while ($related_projects->have_posts()) : $related_projects->the_post();
                                get_template_part('template-parts/list-projetos');
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php
        wp_reset_postdata();
    endif;
    ?>
<?php endif; ?>



<?php get_footer(); ?>