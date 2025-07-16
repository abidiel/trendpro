<?php

/**
 * The template part for displaying Lista de Depoimentos Home
 * @package WordPress
 * @subpackage Micheli Waldow
 * @since Micheli Waldow 1.0
 */

?>

<!-- start testimonial item -->
<div class="swiper-slide d-flex align-items-center min-h-400px">
    <div class="row align-items-center justify-content-center">
        <?php if (get_field('imagem_depoimento')) : ?>
            <div class="col-lg-4 col-md-4 col-sm-6 text-center md-mb-30px position-relative">
                <img src="<?php echo esc_url(get_field('imagem_depoimento')['sizes']['cliente-imagem']); ?>" alt="<?php echo esc_attr(get_field('logo_depoimento')['alt']); ?>" class="border-radius-50">

                <!-- Quote dinâmico -->
                <div class="position-absolute bg-base-color w-50px h-50px d-flex align-items-center justify-content-center border-radius-6px" style="top: -10px; right: calc(50% - 90px);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.57-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-4v-10h10z" fill="black" />
                    </svg>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-8 col-md-7 last-paragraph-no-margin text-center text-md-start">
            <?php if (get_field('logo_depoimento')) : ?>
                <a href="#" class="mb-15px d-block"><img src="<?php echo esc_url(get_field('logo_depoimento')['sizes']['cliente-logo-depoimento']); ?>" alt="<?php echo esc_attr(get_field('logo_depoimento')['alt']); ?>"></a>
            <?php endif; ?>

            <span class="mb-10px fw-500 d-table fs-18 lh-28"><?php the_content(); ?></span>
            <span class="fs-15 text-uppercase fw-700 ls-1px"><?php the_title(); ?></span>

            <?php
            $post_id = get_the_ID(); // pega o ID do post atual (projeto)

            $link_depoimento_youtube = get_field('link_depoimento_youtube');
            $link_depoimento_youtube_vertical = get_field('link_depoimento_youtube_vertical');

            if ($link_depoimento_youtube || $link_depoimento_youtube_vertical) :

            ?>
                <div>
                    <a href="<?php echo esc_url($link_depoimento_youtube); ?>" class="video-link btn btn-small btn-transparent-base-color border-color-white text-transform-none btn-rounded btn-hover-animation-switch popup-youtube mt-15px"
                        data-desktop="<?php echo esc_url($link_depoimento_youtube); ?>"
                        data-mobile="<?php echo esc_url($link_depoimento_youtube_vertical); ?>"
                        id="video-link">
                        <span>
                            <span class="btn-text text-white">Assistir depoimento</span>
                            <span class="btn-icon"><i class="fa-brands fa-youtube"></i></span>
                            <span class="btn-icon"><i class="fa-brands fa-youtube"></i></span>
                        </span>
                    </a>
                </div>

            <?php endif; ?>


        </div>
    </div>
</div>
<!-- end testimonial item -->