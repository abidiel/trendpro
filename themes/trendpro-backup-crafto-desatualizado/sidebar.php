<!-- Status> OK -->
<?php
global $dispositivo;
global $matriz_retorno;
?>
<!--widget newsletter-->
<div class="widget  widget-newsletter">
	<h4 class="widget-title">Pesquisar</h4>
	<form id="widget-search-form-sidebar" action="<?php echo esc_url(home_url('/')); ?>" method="get">
		<div class="input-group">
			<input type="text" aria-required="true" value="<?php echo get_search_query(); ?>" name="s" class="form-control widget-search-form" placeholder="Pesquisar no blog...">
			<div class="input-group-append">
				<button class="btn" type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
	</form>
</div>
<!--end: widget newsletter-->
<!--Nav -->
<div class="widget  widget-tags">
	<h4 class="widget-title">Categorias</h4>
	<ul class="list-icon list-icon-arrow list-icon-colored">
		<?php
		$terms = get_terms(array('taxonomy' => 'category', 'hide_empty' => true, 'order' => 'ASC', 'parent' => 0, 'showposts' => 30));
		foreach ($terms as $term) {
			$class = (is_category($term->name)) ? 'active' : ''; // assign this class if we're on the same category page as $term->name
			echo '<li class="' . $class . '"><a href="' . get_term_link($term) . '" >' . $term->name . '</a></li>';
		}
		?>
	</ul>
</div>
<!--end: Nav -->
<!--Tags -->

<!-- post tags -->
<?php
// TEST IF HAVE TAGS, IF TRUE - GET TAGS BY POST_ID
if (has_tag()) { ?>
	<div class="widget  widget-tags">
		<h4 class="widget-title">Tags</h4>
		<?php
		$tags = get_tags(array(
			'hide_empty' => false
		  ));  ?>
		<div class="tags">
			<?php foreach ($tags as $tag) :  ?>
				<a class="a-tags-blog m-r-5" href="<?php bloginfo('url'); ?>/tag/<?php print_r($tag->slug); ?>">
					<?php print_r($tag->name); ?>
				</a>
			<?php endforeach;  ?>
		</div>
	</div>
	<!--end: Tags -->
<?php
} else {
	//Article untagged
}
?>