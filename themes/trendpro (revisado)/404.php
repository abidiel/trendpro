<?php get_header();

get_template_part('template-parts/breadcrumbs'); ?>

<!-- start section -->
<section class="cover-background full-screen ipad-top-space-margin md-h-550px bg-dark-gray">
	<div class="container h-100">
		<div class="row align-items-center justify-content-center h-100">
			<div class="col-12 col-xl-6 col-lg-7 col-md-9 text-center text-white" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
				<h6 class="text-white fw-600 mb-5px text-uppercase">Ooops!</h6>
				<h1 class="fs-200 sm-fs-170 text-white fw-700 ls-minus-8px">404</h1>
				<h4 class="text-white fw-600 sm-fs-22 mb-10px ls-minus-1px">A página que você procura não foi encontrada.</h4>
				<p class="mb-30px lh-28 sm-mb-30px mx-auto">Ela pode ter sido removida ou mudou, faça uma busca no site ou vá para a página inicial</p>

				<!-- barra de busca -->
				<form id="widget-search-form-sidebar" action="<?php echo esc_url(home_url('/')); ?>" method="get">
					<div class="input-group border-radius-10px overflow-hidden">
						<input type="text" aria-required="true" value="<?php echo esc_attr(get_search_query()); ?>" name="s" class="form-control widget-search-form border-radius-0px" placeholder="Pesquisar no site...">
						<div class="input-group-append">
							<button class="btn h-100 bg-base-color border-radius-0px" type="submit"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
				<!--end:  barra de busca -->

				<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-large left-icon btn-rounded btn-base-color btn-box-shadow text-transform-none mt-40px"><i class="fa-solid fa-arrow-left"></i>Página inicial</a>

			</div>
		</div>
	</div>
</section>
<!-- end section -->




<?php get_footer(); ?>