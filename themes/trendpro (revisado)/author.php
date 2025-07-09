<?php get_header(); ?>

<!-- This sets the $curauth variable -->

<?php
	$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>

<!-- start page title -->
<?php
$attachment_breadcrumb_id = get_field('imagem_breadcrumb', 'option');
$size_breadcrumb = "img_breadcrumb"; // (thumbnail, medium, large, full or custom size)
$imagem_breadcrumb = wp_get_attachment_image_src($attachment_breadcrumb_id, $size_breadcrumb);
?>


<section class="ipad-top-space-margin page-title-big-typography bg-dark-gray cover-background background-position-center-bottom p-0" style="background-image: url(<?php echo esc_url($imagem_breadcrumb[0] ?? ''); ?>)">
	<div class="container">
		<div class="row align-items-end justify-content-center small-screen md-small-screen sm-extra-small-screen pb-9">
			<div class="col-lg-6 col-md-8 position-relative page-title-extra-small text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
				<h4 class="mb-20px alt-font text-white fw-500 "><?php wp_title(); ?></h4>
				<!-- <h2 class="text-white mb-0 text-uppercase ls-3px fw-600">Conheça</h2> -->
			</div>
		</div>
		<div class="row d-flex justify-content-center breadcrumb text-center text-white pb-9" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
			<?php if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<ul class="breadcrumbs text-center">', '</ul>');
			} ?>
		</div>
	</div>
</section>
<!-- end page title -->


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