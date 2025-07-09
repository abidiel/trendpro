<?php

/**
 * The template part for displaying posts
 * @package WordPress
 * @subpackage Agencia Tatica
 * @since Agencia Tatica 1.0
 */ ?>



<!-- start blog item -->
<li class="grid-item">
	<div class="card border-0 border-radius-4px box-shadow-extra-large box-shadow-extra-large-hover">
		<div class="blog-image">
			<a href="<?php the_permalink(); ?>" class="d-block">
				
				<?php
				if (has_post_thumbnail()) {
					the_post_thumbnail('blog_lista', array('class' => 'img-fluid '));
				} ?>
			</a>
		</div>
		<div class="card-body p-12">
			<a href="<?php the_permalink(); ?>" class="card-title mb-15px fw-600 fs-17 lh-26 text-dark-gray text-dark-gray-hover d-inline-block"><?php the_title(); ?></a>
			<br><p class="blog-date fw-500 d-inline-block"><?php echo get_the_date(get_option('date_format')); ?></p>
		</div>
	</div>
</li>
<!-- end blog item -->
