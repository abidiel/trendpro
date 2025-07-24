<?php get_header(); 

get_template_part('template-parts/breadcrumbs'); ?>


<!-- start section -->
<section class="bg-dark-gray background-position-center-top big-section overlap-height" style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/demo-architecture-dotted-pattern.svg')">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<ul class="blog-grid blog-wrapper grid-loading grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
					<li class="grid-sizer"></li>

					<!-- Blog -->
					<div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item" data-animate="fadeInUp">

						<?php if (have_posts()) {
							while (have_posts()) : the_post();
								get_post_format();
								get_template_part('template-parts/list-blog', get_post_format());
							endwhile;
						}
						wp_reset_query(); ?>


					</div>
					<!-- end: Blog -->

				</ul>
			</div>

			<!-- Paginação  -->
			<!-- Obs: Classes do front estão no wp_bootstrap_pagination.php  -->
			<?php wp_bootstrap_pagination(); ?>
			<!-- end: Paginação  -->

			<div class="text-center">
				<a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-base-color btn-large text-white mt-20px">Voltar para o blog</a>
			</div>

		</div>
	</div>
</section>
<!-- end section -->



<?php get_footer(); ?>