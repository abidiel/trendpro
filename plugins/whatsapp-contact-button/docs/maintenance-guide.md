# 📋 Manual Completo - WhatsApp Contact Button Plugin

## 🎯 Visão Geral do Projeto

Plugin WordPress completo para captura de leads via formulários Contact Form 7 com redirecionamento automático para WhatsApp. Inclui sistema de analytics, mapeamento por página e configurações flexíveis.

---

## 📊 Status Atual: v1.1.0

### ✅ Funcionalidades Implementadas

- **Sistema de captura de leads** via Contact Form 7 ✅
- **Redirecionamento automático** para WhatsApp após envio ✅
- **Analytics completos** com gráficos e métricas ✅
- **Mapeamento por página** (formulários e mensagens específicas) ✅
- **Sistema de prioridade** para configurações ✅
- **Suporte a taxonomias CPT** (projetos, serviços, etc.) ✅ NOVO v1.1.0
- **Interface admin completa** com 3 abas ✅
- **Notificações por email** ✅
- **Exportação CSV** ✅
- **Tracking de eventos** (click, submit, redirect) ✅

### 🎯 Próximas Melhorias Planejadas

- **Máscaras automáticas** nos campos CF7
- **Visual do botão "Ver"** (cards no admin)
- **Exportação selecionados**
- **Select2** para mapeamentos

---

## 🏗️ Arquitetura do Plugin

### **Estrutura de Arquivos**

```
📂 whatsapp-contact-button/
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
│   │   └── style.css               # Frontend
│   └── js/
│       ├── admin.js                # Funcionalidades admin
│       └── script.js               # Frontend + tracking
├── readme.txt                      # Documentação WordPress
└── uninstall.php                   # Limpeza dados
```

### **Classes Principais**

- `WhatsAppContactButton` - Classe principal
- `WCB_Admin` - Interface administrativa
- `WCB_Frontend` - Funcionalidades frontend
- `WCB_CF7_Integration` - Integração formulários
- `WCB_Database` - Operações banco
- `WCB_Analytics` - Métricas e relatórios
- `WCB_Notifications` - Sistema emails

---

## 🗄️ Estrutura do Banco de Dados

### **Tabela: `{prefix}_whatsapp_contacts`**

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

### **Tabela: `{prefix}_whatsapp_analytics`**

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

### **Opções Salvas no `wp_options`**

```php
// Configurações principais
'wcb_enabled' => true/false
'wcb_button_position' => 'bottom-right'|'bottom-left'

// WhatsApp
'wcb_whatsapp_number' => '5511999999999'  // Específico plugin

// Formulários e textos
'wcb_default_form_id' => 123
'wcb_default_popup_text' => 'Texto padrão...'
'wcb_default_whatsapp_message' => 'Olá! Sou {nome_usuario}...'

// Mapeamentos por página
'wcb_form_mappings' => [
    [
        'type' => 'slug',           // slug|category|post_type
        'value' => 'contato',       // Valor para comparar
        'form_id' => 456,           // ID do CF7
        'popup_text' => 'Texto específico...',
        'whatsapp_message' => 'Mensagem específica...'
    ]
]

// Notificações e sistema
'wcb_notification_emails' => ['admin@site.com']
'wcb_delete_data_on_uninstall' => false
```

### **Campos ACF Necessários (Opções do Tema)**

```php
// Campo obrigatório nas Options do tema
'whatsapp' => '55 (11) 99999-9999'  // Número principal do site
```

---

## 🔄 Sistema de Prioridades

### **1. Número WhatsApp**

```
1️⃣ Plugin (`wcb_whatsapp_number`)
2️⃣ ACF Options (`whatsapp`)
```

### **2. Texto do Popup**

```
1️⃣ Específico da página (mapeamento)
2️⃣ Plugin (`wcb_default_popup_text`)
3️⃣ ACF (`whatsapp_texto_popup`) [DEPRECADO]
```

### **3. Mensagem WhatsApp**

```
1️⃣ Específica da página (mapeamento)
2️⃣ Plugin (`wcb_default_whatsapp_message`)
3️⃣ ACF (`whatsapp_mensagem_base`) [DEPRECADO]
```

### **4. Formulário CF7**

```
1️⃣ Específico da página (mapeamento)
2️⃣ Plugin (`wcb_default_form_id`)
3️⃣ Link direto WhatsApp (se nenhum configurado)
```

### **Exemplo Prático**

Página: /projetos/evento-experiencia-lendaria/

Tipo de post: "projetos"
Categoria: "cobertura-de-evento"

Mapeamentos configurados:

Tipo "projetos" → Formulário A
Categoria "cobertura-de-evento" → Formulário B

Resultado: Usa Formulário B (categoria tem prioridade)

---

## 📋 Interface Admin - 3 Abas

### **Aba 1: Contatos**

- **Listagem** com filtros (status, página, data, busca)
- **Ações em massa** (deletar, alterar status)
- **Exportação CSV** com todos os campos
- **Modal "Ver"** com detalhes do contato
- **Paginação** (20 por página)

### **Aba 2: Analytics**

- **Cards de métricas** (clicks, submits, redirects, conversão)
- **Gráfico de funil** (Chart.js)
- **Top páginas geradoras** com métricas
- **Filtros por período**

### **Aba 3: Configurações**

- **Seção 1: Número Principal** (status ACF)
- **Seção 2: Número Específico** (campo plugin)
- **Seção 3: Configurações Globais** (formulários, textos)
  **Seção 4: Mapeamento por Página** (específicos) ✅ NOVO v1.1.0
- **Seção 5: Notificações e Sistema**

---

## 🎯 Mapeamento por Página (v1.1.0)

### **Tipos de Mapeamento Suportados**

'slug' // Slug específico da página (ex: 'contato', 'sobre')
'category' // Categoria de posts/CPT (ex: 'noticias', 'cobertura-de-evento')
'post_type' // Tipo de post (ex: 'product', 'service', 'projetos')
'page_template' // Template de página (ex: 'page-contact.php')

Taxonomias Suportadas (v1.1.0)

✅ Posts padrão: category, post_tag
✅ Custom Post Types: Qualquer taxonomia customizada
✅ Exemplos: categoria de projetos, tipo de serviço, tag de produto
✅ Universal: Mesma categoria funciona em posts e CPTs

Contexto da Página Detectado
php$context = [
'slug' => 'contato', // Slug da página atual
'post_type' => 'page', // Tipo do post
'categories' => ['noticias', 'blog'], // TODAS as taxonomias (v1.1.0)
'template' => 'page-contact', // Template da página
'is_front_page' => false, // Se é página inicial
'is_home' => false // Se é página do blog
];
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

## 🔧 Principais Funções e Hooks

### **Hooks WordPress Utilizados**

```php
// Admin
add_action('admin_menu', 'add_admin_menu')
add_action('admin_init', 'admin_init')
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts')

// Frontend
add_action('wp_enqueue_scripts', 'enqueue_scripts')
add_action('wp_footer', 'render_button_and_modal')

// CF7 Integration
add_action('wpcf7_mail_sent', 'handle_form_submission')
add_filter('wpcf7_form_elements', 'add_hidden_fields')

// AJAX
add_action('wp_ajax_wcb_track_event', 'ajax_track_event')
add_action('wp_ajax_wcb_process_cf7_submission', 'ajax_process_submission')
```

### **Funções Principais (v1.1.0)**

````php
// Core
WhatsAppContactButton::get_whatsapp_number()  // Número com prioridade
WhatsAppContactButton::get_option($key, $default)  // Configurações

// Frontend - Sistema de Prioridade
$frontend->get_popup_text_with_priority()
$frontend->get_whatsapp_message_with_priority()
$frontend->get_specific_form_for_page()       // NOVO v1.1.0

// Frontend - Contexto e Mapeamento
$frontend->get_current_page_context()         // MELHORADO v1.1.0
$frontend->matches_page_context($mapping, $context)

// Database
WCB_Database::insert_contact($data)
WCB_Database::get_contacts($args)
WCB_Database::get_analytics_summary($date_from, $date_to)

// CF7
$cf7->extract_contact_data($posted_data)
$cf7->generate_whatsapp_url($contact_data)
$cf7->replace_message_variables($message, $contact_data)
$cf7->extract_slug_from_url($url)             // NOVO v1.1.0

---

## 🧪 Sistema de Variáveis Personalizáveis

### **Variáveis Disponíveis nas Mensagens**

```php
'{nome_usuario}'     => $contact_data['name']
'{email_usuario}'    => $contact_data['email']
'{telefone_usuario}' => $contact_data['phone']
'{titulo_pagina}'    => $contact_data['page_title']
'{url_pagina}'       => $contact_data['page_url']
'{data_atual}'       => date_i18n(get_option('date_format'))
'{hora_atual}'       => date_i18n(get_option('time_format'))
'{dispositivo}'      => ucfirst($contact_data['device_type'])
````

### **Exemplo de Uso**

```
Olá! Sou {nome_usuario} ({email_usuario}).
Vim através da página {titulo_pagina} em {data_atual}
e gostaria de conversar sobre seus serviços.
```

---

## 📱 Fluxo Completo do Sistema

### **1. Usuário clica no botão**

```javascript
// assets/js/script.js
wcbTrackEvent('click')  // Registra analytics
wcbOpenModal()          // Abre modal com formulário
wcbFillHiddenFields()   // Preenche campos página (v1.1.0)
```

### **2. Preenche formulário CF7**

```php
// Campos ocultos adicionados automaticamente
wcb_whatsapp_form: "1"
wcb_page_title: "Título da página"
wcb_page_url: "URL atual"
wcb_page_slug: "slug-pagina"
```

### **3. Envia formulário**

```javascript
// Event wpcf7mailsent
wcbTrackEvent("submit"); // Analytics
ajax_process_cf7_submission(); // Processa dados
```

### **4. Backend processa  (v1.1.0)**

```php
// cf7-integration.php
handle_form_submission()    // Salva no banco
extract_contact_data()      // Extrai dados CF7
generate_whatsapp_url()     // Monta URL WhatsApp com prioridade
extract_slug_from_url()     // Fallback para slug (NOVO)
replace_message_variables() // Substitui variáveis
```

### **5. Redirecionamento**

```javascript
// Abre WhatsApp
window.open(whatsapp_url, "_blank");
wcbTrackEvent("redirect", contact_id); // Analytics final
```

---

## 🔍 Debugging e Troubleshooting

### **Logs Principais**

```php
// Ativar logs WP
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

// Logs do plugin (buscar por 'WCB:')
error_log('WCB: mensagem debug');
```


### **Problemas Comuns (v1.1.0)**

#### **Mapeamento não funciona**
```php
// Verificar contexto da página
$context = $frontend->get_current_page_context();
error_log('WCB Context: ' . print_r($context, true));

// Verificar mapeamento
$mappings = get_option('wcb_form_mappings');
error_log('WCB Mappings: ' . print_r($mappings, true));

// Verificar prioridade usada
// Logs mostram: "WCB: Using CATEGORY mapping: cobertura-de-evento"

```
Categoria de CPT não detectada
// Verificar se get_current_page_context() captura taxonomias
// Logs devem mostrar 'categories' array com terms do CPT
// Se não capturar, verificar get_object_taxonomies() no frontend.php



### **Problemas Comuns**

#### **Mensagem específica não funciona**

```php
// Verificar mapeamento
$mappings = get_option('wcb_form_mappings');
var_dump($mappings);

// Verificar contexto da página
$context = $frontend->get_current_page_context();
var_dump($context['slug']);
```

#### **Formulário não aparece**

```php
// Verificar CF7 ativo
if (!class_exists('WPCF7')) return;

// Verificar formulário existe
$form = wpcf7_contact_form($form_id);
if (!$form) return;
```

#### **WhatsApp não abre**

```php
// Verificar número configurado
$number = WhatsAppContactButton::get_whatsapp_number();
error_log('Número: ' . $number);

// Verificar URL gerada
error_log('URL WhatsApp: ' . $whatsapp_url);
```

---

## 🚀 Guia de Desenvolvimento

### **Adicionando Nova Funcionalidade**

#### **1. Backend (PHP)**

```php
// includes/nome-funcionalidade.php
class WCB_NovaFuncionalidade {
    public function __construct() {
        add_action('hook_apropriado', [$this, 'metodo']);
    }

    public function metodo() {
        // Implementação
    }
}

// Instanciar na classe principal
new WCB_NovaFuncionalidade();
```

#### **2. Frontend (JS)**

```javascript
// assets/js/script.js
function novaFuncionalidade() {
  // Implementação

  // Se precisar AJAX
  $.ajax({
    url: wcb_data.ajax_url,
    data: {
      action: "wcb_nova_action",
      nonce: wcb_data.nonce,
    },
  });
}
```

#### **3. Admin (Interface)**

```php
// includes/admin.php - settings_tab()
<tr>
    <th><?php _e('Nova Configuração'); ?></th>
    <td>
        <input type="text" name="wcb_nova_config">
    </td>
</tr>

// save_settings()
$nova_config = sanitize_text_field($_POST['wcb_nova_config']);
WhatsAppContactButton::update_option('wcb_nova_config', $nova_config);
```

### **Padrões de Código**

#### **Nomenclatura**

- Classes: `WCB_NomeClasse`
- Funções: `snake_case`
- Hooks: `wcb_nome_hook`
- Options: `wcb_nome_opcao`
- CSS: `.wcb-classe-css`

#### **Segurança**

```php
// Sanitização
$input = sanitize_text_field($_POST['campo']);
$textarea = sanitize_textarea_field($_POST['textarea']);
$email = sanitize_email($_POST['email']);

// Validação
check_ajax_referer('wcb_nonce', 'nonce');
if (!current_user_can('manage_options')) wp_die();

// Escape output
echo esc_html($data);
echo esc_url($url);
echo esc_attr($attr);
```

#### **Database**

```php
// Usar prepared statements
$wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", $id);

// Nomenclatura consistente
$table = $wpdb->prefix . 'whatsapp_tabela';
```

---

## 📦 Deploy e Versionamento

### **Checklist Pré-Deploy**

- ✅ Testar em ambiente local
- ✅ Verificar compatibilidade WordPress
- ✅ Validar dependências (CF7, ACF)
- ✅ Testar upgrade de versões anteriores
- ✅ Documentar mudanças no readme.txt

### **Versionamento**

```
v1.0.0 - Release inicial
v1.1.0 - Mapeamento por página + melhorias admin
v1.2.0 - Próximas funcionalidades (máscaras, visual)
```

### **Estrutura Commits**

```bash
feat: Nova funcionalidade
fix: Correção de bug
refactor: Refatoração código
docs: Documentação
style: Formatação código
test: Testes
```

---

## 🎯 Próximas Implementações

### **Máscaras Automáticas CF7**

```php
// Detectar campos telefone no CF7
// Adicionar máscara via JavaScript
// Validação no backend
```

### **Visual Cards Admin**

```html
<!-- Modal "Ver" com cards organizados -->
<div class="wcb-contact-card">
  <div class="wcb-card-header">Dados Principais</div>
  <div class="wcb-card-body">...</div>
</div>
```

### **Exportação Selecionados**

```php
// Capturar IDs checkbox marcados
// Modificar ajax_export_contacts()
// Validar seleção mínima
```

### **Select2 Mapeamentos**

```javascript
// Integrar Select2
// Autocompletar categorias/CPTs
// Melhorar UX seleção
```

---

## 📞 Suporte e Manutenção

### **Informações de Contato**

- **Desenvolvedor**: [Seu nome/empresa]
- **Versão atual**: v1.1.0
- **Compatibilidade**: WordPress 5.0+, PHP 7.4+
- **Dependências**: Contact Form 7, ACF (opcional)

### **Links Úteis**

- Repositório: [Link do repo]
- Documentação: [Link docs]
- Issues: [Link issues]

---

**📅 Última atualização**: 16 Jul 2025  
**🎯 Status**: Pronto para desenvolvimento contínuo  
**⚡ Performance**: Otimizado e escalável
