<?php

/**
 * The template part for displaying Lista de Projetos
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


<!-- start portfolio item -->
<li class="grid-item  <?php echo $slugCategoria; ?> transition-inner-all">
    <div class="portfolio-box ">
        <div class="portfolio-image ">
            <?php $url = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'img_destacada_projeto_square') ?>
            <img src="<?php echo $url ?>" alt="" />
            <div class="portfolio-hover d-flex justify-content-center flex-column">
                <div class="portfolio-icon d-flex flex-row justify-content-center align-items-center">
                    <a href="<?php the_permalink(); ?>" class="d-flex flex-column justify-content-center text-dark-gray text-dark-gray-hover rounded-circle bg-white w-60px h-60px move-bottom-top">
                        <i class="fa-solid fa-plus icon-small" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="portfolio-overlay bg-dark-gray bg-base-color" style="background-color: var(--base-color);"></div>
        </div>
        <div class="portfolio-caption pt-30px pb-30px lg-pt-20px lg-pb-20px">
            <div class="fs-14 lh-20 text-uppercase"><?php echo $nomeCategoria; ?></div>
            <a href="<?php the_permalink(); ?>" class="fs-17 fw-600 text-white text-white-hover"><?php the_title(); ?></a>
        </div>
    </div>
</li>
<!-- end portfolio item -->





<!-- portfolio item -->





<div class="portfolio-item p-l-10 p-t-10 p-r-10 d-none <?php echo $slugCategoria; ?>">
    <div class="team-member box-shadow transitions2">


        <a href="<?php the_permalink(); ?>">
            <div class="team-image">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('produto_lista', array('class' => 'lista_produtos_img img-fluid d-block'));
                } else {
                    echo wp_get_attachment_image(334, 'produto_lista', '', array("class" => "lista_produtos_img img-fluid d-block"));
                } ?>


            </div>
        </a>

        <div class="team-desc">
            <a href="<?php the_permalink(); ?>">
                <h3 class="text-brown m-b-5"><?php the_title(); ?></h3>
            </a>

            <span><?php the_field('data_produtos'); ?></span>

            <p><?php the_field('breve_descricao_produtos'); ?></p>

            <!-- <a class="text-brown" href="<?php echo get_site_url() . '/' . $taxCategoria . '/' . $slugCategoria; ?>" title="Pacotes da categoria <?php echo $nomeCategoria ?>">
				<?php echo $nomeCategoria ?>
			</a> -->

            <div class="m-t-10">
                <a href="<?php the_permalink(); ?>" class="btn"><span>Ver mais</span></a>
            </div>
        </div>

    </div>
</div>
<!-- end: portfolio item -->