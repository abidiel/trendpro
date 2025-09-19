# WhatsApp Contact Button - Documentação Técnica

## Visão Geral

O WhatsApp Contact Button é um plugin WordPress completo desenvolvido para facilitar a captura de leads através de um botão flutuante de WhatsApp integrado com Contact Form 7. O plugin oferece funcionalidades avançadas de rastreamento, analytics e gerenciamento de contatos através de um painel administrativo intuitivo.

## Arquitetura do Plugin

### Estrutura de Arquivos

```
whatsapp-contact-button/
├── whatsapp-contact-button.php    # Arquivo principal do plugin
├── includes/                      # Classes e funcionalidades PHP
│   ├── admin.php                 # Painel administrativo
│   ├── analytics.php             # Sistema de analytics
│   ├── cf7-integration.php       # Integração Contact Form 7
│   ├── database.php              # Operações de banco de dados
│   ├── frontend.php              # Funcionalidades do frontend
│   ├── notifications.php         # Sistema de notificações
│   └── schedule.php              # Gerenciamento de horários
├── assets/                       # Assets estáticos
│   ├── css/
│   │   ├── style.css            # Estilos do frontend
│   │   └── admin.css            # Estilos do admin
│   ├── js/
│   │   ├── script.js            # JavaScript do frontend
│   │   └── admin.js             # JavaScript do admin
│   └── images/
│       └── whatsapp-icon.svg    # Ícone do WhatsApp
├── readme.txt                   # Arquivo readme do WordPress
└── DOCUMENTATION.md             # Esta documentação
```

### Classes Principais

#### WhatsAppContactButton (Classe Principal)
- **Localização**: `whatsapp-contact-button.php`
- **Responsabilidade**: Inicialização do plugin, gerenciamento de hooks e configurações globais
- **Métodos principais**:
  - `init()`: Inicializa o plugin
  - `activate()`: Executado na ativação
  - `deactivate()`: Executado na desativação
  - `get_whatsapp_number()`: Retorna número limpo do WhatsApp
  - `is_cf7_active()`: Verifica se CF7 está ativo

#### WCB_Database
- **Localização**: `includes/database.php`
- **Responsabilidade**: Operações de banco de dados
- **Métodos principais**:
  - `create_tables()`: Cria tabelas do plugin
  - `insert_contact()`: Insere novo contato
  - `get_contacts()`: Busca contatos com filtros
  - `insert_analytics()`: Registra evento de analytics

#### WCB_Frontend
- **Localização**: `includes/frontend.php`
- **Responsabilidade**: Funcionalidades do frontend
- **Métodos principais**:
  - `enqueue_scripts()`: Carrega assets do frontend
  - `render_button_and_modal()`: Renderiza botão e modal
  - `ajax_track_event()`: Processa eventos AJAX

#### WCB_Admin
- **Localização**: `includes/admin.php`
- **Responsabilidade**: Painel administrativo
- **Métodos principais**:
  - `add_admin_menu()`: Adiciona menu no admin
  - `admin_page()`: Renderiza páginas do admin
  - `ajax_export_contacts()`: Exporta contatos em CSV

## Banco de Dados

### Tabela: wp_whatsapp_contacts

Armazena informações dos contatos capturados.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | ID único do contato |
| name | varchar(255) | Nome do contato |
| phone | varchar(50) | Telefone do contato |
| email | varchar(255) | Email do contato |
| consent | tinyint(1) | Consentimento LGPD |
| page_title | varchar(255) | Título da página origem |
| page_url | text | URL da página origem |
| page_slug | varchar(255) | Slug da página origem |
| device_type | varchar(50) | Tipo de dispositivo |
| user_agent | text | User agent completo |
| click_time | datetime | Horário do clique no botão |
| submit_time | datetime | Horário do envio do formulário |
| whatsapp_redirect_time | datetime | Horário do redirecionamento |
| status | varchar(50) | Status do contato |
| admin_notes | text | Notas administrativas |
| form_data | text | Dados completos do formulário (JSON) |
| created_at | datetime | Data de criação |
| updated_at | datetime | Data de atualização |

### Tabela: wp_whatsapp_analytics

Armazena eventos de analytics para métricas.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | ID único do evento |
| event_type | varchar(50) | Tipo do evento (click/submit/redirect) |
| page_slug | varchar(255) | Slug da página |
| page_title | varchar(255) | Título da página |
| page_url | text | URL da página |
| device_type | varchar(50) | Tipo de dispositivo |
| user_agent | text | User agent |
| session_id | varchar(255) | ID da sessão |
| contact_id | int(11) | ID do contato relacionado |
| timestamp | datetime | Timestamp do evento |

## Integração com Contact Form 7

### Hook Principal: wpcf7_mail_sent

O plugin utiliza o hook `wpcf7_mail_sent` para capturar dados após o envio bem-sucedido de formulários CF7.

```php
add_action('wpcf7_mail_sent', array($this, 'handle_form_submission'));
```

### Campos Obrigatórios

Para funcionar corretamente, os formulários CF7 devem conter campos com os seguintes nomes (ou variações):

- **Nome**: `your-name`, `name`, `nome`, `first-name`, `firstname`
- **Email**: `your-email`, `email`, `e-mail`
- **Telefone**: `your-phone`, `phone`, `telefone`, `tel`, `celular`, `whatsapp`

### Campos Ocultos Automáticos

O plugin adiciona automaticamente campos ocultos aos formulários:

```html
<input type="hidden" name="wcb_whatsapp_form" value="1">
<input type="hidden" name="wcb_page_title" value="">
<input type="hidden" name="wcb_page_url" value="">
<input type="hidden" name="wcb_page_slug" value="">
```

## Integração com Advanced Custom Fields

### Campos Necessários

O plugin busca os seguintes campos ACF nas opções do tema:

1. **whatsapp** (text)
   - Número do WhatsApp com formatação
   - Exemplo: `(11) 99999-9999`

2. **whatsapp_texto_popup** (textarea)
   - Texto exibido no popup
   - Suporta HTML básico

3. **whatsapp_mensagem_base** (textarea)
   - Mensagem base enviada no WhatsApp
   - Será complementada com dados da página

### Acesso aos Campos

```php
$numero = get_field('whatsapp', 'option');
$texto_popup = get_field('whatsapp_texto_popup', 'option');
$mensagem_base = get_field('whatsapp_mensagem_base', 'option');
```

## Sistema de Analytics

### Tipos de Eventos

O plugin rastreia três tipos principais de eventos:

1. **click**: Clique no botão WhatsApp
2. **submit**: Envio do formulário CF7
3. **redirect**: Redirecionamento para WhatsApp

### Métricas Calculadas

- **Taxa de Conversão**: (Envios / Cliques) × 100
- **Taxa de Redirecionamento**: (Redirecionamentos / Envios) × 100
- **Top Páginas**: Páginas com mais conversões

### Coleta de Dados

```javascript
// Exemplo de tracking de evento
wcbTrackEvent('click', {
    page_title: document.title,
    page_url: window.location.href,
    page_slug: 'home',
    session_id: wcbSessionId
});
```

## Sistema de Notificações

### Tipos de Notificações

1. **Novo Contato**: Enviada imediatamente após captura
2. **Resumo Diário**: Enviada diariamente às 8h
3. **Resumo Semanal**: Enviada semanalmente às segundas 9h

### Configuração de Emails

Os emails de notificação são configuráveis no painel administrativo:

```php
$notification_emails = WhatsAppContactButton::get_option('wcb_notification_emails', array());
```

### Template de Email

```php
$message = sprintf(
    "Novo contato recebido:\n\n" .
    "Nome: %s\n" .
    "Email: %s\n" .
    "Telefone: %s\n" .
    "Página: %s\n",
    $contact_data['name'],
    $contact_data['email'],
    $contact_data['phone'],
    $contact_data['page_title']
);
```

## Horários de Funcionamento

### Configuração

Os horários são configurados por dia da semana:

```php
$working_hours = array(
    'monday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
    'tuesday' => array('enabled' => true, 'start' => '09:00', 'end' => '18:00'),
    // ... outros dias
);
```

### Verificação

```php
$is_working = WCB_Schedule::is_working_hours();
```

## Personalização e Hooks

### Hooks Disponíveis

#### Actions

- `wcb_before_contact_insert`: Antes de inserir contato
- `wcb_after_contact_insert`: Após inserir contato
- `wcb_new_contact`: Novo contato criado

#### Filters

- `wcb_whatsapp_message`: Filtrar mensagem do WhatsApp
- `wcb_notification_emails`: Filtrar emails de notificação
- `wcb_contact_data`: Filtrar dados do contato antes de salvar

### Exemplo de Uso

```php
// Personalizar mensagem do WhatsApp
add_filter('wcb_whatsapp_message', function($message, $contact_data) {
    return "Olá! Sou " . $contact_data['name'] . " e vim do site.";
}, 10, 2);

// Adicionar ação após novo contato
add_action('wcb_new_contact', function($contact_id, $contact_data) {
    // Integrar com CRM externo
    send_to_crm($contact_data);
}, 10, 2);
```

## Shortcodes

### [whatsapp_button]

Permite inserir botão manual em qualquer lugar.

**Parâmetros:**
- `text`: Texto do botão (padrão: "Fale conosco no WhatsApp")
- `class`: Classe CSS adicional

**Exemplo:**
```php
[whatsapp_button text="Contate-nos" class="meu-botao"]
```

## JavaScript API

### Funções Globais

#### wcbOpenModal()
Abre o modal do WhatsApp programaticamente.

```javascript
// Abrir modal
wcbOpenModal();

// Abrir modal com mensagem de fora do horário
wcbOpenModal(true);
```

#### wcbTrackEvent()
Registra evento de analytics.

```javascript
wcbTrackEvent('custom_event', contactId);
```

### Eventos Personalizados

```javascript
// Escutar eventos do plugin
$(document).on('wcb_modal_opened', function() {
    console.log('Modal aberto');
});

$(document).on('wcb_form_submitted', function(e, contactData) {
    console.log('Formulário enviado', contactData);
});
```

## CSS e Personalização Visual

### Classes CSS Principais

#### Botão
- `.wcb-button`: Botão principal
- `.wcb-position-bottom-right`: Posição inferior direita
- `.wcb-position-bottom-left`: Posição inferior esquerda

#### Modal
- `.wcb-modal`: Container do modal
- `.wcb-modal-content`: Conteúdo do modal
- `.wcb-modal-header`: Cabeçalho do modal
- `.wcb-modal-body`: Corpo do modal

#### Formulário
- `.wcb-form-container`: Container do formulário
- `.wcb-whatsapp-form`: Formulário CF7 no modal

### Personalização CSS

```css
/* Personalizar cor do botão */
.wcb-button {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
}

/* Personalizar modal */
.wcb-modal-content {
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

/* Responsivo personalizado */
@media (max-width: 768px) {
    .wcb-button {
        width: 50px;
        height: 50px;
    }
}
```

## Segurança

### Sanitização de Dados

Todos os dados são sanitizados antes de serem salvos:

```php
$data['name'] = sanitize_text_field($data['name']);
$data['email'] = sanitize_email($data['email']);
$data['phone'] = sanitize_text_field($data['phone']);
```

### Nonces

Todas as requisições AJAX utilizam nonces para segurança:

```php
wp_nonce_field('wcb_admin_nonce', 'nonce');
check_ajax_referer('wcb_admin_nonce', 'nonce');
```

### Permissões

Verificação de permissões em operações administrativas:

```php
if (!current_user_can('manage_options')) {
    wp_die(__('Permissão negada.', 'whatsapp-contact-button'));
}
```

## Performance

### Otimizações Implementadas

1. **Carregamento Condicional**: Assets só carregam quando necessário
2. **Minificação**: CSS e JS otimizados
3. **Cache**: Consultas de banco otimizadas
4. **Lazy Loading**: Componentes carregados sob demanda

### Boas Práticas

```php
// Carregar assets apenas no frontend
if (!is_admin()) {
    wp_enqueue_style('wcb-style', WCB_PLUGIN_URL . 'assets/css/style.css');
}

// Usar transients para cache
$cached_data = get_transient('wcb_analytics_summary');
if (false === $cached_data) {
    $cached_data = WCB_Database::get_analytics_summary();
    set_transient('wcb_analytics_summary', $cached_data, HOUR_IN_SECONDS);
}
```

## Troubleshooting

### Problemas Comuns

#### 1. Botão não aparece
- Verificar se o plugin está ativado
- Verificar se `wcb_enabled` está true
- Verificar conflitos de CSS/JS

#### 2. Formulário não captura dados
- Verificar se CF7 está ativo
- Verificar nomes dos campos do formulário
- Verificar se há erros no console

#### 3. WhatsApp não abre
- Verificar se número está configurado
- Verificar se ACF está funcionando
- Verificar formato do número

### Debug

Ativar debug no WordPress:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

Logs do plugin:

```php
error_log('WCB Debug: ' . print_r($data, true));
```

## Migração e Backup

### Backup de Dados

```sql
-- Backup das tabelas
CREATE TABLE wp_whatsapp_contacts_backup AS SELECT * FROM wp_whatsapp_contacts;
CREATE TABLE wp_whatsapp_analytics_backup AS SELECT * FROM wp_whatsapp_analytics;
```

### Exportação de Configurações

```php
$settings = array(
    'wcb_enabled' => get_option('wcb_enabled'),
    'wcb_working_hours' => get_option('wcb_working_hours'),
    'wcb_form_mappings' => get_option('wcb_form_mappings'),
    // ... outras configurações
);

file_put_contents('wcb_settings_backup.json', json_encode($settings));
```

## Desenvolvimento e Contribuição

### Ambiente de Desenvolvimento

1. WordPress local (XAMPP, Local, etc.)
2. PHP 7.4+
3. Contact Form 7 instalado
4. Advanced Custom Fields instalado

### Estrutura de Commits

```
feat: adicionar nova funcionalidade
fix: corrigir bug
docs: atualizar documentação
style: melhorar CSS/design
refactor: refatorar código
test: adicionar testes
```

### Testes

```php
// Teste básico de funcionalidade
function test_wcb_contact_insertion() {
    $contact_data = array(
        'name' => 'Teste',
        'email' => 'teste@exemplo.com',
        'phone' => '11999999999'
    );
    
    $contact_id = WCB_Database::insert_contact($contact_data);
    assert($contact_id > 0);
}
```

## Roadmap

### Versão 1.1
- [ ] Integração com Google Analytics
- [ ] Suporte a múltiplos idiomas
- [ ] Templates de mensagem personalizáveis
- [ ] API REST para integrações

### Versão 1.2
- [ ] Chatbot básico
- [ ] Integração com CRMs populares
- [ ] A/B testing de mensagens
- [ ] Relatórios avançados

### Versão 2.0
- [ ] Suporte a outros apps de mensagem
- [ ] Dashboard em tempo real
- [ ] Machine learning para otimização
- [ ] App mobile para gestão

## Suporte

Para suporte técnico ou dúvidas sobre implementação:

1. Consulte esta documentação
2. Verifique o arquivo readme.txt
3. Analise os logs de erro
4. Entre em contato com o desenvolvedor

---

**Desenvolvido por Manus AI**  
**Versão da Documentação**: 1.0.0  
**Última Atualização**: 2024

