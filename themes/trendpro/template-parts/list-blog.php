<?php

/**
 * The template part for displaying posts
 * @package WordPress
 * @subpackage Trend Pro
 * @since Trend Pro 1.0
 */ ?>


<!-- start blog item -->
<li class="grid-item" data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "easing": "easeOutQuad" }'>
	<figure class="position-relative mb-0 box-hover">
		<div class="blog-image">
			<?php
			if (has_post_thumbnail()) {
				the_post_thumbnail('blog_lista', array('class' => 'img-fluid '));
			} ?>
			<span class="box-overlay bg-dark-slate-blue"></span>
			<span class="bg-gradient-gray-light-dark-transparent position-absolute top-0px left-0px w-100 h-100"></span>
		</div>
		<figcaption class="d-flex flex-column h-100">
			<div class="my-auto w-100 text-center blog-hover-icon"><a href="<?php the_permalink(); ?>" class="d-inline-block"><i class="line-icon-Arrow-OutRight icon-extra-large text-white"></i></a></div>
			<div class="position-relative p-14 text-center last-paragraph-no-margin">
				<div class="position-relative z-index-2 overflow-hidden">
					<a href="<?php the_permalink(); ?>" class="d-inline-block fs-12 text-base-color mb-5px text-uppercase fw-600"><?php echo get_the_date(get_option('date_format')); ?></a>
					<a href="<?php the_permalink(); ?>" class="card-title fs-20 alt-font fw-500 text-white mb-0 d-block"><?php the_title(); ?></a>
					<div class="hover-text"><a href="<?php the_permalink(); ?>" class="btn btn-link-gradient btn-medium text-white thin mt-20px mb-5px opacity-6 fw-300">Ler artigo<span class="bg-white"></span></a></div>
				</div>
				<div class="box-overlay bg-dark-slate-blue"></div>
			</div>
		</figcaption>
	</figure>
</li>
<!-- end blog item -->
