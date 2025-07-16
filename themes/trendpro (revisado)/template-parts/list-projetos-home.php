<?php

/**
 * The template part for displaying Lista de Projetos Home
 * @package WordPress
 * @subpackage Trend Pro
 * @since Trend Pro 1.0
 */

?>

<?php $term_list = wp_get_post_terms(get_the_ID(), 'projetos-categoria', array("fields" => "all"));
if ($term_list) { ?>
    <?php
    foreach ($term_list as $cat) { ?>

        <?php $slugCategoria = $cat->slug; ?>
        <?php $nomeCategoria = $cat->name; ?>
        <?php $taxCategoria = $cat->taxonomy; ?>

    <?php
    } ?>
<?php } ?>



<!-- start text slider item -->
<div class="swiper-slide">

    <?php $url = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'img_destacada_projeto_full') ?>
    <img src="<?php echo $url ?>" alt="" />
    <div class="container position-absolute sm-position-relative bottom-0 right-0px z-index-1 swiper-slide-content">
        <div class="row justify-content-end align-items-end h-100">
            <div class="col-lg-5 col-md-7 p-0">
                <div class="bg-white p-16 lg-p-12">
                    <span class="text-base-color fs-15 text-uppercase ls-1px fw-700"><?php echo $nomeCategoria; ?></span>
                    <h4 class="alt-font text-dark-gray fw-600 mb-20px ls-minus-2px"><?php the_title(); ?></h4>
                    <a href="<?php the_permalink(); ?>" class="btn btn-link btn-hover-animation-switch btn-large text-dark-gray fw-800">
                        <span>
                            <span class="btn-text">Ver conteúdo</span>
                            <span class="btn-icon text-base-color"><i class="fa-solid fa-arrow-right fs-14"></i></span>
                            <span class="btn-icon text-base-color"><i class="fa-solid fa-arrow-right fs-14"></i></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end text slider item -->