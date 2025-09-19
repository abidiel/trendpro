# Plugin WordPress: WhatsApp Contact Button com CF7

## Objetivo
Desenvolver um plugin WordPress simples e minimalista que adiciona um botão fixo de WhatsApp ao site, captura leads através de formulário Contact Form 7 e redireciona para WhatsApp após o envio.

## Funcionalidades Principais

### 1. Botão Flutuante WhatsApp
- **Posição**: Fixo no canto inferior direito da tela
- **Design**: Minimalista, ícone do WhatsApp padrão
- **Comportamento**: Ao clicar, abre modal/popup
- **Horário de funcionamento**: 
  - Configurável (dias da semana + horários)
  - Fora do horário: modal com mensagem alternativa
  - Botão pode ficar visível mas com comportamento diferente

### 2. Modal/Popup de Contato Inteligente
- **Conteúdo dinâmico por página**: 
  - Texto via campo ACF das opções do tema
  - Formulário CF7 específico por página/contexto
  - Regras: por slug, categoria, tipo de post, etc.
- **Campos obrigatórios**: Nome, Telefone, Email, Checkbox de consent
- **Integração**: Múltiplos shortcodes CF7 configuráveis

### 3. Fluxo Pós-Envio
- **Após sucesso do CF7**: Redirecionar automaticamente para WhatsApp
- **URL WhatsApp**: Usar campo ACF das opções do tema para número
- **Mensagem personalizada**: 
  - Campo ACF para mensagem base nas opções do tema
  - Incluir automaticamente informações da página atual:
    - Nome da página/post onde o usuário estava
    - URL da página (para referência)
    - Data/hora do contato
  - Formato: "Olá! Vim através da página [Nome da Página] ([URL]) e gostaria de conversar sobre..."
- **Captura de dados**: Salvar no banco de dados do WordPress

### 4. Painel Administrativo + Analytics
- **Página no admin**: "WhatsApp Contacts" com abas
- **Aba Configurações**:
  - Integração com campos ACF das opções do tema
  - Horários de funcionamento (dias da semana + horas)
  - Múltiplos formulários CF7 por contexto de página
  - Ativar/desativar botão e funcionalidades
- **Aba Lista de contatos**:
  - Visualização em tabela com filtros
  - Campos: Nome, Telefone, Email, Página Origem, Dispositivo, Data/Hora
  - Status de acompanhamento (Novo, Contatado, Convertido)
  - Ações: Visualizar, Deletar, Marcar status
- **Aba Analytics**:
  - Métricas de conversão por página
  - Cliques vs Envios vs Redirecionamentos WhatsApp
  - Gráficos de atividade por horário/dia
  - Top páginas geradoras de leads
  - Dispositivos mais utilizados (mobile/desktop)
- **Ações em massa**:
  - Exportar CSV com filtros
  - Deletar selecionados
  - Alterar status em lote
- **Notificações internas**:
  - Email automático para administradores
  - Configurar emails de destino
  - Personalizar template da notificação

## Especificações Técnicas

### Integração com Contact Form 7
- **Hook**: Usar `wpcf7_mail_sent` para capturar dados após envio bem-sucedido
- **Redirecionamento**: JavaScript/AJAX para redirecionar sem recarregar página
- **Compatibilidade**: Funcionar com webhooks existentes do CF7 (não interferir)

### Banco de Dados
- **Tabela customizada**: `wp_whatsapp_contacts`
- **Campos**: 
  - `id` (auto increment)
  - `name` (varchar 255)
  - `phone` (varchar 50)
  - `email` (varchar 255)
  - `consent` (boolean)
  - `page_title` (varchar 255 - título da página origem)
  - `page_url` (text - URL da página origem)
  - `page_slug` (varchar 255 - slug da página para analytics)
  - `device_type` (varchar 50 - mobile/desktop/tablet)
  - `user_agent` (text - navegador completo)
  - `click_time` (datetime - quando clicou no botão)
  - `submit_time` (datetime - quando enviou o formulário)
  - `whatsapp_redirect_time` (datetime - quando foi redirecionado)
  - `status` (varchar 50 - Novo/Contatado/Convertido/Perdido)
  - `admin_notes` (text - notas internas)
  - `form_data` (text - dados completos do formulário em JSON)

- **Tabela de analytics**: `wp_whatsapp_analytics`
- **Campos**:
  - `id` (auto increment)
  - `event_type` (varchar 50 - click/submit/redirect)
  - `page_slug` (varchar 255)
  - `device_type` (varchar 50)
  - `timestamp` (datetime)
  - `session_id` (varchar 255 - para tracking de sessão)

### Frontend
- **CSS**: Minimalista, não conflitar com temas
- **JavaScript**: Vanilla JS ou jQuery (dependendo do que já está carregado)
- **Responsivo**: Funcionar em desktop e mobile

### Configurações
- **Página de admin**: Submenu em "Configurações" ou menu próprio
- **Options**: Salvar em `wp_options` table
- **Validações**: Número do WhatsApp, seleção de formulário válido

## Requisitos de Desenvolvimento

### Estrutura do Plugin
```
whatsapp-contact-button/
├── whatsapp-contact-button.php (arquivo principal)
├── includes/
│   ├── admin.php (painel administrativo)
│   ├── admin-analytics.php (aba de métricas)
│   ├── admin-settings.php (aba de configurações)
│   ├── frontend.php (botão e modal)
│   ├── database.php (operações de BD)
│   ├── cf7-integration.php (integração CF7)
│   ├── analytics.php (tracking de eventos)
│   ├── notifications.php (emails automáticos)
│   └── schedule.php (horários de funcionamento)
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── admin.css
│   ├── js/
│   │   ├── script.js
│   │   ├── admin.js
│   │   └── analytics.js
│   └── images/whatsapp-icon.svg
└── readme.txt
```

### Funcionalidades Específicas
1. **Ativação do plugin**: Criar tabela no banco
2. **Desativação**: Manter dados (não deletar)
3. **Desinstalação**: Opção para limpar dados
4. **Shortcode alternativo**: `[whatsapp_button]` para uso manual
5. **Filtros WordPress**: Para desenvolvedores customizarem

## Comportamento Esperado

### Fluxo do Usuário
1. Usuário clica no botão flutuante do WhatsApp (analytics: evento 'click')
2. **Verificação de horário**: Se fora do horário, mostra modal alternativo
3. Modal abre com texto dinâmico (ACF) + formulário CF7 específico da página
4. Usuário preenche: nome, telefone, email + aceita consent
5. Clica em "Enviar" (analytics: evento 'submit')
6. CF7 processa e envia (webhooks do CF7 to Webhook funcionam normalmente)
7. Plugin captura dados, página atual, dispositivo e salva no BD
8. **Notificação interna**: Email automático para administradores
9. Redirecionamento automático para WhatsApp (analytics: evento 'redirect'):
   - wa.me/[número_acf]?text=[mensagem_base_acf] + informações da página
10. Modal fecha

**Exemplo da mensagem WhatsApp:**
`Olá! Vim através da página "Sobre Nós" (https://site.com/sobre) e gostaria de conversar sobre seus serviços. Meu nome é João Silva.`

**Tracking de conversão completa**: Click → Submit → Redirect para analytics precisos

### Fluxo do Admin
1. Instala e ativa plugin
2. Cria campos ACF nas opções do tema (se ainda não existem):
   - `whatsapp` (text) - número com formatação (será limpo pelo plugin)
   - `whatsapp_texto_popup` (textarea) - texto do popup
   - `whatsapp_mensagem_base` (textarea) - mensagem que aparece no WhatsApp
3. Vai em Configurações > WhatsApp Contact
4. **Aba Configurações**:
   - Define horários de funcionamento
   - Mapeia formulários CF7 por contexto de página
   - Configura emails para notificações
   - Ativa funcionalidades desejadas
5. **Aba Analytics**: Monitora performance e conversões
6. **Aba Contatos**: Gerencia leads e acompanha status
7. Botão aparece automaticamente no site conforme configurações

**Configuração de contextos por página:**
- Home: Formulário "Contato Geral" 
- /servicos: Formulário "Solicitar Orçamento"
- /sobre: Formulário "Conhecer Empresa"
- Padrão: Formulário configurado como fallback

**Campos ACF necessários nas opções do tema:**
- `whatsapp` (text) - número com formatação
- `whatsapp_texto_popup` (textarea) - texto do popup
- `whatsapp_mensagem_base` (textarea) - mensagem que aparece no WhatsApp

## Observações Importantes

- **Uso pessoal**: Não precisa ser market-ready, foco na funcionalidade
- **CF7 dependency**: Plugin deve verificar se CF7 está ativo
- **ACF integration**: Buscar campos das opções do tema via `get_field('campo', 'option')`
- **Performance**: Carregar assets apenas quando necessário
- **Webhooks**: Não interferir com integrações existentes (Make, etc.)
- **Segurança**: Validar e sanitizar todos os inputs
- **Mensagem dinâmica**: Capturar `document.title` e `window.location.href` via JavaScript
- **URL encoding**: Codificar mensagem do WhatsApp para URL válida

## Integração ACF Específica

### Campos necessários nas opções do tema:
```php
// Acessar via:
$numero_bruto = get_field('whatsapp', 'option');
$numero_limpo = str_replace(array('(', ')', ' ', '-'), array('', '', '', ''), $numero_bruto);
$texto_popup = get_field('whatsapp_texto_popup', 'option'); 
$mensagem_base = get_field('whatsapp_mensagem_base', 'option');
```

### Construção da URL WhatsApp:
```javascript
// O número já deve vir limpo do PHP para o JavaScript
const numero = '[numero_limpo_do_php]';
const mensagemBase = '[mensagem_base_acf]';
const paginaTitulo = document.title;
const paginaUrl = window.location.href;
const nomeUsuario = '[nome_do_formulario]';

const mensagemCompleta = `${mensagemBase} Vim através da página "${paginaTitulo}" (${paginaUrl}). Meu nome é ${nomeUsuario}.`;
const urlWhatsapp = `https://wa.me/${numero}?text=${encodeURIComponent(mensagemCompleta)}`;
```

### Limpeza do número WhatsApp:
```php
// Função para limpar o número antes de usar
function clean_whatsapp_number($number) {
    return str_replace(array('(', ')', ' ', '-'), array('', '', '', ''), $number);
}

// Uso:
$whatsapp_clean = clean_whatsapp_number(get_field('whatsapp', 'option'));
```

## Prioridades de Desenvolvimento
1. ✅ Funcionalidade core (botão + modal + captura)
2. ✅ Integração CF7 + redirecionamento WhatsApp
3. ✅ Múltiplos formulários por contexto de página
4. ✅ Horários de funcionamento
5. ✅ Painel admin básico + lista contatos com status
6. ✅ Sistema de analytics e métricas
7. ✅ Notificações por email
8. ✅ Exportação CSV com filtros
9. 🔄 Melhorias visuais e UX (se sobrar tempo)

**Integração com CF7 to Webhook**: O plugin deve ser compatível e não interferir com webhooks existentes do CF7, permitindo que as automações do Make.com continuem funcionando normalmente.