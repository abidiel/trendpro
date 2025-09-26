# Padrões de Desenvolvimento - Crafto + WordPress

## Framework Crafto - Helper Classes

### Font Size
```css
.fs-9 a .fs-400    /* 9px a 400px */
.fs-14             /* Texto padrão - 14px */
.fs-16             /* Texto body - 16px */
.fs-24             /* H4 - 24px */
.fs-32             /* H3 - 32px */
.fs-45             /* H2 - 45px */
.fs-60             /* H1 - 60px */
```

### Colors - Trend Pro
```css
/* Texto */
.text-white
.text-base-color           /* Azul principal */
.text-black
.text-dark-gray
.text-medium-gray
.text-light-gray

/* Background */
.bg-base-color             /* Azul principal */
.bg-white
.bg-dark-gray
.bg-light-gray
.bg-transparent

/* Gradientes */
.text-gradient-fast-blue-purple
.bg-gradient-light-blue-light-turquoise
```

### Spacing
```css
/* Margin */
.m-5px a .m-70px          /* Pixels */
.m-1 a .m-30              /* Percentual */
.mt-20px, .mb-20px        /* Top/Bottom */
.ms-15px, .me-15px        /* Left/Right */

/* Padding */
.p-5px a .p-70px          /* Pixels */
.p-1 a .p-30              /* Percentual */
.pt-20px, .pb-20px        /* Top/Bottom */
.ps-15px, .pe-15px        /* Left/Right */
```

### Layout
```css
/* Width & Height */
.w-100, .w-50, .w-25      /* Percentual */
.w-300px, .w-500px        /* Pixels */
.h-auto, .h-300px         /* Height */

/* Position */
.position-inherit
.absolute-middle-center
.absolute-top-center
.absolute-bottom-center

/* Border */
.border-radius-5px a .border-radius-100px
.border-1 a .border-10
.border-color-base-color
```

## Padrões WordPress + ACF

### 1. Exibição de Campos
```php
<!-- ✅ CORRETO: Escape direto -->
<h2><?php echo esc_html(get_field('titulo_campo')); ?></h2>
<p><?php echo wp_kses_post(get_field('descricao')); ?></p>
<a href="<?php echo esc_url(get_field('link')); ?>">Link</a>

<!-- ❌ EVITAR: Variáveis desnecessárias -->
<?php $titulo = get_field('titulo'); ?>
<h2><?php echo esc_html($titulo); ?></h2>
```

### 2. Funções de Escape
```php
esc_html()      // Texto sem HTML
wp_kses_post()  // Texto com HTML permitido
esc_url()       // URLs e links
esc_attr()      // Atributos HTML
wp_json_encode() // Dados para JavaScript
```

### 3. Imagens - Sempre usar wp_get_attachment_image
```php
<?php
$imagem = get_field('campo_imagem');
if ($imagem):
    echo wp_get_attachment_image(
        $imagem['ID'],
        'large',           // Tamanho registrado
        false,
        array(
            'class' => 'img-responsiva',
            'loading' => 'lazy'
        )
    );
endif;
?>
```

### 4. Verificação de Existência
```php
<!-- Para campos simples -->
<?php if (get_field('campo')): ?>
    <div><?php echo esc_html(get_field('campo')); ?></div>
<?php endif; ?>

<!-- Para campos longos -->
<?php if (!empty(get_field('conteudo'))): ?>
    <div><?php echo wp_kses_post(get_field('conteudo')); ?></div>
<?php endif; ?>
```

### 5. Links ACF
```php
<?php
$link = get_field('campo_link');
if ($link): ?>
    <a href="<?php echo esc_url($link['url']); ?>" 
       target="<?php echo esc_attr($link['target']); ?>"
       class="botao bg-base-color text-white p-15px border-radius-5px">
        <?php echo esc_html($link['title']); ?>
    </a>
<?php endif; ?>
```

### 6. Repeaters
```php
<?php if (have_rows('nome_repeater')): ?>
    <div class="grid">
        <?php while (have_rows('nome_repeater')): the_row(); ?>
            <div class="item p-20px">
                <h3 class="fs-24 text-base-color mb-10px">
                    <?php echo esc_html(get_sub_field('titulo')); ?>
                </h3>
                <p class="fs-16 text-dark-gray">
                    <?php echo wp_kses_post(get_sub_field('descricao')); ?>
                </p>
                
                <?php
                $item_imagem = get_sub_field('imagem');
                if ($item_imagem):
                    echo wp_get_attachment_image(
                        $item_imagem['ID'],
                        'medium',
                        false,
                        array('class' => 'w-100 border-radius-10px')
                    );
                endif;
                ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
```

### 7. Posts Relacionados
```php
<?php
$posts = get_field('posts_relacionados');
if ($posts): ?>
    <div class="posts-relacionados">
        <?php foreach ($posts as $post): ?>
            <article class="post-item p-20px bg-light-gray border-radius-10px">
                <h3 class="fs-24 mb-10px">
                    <?php echo esc_html(get_the_title($post->ID)); ?>
                </h3>
                <p class="fs-14 text-medium-gray mb-15px">
                    <?php echo esc_html(get_the_excerpt($post->ID)); ?>
                </p>
                <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" 
                   class="text-base-color fw-600">
                    Ler mais
                </a>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
```

## Componentes Padrão - Trend Pro

### Hero Section
```php
<section class="hero bg-gradient-fast-blue-purple min-h-600px">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="fs-60 text-white fw-700 mb-20px">
                    <?php echo esc_html(get_field('hero_titulo')); ?>
                </h1>
                <p class="fs-18 text-white mb-30px">
                    <?php echo wp_kses_post(get_field('hero_subtitulo')); ?>
                </p>
                <?php
                $hero_cta = get_field('hero_cta');
                if ($hero_cta): ?>
                    <a href="<?php echo esc_url($hero_cta['url']); ?>" 
                       class="btn bg-white text-base-color p-15px border-radius-5px fw-600">
                        <?php echo esc_html($hero_cta['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
```

### Card de Serviço
```php
<div class="servico-card bg-white p-30px border-radius-15px">
    <?php
    $servico_icone = get_sub_field('icone');
    if ($servico_icone):
        echo wp_get_attachment_image(
            $servico_icone['ID'],
            'thumbnail',
            false,
            array('class' => 'icon-large mb-20px')
        );
    endif;
    ?>
    
    <h3 class="fs-28 text-dark-gray fw-600 mb-15px">
        <?php echo esc_html(get_sub_field('titulo')); ?>
    </h3>
    
    <p class="fs-16 text-medium-gray mb-20px">
        <?php echo wp_kses_post(get_sub_field('descricao')); ?>
    </p>
    
    <?php
    $servico_link = get_sub_field('link');
    if ($servico_link): ?>
        <a href="<?php echo esc_url($servico_link['url']); ?>" 
           class="text-base-color fw-600 fs-14">
            <?php echo esc_html($servico_link['title']); ?> →
        </a>
    <?php endif; ?>
</div>
```

## Checklist de Revisão

### ✅ Segurança
- [ ] Todos os outputs têm escape apropriado
- [ ] Verificação de existência de campos ACF
- [ ] Sanitização de inputs (se houver)

### ✅ Performance
- [ ] Imagens usam wp_get_attachment_image()
- [ ] Lazy loading implementado
- [ ] Classes CSS otimizadas (Crafto)

### ✅ SEO
- [ ] Estrutura semântica (H1, H2, H3...)
- [ ] Alt text em imagens
- [ ] Meta tags implementadas

### ✅ Acessibilidade
- [ ] Contraste adequado
- [ ] Navegação por teclado
- [ ] Textos alternativos

### ✅ Responsividade
- [ ] Classes Crafto para mobile
- [ ] Testes em dispositivos
- [ ] Breakpoints funcionando

## Convenções de Código

### Indentação
- 4 espaços para PHP
- 2 espaços para HTML/CSS

### Nomenclatura
- **Campos ACF**: snake_case (ex: titulo_principal)
- **Classes CSS**: kebab-case (ex: servico-card)
- **Variáveis PHP**: snake_case (ex: $posts_relacionados)

### Comentários
```php
// Título da seção
<?php if (get_field('titulo_secao')): ?>
    <!-- Comentário HTML quando necessário -->
<?php endif; ?>
```