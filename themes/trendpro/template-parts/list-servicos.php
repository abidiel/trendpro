<?php

/**
 * The template part for displaying Lista de Projetos
 * @package WordPress
 * @subpackage Trend Pro
 * @since Trend Pro 1.0
 */

?>

<li class="grid-item selected digital transition-inner-all">
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
</li>