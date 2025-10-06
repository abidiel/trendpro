<?php

/**
 * Template para single area_cliente
 * 
 * @package TrendPro
 */

get_header();

get_template_part('template-parts/breadcrumbs'); ?>

<main id="main" class="site-main">
    <?php
    // Verificar se precisa de senha
    if (post_password_required()):
        $erro_senha = isset($_GET['pwd_error']) && $_GET['pwd_error'] === '1'; ?>

        <section class="password-section">
            <div class="container">
                <div class="password-form-wrapper text-center">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="bg-dark p-4 border-radius-10px">

                                <?php if ($erro_senha): ?>
                                    <div class="bg-red text-white p-3 mb-3 border-radius-5px">
                                        <strong>⚠️ Senha incorreta!</strong> Verifique e tente novamente.
                                    </div>
                                <?php endif; ?>

                                <?php
                                // Verificar se há erro de nonce
                                if (isset($_GET['nonce_error'])): ?>
                                    <div class="bg-red text-white p-3 mb-3 border-radius-5px">
                                        <strong>⚠️ Erro de segurança!</strong> Tente novamente.
                                    </div>
                                <?php endif; ?>

                                <form action="<?php echo esc_url(site_url('wp-login.php?action=postpass', 'login_post')); ?>" method="post">
                                    <h3 class="text-white mb-3">Área do Cliente</h3>
                                    <p class="text-light-gray mb-4">Digite a senha para acessar seus materiais:</p>

                                    <!-- Campo oculto com ID do post -->
                                    <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                    <?php wp_nonce_field('area_cliente_password_' . get_the_ID(), 'area_cliente_nonce'); ?>

                                    <div class="form-group mb-3">
                                        <input name="post_password" type="password" class="form-control" placeholder="Digite a senha" required>
                                    </div>

                                    <button type="submit" class="btn btn-extra-large btn-rounded with-rounded btn-base-color text-white d-table d-lg-inline-block lg-mb-15px md-mx-auto">Acessar Área do Cliente<span class="bg-dark-gray text-white"><i class="fa-solid fa-arrow-right"></i></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php else:

        while (have_posts()) : the_post();
            // Obter dados ACF com sanitização
            $cliente_logo = get_field('cliente_logo');
            $entregas = get_field('entregas');

            // Sanitizar dados das entregas
            if ($entregas && is_array($entregas)) {
                foreach ($entregas as $key => $entrega) {
                    if (isset($entrega['titulo'])) {
                        $entregas[$key]['titulo'] = sanitize_text_field($entrega['titulo']);
                    }
                    if (isset($entrega['descricao'])) {
                        $entregas[$key]['descricao'] = wp_kses_post($entrega['descricao']);
                    }
                    if (isset($entrega['servico'])) {
                        $entregas[$key]['servico'] = sanitize_text_field($entrega['servico']);
                    }
                    if (isset($entrega['links_download']) && is_array($entrega['links_download'])) {
                        foreach ($entrega['links_download'] as $link_key => $link) {
                            if (isset($link['titulo'])) {
                                $entregas[$key]['links_download'][$link_key]['titulo'] = sanitize_text_field($link['titulo']);
                            }
                            if (isset($link['url'])) {
                                $entregas[$key]['links_download'][$link_key]['url'] = esc_url_raw($link['url']);
                            }
                        }
                    }
                }
            }
        ?>

            <!-- Seção 1: Logo + Mensagem -->
            <section class="cliente-intro">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <!-- Logo do Cliente -->
                            <?php if ($cliente_logo): ?>
                                <div class="logo-container mb-30px">
                                    <?php echo wp_get_attachment_image($cliente_logo['ID'], 'cliente-logo', false, array(
                                        'class' => 'cliente-logo'
                                    )); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Conteúdo Personalizado do Cliente -->
                            <?php if (get_the_content()): ?>
                                <div class="cliente-content-wrapper">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Seção 2: Stack Cards de Entregas -->
            <?php if ($entregas): ?>
                <section class="ps-13 pe-13 xxl-ps-8 xxl-pe-8 xl-ps-3 xl-pe-3 sm-ps-2 sm-pe-2 bg-dark-gray">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <!-- start stack card -->
                                <div class="stack-card cards" data-scale="true" data-top-space="35">
                                    <?php foreach ($entregas as $index => $entrega):
                                        // Verificar se a entrega está ativa (tem links de download)
                                        $entrega_ativa = !empty($entrega['links_download']);
                                        $card_class = $entrega_ativa ? '' : 'entrega-desabilitada';
                                    ?>
                                        <div class="stack-item <?php echo ($index < count($entregas) - 1) ? 'mb-50px' : ''; ?>" data-index="<?php echo $index; ?>">
                                            <div class="stack-card-item p-70px xl-p-50px sm-p-30px cover-background <?php echo $card_class; ?>">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/modern-business-bg-01.png" alt="" class="position-absolute z-index-1 left-0px top-0px h-100 d-none d-lg-block" data-bottom-top="transform:rotate(0deg); filter: blur(0px)" data-top-bottom="transform:rotate(-<?php echo ($index * 20 + 20); ?>deg); filter: blur(<?php echo (100 - $index * 20); ?>px)">
                                                <div class="row z-index-9 position-relative align-items-center">
                                                    <div class="col-xl-7 col-lg-6 md-mb-30px">
                                                        <?php if ($entrega['banner']): ?>
                                                            <?php
                                                            // Definir ícone e nome amigável do serviço para o badge
                                                            $icon_map_badge = array(
                                                                'design' => 'bi bi-palette',
                                                                'social_media' => 'bi bi-megaphone',
                                                                'branding' => 'bi bi-award',
                                                                'web' => 'bi bi-laptop',
                                                                'video' => 'bi bi-camera-video',
                                                                'edicao_vfx' => 'bi bi-film',
                                                                'desenvolvimento_sites' => 'bi bi-code-slash',
                                                                'cobertura_eventos' => 'bi bi-camera',
                                                                'producao_conteudo' => 'bi bi-pencil-square',
                                                                'banco_conteudo' => 'bi bi-collection'
                                                            );
                                                            $servicos_map_badge = array(
                                                                'design' => 'Design Gráfico',
                                                                'social_media' => 'Social Media',
                                                                'branding' => 'Branding',
                                                                'web' => 'Web Design',
                                                                'video' => 'Produção de Vídeo',
                                                                'edicao_vfx' => 'Edição VFX',
                                                                'desenvolvimento_sites' => 'Desenvolvimento de Sites',
                                                                'cobertura_eventos' => 'Cobertura de Eventos',
                                                                'producao_conteudo' => 'Produção de Conteúdo',
                                                                'banco_conteudo' => 'Banco de Conteúdo'
                                                            );
                                                            $icon_class_badge = isset($entrega['servico'], $icon_map_badge[$entrega['servico']]) ? $icon_map_badge[$entrega['servico']] : 'bi bi-folder';
                                                            $servico_texto_badge = isset($entrega['servico'], $servicos_map_badge[$entrega['servico']]) ? $servicos_map_badge[$entrega['servico']] : (isset($entrega['servico']) ? $entrega['servico'] : '');
                                                            ?>
                                                            <span class="btn btn-small btn-rounded btn-white text-dark-gray btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16 ls-0px fw-700 position-absolute right-25px top-25px pe-none">
                                                                <i class="<?php echo esc_attr($icon_class_badge); ?> me-5px align-middle"></i>
                                                                <?php echo esc_html($servico_texto_badge); ?>
                                                            </span>
                                                            <?php echo wp_get_attachment_image($entrega['banner']['ID'], 'imagem-area-cliente', false, array(
                                                                'alt' => esc_attr($entrega['titulo'])
                                                            )); ?>

                                                        <?php else: ?>
                                                            <img src="https://placehold.co/674x452" alt="<?php echo esc_attr($entrega['titulo']); ?>" class="w-100">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-xl-5 col-lg-6 pt-6 pb-6 xl-py-0">

                                                        <h3 class="ls-minus-1px <?php echo $entrega_ativa ? 'text-white' : 'text-medium-gray'; ?> fw-700 mb-20px"><?php echo esc_html($entrega['titulo']); ?></h3>

                                                        <!-- Indicador de Status - apenas para cards desabilitados -->
                                                        <?php if (!$entrega_ativa): ?>
                                                            <div class="status-indicator mb-20px">
                                                                <span class="badge bg-warning text-dark fs-12">⏳ Pendente</span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if ($entrega['descricao']): ?>
                                                            <p class="mb-20px <?php echo $entrega_ativa ? '' : 'text-medium-gray'; ?>"><?php echo wp_kses_post($entrega['descricao']); ?></p>
                                                        <?php endif; ?>

                                                        <?php if ($entrega['links_download']): ?>
                                                            <?php foreach ($entrega['links_download'] as $link): ?>
                                                                <a href="<?php echo esc_url($link['url']); ?>"
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                    class="btn btn-extra-large btn-base-color btn-switch-text btn-box-shadow btn-rounded text-transform-none left-icon dropbox-link mb-10px">
                                                                    <span>
                                                                        <span><i class="feather icon-feather-download"></i></span>
                                                                        <span class="btn-double-text fw-600" data-text="<?php echo esc_attr($link['titulo']); ?>"><?php echo esc_html($link['titulo']); ?></span>
                                                                    </span>
                                                                </a>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- end stack card -->
                            </div>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <div class="no-entregas text-center p-50px">
                    <div class="container">
                        <p class="fs-16 text-medium-gray">Nenhuma entrega disponível no momento.</p>
                    </div>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    <?php endif; ?>
</main>

<!-- Modal do Crafto para Dropbox -->
<div id="dropbox-modal" class="white-popup-block mfp-hide col-xl-8 col-lg-10 col-md-11 col-11 mx-auto bg-black text-center modal-popup-main p-50px">
    <div class="mb-20px">
        <span class="text-white fw-600 fs-18">Preview do Arquivo</span>
    </div>
    <div id="dropbox-embedder" class="dropbox-embedder-container" style="min-height: 600px; width: 100%;">
        <!-- Dropbox embedder será inserido aqui -->
    </div>
    <div class="mt-20px">
        <a id="dropbox-download" href="#" target="_blank" class="btn btn-extra-large btn-rounded with-rounded btn-base-color text-white d-table d-lg-inline-block lg-mb-15px md-mx-auto">
            Download no Dropbox<span class="bg-dark-gray text-white"><i class="fa-solid fa-download"></i></span>
        </a>
    </div>
</div>



<style>
    /* Estilos específicos para área do cliente */
    .password-section {
        padding: 60px 0;
    }

    .cliente-intro {
        padding: 60px 0 40px 0;
    }


    .cliente-content-wrapper {
        background: rgba(255, 255, 255, 0.1);
        padding: 40px;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .cliente-content-wrapper h1,
    .cliente-content-wrapper h2,
    .cliente-content-wrapper h3,
    .cliente-content-wrapper h4,
    .cliente-content-wrapper h5,
    .cliente-content-wrapper h6 {
        color: #fff;
        margin-bottom: 20px;
    }

    .cliente-content-wrapper p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .cliente-content-wrapper a {
        color: var(--base-color, #007cba);
        text-decoration: none;
    }

    .cliente-content-wrapper a:hover {
        color: #fff;
        text-decoration: underline;
    }

    .entregas-section {
        padding: 40px 0 60px 0;
    }

    /* Espaçamento entre cards de entregas */
    .entregas-section .interactive-banner-style-02 {
        margin-bottom: 30px;
    }

    /* Garantir que o último card não tenha margin-bottom */
    .entregas-section .interactive-banner-style-02:last-child {
        margin-bottom: 0;
    }

    /* Ajuste mínimo para cards sem descrição */
    .entregas-section .interactive-banner-style-02 .position-relative.z-index-2 {
        min-height: 80px;
    }

    .no-entregas {
        padding: 50px;
        text-align: center;
    }

    .btn-download {
        width: 100%;
        padding: 15px;
        background: var(--base-color, #007cba);
        color: white;
        border-radius: 30px;
        text-decoration: none;
        display: block;
        text-align: center;
        font-weight: 500;
        transition: background-color 0.3s ease;
        border: none;
    }

    .btn-download:hover {
        background: var(--dark-gray, #6c757d);
        color: white;
        text-decoration: none;
    }

    .links-download .btn-download:last-child {
        margin-bottom: 0;
    }


    /* Responsividade */
    @media (max-width: 768px) {
        .password-section {
            padding: 40px 0;
        }

        .cliente-intro {
            padding: 40px 0 30px 0;
        }


        .cliente-content-wrapper {
            padding: 25px;
            margin: 0 15px;
        }

        .cliente-content-wrapper h1,
        .cliente-content-wrapper h2,
        .cliente-content-wrapper h3 {
            font-size: 24px;
        }

        .cliente-content-wrapper p {
            font-size: 15px;
        }

        .entregas-section {
            padding: 30px 0 40px 0;
        }

        /* Espaçamento reduzido no mobile */
        .entregas-section .interactive-banner-style-02 {
            margin-bottom: 20px;
        }

    }

    /* Estilos para modal Dropbox */
    .dropbox-embedder-container {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: auto;
        min-height: 600px;
        height: 600px;
        max-height: 600px;
    }

    .dropbox-embedder-container iframe {
        width: 100% !important;
        height: 600px !important;
        min-height: 600px !important;
        border: none;
        display: block;
        overflow: auto;
        overflow-y: scroll;
    }

    /* Botão de fechar personalizado */
    .popup-modal-dismiss {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .popup-modal-dismiss:hover {
        background: #e9ecef;
        color: #495057;
    }


    /* Estilos para cards desabilitados */
    .entrega-desabilitada {
        filter: grayscale(100%);
        pointer-events: none;
    }

    .entrega-desabilitada .stack-card-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    }

    .entrega-desabilitada img {
        filter: grayscale(100%) brightness(0.8);
    }

    .entrega-desabilitada .feature-box-icon {
        background-color: #e9ecef !important;
        border: 2px solid #dee2e6;
    }

    .entrega-desabilitada .status-indicator .badge {
        font-size: 11px !important;
        padding: 4px 8px;
    }

    /* Hover effect apenas para cards ativos */
    .stack-item:not(.entrega-desabilitada) .stack-card-item:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }

    /* Responsividade para modal Dropbox */
    @media (max-width: 768px) {

        /* Modal mais compacto no mobile */
        #dropbox-modal {
            padding: 20px !important;
            margin: 10px !important;
            max-width: calc(100vw - 20px) !important;
        }

        .dropbox-embedder-container {
            min-height: 400px;
            height: 400px;
            margin: 0 -10px;
            /* Usar toda largura disponível */
            width: calc(100% + 20px);
            overflow: hidden;
            /* Prevenir scroll duplo */
        }

        .dropbox-embedder-container iframe {
            height: 400px !important;
            min-height: 400px !important;
            width: 100% !important;
            overflow: hidden !important;
            /* Prevenir scroll duplo */
        }

        #dropbox-embedder {
            min-height: 400px !important;
        }

        /* Corrigir texto gigante do Dropbox */
        .dropbox-embedder-container .dropins-previewer-header-folder-name-container,
        .dropbox-embedder-container .dropins-text-primary {
            font-size: 14px !important;
            line-height: 1.2 !important;
            max-width: 200px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        /* Garantir que botões sejam clicáveis */
        .dropbox-embedder-container .dropins-previewer-header-actions {
            z-index: 10 !important;
            position: relative !important;
        }

        .dropbox-embedder-container .dropins-previewer-header-actions button,
        .dropbox-embedder-container .dropins-previewer-header-actions a {
            min-width: 32px !important;
            min-height: 32px !important;
            padding: 4px !important;
            z-index: 11 !important;
            position: relative !important;
        }
    }

    @media (max-width: 480px) {

        /* Mobile pequeno - otimização máxima */
        #dropbox-modal {
            padding: 15px !important;
            margin: 5px !important;
            max-width: calc(100vw - 10px) !important;
        }

        .dropbox-embedder-container {
            min-height: 350px;
            height: 350px;
            margin: 0 -5px;
            /* Usar toda largura disponível */
            width: calc(100% + 10px);
            overflow: hidden;
            /* Prevenir scroll duplo */
        }

        .dropbox-embedder-container iframe {
            height: 350px !important;
            min-height: 350px !important;
            width: 100% !important;
            overflow: hidden !important;
            /* Prevenir scroll duplo */
        }

        #dropbox-embedder {
            min-height: 350px !important;
        }

        /* Texto menor no mobile */
        #dropbox-modal .text-dark-gray {
            font-size: 16px !important;
        }

        /* Corrigir texto gigante do Dropbox - mobile pequeno */
        .dropbox-embedder-container .dropins-previewer-header-folder-name-container,
        .dropbox-embedder-container .dropins-text-primary {
            font-size: 12px !important;
            line-height: 1.1 !important;
            max-width: 150px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        /* Garantir que botões sejam clicáveis - mobile pequeno */
        .dropbox-embedder-container .dropins-previewer-header-actions {
            z-index: 10 !important;
            position: relative !important;
        }

        .dropbox-embedder-container .dropins-previewer-header-actions button,
        .dropbox-embedder-container .dropins-previewer-header-actions a {
            min-width: 28px !important;
            min-height: 28px !important;
            padding: 2px !important;
            z-index: 11 !important;
            position: relative !important;
        }

    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aguardar carregamento do Dropbox
        function waitForDropbox(callback) {
            if (typeof Dropbox !== 'undefined') {
                callback();
            } else {
                setTimeout(function() {
                    waitForDropbox(callback);
                }, 100);
            }
        }

        // Detectar links Dropbox
        const dropboxLinks = document.querySelectorAll('.dropbox-link');

        dropboxLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const dropboxUrl = this.href;
                openDropboxModal(dropboxUrl);
            });
        });

        function openDropboxModal(dropboxUrl) {
            // Configurar link de download
            document.getElementById('dropbox-download').href = dropboxUrl;

            // Limpar container
            const embedderContainer = document.getElementById('dropbox-embedder');
            embedderContainer.innerHTML = '<div class="text-center p-4"><i class="fa-solid fa-spinner fa-spin me-2"></i>Carregando preview...</div>';

            // Abrir modal
            if (typeof $.magnificPopup !== 'undefined') {
                $.magnificPopup.open({
                    items: {
                        src: '#dropbox-modal',
                        type: 'inline'
                    },
                    mainClass: 'mfp-fade',
                    removalDelay: 300
                });
            }

            // Aguardar Dropbox e fazer embeddin
            waitForDropbox(function() {
                const options = {
                    link: dropboxUrl,
                    folder: {
                        view: 'list',
                        headerSize: 'normal'
                    }
                };

                try {
                    Dropbox.embed(options, embedderContainer);

                    // Remover loading após embeddin
                    setTimeout(function() {
                        // Procurar e remover loading
                        const loadingElements = embedderContainer.querySelectorAll('.text-center');
                        loadingElements.forEach(function(element) {
                            if (element.textContent.includes('Carregando') || element.textContent.includes('spinner')) {
                                element.remove();
                            }
                        });
                    }, 2000);

                } catch (error) {
                    embedderContainer.innerHTML = '<div class="text-center p-4"><a href="' + dropboxUrl + '" target="_blank" class="btn btn-primary">Abrir no Dropbox</a></div>';
                }
            });
        }

        // Modal fecha automaticamente com o botão X do Crafto
    });
</script>

<!-- Script do Dropbox - carregado após jQuery -->
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="2u13n5v3ptjaec4"></script>

<?php get_footer(); ?>