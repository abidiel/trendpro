# WhatsApp Contact Button - Documentação Técnica

## 🎯 Visão Geral

O WhatsApp Contact Button é um plugin WordPress completo para captura de leads através de um botão flutuante de WhatsApp integrado com Contact Form 7. O plugin oferece funcionalidades avançadas de analytics, mapeamento por página e sistema de prioridades flexível para configurações.

**Versão Atual:** v1.1.1  
**Compatibilidade:** WordPress 5.0+, PHP 7.4+  
**Dependências:** Contact Form 7 (recomendado), ACF (opcional)

---

## 🏗️ Arquitetura do Plugin

### Estrutura de Arquivos

```
whatsapp-contact-button/
├── whatsapp-contact-button.php     # Core plugin + classe principal
├── includes/
│   ├── admin.php                   # Interface admin (3 abas)
│   ├── frontend.php                # Funcionalidades frontend
│   ├── cf7-integration.php         # Integração Contact Form 7
│   ├── database.php                # Operações banco de dados
│   ├── analytics.php               # Queries analytics
│   └── notifications.php           # Sistema emails
├── assets/
│   ├── css/
│   │   ├── admin.css               # Estilos admin
│   │   └── style.css               # Frontend + integração --base-color
│   └── js/
│       ├── admin.js                # Funcionalidades admin
│       └── script.js               # Frontend + tracking
├── readme.txt                      # Documentação WordPress
├── DOCUMENTATION.md                # Esta documentação
├── THEME-INTEGRATION.md            # Guia integração com temas
└── uninstall.php                   # Limpeza dados
```

### Classes Principais

#### WhatsAppContactButton (Classe Principal)
- **Localização**: `whatsapp-contact-button.php`
- **Responsabilidade**: Inicialização, hooks e configurações globais
- **Métodos principais**:
  - `init()`: Inicializa o plugin
  - `get_whatsapp_number()`: Número com sistema de prioridade
  - `get_option()`: Configurações do plugin
  - `is_cf7_active()`: Verifica CF7

#### WCB_Frontend
- **Localização**: `includes/frontend.php`
- **Responsabilidade**: Funcionalidades frontend e mapeamento por página (v1.1.0)
- **Métodos principais**:
  - `get_popup_text_with_priority()`: Texto popup com prioridade
  - `get_whatsapp_message_with_priority()`: Mensagem com prioridade
  - `get_current_page_context()`: Contexto da página atual (MELHORADO v1.1.0)
  - `matches_page_context()`: Verifica mapeamento
  - `get_specific_form_for_page()`: Formulário específico com prioridade (NOVO v1.1.0)

#### WCB_CF7_Integration
- **Localização**: `includes/cf7-integration.php`
- **Responsabilidade**: Integração Contact Form 7
- **Métodos principais**:
  - `handle_form_submission()`: Processa envio CF7
  - `generate_whatsapp_url()`: Gera URL WhatsApp
  - `extract_slug_from_url()`: Extrai slug da URL
  - `replace_message_variables()`: Substitui variáveis

#### WCB_Admin
- **Localização**: `includes/admin.php`
- **Responsabilidade**: Interface administrativa
- **Métodos principais**:
  - `contacts_tab()`: Aba contatos
  - `analytics_tab()`: Aba analytics
  - `settings_tab()`: Aba configurações

---

## 🗄️ Banco de Dados

### Tabela: `{prefix}_whatsapp_contacts`

```sql
CREATE TABLE {prefix}_whatsapp_contacts (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    phone varchar(50) NOT NULL,
    consent tinyint(1) DEFAULT 1,
    page_title varchar(500) DEFAULT NULL,
    page_url varchar(1000) DEFAULT NULL,
    page_slug varchar(255) DEFAULT NULL,
    device_type varchar(20) DEFAULT NULL,
    user_agent text,
    submit_time datetime NOT NULL,
    whatsapp_redirect_time datetime DEFAULT NULL,
    status varchar(50) DEFAULT 'Novo',
    form_data longtext,
    PRIMARY KEY (id),
    KEY idx_submit_time (submit_time),
    KEY idx_page_slug (page_slug),
    KEY idx_status (status)
);
```

### Tabela: `{prefix}_whatsapp_analytics`

```sql
CREATE TABLE {prefix}_whatsapp_analytics (
    id int(11) NOT NULL AUTO_INCREMENT,
    event_type varchar(50) NOT NULL,
    page_title varchar(500) DEFAULT NULL,
    page_url varchar(1000) DEFAULT NULL,
    page_slug varchar(255) DEFAULT NULL,
    device_type varchar(20) DEFAULT NULL,
    user_agent text,
    session_id varchar(100) DEFAULT NULL,
    contact_id int(11) DEFAULT NULL,
    event_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_event_type (event_type),
    KEY idx_event_time (event_time),
    KEY idx_page_slug (page_slug),
    KEY idx_contact_id (contact_id)
);
```

---

## ⚙️ Sistema de Configurações

### Opções Salvas no `wp_options`

```php
// Configurações principais
'wcb_enabled' => true/false
'wcb_button_position' => 'bottom-right'|'bottom-left'

// WhatsApp - Sistema de Prioridade
'wcb_whatsapp_number' => '5511999999999'  // Específico plugin (prioridade 1)
// ACF 'whatsapp' field                   // Número principal (prioridade 2)

// Configurações globais do plugin
'wcb_default_form_id' => 123
'wcb_default_popup_text' => 'Texto padrão...'
'wcb_default_whatsapp_message' => 'Olá! Sou {nome_usuario}...'

// Mapeamentos específicos por página
'wcb_form_mappings' => [
    [
        'type' => 'slug',                    // slug|category|post_type|page_template
        'value' => 'contato',                // Valor para comparar
        'form_id' => 456,                    // ID do CF7
        'popup_text' => 'Texto específico...',
        'whatsapp_message' => 'Mensagem específica...'
    ]
]

// Sistema
'wcb_notification_emails' => ['admin@site.com']
'wcb_delete_data_on_uninstall' => false
```

### Campos ACF (Opções do Tema)

```php
// Campo obrigatório nas Options do tema
'whatsapp' => '55 (11) 99999-9999'  // Número principal do site

// Campos DEPRECADOS (não mais utilizados)
'whatsapp_texto_popup'    // Substituído por wcb_default_popup_text
'whatsapp_mensagem_base'  // Substituído por wcb_default_whatsapp_message
```

---

## 🔄 Sistema de Prioridades (v1.1.0)

### Ordem de Precedência para Mapeamentos
1️⃣ Slug da página (mais específico)
2️⃣ Categoria/Taxonomia
3️⃣ Tipo de post (menos específico)

### Exemplo Prático
Página: /projetos/evento-experiencia-lendaria/

Tipo de post: "projetos"
Categoria: "cobertura-de-evento"

Mapeamentos configurados:

Tipo "projetos" → Formulário A
Categoria "cobertura-de-evento" → Formulário B

Resultado: Usa Formulário B (categoria tem prioridade)

### 1. Número WhatsApp
```
1️⃣ Plugin (wcb_whatsapp_number) 
2️⃣ ACF Options (whatsapp)
```

### 2. Texto do Popup
```
1️⃣ Específico da página (mapeamento)
2️⃣ Plugin (wcb_default_popup_text)
3️⃣ ACF (whatsapp_texto_popup) [FALLBACK]
```

### 3. Mensagem WhatsApp
```
1️⃣ Específica da página (mapeamento)
2️⃣ Plugin (wcb_default_whatsapp_message)
3️⃣ ACF (whatsapp_mensagem_base) [FALLBACK]
```

### 4. Formulário CF7
```
1️⃣ Específico da página (mapeamento)
2️⃣ Plugin (wcb_default_form_id)
3️⃣ Link direto WhatsApp (se nenhum configurado)
```

---

## 📋 Interface Admin - 3 Abas

### **Aba 1: Contatos**
- **Listagem completa** com filtros avançados
  - Status, página, data, busca por nome/email/telefone
- **Ações em massa** (deletar, alterar status)
- **Exportação CSV** com todos os campos do formulário
- **Modal "Ver"** com detalhes completos do contato
- **Paginação** automática (20 por página)
- **Estados de contato**: Novo, Contatado, Convertido, Perdido

### **Aba 2: Analytics**
- **Cards de métricas** principais
  - Cliques no botão, formulários enviados, redirecionamentos
  - Taxa de conversão automática
- **Gráfico de funil** interativo (Chart.js)
- **Top páginas geradoras** com métricas detalhadas
- **Filtros por período** personalizáveis
- **Dados em tempo real**

### **Aba 3: Configurações**

#### **Seção 1: Número WhatsApp Principal**
- Status do campo ACF `whatsapp`
- Exibe número configurado ou alerta se não configurado

#### **Seção 2: Número Específico do Botão**
- Campo opcional para sobrescrever número principal
- Explicação clara de quando usar
- Status visual do número ativo
- Informações sobre prioridade

#### **Seção 3: Configurações Globais**
- Formulário CF7 padrão
- Texto popup padrão
- Mensagem WhatsApp padrão
- Sistema de variáveis personalizáveis

#### **Seção 4: Mapeamento por Página (v1.1.0)**
- Configurações específicas por slug/categoria/post_type
- Formulário, texto e mensagem específicos
- Interface drag-and-drop para adicionar/remover
- Disclaimer explicativo sobre tipos e prioridades (NOVO v1.1.0)
- Exemplos de configuração

#### **Seção 5: Sistema**
- Emails para notificações
- Configurações de desinstalação

## 🎯 Mapeamento por Página (v1.1.0)
### Tipos de Mapeamento Suportados
'slug'          // Slug específico da página (ex: 'contato', 'sobre')
'category'      // Categoria de posts/CPT (ex: 'noticias', 'cobertura-de-evento')
'post_type'     // Tipo de post (ex: 'product', 'service', 'projetos')
'page_template' // Template de página (ex: 'page-contact.php')

Contexto da Página
O plugin detecta automaticamente:

$context = [
    'slug' => 'contato',                    // Slug da página atual
    'post_type' => 'page',                  // Tipo do post
    'categories' => ['noticias', 'blog'],   // TODAS as taxonomias (v1.1.0)
    'template' => 'page-contact',           // Template da página
    'is_front_page' => false,               // Se é página inicial
    'is_home' => false                      // Se é página do blog
];

Taxonomias Suportadas (v1.1.0)

✅ Posts padrão: category, post_tag
✅ Custom Post Types: Qualquer taxonomia customizada
✅ Exemplos: categoria de projetos, tipo de serviço, tag de produto
✅ Universal: Mesma categoria funciona em posts e CPTs

Exemplos de Configuração
php// Página específica
['type' => 'slug', 'value' => 'contato']

// Categoria universal (posts + CPTs)
['type' => 'category', 'value' => 'cobertura-de-evento']

// Tipo de post customizado
['type' => 'post_type', 'value' => 'projetos']

// Página inicial
['type' => 'slug', 'value' => 'front-page']


---

## 📝 Configuração Contact Form 7

### Estrutura Recomendada do Formulário

Para funcionar corretamente com o plugin, o formulário CF7 deve seguir esta estrutura:

```html
<!-- Conteúdo HTML personalizado (PERMITIDO) -->
<h3>Entre em contato conosco</h3>
<p>Preencha os dados abaixo e entraremos em contato via WhatsApp:</p>

<!-- Campos obrigatórios (nomes específicos) -->
<label>Seu nome *
    [text* your-name autocomplete:name]</label>

<label>Seu e-mail *
    [email* your-email autocomplete:email]</label>

<label>Telefone *
    [tel* your-phone]</label>

<!-- Campos personalizados opcionais -->
<label>Data do evento
    [text data-evento]</label>

<label>Como nos conheceu?
    [select origem "Google" "Facebook" "Indicação" "Outros"]</label>

<label>Observações
    [textarea observacoes]</label>

[submit "Enviar"]

<!-- Campos ocultos OBRIGATÓRIOS (adicionar manualmente) -->
[hidden wcb_whatsapp_form "1"]
<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">
<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">
<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">
```

### Campos Obrigatórios

O plugin detecta automaticamente os seguintes campos (use **pelo menos um de cada grupo**):

#### **Nome** (obrigatório)
- `your-name`, `name`, `nome`, `first-name`, `firstname`

#### **Email** (obrigatório)  
- `your-email`, `email`, `e-mail`

#### **Telefone** (obrigatório)
- `your-phone`, `phone`, `telefone`, `tel`, `celular`, `whatsapp`

### Campos Ocultos Obrigatórios

**Estes campos DEVEM estar presentes** para o plugin funcionar:

```html
<!-- Identifica como formulário do plugin -->
[hidden wcb_whatsapp_form "1"]

<!-- Campos preenchidos automaticamente pelo JavaScript -->
<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">
<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">
<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">
```

### Personalização do Conteúdo

**✅ PERMITIDO:**
- Títulos e parágrafos HTML
- Textos explicativos
- Campos personalizados adicionais
- Formatação com CSS
- Elementos visuais (ícones, imagens)

```html
<!-- Exemplo de personalização -->
<div class="form-intro">
    <h3>💬 Fale Conosco</h3>
    <p>Estamos aqui para ajudar! Preencha o formulário e nossa equipe entrará em contato via WhatsApp.</p>
</div>

<div class="form-section">
    <h4>📝 Seus dados</h4>
    [text* your-name placeholder "Digite seu nome"]
    [email* your-email placeholder "seu@email.com"]
    [tel* your-phone placeholder "(11) 99999-9999"]
</div>

<div class="form-section">
    <h4>📅 Sobre seu evento</h4>
    [text data-evento placeholder "Ex: 15/12/2024"]
    [textarea observacoes placeholder "Conte-nos mais detalhes..."]
</div>
```

### Exemplos por Contexto

#### **Formulário de Contato Geral**
```html
<h3>Entre em contato</h3>
<p>Nossa equipe responderá em até 2 horas!</p>

[text* your-name placeholder "Seu nome"]
[email* your-email placeholder "Seu e-mail"]
[tel* your-phone placeholder "Seu WhatsApp"]
[textarea observacoes placeholder "Como podemos ajudar?"]

[submit "Enviar mensagem"]
[hidden wcb_whatsapp_form "1"]
<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">
<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">
<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">
```

#### **Formulário para Orçamento**
```html
<h3>Solicitar Orçamento</h3>
<p>Receba uma proposta personalizada via WhatsApp!</p>

[text* your-name placeholder "Nome da empresa"]
[email* your-email placeholder "E-mail comercial"]
[tel* your-phone placeholder "WhatsApp para contato"]
[select tipo-servico "Desenvolvimento" "Consultoria" "Suporte" "Outros"]
[text orcamento placeholder "Orçamento estimado"]
[textarea detalhes placeholder "Descreva seu projeto..."]

[submit "Solicitar orçamento"]
[hidden wcb_whatsapp_form "1"]
<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">
<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">
<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">
```

#### **Formulário para Eventos**
```html
<h3>Informações do Evento</h3>
<p>Planejamos seu evento dos sonhos!</p>

[text* your-name placeholder "Nome do contratante"]
[email* your-email placeholder "E-mail principal"]
[tel* your-phone placeholder "WhatsApp"]
[text data-evento placeholder "Data do evento"]
[text local-evento placeholder "Local aproximado"]
[number convidados placeholder "Número de convidados"]
[select tipo-evento "Casamento" "Aniversário" "Corporativo" "Outros"]

[submit "Solicitar contato"]
[hidden wcb_whatsapp_form "1"]
<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">
<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">
<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">
```

### Troubleshooting CF7

#### **Formulário não captura dados**
1. Verifique se campos obrigatórios têm os nomes corretos
2. Confirme se campos ocultos estão presentes
3. Teste em navegador sem cache

#### **Redirecionamento não funciona**
1. Verifique se `[hidden wcb_whatsapp_form "1"]` está presente
2. Confirme se CF7 está ativo e atualizado
3. Verifique console do navegador para erros

#### **Campos não aparecem na exportação**
- Todos os campos do formulário são salvos automaticamente
- Campos personalizados aparecem na seção "Observações" do CSV

---

## 🎯 Mapeamento por Página

### Tipos de Mapeamento Suportados

```php
'slug'          // Slug específico da página (ex: 'contato', 'sobre')
'category'      // Categoria de posts (ex: 'noticias', 'blog')
'post_type'     // Tipo de post (ex: 'product', 'service')
'page_template' // Template de página (ex: 'page-contact.php')
```

### Contexto da Página

O plugin detecta automaticamente:

```php
$context = [
    'slug' => 'contato',           // Slug da página atual
    'post_type' => 'page',         // Tipo do post
    'categories' => ['noticias'],  // Categorias (se post)
    'template' => 'page-contact',  // Template da página
    'is_front_page' => false,      // Se é página inicial
    'is_home' => false            // Se é página do blog
];
```

### Exemplos de Configuração

```php
// Página específica
['type' => 'slug', 'value' => 'contato']

// Categoria de posts
['type' => 'category', 'value' => 'noticias']

// Tipo de post customizado
['type' => 'post_type', 'value' => 'product']

// Página inicial
['type' => 'slug', 'value' => 'front-page']
```

---

## 🧪 Sistema de Variáveis

### Variáveis Disponíveis

```php
'{nome_usuario}'     => Nome do formulário
'{email_usuario}'    => Email do formulário
'{telefone_usuario}' => Telefone do formulário
'{titulo_pagina}'    => Título da página atual
'{url_pagina}'       => URL da página atual
'{data_atual}'       => Data formatada atual
'{hora_atual}'       => Hora formatada atual
'{dispositivo}'      => Tipo de dispositivo (desktop/mobile/tablet)
```

### Exemplo de Mensagem

```
Olá! Sou {nome_usuario} ({email_usuario}).
Vim através da página {titulo_pagina} em {data_atual}
e gostaria de conversar sobre seus serviços.
Estou usando {dispositivo} para acessar o site.
```

---

## 📱 Fluxo Completo do Sistema

## 🛡️ Sistema de Validação Aprimorado (v1.1.1)

### Visão Geral

O plugin implementa um sistema híbrido de validação que **preserva o comportamento nativo do CF7** enquanto adiciona melhorias visuais e correções específicas para o contexto do modal.

### Comportamento Nativo Preservado

#### **Acceptance (Checkboxes de Termos)**
// Botão automaticamente desabilitado quando acceptance desmarcado
// Re-habilitado quando marcado
// Comportamento 100% nativo do Contact Form 7

Validação de Campos

✅ Campos obrigatórios: Validação nativa CF7
✅ Formato de email: Validação nativa CF7
✅ Mensagens de erro: Exibição nativa CF7
✅ Estados visuais: Integração com classes CF7

### 1. Carregamento da Página
```php
// frontend.php - enqueue_scripts()
$localized_data = [
    'whatsapp_number' => WhatsAppContactButton::get_whatsapp_number(),
    'base_message' => $this->get_whatsapp_message_with_priority(),
    'popup_text' => $this->get_popup_text_with_priority(),
    'form_shortcode' => $this->get_form_shortcode_for_current_page()
];
```

### 2. Clique no Botão
```javascript
// script.js
wcbTrackEvent('click');  // Analytics
wcbOpenModal();          // Abre modal
```

### 3. Exibição do Modal
```php
// frontend.php - render_button_and_modal()
// Modal com formulário específico da página ou padrão
// Texto personalizado baseado em prioridade
```

### 4. Envio do Formulário
```javascript
// Event wpcf7mailsent
wcbTrackEvent('submit');
ajax_process_cf7_submission();
```

### 5. Processamento Backend
```php
// cf7-integration.php
handle_form_submission();     // Salva contato
generate_whatsapp_url();      // Monta URL com mensagem específica
extract_slug_from_url();      // Fallback para detecção de slug
replace_message_variables();  // Substitui variáveis
```

### 6. Redirecionamento
```javascript
window.open(whatsapp_url, '_blank');
wcbTrackEvent('redirect', contact_id);
```



---

## 🎨 Integração com Temas

### Variável CSS Principal

```css
:root {
    --base-color: #your-brand-color;
}
```

### Elementos que Usam --base-color

- Campos de formulário em foco
- Checkboxes e elementos interativos
- Botões secundários e links
- Cards de analytics no admin
- Elementos de loading

### Fallback Automático

```css
:root {
    --wcb-theme-color: var(--base-color, #007cba);
    --wcb-theme-color-light: color-mix(in srgb, var(--wcb-theme-color) 20%, white);
    --wcb-theme-color-dark: color-mix(in srgb, var(--wcb-theme-color) 80%, black);
}
```

---

## 🔧 Principais Funções e Hooks

### Hooks WordPress Utilizados

```php
// Admin
add_action('admin_menu', 'add_admin_menu');
add_action('admin_init', 'admin_init');
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

// Frontend
add_action('wp_enqueue_scripts', 'enqueue_scripts');
add_action('wp_footer', 'render_button_and_modal');

// CF7 Integration
add_action('wpcf7_mail_sent', 'handle_form_submission');
add_filter('wpcf7_form_elements', 'add_hidden_fields');

// AJAX
add_action('wp_ajax_wcb_track_event', 'ajax_track_event');
add_action('wp_ajax_wcb_process_cf7_submission', 'ajax_process_submission');
```

### Funções de Prioridade (v1.1.0)

```php
// Sistema de prioridade implementado
$frontend->get_popup_text_with_priority();
$frontend->get_whatsapp_message_with_priority();
$frontend->get_specific_popup_text();
$frontend->get_specific_whatsapp_message();
$frontend->get_specific_form_for_page();        // NOVO v1.1.0
```

---

## 🔍 Analytics e Tracking

### Eventos Rastreados

```php
'click'    => Clique no botão WhatsApp
'submit'   => Envio do formulário CF7
'redirect' => Redirecionamento para WhatsApp
```

### Métricas Calculadas

```php
$click_to_submit = ($submits / $clicks) * 100;
$submit_to_redirect = ($redirects / $submits) * 100;
```

### Dados Coletados

```php
$analytics_data = [
    'event_type' => $event_type,
    'page_title' => $page_title,
    'page_url' => $page_url,
    'page_slug' => $page_slug,
    'device_type' => $device_type,
    'session_id' => $session_id,
    'contact_id' => $contact_id
];
```

---

## 🛡️ Segurança

### Sanitização

```php
// Dados de entrada
$data['name'] = sanitize_text_field($data['name']);
$data['email'] = sanitize_email($data['email']);
$data['phone'] = sanitize_text_field($data['phone']);

// Número WhatsApp
$whatsapp_number = preg_replace('/[^0-9]/', '', $_POST['wcb_whatsapp_number']);
```

### Verificações AJAX

```php
check_ajax_referer('wcb_frontend_nonce', 'nonce');
if (!current_user_can('manage_options')) wp_die();
```

### Escape de Output

```php
echo esc_html($contact->name);
echo esc_url($contact->page_url);
echo esc_attr($contact->device_type);
```

---

## 🚀 Performance

### Carregamento Condicional

```php
// Assets apenas quando necessário
if (!WhatsAppContactButton::get_option('wcb_enabled', true)) {
    return;
}
```

### Otimizações

- Minificação de assets
- Lazy loading de componentes
- Cache de consultas pesadas
- Queries otimizadas com índices

## ✅ Checklist de Testes v1.1.0

### **1. Teste Global:**
- [ ] Home page → Formulário padrão
- [ ] Página qualquer → Formulário padrão
- [ ] Variáveis funcionando

### **2. Teste por Categoria:**
- [ ] Post categoria "noticias" → Formulário específico
- [ ] CPT "projetos" categoria "cobertura-de-evento" → Formulário específico ✅ NOVO
- [ ] Campos personalizados aparecendo

### **3. Teste de Prioridade:** ✅ NOVO
- [ ] Página com múltiplos mapeamentos
- [ ] Categoria sobrepõe tipo de post
- [ ] Slug sobrepõe categoria
- [ ] Logs de debug funcionando

### **4. Teste de Variáveis:**
- [ ] `{nome_usuario}` substitui corretamente
- [ ] `{titulo_pagina}` captura título correto
- [ ] `{url_pagina}` captura URL correta
- [ ] Data/hora funcionando
- [ ] Dispositivo detectado

---

---

## 🔧 Troubleshooting

### Problemas Comuns

#### 1. Formulário envia sem validar (CORRIGIDO v1.1.1)
**Sintoma**: Formulário envia mesmo com campos vazios quando acceptance desmarcado
**Solução**: Atualizar para v1.1.1 que corrige este bug crítico

```php
// Verificar se correção está ativa
console.log('Observer ativo:', !!window.wcbObserver);
console.log('Eventos CF7:', $._data(document, 'events'));

#### 1. Mapeamento não funciona (v1.1.0)
```php
// Debug: verificar contexto da página
$context = $frontend->get_current_page_context();
error_log('WCB Context: ' . print_r($context, true));

// Debug: verificar mapeamento
$mappings = get_option('wcb_form_mappings');
error_log('WCB Mappings: ' . print_r($mappings, true));

// Verificar prioridade
error_log('WCB: Using mapping type X for page Y');
```

#### 1. Mensagem específica não funciona
```php
// Debug: verificar mapeamento
$mappings = get_option('wcb_form_mappings');
error_log('Mappings: ' . print_r($mappings, true));

// Debug: verificar contexto
$context = $frontend->get_current_page_context();
error_log('Context: ' . print_r($context, true));
```

#### 2. Botão não aparece
- Verificar `wcb_enabled`
- Verificar conflitos CSS/JS
- Verificar console do navegador

#### 3. Formulário não captura dados
- Verificar CF7 ativo
- Verificar nomes dos campos
- Verificar campos ocultos

### Debug Mode

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

// Logs do plugin
error_log('WCB Debug: ' . print_r($data, true));
```

---

## 📦 Deployment

### Checklist Pré-Deploy

- ✅ Testar em ambiente local
- ✅ Verificar compatibilidade WordPress/PHP
- ✅ Validar dependências (CF7, ACF)
- ✅ Testar upgrade de versões anteriores
- ✅ Documentar mudanças

### Estrutura de Commits

```bash
feat: Nova funcionalidade
fix: Correção de bug
refactor: Refatoração
docs: Documentação
style: CSS/design
test: Testes
```

---

## 🎯 Roadmap

### v1.2.0 (Próxima)
- [ ] Máscaras automáticas nos campos CF7
- [ ] Visual melhorado do modal "Ver" contato
- [ ] Exportação de contatos selecionados
- [ ] Select2 para mapeamentos

### v1.3.0
- [ ] Integração com Google Analytics
- [ ] Templates de mensagem personalizáveis
- [ ] A/B testing de mensagens
- [ ] API REST para integrações

### v2.0.0
- [ ] Suporte a múltiplos idiomas
- [ ] Chatbot básico
- [ ] Integração com CRMs populares
- [ ] Dashboard em tempo real

---

## 📞 Suporte

### Informações Técnicas
- **Versão atual**: v1.1.0
- **Compatibilidade**: WordPress 5.0+, PHP 7.4+
- **Dependências**: Contact Form 7 (recomendado), ACF (opcional)

### Para Desenvolvedores
- Documentação completa incluída
- Código bem documentado e estruturado
- Sistema de hooks para extensões
- Padrões WordPress seguidos

---

**Desenvolvido com foco em simplicidade, performance e funcionalidade completa.**  
**Última atualização**: 16 Jul 2025 - v1.1.0 - 23:00h