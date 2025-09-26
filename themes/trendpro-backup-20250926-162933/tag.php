<?php get_header();
// Status: Ok, pronto.

get_template_part('template-parts/breadcrumbs');

?>

<!-- start section -->
<section class="ps-7 pe-7 xl-ps-2 xl-pe-2 xs-px-0 bg-dark-gray background-position-center-top big-section overlap-height">
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
		</div>

	</div>
</section>
<!-- end section -->


<?php get_footer(); ?>