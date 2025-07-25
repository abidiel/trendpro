<?php

/**
 * The template part for displaying Lista de Depoimentos Home
 * @package WordPress
 * @subpackage Trend Pro
 * @since Trend Pro 1.0
 */

?>

<!-- start testimonial item -->
<div class="swiper-slide">
    <div class="row align-items-center justify-content-center">
        <?php if (get_field('imagem_depoimento')) : ?>
            <div class="col-8 col-md-4 col-sm-6 text-center md-mb-30px">
                <img src="<?php echo esc_url(get_field('imagem_depoimento')['sizes']['cliente-imagem']); ?>" alt="<?php echo esc_attr(get_field('logo_depoimento')['alt']); ?>" class="border-radius-50">
            </div>
        <?php endif; ?>

        <div class="col-lg-5 col-md-7 last-paragraph-no-margin text-center text-md-start">
            <?php if (get_field('logo_depoimento')) : ?>
                <a href="#" class="mb-15px d-block"><img src="<?php echo esc_url(get_field('logo_depoimento')); ?>"  alt="<?php echo esc_attr(get_field('logo_depoimento')['alt']); ?>"></a>
            <?php endif; ?>

            <span class="mb-10px fw-500 d-table fs-18 lh-28"><?php the_content(); ?></span>
            <span class="fs-15 text-uppercase fw-700 ls-1px"><?php the_title(); ?></span>

            <?php
            $post_id = get_the_ID();
            $botao_depoimento =  get_field('link_depoimento_youtube', $post_id);

            if ($botao_depoimento) :
                $botao_depoimento_url = $botao_depoimento['url'];
                $botao_depoimento_titulo = $botao_depoimento['title'];
                $botao_depoimento_target = $botao_depoimento['target'];

            ?>

                <a href="<?php echo esc_url($botao_depoimento_url); ?>" class="btn btn-extra-large btn-base-color btn-box-shadow text-transform-none btn-rounded btn-hover-animation-switch popup-youtube">
                    <span>
                        <span class="btn-text"><?php echo esc_html($botao_depoimento_titulo); ?></span>
                        <span class="btn-icon"><i class="fa-brands fa-youtube"></i></span>
                        <span class="btn-icon"><i class="fa-brands fa-youtube"></i></span>
                    </span>
                </a>

            <?php endif; ?>

        </div>
    </div>
</div>
<!-- end testimonial item -->