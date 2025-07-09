<?php get_header();

get_template_part('template-parts/breadcrumbs'); ?>




<!-- start section -->
<section class="pb-0 ficha-tecnica">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-5 col-xl-7 col-lg-10 text-center">

                <?php if (get_field('imagem_introducao')) : ?>
                    <img class="mb-30px" src="<?php echo esc_url(get_field('imagem_introducao')['sizes']['cliente-imagem']); ?>" alt="">
                <?php endif; ?>



                <?php if (get_field('texto_introducao')) : ?>
                    <span class="fw-300 mb-7 fs-26 w-90 sm-w-100 mx-auto d-inline-block"><?php echo wp_kses_post(get_field('texto_introducao')); ?></span>
                <?php endif; ?>
                <div class="row row-cols-1 row-cols-sm-3 align-items-center text-center">

                    <div class="col border-end xs-border-end-0 xs-pb-25px border-color-transparent-white-light">
                        <span class="text-uppercase fs-15">Cliente</span>
                        <span class="d-block text-white lh-24"><?php the_title(); ?></span>
                    </div>

                    <?php
                    $term_list = wp_get_post_terms(get_the_ID(), 'projetos-categoria', array("fields" => "all"));
                    if (!empty($term_list) && !is_wp_error($term_list)) :
                        $first_term = $term_list[0]; ?>
                        <div class="col border-end xs-border-end-0 xs-pb-25px border-color-transparent-white-light">
                            <span class="text-uppercase fs-15">Categoria</span>
                            <a href="<?php echo esc_url(get_term_link($first_term)); ?>" class="d-block text-white lh-24">
                                <?php echo esc_html($first_term->name); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (have_rows('caracteristicas_do_projeto')) : ?>
                        <?php while (have_rows('caracteristicas_do_projeto')) : the_row(); ?>

                            <div class="col border-end xs-border-end-0 xs-pb-25px border-color-transparent-white-light">

                                <?php if (get_sub_field('titulo_caracteristicas_do_projeto')) : ?>
                                    <span class="text-uppercase fs-15"><?php echo esc_html(get_sub_field('titulo_caracteristicas_do_projeto')); ?></span>
                                <?php endif; ?>

                                <?php if (get_sub_field('descricao_caracteristicas_do_projeto')) : ?>
                                    <span class="d-block text-white lh-24"><?php echo esc_html(get_sub_field('descricao_caracteristicas_do_projeto')); ?></span>
                                <?php endif; ?>

                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>




                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->


<!-- start section -->
<section class="d-flex align-items-center full-screen cover-background ipad-top-space-margin">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center atropos" data-atropos>
                <div class="atropos-scale">
                    <div class="atropos-rotate">
                        <div class="atropos-inner" data-atropos-offset="3">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'img_destacada_projeto_full')); ?>" class="md-transform-none" alt="">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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



<!-- start section -->
<section class="cover-background one-fourth-screen d-flex align-items-center justify-content-center" style="background-image: url('<?php if (get_field('imagem_background_video')) : ?><?php echo esc_url(get_field('imagem_background_video')['sizes']['video-principal-bg']); ?><?php endif; ?>');">
    <a href="<?php if (get_field('link_youtube')) : ?><?php echo esc_url(get_field('link_youtube')); ?><?php endif; ?>" class="text-center bg-white rounded-circle video-icon-box video-icon-extra-large popup-vimeo slide-up-animation">
        <span>
            <span class="video-icon bg-white">
                <i class="feather icon-feather-play text-dark-gray"></i>
                <span class="video-icon-sonar">
                    <span class="video-icon-sonar-bfr bg-white"></span>
                </span>
            </span>
        </span>
    </a>
</section>
<!-- end section -->


<!-- start section -->
<?php
$featured_posts = get_field('depoimento_do_projeto');
if ($featured_posts) : ?>
    <section class="bg-dark-gray background-position-center-top overlap-height overflow-visible" style="background-image: url('images/demo-architecture-dotted-pattern.svg')">
        <div class="container">

            <div class="row overlap-gap-section">

                <ul>
                    <?php foreach ($featured_posts as $post) :

                        // Setup this post for WP functions (variable must be named $post).
                        setup_postdata($post);

                        get_template_part('template-parts/list-depoimentos');

                    ?>

                    <?php endforeach; ?>
                </ul>

            </div>
            <div class="row align-items-center justify-content-center mt-10">
                <div class="col-xxl-3 col-md-4 text-white text-center text-md-end fw-500 fs-20">Compartilhe este projeto</div>
                <div class="col-xxl-3 col-md-3">
                    <div class="w-100 h-1px bg-base-color sm-mt-15px sm-mb-15px"></div>
                </div>
                <div class="col-xxl-3 col-md-5 text-center text-md-start elements-social social-icon-style-02">
                    <ul class="medium-icon light mb-0">
                        <li class="mb-0"><a class="facebook" href="https://www.facebook.com/share.php?u=<?php echo get_permalink(); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li class="mb-0"><a class="twitter" href="https://www.twitter.com/share?url=<?php echo get_permalink(); ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                        <li class="mb-0"><a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink(); ?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <li class="mb-0"><a class="pinterest" href="https://www.pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Reset the global post object so that the rest of the page works correctly.
    wp_reset_postdata(); ?>
<?php endif; ?>
<!-- end section -->


<?php
get_footer(); ?>