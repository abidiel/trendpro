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
                <?php 
                $imagem_card = get_field('imagem_card');
                if ($imagem_card && !empty($imagem_card['ID'])) : ?>
                    <?php echo wp_get_attachment_image(
                        $imagem_card['ID'], 
                        'servico-imagem', 
                        false, 
                        array(
                            'alt' => esc_attr($imagem_card['alt'] ?: get_the_title()),
                            'loading' => 'lazy'
                        )
                    ); ?>
                <?php else : ?>
                    <img src="https://placehold.co/520x620/e2e8f0/64748b?text=<?php echo urlencode(get_the_title()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" />
                <?php endif; ?>
                
                <div class="overlay-bg bg-gradient-dark-transparent opacity-light"></div>
                
                <?php 
                $service_icon = get_field('service_icon');
                if ($service_icon && !empty($service_icon['ID'])) : ?>
                    <span class="banners-icon text-white icon-hover-base-color position-absolute left-30px lg-left-30px">
                        <?php echo wp_get_attachment_image(
                            $service_icon['ID'], 
                            'full', 
                            false, 
                            array(
                                'class' => 'w-42px h-42px',
                                'alt' => esc_attr($service_icon['alt'] ?: get_the_title() . ' - Ícone'),
                                'loading' => 'lazy'
                            )
                        ); ?>
                    </span>
                <?php else : ?>
                    <span class="banners-icon text-white icon-hover-base-color position-absolute left-30px lg-left-30px">
                        <img src="https://placehold.co/42x42/ffffff/64748b?text=?" 
                             alt="<?php echo esc_attr(get_the_title() . ' - Ícone'); ?>" 
                             class="w-42px h-42px" loading="lazy" />
                    </span>
                <?php endif; ?>
            </div>
            <div class="interactive-banners-content p-60px lg-p-30px">
                <div class="h-100 w-100 last-paragraph-no-margin">
                    <span class="fs-22 fw-700 d-block text-white mb-10px fw-500"><?php echo esc_html(get_the_title()); ?></span>
                    <p class="interactive-banners-content-text w-95 lg-w-100 text-white fw-300">
                        <?php echo esc_html(get_field('service_short_description') ?: 'Descrição não disponível'); ?>
                    </p>
                </div>
            </div>
            <div class="box-overlay bg-gradient-dark-transparent"></div>
            <a href="<?php the_permalink(); ?>" class="box-link"></a>
        </div>
    </a>
</li>