<!-- start page title -->
<?php
$attachment_breadcrumb_id = get_field('imagem_breadcrumb', 'option');
$size_breadcrumb = "img_breadcrumb"; // (thumbnail, medium, large, full or custom size)
$imagem_breadcrumb = wp_get_attachment_image_src($attachment_breadcrumb_id, $size_breadcrumb);
?>


<section class="page-title-big-typography bg-dark-gray cover-background background-position-center-bottom p-0" style="background-image: url(<?php echo $imagem_breadcrumb[0]; ?>)">
    <div class="container">
        <div class="row align-items-end justify-content-center small-screen md-small-screen sm-extra-small-screen pb-9">
            <div class="col-lg-6 col-md-8 position-relative page-title-extra-small text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <h4 class="mb-20px primary-font text-white fw-700"><?php the_title(); ?></h4>
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