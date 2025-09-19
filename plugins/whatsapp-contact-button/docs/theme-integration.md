# 🎨 Integração com Variáveis CSS do Tema

## 🎯 Visão Geral

O WhatsApp Contact Button v1.1.0+ foi desenvolvido para se integrar harmoniosamente com o design do seu tema WordPress através da variável CSS `--base-color`. Esta integração permite que o plugin adote automaticamente a cor principal do seu tema em elementos estratégicos, mantendo a consistência visual enquanto preserva a identidade do WhatsApp onde apropriado.

---

## 🔧 Como Funciona

### Variável CSS Principal

O plugin detecta e utiliza a variável CSS `--base-color` definida no seu tema:

```css
:root {
    --base-color: #ff6b6b; /* Sua cor principal */
}
```

### Sistema de Fallback Inteligente

Caso a variável `--base-color` não esteja definida, o plugin utiliza um fallback azul padrão do WordPress:

```css
:root {
    --wcb-theme-color: var(--base-color, #007cba);
    --wcb-theme-color-light: color-mix(in srgb, var(--wcb-theme-color) 20%, white);
    --wcb-theme-color-dark: color-mix(in srgb, var(--wcb-theme-color) 80%, black);
}
```

### Suporte a Navegadores Antigos

Para navegadores que não suportam `color-mix()`:

```css
@supports not (color: color-mix(in srgb, red, blue)) {
    :root {
        --wcb-theme-color-light: rgba(0, 124, 186, 0.1);
        --wcb-theme-color-dark: rgba(0, 124, 186, 0.8);
    }
}
```

---

## 🎨 Elementos que Utilizam a --base-color

### Frontend

#### 1. Campos de Formulário
```css
/* Estado de foco */
.wcb-form-container input:focus,
.wcb-form-container textarea:focus {
    border-color: var(--wcb-theme-color);
    box-shadow: 0 0 0 3px var(--wcb-theme-color-light);
}

/* Labels ativas */
.wcb-form-container label.active {
    color: var(--wcb-theme-color);
}
```

#### 2. Elementos Interativos
```css
/* Checkboxes */
input[type="checkbox"] {
    accent-color: var(--wcb-theme-color);
}

/* Links no modal */
.wcb-modal a {
    color: var(--wcb-theme-color);
}

/* Botão direto WhatsApp (quando não há formulário) */
.wcb-direct-whatsapp {
    background: linear-gradient(135deg, var(--wcb-theme-color) 0%, var(--wcb-theme-color-dark) 100%);
}
```

#### 3. Estados de Loading
```css
/* Spinner de carregamento */
.wcb-loading-spinner {
    border-left-color: var(--wcb-theme-color);
}

/* Indicadores de progresso */
.wcb-progress-bar {
    background-color: var(--wcb-theme-color);
}
```

### Painel Administrativo

#### 1. Cards de Analytics
```css
/* Números das métricas */
.wcb-card-number {
    color: var(--wcb-theme-color);
}

/* Ícones dos cards */
.wcb-card-icon {
    background: var(--wcb-theme-color-light);
    color: var(--wcb-theme-color);
}
```

#### 2. Botões de Ação
```css
/* Botão exportar */
.wcb-export-button {
    background: var(--wcb-theme-color);
}

.wcb-export-button:hover {
    background: var(--wcb-theme-color-dark);
}
```

#### 3. Estados de Status
```css
/* Status ativo */
.wcb-status-active {
    color: var(--wcb-theme-color);
}

/* Badges de notificação */
.wcb-badge {
    background: var(--wcb-theme-color);
}
```

---

## 🚀 Uso do Shortcode

### Sintaxe Básica

```php
[whatsapp_button]
```

### Parâmetros Disponíveis

```php
[whatsapp_button text="Fale Conosco" style="whatsapp" class="meu-botao"]
```

#### Parâmetros Detalhados:

- **text**: Texto do botão (padrão: "Fale conosco no WhatsApp")
- **style**: Estilo do botão
  - `theme` (padrão): Usa a `--base-color` do tema
  - `whatsapp`: Usa o verde tradicional do WhatsApp (#25D366)
- **class**: Classe CSS adicional para personalização


### Exemplos Práticos

#### Botão com cor do tema (padrão)
```php
[whatsapp_button text="Entre em Contato"]
```
**Resultado**: Botão com a cor principal do seu tema

#### Botão com verde do WhatsApp
```php
[whatsapp_button text="WhatsApp" style="whatsapp"]
```
**Resultado**: Botão com o verde tradicional #25D366

#### Botão personalizado
```php
[whatsapp_button text="Suporte Técnico" class="botao-suporte" style="whatsapp"]
```
**Resultado**: Botão com cor do tema + classe CSS personalizada

#### Múltiplos botões na mesma página
```php
<!-- Botão primário com cor do tema -->
[whatsapp_button text="Vendas" style="theme" class="btn-vendas"]

<!-- Botão secundário com verde WhatsApp -->
[whatsapp_button text="Suporte" style="whatsapp" class="btn-suporte"]
```

---

## 🎛️ Personalização Avançada

### Sobrescrevendo Cores Globalmente

```css
/* Forçar uma cor específica em todo o plugin */
:root {
    --wcb-theme-color: #your-custom-color !important;
    --wcb-theme-color-light: rgba(your-r, your-g, your-b, 0.1) !important;
    --wcb-theme-color-dark: #your-darker-color !important;
}
```

### Personalizando Elementos Específicos

```css
/* Apenas botões manuais */
.wcb-manual-button {
    background: linear-gradient(135deg, #custom-color 0%, #custom-darker 100%) !important;
}

/* Apenas campos de formulário */
.wcb-form-container input:focus {
    border-color: #custom-focus-color !important;
}

/* Apenas elementos do admin */
.wp-admin .wcb-card-number {
    color: #custom-admin-color !important;
}
```

### Criando Variações Temáticas

```css
/* Tema escuro personalizado */
[data-theme="dark"] {
    --wcb-theme-color: #light-accent-color;
    --wcb-theme-color-light: rgba(light-r, light-g, light-b, 0.2);
}

/* Tema alta acessibilidade */
[data-theme="high-contrast"] {
    --wcb-theme-color: #000000;
    --wcb-theme-color-light: #f0f0f0;
}
```

### Responsividade Personalizada

```css
/* Mobile - cores mais suaves */
@media (max-width: 768px) {
    :root {
        --wcb-theme-color-light: rgba(var(--base-color-rgb), 0.05);
    }
}

/* Desktop - cores mais intensas */
@media (min-width: 1200px) {
    :root {
        --wcb-theme-color-dark: color-mix(in srgb, var(--wcb-theme-color) 90%, black);
    }
}
```

---

## 🌈 Suporte a Temas Escuros

### Detecção Automática

```css
@media (prefers-color-scheme: dark) {
    .wcb-modal-content {
        background: #1e1e1e;
        color: #ffffff;
    }
    
    .wcb-form-container input {
        background: #2a2a2a;
        border-color: #444;
        color: #fff;
    }
}
```

### Implementação Manual

```css
/* Classe para tema escuro */
.dark-theme .wcb-modal {
    --wcb-bg-primary: #1a1a1a;
    --wcb-bg-secondary: #2d2d2d;
    --wcb-text-primary: #ffffff;
    --wcb-text-secondary: #cccccc;
}
```

---

## 🛠️ Implementação no Tema

### Definindo a --base-color

#### No arquivo `style.css`:
```css
:root {
    --base-color: #your-brand-color;
}
```

#### Via Customizer WordPress:
```php
// functions.php
function my_theme_customize_css() {
    $primary_color = get_theme_mod('primary_color', '#007cba');
    ?>
    <style>
        :root {
            --base-color: <?php echo esc_attr($primary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'my_theme_customize_css');
```

### Usando em Outros Elementos do Tema

```css
/* Consistência em todo o tema */
.site-header {
    background-color: var(--base-color);
}

.button-primary,
.btn-primary {
    background-color: var(--base-color);
    border-color: var(--base-color);
}

.button-primary:hover,
.btn-primary:hover {
    background-color: color-mix(in srgb, var(--base-color) 80%, black);
}

a:hover,
.link-primary {
    color: var(--base-color);
}

/* Elementos de destaque */
.highlight,
.accent {
    border-left: 4px solid var(--base-color);
}
```

---

## 🔧 Compatibilidade com Navegadores

### Função color-mix() - Suporte Moderno

```css
/* Navegadores modernos */
--wcb-theme-color-light: color-mix(in srgb, var(--wcb-theme-color) 20%, white);
--wcb-theme-color-dark: color-mix(in srgb, var(--wcb-theme-color) 80%, black);
```

### Fallbacks para Navegadores Antigos

```css
/* Fallback para IE/Edge antigo */
@supports not (color: color-mix(in srgb, red, blue)) {
    :root {
        --wcb-theme-color-light: rgba(0, 124, 186, 0.1);
        --wcb-theme-color-dark: rgba(0, 124, 186, 0.8);
    }
    
    /* Sobrescrever se --base-color disponível */
    [style*="--base-color"] {
        --wcb-theme-color-light: rgba(255, 255, 255, 0.1);
        --wcb-theme-color-dark: rgba(0, 0, 0, 0.2);
    }
}
```

### Graceful Degradation

```css
/* Se nenhuma variável CSS for suportada */
.no-css-vars .wcb-button {
    background: #007cba; /* Fallback estático */
}

.no-css-vars .wcb-form-container input:focus {
    border-color: #007cba;
}
```

---

## 📊 Benefícios da Integração

### 1. **Consistência Visual**
- Elementos seguem automaticamente a paleta do tema
- Reduz conflitos visuais entre plugin e tema
- Experiência de usuário mais coesa

### 2. **Facilidade de Manutenção**
- Alterar cor principal do tema atualiza o plugin automaticamente
- Não é necessário personalizar CSS adicional
- Gerenciamento centralizado de cores

### 3. **Flexibilidade de Design**
- Mantém identidade do WhatsApp onde apropriado
- Usa cores do tema em elementos secundários
- Suporte a múltiplas variações

### 4. **Acessibilidade Melhorada**
- Mantém contraste adequado através das variações automáticas
- Suporte a preferências de tema escuro
- Fallbacks para navegadores antigos

### 5. **Performance**
- Usa CSS nativo sem JavaScript adicional
- Variações de cor geradas automaticamente
- Carregamento otimizado

---

## 🔍 Troubleshooting

### Plugin não está usando a cor do tema

1. **Verificar definição da variável**:
```css
/* No CSS do tema, adicione: */
:root {
    --base-color: #your-color;
}
```

2. **Verificar especificidade CSS**:
```css
/* Remover !important que possa estar sobrescrevendo */
.some-class {
    color: red !important; /* ← Remover se estiver causando conflito */
}
```

3. **Testar em diferentes navegadores**:
- Chrome/Edge: Suporte completo
- Firefox: Suporte completo  
- Safari: Suporte a partir da versão 15
- IE: Fallback automático

### Cor muito clara ou escura

```css
/* Ajustar manualmente as variações */
:root {
    --wcb-theme-color-light: rgba(your-r, your-g, your-b, 0.15); /* Mais escuro */
    --wcb-theme-color-dark: rgba(your-r, your-g, your-b, 0.9);   /* Mais claro */
}
```

### Conflitos com outros plugins

```css
/* Usar seletores mais específicos */
.wcb-plugin-container .wcb-button {
    background: var(--base-color) !important;
}

/* Ou resetar apenas elementos do plugin */
.wcb-container * {
    color: inherit;
    background: inherit;
}
```

### Tema não define --base-color

```css
/* Definir manualmente no CSS do tema ou child theme */
:root {
    --base-color: #choose-your-color;
}
```

---

## 🎨 Exemplos Práticos por Tipo de Tema

### Tema Corporativo Azul
```css
:root {
    --base-color: #1e3a8a; /* Azul corporativo */
}
```
**Resultado**: Plugin harmoniza com identidade corporativa

### Tema E-commerce Rosa
```css
:root {
    --base-color: #ec4899; /* Rosa vibrante */
}
```
**Resultado**: Elementos em rosa com variações automáticas

### Tema Sustentabilidade Verde
```css
:root {
    --base-color: #059669; /* Verde eco */
}
```
**Resultado**: Harmonia natural com o verde do WhatsApp

### Tema Criativo Laranja
```css
:root {
    --base-color: #ea580c; /* Laranja criativo */
}
```
**Resultado**: Plugin se adapta mantendo energia do design

---

## 📝 Conclusão

A integração com `--base-color` torna o WhatsApp Contact Button verdadeiramente adaptável ao design do seu tema, proporcionando uma experiência visual profissional e coesa. O sistema robusto de fallbacks garante que o plugin funcione perfeitamente em qualquer ambiente, desde temas modernos até navegadores antigos.

**Principais vantagens:**
- ✅ Integração automática sem configuração adicional
- ✅ Manutenção simplificada com gerenciamento centralizado
- ✅ Flexibilidade total para personalização avançada
- ✅ Compatibilidade ampla com fallbacks inteligentes
- ✅ Performance otimizada com CSS nativo

---

**Desenvolvido com foco na harmonia visual e facilidade de uso.**  
**Versão**: v1.1.0+  
**Última atualização**: 16 Jul 2025