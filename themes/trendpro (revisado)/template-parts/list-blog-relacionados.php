<?php

/**
 * The template part for displaying Lista de posts relacionados
 * @package WordPress
 * @subpackage Agência tática
 * @since Agência tática 1.0
 */

$the_cat = get_the_category();
$category_name = $the_cat[0]->cat_name;

// Defino o Nome da Categoria e a Quantidade de Posts a serem exibidos
$the_query = new WP_Query(
	array(
		'category_name' => $category_name,
		'posts_per_page' => 3,
		'post__not_in' => array($post->ID),
		'orderby' => 'rand'
	)
);

if ($the_query->have_posts()) {


	while ($the_query->have_posts()) {
		$the_query->the_post(); ?>




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
					<!-- armazenando nome e url da categoria -->
					<?php

					$the_cat = get_the_category();
					$category_name = $the_cat[0]->cat_name;
					$category_link = get_category_link($the_cat[0]->cat_ID);
					?>

					<div class="blog-categories">
						<a href="<?php echo $category_link; ?>" class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-700"><?php echo $category_name; ?></a>
					</div>
				</div>
				<div class="card-body p-12">
					<a href="<?php the_permalink(); ?>" class="card-title mb-15px fw-600 fs-17 lh-26 text-dark-gray text-dark-gray-hover d-inline-block"><?php the_title(); ?></a>
					<br>
					<p class="blog-date fw-500 d-inline-block"><?php echo get_the_date(get_option('date_format')); ?></p>
				</div>
			</div>
		</li>
		<!-- end blog item -->




	<?php
	}
} else { ?>

	<div class="row m-t-40">
		<div class="col-12 text-center">
			<p>Nenhum artigo relacionado.</p>
		</div>
	</div>

<?php
}
?>