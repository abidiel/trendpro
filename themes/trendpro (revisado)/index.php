<?php
/* Template Name: Blog */
get_header();

get_template_part('template-parts/breadcrumbs');
?>


<!-- start section -->
<section class="bg-dark-gray background-position-center-top big-section overlap-height pb-0">

	<div class="container">
		<div class="row align-items-end mb-6">
			<div class="col-md-6 sm-mb-20px"
				data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
				<span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block"><?php echo esc_html(get_field('blog_subtitle', 43)); ?></span>
				<h3 class="text-white fw-600 mb-0"><?php echo esc_html(get_field('blog_title', 43)); ?></h3>
			</div>
			<div class="col-md-5 offset-md-1 last-paragraph-no-margin"
				data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
				<p class="w-80 xl-w-85 lg-w-100 text-white fw-300"><?php echo esc_html(get_field('blog_description', 43)); ?></p>
			</div>
		</div>
	</div>

</section>
<!-- end section -->

<!-- start section -->
<section class="pt-0 ps-7 pe-7 xl-ps-2 xl-pe-2 xs-px-0 bg-dark-gray background-position-center-top big-section overlap-height">
	<div class="container-fluid">

		<div class="row">
			<div class="col-12">
				<ul class="blog-simple blog-wrapper grid-loading grid grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
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

			<div class="col-12 btn-dual justify-content-center text-center pt-2">
				<span class="text-white d-table d-lg-inline-block xl-mt-15px md-mx-auto fs-20">Categorias</span>

				<a href="<?php the_permalink('19'); ?>" class="btn btn-link  btn-medium text-white d-table d-lg-inline-block xl-mb-15px md-mx-auto">Ver tudo</a>

				<?php
				$terms = get_terms(array('taxonomy' => 'category', 'hide_empty' => true, 'order' => 'ASC', 'parent' => 0, 'showposts' => 30));
				foreach ($terms as $term) {

					echo '<a href="' . get_term_link($term) . '" class="btn btn-link btn-medium text-white d-table d-lg-inline-block xl-mb-15px md-mx-auto">' . $term->name . '</a>';
				}
				?>

			</div>

		</div>
	</div>
</section>
<!-- end section -->



<?php get_footer(); ?>