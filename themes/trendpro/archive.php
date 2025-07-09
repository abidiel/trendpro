<?php 
get_header();?>


<!-- 404 PAGE -->
<section class="m-t-80 p-b-150">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="page-error-404">404</div>
			</div>
			<div class="col-lg-6">
				<div class="text-left">
					<h1 class="text-medium">A página que você procura não foi encontrada.</h1>
					<p class="lead">Ela pode ter sido removida ou mudou, faça uma busca no site ou vá para a página inicial.</p>
					<div class="seperator m-t-20 m-b-20"></div>
					<!-- barra de busca -->
					<form id="widget-search-form-sidebar" action="<?php echo esc_url(home_url('/')); ?>" method="get">
						<div class="input-group">
							<input type="text" aria-required="true" value="<?php echo get_search_query(); ?>" name="s" class="form-control widget-search-form" placeholder="Faça uma busca...">
							<div class="input-group-append">
								<button class="btn" type="submit"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
					<!--end:  barra de busca -->

					<div>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn m-t-30"><i class="fa fa-home"></i> Página inicial</a>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
<!-- end:  404 PAGE -->






<?php get_footer();?>