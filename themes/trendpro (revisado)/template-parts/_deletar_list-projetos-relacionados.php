<?php

/**
 * The template part for displaying Lista de posts relacionados
 * @package WordPress
 * @subpackage Trend Pro
 * @since Trend Pro 1.0
 */


 
 $term_list = wp_get_post_terms(get_the_ID(), 'projetos-categoria', array("fields" => "all"));
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
 <li class="grid-item <?php echo $slugCategoria; ?> transition-inner-all">
	 <div class="portfolio-box">
		 <div class="portfolio-image">
			 <?php $url = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'img_destacada_projeto_square') ?>
			 <img src="<?php echo $url ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			 <div class="portfolio-hover d-flex justify-content-center flex-column">
				 <div class="portfolio-icon d-flex flex-row justify-content-center align-items-center">
					 <a href="<?php the_permalink(); ?>" class="d-flex flex-column justify-content-center text-dark-gray text-dark-gray-hover rounded-circle bg-white w-60px h-60px move-bottom-top">
						 <i class="fa-solid fa-angles-right icon-small" aria-hidden="true"></i>
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