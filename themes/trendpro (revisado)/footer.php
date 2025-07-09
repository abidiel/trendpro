    <!-- start footer -->
    <footer class="bg-black pb-0 pt-4 md-pt-6 sm-pt-9 xs-pt-11 background-position-center-top"
    	id="contato">
    	<div class="container">
    		<div class="row align-items-center mb-70px md-mb-5 xs-mb-8">
    			<div class="col-sm-8 text-center text-sm-start order-2 order-sm-1">
    				<h6 class="fw-200 text-white d-inline-block align-middle mb-0">Vamos construir juntos o sucesso do
    					<span class="text-white fw-700">seu negócio?</span>
    				</h6>
    			</div>
    			<div class="col-sm-4 text-center text-sm-end order-1 order-sm-2 xs-mb-15px">


    				<a href="https://api.whatsapp.com/send?l=pt&phone=55<?php echo esc_attr(str_replace(array('(', ')', ' ', '-'), array('', '', '', ''), get_field('whatsapp', 'option'))); ?>&text=Gostaria%20de%20saber%20mais%20sobre%20os%20servi%C3%A7os%20da%20Trend%20Pro."
    					target="_blank"
    					class="btn border-1 btn-transparent-base-color border-color-white btn-extra-large btn-rounded with-rounded mt-20px sm-mt-0 text-white">Falar
    					com Especialista<span class="icon-extra-medium"><i
    							class="fa-brands fa-whatsapp"></i></span></a>
    			</div>
    		</div>
    	</div>
    	<div class="footer-bottom p-20px border-top border-color-transparent-white-light">
    		<div class="container">
    			<div class="row align-items-center">
    				<div class="col-lg-7 text-center text-lg-start md-mb-10px">
    					<ul class="footer-navbar fs-15 lh-normal">
    						<li class="nav-item active"><a href="<?php echo esc_url(get_permalink(7)); ?>"
    								class="nav-link">Início</a></li>
    						<li class="nav-item"><a href="<?php echo esc_url(get_permalink(37)); ?>" class="nav-link">Sobre</a></li>
    						<li class="nav-item"><a href="<?php echo esc_url(get_permalink(41)); ?>" class="nav-link">Serviços</a></li>
    						<li class="nav-item"><a href="<?php echo esc_url(get_permalink(39)); ?>" class="nav-link">Cases</a></li>
    						<li class="nav-item"><a href="<?php echo esc_url(get_permalink(43)); ?>" class="nav-link">Blog</a></li>
    						<li class="nav-item"><a href="<?php echo esc_url(get_permalink(46)); ?>" class="nav-link">Contato</a></li>


    					</ul>
    				</div>
    				<div class="col-lg-5 text-center text-lg-end">
						<span class="fs-15">© <?php echo esc_html(date('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?></span>
    				</div>
    			</div>
    		</div>
    	</div>
    </footer>
    <!-- end footer -->


    <!-- start scroll progress -->
    <div class="scroll-progress d-none d-xxl-block">
    	<a href="#" class="scroll-top" aria-label="scroll">
    		<span class="scroll-text">Scroll</span><span class="scroll-line"><span class="scroll-point"></span></span>
    	</a>
    </div>
    <!-- end scroll progress -->



    <?php wp_footer(); ?>

    </body>

    </html>