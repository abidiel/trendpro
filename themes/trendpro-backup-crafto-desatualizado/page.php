<?php get_header();

get_template_part('template-parts/breadcrumbs'); ?>

<!-- Page Content -->
<section id="page-content" class="bg-dark-gray">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (post_password_required()): ?>
                    <?php $erro_senha = isset($_GET['pwd_error']); ?>
                    
                    <div class="password-form-wrapper text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="bg-white p-4 border-radius-10px">
                                    
                                    <?php if ($erro_senha): ?>
                                        <div class="bg-red text-white p-3 mb-3 border-radius-5px">
                                            <strong>⚠️ Senha incorreta!</strong> Verifique e tente novamente.
                                        </div>
                                    <?php endif; ?>
                                    
                                    <form action="<?php echo esc_url(site_url('wp-login.php?action=postpass', 'login_post')); ?>" method="post">
                                        <h3 class="text-dark-gray mb-3">Conteúdo Protegido</h3>
                                        <p class="text-medium-gray mb-4">Digite a senha para acessar este conteúdo:</p>
                                        
                                        <!-- Campo oculto com ID do post -->
                                        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                        
                                        <div class="form-group mb-3">
                                            <input name="post_password" type="password" class="form-control" placeholder="Digite a senha" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-dark-gray">Acessar Conteúdo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="heading-text heading-section">
                        <?php echo wp_kses_post(get_the_content()); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>