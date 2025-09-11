<?php get_header();
// Status: Ok, pronto.


if (have_posts()) {
	while (have_posts()) : the_post();
		setup_postdata($post); ?>





		<!-- start section -->
		<section class="one-third-screen bg-dark-gray ipad-top-space-margin sm-mb-50px" data-parallax-background-ratio="0.5" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'fullhd')); ?>')">
			<div class="row d-flex justify-content-center breadcrumb-normal position-relative text-center text-white pt-60px" data-anime='{ "el": "childs", "translateY": [20, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
				<div class="col-12">
					<?php if (function_exists('yoast_breadcrumb')) : ?>
						<div class="breadcrumb-wrapper">
							<?php yoast_breadcrumb('<nav class="breadcrumb-nav" aria-label="Navegação">', '</nav>'); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<!-- end section -->
		<!-- start section -->
		<section class="p-0">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-10 overlap-section text-center">
						<div class="p-10 box-shadow-extra-large border-radius-4px bg-white text-center">
							<?php
							$categories = get_the_category();
							if (!empty($categories)) :
								$first_category = $categories[0];
							?>
								<a href="<?php echo esc_url(get_category_link($first_category->cat_ID)); ?>" class="bg-solitude-blue text-uppercase fs-13 ps-25px pe-25px alt-font fw-500 text-base-color lh-40 sm-lh-55 border-radius-100px d-inline-block mb-3 sm-mb-15px">
									<?php echo esc_html($first_category->cat_name); ?>
								</a>
							<?php endif; ?>
							<h3 class="alt-font text-dark-gray fw-600 ls-minus-1px mb-15px"><?php the_title(); ?></h3>
							<div class="lg-20px sm-mb-0">
								<span>Por <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-dark-gray"><?php echo esc_html(get_the_author()); ?></a></span> em <span class="text-dark-gray"><?php echo esc_html(get_the_date(get_option('date_format'))); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end section -->
		<!-- start section -->
		<section class="overlap-section text-center p-0 sm-pt-30px">
			<img class="rounded-circle box-shadow-extra-large w-130px h-130px border border-8 border-color-white" src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'), array('size' => 130))); ?>" alt="<?php echo esc_attr(get_the_author()); ?>">
		</section>
		<!-- end section -->





		<!-- start section -->
		<section class="bg-dark-gray background-position-center-top section-blog">
			<div class="container">

				<div class="row justify-content-center">

					<div class="col-lg-10 last-paragraph-no-margin" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</section>
		<!-- end section -->

		<!-- start section -->
		<section class="bg-dark-gray background-position-center-top pt-0">
			<div class="container">
				<div class="row justify-content-center" data-anime='{ "el": "childs", "translateY": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
					<div class="col-lg-8">
						<!-- post tags -->
						<?php
						// TEST IF HAVE TAGS, IF TRUE - GET TAGS BY POST_ID
						if (has_tag()) {

							$tags = get_the_tags($post->ID);  ?>

							<div class="row mb-30px">
								<div class="tag-cloud col-md-9 text-center text-md-start sm-mb-15px">

									<?php foreach ($tags as $tag) :  ?>
										<a href="<?php echo esc_url(home_url('/tag/' . $tag->slug)); ?>"><?php echo esc_html($tag->name); ?></a>
									<?php endforeach;  ?>

								</div>
							</div>
						<?php
						} else {
							//Article untagged
						}
						?>

						<div class="row">
							<div class="col-12 mb-6">
								<div class="bg-nero-grey d-block d-md-flex w-100 box-shadow-extra-large align-items-center border-radius-4px p-7 sm-p-35px">
									<div class="w-140px text-center me-50px sm-mx-auto">
										<?php echo get_avatar(get_the_author_meta('user_email'), '80', ''); ?>
										<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-white fw-500 mt-20px d-inline-block lh-20"><?php the_author_posts_link(); ?></a>
										<div class="text-gray fs-13">
											<?php echo wp_kses_post(wpautop(get_the_author_meta('nickname'))); ?>
										</div>
									</div>
									<div class="w-75 sm-w-100 text-center text-md-start last-paragraph-no-margin">
										<?php echo wp_kses_post(wpautop(get_the_author_meta('description'))); ?>
										<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-white text-uppercase fs-13 ">Todos os posts de <?php the_author(); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-12 text-center elements-social social-icon-style-04">
								<ul class="medium-icon light">
									<li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i><span></span></a></li>

									<li><a class="twitter" href="https://twitter.com/intent/tweet?url=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i class="fa-brands fa-twitter"></i><span></span></a></li>

									<li><a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i><span></span></a></li>

									<li><a class="pinterest" href="https://www.pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i class="fa-brands fa-pinterest"></i><span></span></a></li>
								</ul>
							</div>
						</div>

						<!-- post navigation -->
						<div class="mt-5">

							<?php
							if (is_singular('post')) {
								// Previous/next post navigation.
								the_post_navigation(
									array(
										'screen_reader_text' => ' ',
										'next_text' => '<div class="pe-40px"><span>' . __('Próximo', 'nd_dosth') .  '</span><div class="post-next-title">%title</div></div>',
										'prev_text' => '<div class="ps-40px"><span>' . __('Anterior', 'nd_dosth') . '</span><div class="post-prev-title">%title</div></div>',
									)
								);
							}
							?>
						</div>

					</div>
				</div>
			</div>
		</section>
		<!-- end section -->
		<!-- start section -->
		<section class="bg-nero-grey overlap-height background-position-center-top">
			<div class="container">
				<div class="row justify-content-center mb-1 sm-mb-7">
					<div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
						<span class="text-base-color fs-12 fw-600 ls-3px text-uppercase d-inline-block">Você pode gostar também</span>
						<h4 class="text-white fw-600">Posts relacionados</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<ul class="blog-simple blog-wrapper grid-loading blog-grid grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
							<li class="grid-sizer"></li>

							<!-- Blog -->
							<div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item" data-animate="fadeInUp">



								<?php get_template_part('template-parts/list-blog-relacionados'); ?>

							</div>

						</ul>
					</div>

				</div>


				<div class="row row-cols-1 justify-content-center mt-5">
					<div class="col btn-dual text-center">
						<span class="text-white d-table d-lg-inline-block xl-mt-15px md-mx-auto fs-20">Categorias</span>

						<a href="<?php the_permalink('43'); ?>" class="btn btn-link btn-medium text-white d-table d-lg-inline-block xl-mb-15px md-mx-auto">Ver tudo</a>

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

<?php endwhile;
} ?>



<?php get_footer(); ?>