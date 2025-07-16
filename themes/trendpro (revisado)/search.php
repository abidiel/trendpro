<?php
/* Template Name: Busca */
get_header(); 

get_template_part('template-parts/breadcrumbs'); ?>




<!-- Section - Bloco 1 Listagem -->
<section class="ps-7 pe-7 xl-ps-2 xl-pe-2 xs-px-0 bg-dark-gray background-position-center-top big-section overlap-height">

	<div class="container-fluid">

		<div class="row">
			<div class="col-12">

				<h4 class="text-center text-white m-b-20">Resultado da pesquisa:</h4>

				<ul class="blog-simple blog-wrapper grid-loading grid grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
					<li class="grid-sizer"></li>

					<!-- Blog -->
					<div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item" data-animate="fadeInUp">

						<?php if (have_posts()) { ?>
							<!-- Portfolio -->
							<div id="portfolio" class="grid-layout portfolio-3-columns" data-margin="20">
								<div class="team-members">
									<?php
									while (have_posts()) : the_post();
										get_post_format();
										get_template_part('template-parts/list-busca', get_post_format());
									endwhile; ?>
								</div>
							</div>


							<!-- end: Blog -->


						<?php
						} else { ?>
							<div class="row justify-content-center mb-40px">
								<div class="col-10">
									<h5 class=" text-center ">Sem resultados, tente novamente.</h5>
								</div>

							</div>
						<?php }

						wp_reset_query(); ?>


					</div>
					<!-- end: Blog -->

				</ul>


			</div>
		</div>


		<!-- Paginação  -->
		<!-- Obs: Classes do front estão no wp_bootstrap_pagination.php  -->
		<?php wp_bootstrap_pagination(); ?>
		<!-- end: Paginação  -->
		<div class="row justify-content-center mt-40px search-no-results-message">
			<div class="col-10">
				<h6 class="text-center text-white mt-40px">Não encontrou o que procurava? Tente outro termo</h6>
			</div>
			<div class="col-10 col-md-4">


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

			</div>

		</div>
	</div>
</section>
<!-- end: Bloco 1 Listagem -->


<?php get_footer(); ?>