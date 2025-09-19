# Integração com Variáveis CSS do Tema

## Visão Geral

O plugin WhatsApp Contact Button foi desenvolvido para se integrar harmoniosamente com o design do seu tema WordPress através da variável CSS `--base-color`. Esta integração permite que o plugin adote automaticamente a cor principal do seu tema em elementos estratégicos, mantendo a consistência visual.

## Como Funciona

### Variável CSS Principal

O plugin detecta e utiliza a variável CSS `--base-color` definida no seu tema:

```css
:root {
    --base-color: #ff6b6b; /* Sua cor principal */
}
```

### Fallback Inteligente

Caso a variável `--base-color` não esteja definida, o plugin utiliza um fallback azul padrão do WordPress (`#007cba`):

```css
:root {
    --wcb-theme-color: var(--base-color, #007cba);
}
```

## Elementos que Utilizam a --base-color

### Frontend

#### 1. Campos de Formulário em Foco
- Borda dos campos quando em foco
- Sombra de foco (versão transparente da cor)

```css
.wcb-form-container input:focus {
    border-color: var(--wcb-theme-color);
    box-shadow: 0 0 0 3px var(--wcb-theme-color-light);
}
```

#### 2. Checkboxes
- Cor de seleção dos checkboxes

```css
input[type="checkbox"] {
    accent-color: var(--wcb-theme-color);
}
```

#### 3. Link Direto do WhatsApp
- Botão que aparece quando não há formulário configurado
- Usa gradiente da cor do tema

#### 4. Botão Manual (Shortcode)
- Por padrão, usa a cor do tema
- Pode ser alterado para verde WhatsApp com parâmetro `style="whatsapp"`

### Painel Administrativo

#### 1. Cards de Analytics
- Números das métricas principais
- Destaque visual dos dados importantes

#### 2. Botão de Exportar
- Botão de exportação de contatos
- Hover states com versão mais escura

#### 3. Elementos de Loading
- Spinners e indicadores de carregamento

## Uso do Shortcode

### Sintaxe Básica

```php
[whatsapp_button]
```

### Parâmetros Disponíveis

```php
[whatsapp_button text="Fale Conosco" style="theme" class="meu-botao"]
```

#### Parâmetros:

- **text**: Texto do botão (padrão: "Fale conosco no WhatsApp")
- **style**: Estilo do botão
  - `theme` (padrão): Usa a `--base-color` do tema
  - `whatsapp`: Usa o verde tradicional do WhatsApp
- **class**: Classe CSS adicional

### Exemplos de Uso

#### Botão com cor do tema (padrão)
```php
[whatsapp_button text="Entre em Contato"]
```

#### Botão com verde do WhatsApp
```php
[whatsapp_button text="WhatsApp" style="whatsapp"]
```

#### Botão personalizado
```php
[whatsapp_button text="Suporte" class="botao-suporte" style="theme"]
```

## Personalização Avançada

### Sobrescrevendo Cores

Você pode sobrescrever as cores do plugin no CSS do seu tema:

```css
/* Forçar uma cor específica */
.wcb-manual-button {
    background: linear-gradient(135deg, #your-color 0%, #your-darker-color 100%) !important;
}

/* Personalizar apenas elementos específicos */
.wcb-form-container input:focus {
    border-color: #custom-color !important;
}
```

### Criando Variações de Cor

```css
/* Variação secundária */
.wcb-manual-button.secondary {
    --wcb-theme-color: #secondary-color;
    --wcb-theme-color-dark: #secondary-color-dark;
}
```

### Suporte a Temas Escuros

O plugin automaticamente se adapta a temas escuros através de media queries:

```css
@media (prefers-color-scheme: dark) {
    .wcb-card {
        background: #1e1e1e;
        color: #fff;
    }
}
```

## Compatibilidade com Navegadores

### Função color-mix()

O plugin utiliza a função CSS `color-mix()` para criar variações automáticas da cor:

```css
--wcb-theme-color-light: color-mix(in srgb, var(--wcb-theme-color) 20%, white);
--wcb-theme-color-dark: color-mix(in srgb, var(--wcb-theme-color) 80%, black);
```

### Fallback para Navegadores Antigos

Para navegadores que não suportam `color-mix()`, há fallbacks definidos:

```css
@supports not (color: color-mix(in srgb, red, blue)) {
    :root {
        --wcb-theme-color-light: rgba(0, 124, 186, 0.1);
        --wcb-theme-color-dark: rgba(0, 124, 186, 0.8);
    }
}
```

## Implementação no Tema

### Definindo a --base-color

No arquivo `style.css` do seu tema:

```css
:root {
    --base-color: #your-brand-color;
}
```

### Usando em Outros Elementos

Você pode usar a mesma variável em outros elementos do tema:

```css
.site-header {
    background-color: var(--base-color);
}

.button-primary {
    background-color: var(--base-color);
}

a:hover {
    color: var(--base-color);
}
```

## Benefícios da Integração

### 1. Consistência Visual
- Todos os elementos seguem a mesma paleta de cores
- Reduz conflitos visuais entre tema e plugin

### 2. Facilidade de Manutenção
- Alterar a cor principal do tema automaticamente atualiza o plugin
- Não é necessário personalizar CSS adicional

### 3. Flexibilidade
- Mantém a identidade do WhatsApp onde apropriado
- Usa cores do tema em elementos secundários

### 4. Acessibilidade
- Mantém contraste adequado através das variações automáticas
- Suporte a preferências de tema escuro

## Troubleshooting

### Plugin não está usando a cor do tema

1. Verifique se a variável `--base-color` está definida no CSS do tema
2. Confirme que não há CSS com `!important` sobrescrevendo
3. Teste em diferentes navegadores

### Cor muito clara ou escura

O plugin automaticamente cria variações mais claras e escuras. Se necessário, você pode definir manualmente:

```css
:root {
    --wcb-theme-color-light: #your-light-color;
    --wcb-theme-color-dark: #your-dark-color;
}
```

### Conflitos com outros plugins

Se houver conflitos, você pode usar seletores mais específicos:

```css
.wcb-manual-button.priority-override {
    background: var(--base-color) !important;
}
```

## Exemplos Práticos

### Tema Azul Corporativo
```css
:root {
    --base-color: #2c5aa0;
}
```
Resultado: Botões e elementos em azul corporativo

### Tema Rosa Moderno
```css
:root {
    --base-color: #e91e63;
}
```
Resultado: Elementos em rosa com variações automáticas

### Tema Verde Sustentabilidade
```css
:root {
    --base-color: #4caf50;
}
```
Resultado: Harmonia com o verde do WhatsApp

## Conclusão

A integração com `--base-color` torna o plugin WhatsApp Contact Button verdadeiramente adaptável ao design do seu tema, proporcionando uma experiência visual coesa e profissional. O sistema de fallbacks garante que o plugin funcione perfeitamente mesmo em temas que não utilizam esta variável CSS.

