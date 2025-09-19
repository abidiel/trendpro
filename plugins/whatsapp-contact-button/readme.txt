=== WhatsApp Contact Button ===
Contributors: manusai
Tags: whatsapp, contact, button, contact-form-7, analytics, leads, theme-integration, page-mapping
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.1.1
Novo na v1.1.1 Correções técnicas.
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Plugin WordPress completo para botão WhatsApp com mapeamento por página, analytics avançados e integração inteligente com temas.

== Description ==

O WhatsApp Contact Button é um plugin WordPress profissional que adiciona um botão flutuante de WhatsApp ao seu site, com sistema completo de captura de leads, analytics detalhados e mapeamento inteligente por página. **Novo na v1.1.0**: Sistema de prioridades e configurações específicas por página!

= Principais Funcionalidades =

* **🎯 Mapeamento por Página**: Configure formulários e mensagens específicas para cada página
* **📊 Analytics Completos**: Rastreamento de cliques, envios e conversões com gráficos
* **🔧 Sistema de Prioridades**: Configurações globais com sobrescrita específica
* **🎨 Integração com Tema**: Usa automaticamente a variável `--base-color` do seu tema
* **📱 Responsivo Completo**: Funciona perfeitamente em desktop e mobile
* **⚙️ Configuração Flexível**: Interface admin completa com 3 abas organizadas

= Sistema de Mapeamento por Página =

**Novidade v1.1.0**: Configure diferentes formulários e mensagens para páginas específicas:

* **Por Slug**: páginas específicas (ex: `contato`, `sobre`)
* **Por Categoria**: posts de categorias (ex: `noticias`, `blog`) 
* **Por Tipo de Post**: CPTs personalizados (ex: `product`, `service`)
* **Por Template**: templates específicos (ex: `page-contact.php`)

= Sistema de Prioridades =

**Configurações inteligentes** que seguem ordem de prioridade:

1. **Específico da página** (mapeamento)
2. **Configurações globais** do plugin  
3. **Campos ACF** (fallback)

= Taxonomias Suportadas (v1.1.0) =

**Categoria mapping agora funciona universalmente:**
* ✅ **Posts padrão:** category, post_tag
* ✅ **Custom Post Types:** Qualquer taxonomia customizada  
* ✅ **Exemplos:** categoria de projetos, tipo de serviço, tag de produto
* ✅ **Universal:** Mesma categoria funciona em posts e CPTs

**Exemplo prático:**
CPT "projetos" com categoria "cobertura-de-evento"
→ Usa mesmo mapeamento que posts com categoria "cobertura-de-evento"

= Interface Admin Completa =

### **Aba Contatos**
- Lista completa com filtros avançados
- Exportação CSV com todos os dados
- Ações em massa e gestão de status
- Modal detalhado para cada contato

### **Aba Analytics** 
- Cards com métricas principais
- Gráfico de funil interativo
- Top páginas geradoras
- Filtros por período

### **Aba Configurações**
- Configuração do número WhatsApp (com prioridade)
- Configurações globais (formulário, textos)
- Mapeamento específico por página
- Sistema de notificações

= Integração Contact Form 7 =

**Captura automática** de dados dos formulários:

= Estrutura do Formulário =

```html
<!-- Conteúdo personalizado permitido -->
<h3>Entre em contato</h3>
<p>Nossa equipe responderá via WhatsApp!</p>

<!-- Campos obrigatórios (nomes específicos) -->
<label>Nome * [text* your-name]</label>
<label>E-mail * [email* your-email]</label> 
<label>Telefone * [tel* your-phone]</label>

<!-- Campos personalizados opcionais -->
<label>Data do evento [text data-evento]</label>
<label>Observações [textarea observacoes]</label>

[submit "Enviar"]

<!-- Campos ocultos OBRIGATÓRIOS -->
IMPORTANTE: Estes campos devem ser adicionados manualmente ao formulário:
[hidden wcb_whatsapp_form "1"]
<input type="hidden" name="wcb_page_title" class="wcb-page-title" value="">
<input type="hidden" name="wcb_page_url" class="wcb-page-url" value="">
<input type="hidden" name="wcb_page_slug" class="wcb-page-slug" value="">
```
Função de cada campo:
wcb_whatsapp_form "1" - Identifica como formulário do plugin
wcb_page_title - Captura título da página (preenchido automaticamente)
wcb_page_url - Captura URL da página (preenchido automaticamente)
wcb_page_slug - Captura slug da página (preenchido automaticamente)

= Campos Obrigatórios =

**Nome:** `your-name`, `name`, `nome`, `first-name`, `firstname`
**Email:** `your-email`, `email`, `e-mail`  
**Telefone:** `your-phone`, `phone`, `telefone`, `tel`, `celular`, `whatsapp`

**Importante:** Os campos ocultos devem ser adicionados manualmente ao formulário para o plugin funcionar corretamente.

= Funcionalidades =

- Detecta campos automaticamente pelos nomes
- Adiciona dados da página automaticamente
- Redireciona para WhatsApp após envio
- Salva todos os dados para analytics
- Suporta campos personalizados ilimitados
- Permite conteúdo HTML personalizado no formulário

= Sistema de Variáveis =

**Personalize mensagens** com variáveis dinâmicas:
```
{nome_usuario} - Nome do formulário
{email_usuario} - Email do formulário  
{telefone_usuario} - Telefone do formulário
{titulo_pagina} - Título da página
{url_pagina} - URL da página
{data_atual} - Data atual
{hora_atual} - Hora atual
{dispositivo} - Tipo de dispositivo
```

= Integração com Temas =

**Harmonia visual** automática:
- Usa variável `--base-color` do tema
- Fallback inteligente para temas sem a variável
- Suporte a temas escuros
- Mantém identidade do WhatsApp onde apropriado

= Shortcode Flexível =

```
[whatsapp_button text="Fale Conosco" style="theme"]
[whatsapp_button text="WhatsApp" style="whatsapp"] 
```

**Parâmetros:**
* `text`: Texto do botão
* `style`: "theme" (cor do tema) ou "whatsapp" (verde tradicional)
* `class`: Classe CSS adicional

= Requisitos =

* WordPress 5.0 ou superior
* PHP 7.4 ou superior
* Contact Form 7 (recomendado para captura de leads)
* Advanced Custom Fields (opcional, para campo principal do WhatsApp)

= Compatibilidade =

* ✅ Qualquer tema WordPress
* ✅ Totalmente responsivo
* ✅ Compatível com plugins de cache
* ✅ Não interfere com outros plugins
* ✅ Suporte a multisites

== Installation ==

= Instalação Automática =

1. No painel WordPress, vá em 'Plugins' > 'Adicionar novo'
2. Busque por 'WhatsApp Contact Button'
3. Clique em 'Instalar' e depois 'Ativar'
4. Configure através do menu 'Botão WhatsApp'

= Instalação Manual =

1. Faça upload do plugin para `/wp-content/plugins/whatsapp-contact-button/`
2. Ative o plugin através do menu 'Plugins' no WordPress
3. Acesse 'Botão WhatsApp' no menu administrativo

= Configuração Inicial =

### **Passo 1: Número Principal (Recomendado)**
Configure o campo ACF `whatsapp` nas Opções do Tema:
```php
// Exemplo: 55 (11) 99999-9999
```

### **Passo 2: Configurações Básicas**
1. Acesse 'Botão WhatsApp' > 'Configurações'
2. Configure formulário padrão (Contact Form 7)
3. Defina textos padrão para popup e mensagem
4. Salve as configurações

### **Passo 3: Mapeamento por Página (Opcional)**
1. Na seção 'Mapeamento por Página'
2. Adicione configurações específicas
3. Configure formulários diferentes por página
4. Personalize mensagens específicas

### **Passo 4: Analytics**
1. Acesse a aba 'Analytics' para ver métricas
2. Configure notificações por email
3. Monitore conversões e otimize

== Frequently Asked Questions ==

= O plugin funciona sem Contact Form 7? =

Sim, mas a funcionalidade de captura de leads ficará limitada. O botão irá redirecionar diretamente para o WhatsApp. Recomendamos o CF7 para experiência completa.

= É necessário ter Advanced Custom Fields? =

Não é obrigatório. O plugin tem campo próprio para o número WhatsApp. O ACF é recomendado para usar o mesmo número em outras partes do site.

= Como funciona o sistema de prioridades? =
Para mapeamentos por página (v1.1.0):

Slug da página (mais específico)
Categoria/taxonomia
Template da página
Tipo de post (menos específico)

Exemplo prático:
Se você tem um mapeamento para "projetos" (tipo) e outro para "cobertura-de-evento" (categoria),
a categoria terá prioridade por ser mais específica.

= Mapeamento por categoria não funciona com CPT? =
Na v1.1.0 corrigimos este problema! Agora o mapeamento por categoria funciona universalmente:

✅ Posts padrão (category, post_tag)
✅ Custom Post Types (qualquer taxonomia)
✅ Exemplo: categoria "eventos" funciona tanto em posts quanto no CPT "projetos"

= Posso ter diferentes formulários para páginas específicas? =
Sim! O sistema de mapeamento por página (v1.1.0) permite:
Por slug: Formulário específico para /contato/, /sobre/
Por categoria: Formulário para categoria "noticias", "eventos"
Por tipo de post: Formulário para todo CPT "projetos"
Por template: Formulário para template específico
Cada mapeamento pode ter:

Formulário CF7 diferente
Texto do popup personalizado
Mensagem WhatsApp específica
Variáveis personalizáveis



= Posso ter formulários diferentes em páginas diferentes? =

Sim! Use o sistema de mapeamento por página para configurar:
- Formulários específicos por slug/categoria/tipo
- Mensagens personalizadas para cada contexto
- Textos de popup diferentes

= O plugin afeta a velocidade do site? =

Não. O plugin é otimizado para performance:
- Assets carregam apenas quando necessário
- Consultas de banco otimizadas
- Cache inteligente
- Código minificado

= Como personalizar o visual? =

O plugin se integra automaticamente com seu tema através da variável `--base-color`. Para personalização avançada:

```css
/* Personalizar botão */
.wcb-button {
    background: #sua-cor !important;
}

/* Personalizar modal */
.wcb-modal-content {
    border-radius: 20px;
}
```

= Posso usar em múltiplos sites? =

Sim, o plugin segue a licença GPL e pode ser usado em quantos sites desejar.

= Como funciona a exportação de dados? =

A exportação gera um arquivo CSV com:
- Dados básicos (nome, email, telefone)
- Informações da página de origem
- Dados completos do formulário
- Timestamps e device info
- Aplicação de todos os filtros selecionados

= O plugin é compatível com LGPD? =

Sim. O plugin:
- Armazena dados localmente no WordPress
- Não envia dados para serviços externos
- Permite exportação e exclusão de dados
- Respeita configurações de consentimento

= O formulário não valida corretamente no modal? =

Na v1.1.1 corrigimos um bug onde o formulário enviava sem validar campos obrigatórios quando acceptance não estava marcado. Agora:

✅ **Comportamento correto**: Botão desabilitado quando acceptance desmarcado
✅ **Validação nativa**: CF7 valida normalmente todos os campos obrigatórios  
✅ **Feedback visual**: Mensagens de erro estilizadas e sem duplicação
✅ **Zero interferência**: Sistema trabalha harmoniosamente com CF7

Se ainda enfrentar problemas:
1. Verifique se está usando CF7 atualizado
2. Confirme se campos hidden estão no formulário
3. Teste em navegador sem cache
4. Verifique console para erros JavaScript

= Por que o botão voltou a ser verde em vez da cor do tema? =

Decidimos manter o verde WhatsApp (#25d366) no botão principal para preservar a identidade visual da plataforma. 

Para usar a cor do seu tema, utilize o shortcode:
[whatsapp_button style="theme"]

Isso oferece flexibilidade mantendo a familiaridade visual do WhatsApp.

== Screenshots ==

1. **Botão flutuante** no frontend com design responsivo
2. **Modal com formulário** Contact Form 7 integrado
3. **Aba Contatos** - Lista completa com filtros e ações
4. **Aba Analytics** - Métricas e gráfico de funil
5. **Aba Configurações** - Interface completa de configuração
6. **Mapeamento por página** - Configurações específicas
7. **Sistema de prioridades** - Número WhatsApp principal vs específico
8. **Integração com tema** - Cores automáticas do tema

== Changelog ==

= 1.1.1 =
* **🐛 CORREÇÃO CRÍTICA: Validação CF7 em Modal**
  - Corrige bug onde formulário enviava sem validar campos obrigatórios quando acceptance desmarcado
  - Implementa validação customizada que trabalha harmoniosamente com CF7 nativo
  - Observer em tempo real detecta e remove duplicações automaticamente
* **🎨 MELHORIAS VISUAIS: Feedbacks Limpos**
  - Remove spinners e mensagens duplicadas com tripla proteção (JS + Observer + CSS)
  - Esconde campos hidden que criavam espaços desnecessários
  - Estiliza mensagens de erro/sucesso de forma minimalista e profissional
* **✅ COMPORTAMENTO NATIVO PRESERVADO**
  - Mantém botão desabilitado quando acceptance não marcado (padrão CF7)
  - Botão volta a ser verde WhatsApp (#25d366) mantendo identidade visual
  - Zero interferência com validação nativa do Contact Form 7
* **🔧 CORREÇÕES TÉCNICAS**
  - Namespace em eventos para evitar múltiplos listeners
  - CSS anti-duplicação com seletores específicos
  - Melhor integração entre validação customizada e CF7


= 1.1.0 =
* **🎯 NOVO: Suporte Universal a Taxonomias**
  - Mapeamento por categoria funciona com Custom Post Types (projetos, serviços, etc.)
  - Detecção automática de todas as taxonomias personalizadas
  - Sistema universal: mesma categoria em posts e CPTs usa mesmo formulário
* **🔧 NOVO: Sistema de Prioridades para Mapeamentos**
  - Ordem inteligente: slug > categoria > template > tipo de post
  - Configurações específicas sobrepõem configurações gerais
  - Logs de debug mostram qual mapeamento foi aplicado
* **⚙️ MELHORIA: Interface Admin**
  - Disclaimer explicativo sobre tipos de mapeamento e prioridades
  - Status visual melhorado para números WhatsApp
  - Seções reorganizadas para melhor usabilidade
* **🐛 CORREÇÃO: Detecção de Contexto**
  - Fallback inteligente para extração de slug da URL
  - Melhoria na captura de dados da página em contextos AJAX
  - Correção de bug onde slug não era detectado corretamente
* **🎯 NOVO: Sistema de Mapeamento por Página**
  - Configure formulários específicos por slug/categoria/tipo
  - Mensagens WhatsApp personalizadas por contexto
  - Textos de popup específicos para cada página
* **🔧 NOVO: Sistema de Prioridades**
  - Configurações globais com sobrescrita específica
  - Campo WhatsApp do plugin vs ACF com prioridade inteligente
* **📊 NOVO: Analytics Avançados**
  - Gráfico de funil interativo com Chart.js
  - Top páginas geradoras com métricas detalhadas
  - Cards de métricas em tempo real
* **⚙️ NOVO: Interface Admin Reorganizada**
  - 3 abas bem organizadas (Contatos, Analytics, Configurações)
  - Seções lógicas nas configurações
  - Status visual dos números WhatsApp
* **🎨 MELHORIA: Integração com Tema**
  - Variável `--base-color` aplicada em mais elementos
  - Fallbacks inteligentes para navegadores antigos
  - Suporte melhorado a temas escuros
* **🧪 NOVO: Sistema de Variáveis**
  - 8 variáveis personalizáveis para mensagens
  - Substituição automática com dados do usuário
  - Contexto da página e device info
* **🔧 CORREÇÃO: Extração de Slug**
  - Fallback automático para extração de slug da URL
  - Correção de bug onde slug não era capturado
  - Melhoria na detecção de contexto da página
* **⚡ PERFORMANCE: Otimizações**
  - Carregamento condicional melhorado
  - Queries de banco otimizadas
  - Cache de configurações específicas

= 1.0.1 =
* **NOVA FUNCIONALIDADE**: Integração automática com variável CSS `--base-color` do tema
* **MELHORIA**: Shortcode com parâmetro `style` para escolher entre cor do tema ou verde WhatsApp
* **MELHORIA**: Elementos do painel administrativo seguem a cor do tema
* **MELHORIA**: Campos de formulário com foco usando cor do tema
* **MELHORIA**: Sistema de fallback inteligente para navegadores antigos
* **CORREÇÃO**: Erro fatal durante ativação do plugin (classe WCB_Database não encontrada)
* **DOCUMENTAÇÃO**: Novo arquivo THEME-INTEGRATION.md com guia completo

= 1.0.0 =
* **Lançamento inicial**
* Botão flutuante WhatsApp com modal responsivo
* Integração completa com Contact Form 7
* Sistema básico de analytics e rastreamento
* Painel administrativo com gestão de contatos
* Horários de funcionamento configuráveis
* Notificações por email automáticas
* Exportação CSV de contatos
* Design responsivo e acessível
* Integração básica com ACF

== Upgrade Notice ==

= 1.1.0 =
**ATUALIZAÇÃO IMPORTANTE**: Nova versão com sistema de mapeamento por página! Configure formulários e mensagens específicas para cada contexto. Sistema de prioridades e analytics avançados. Recomendamos backup antes da atualização.

= 1.0.1 =
Nova integração com cores do tema! O plugin usa automaticamente a variável --base-color do seu tema. Correção importante de erro fatal na ativação.

= 1.0.0 =
Primeira versão do plugin. Instale para começar a capturar leads via WhatsApp.

== Technical Details ==

= Arquitetura =

**Classes Principais:**
* `WhatsAppContactButton` - Core plugin com sistema de prioridades
* `WCB_Frontend` - Funcionalidades frontend e mapeamento
* `WCB_CF7_Integration` - Integração CF7 com extração de slug
* `WCB_Admin` - Interface admin com 3 abas
* `WCB_Database` - Operações otimizadas de banco
* `WCB_Analytics` - Métricas e relatórios

**Banco de Dados:**
* `wp_whatsapp_contacts` - Dados dos contatos
* `wp_whatsapp_analytics` - Eventos de tracking

= Hooks para Desenvolvedores =

**Actions:**
* `wcb_before_contact_insert` - Antes de inserir contato
* `wcb_after_contact_insert` - Após inserir contato
* `wcb_new_contact` - Novo contato criado

**Filters:**
* `wcb_whatsapp_message` - Filtrar mensagem WhatsApp
* `wcb_contact_data` - Filtrar dados antes de salvar
* `wcb_notification_emails` - Filtrar emails de notificação

= Funções Úteis =

```php
// Número com prioridade
WhatsAppContactButton::get_whatsapp_number()

// Verificar CF7 ativo
WhatsAppContactButton::is_cf7_active()

// Contexto da página atual
$frontend->get_current_page_context()

// Texto com prioridade
$frontend->get_popup_text_with_priority()
```

= Shortcodes =

**Botão manual:**
```
[whatsapp_button text="Contato" style="theme" class="custom"]
```

**Parâmetros:**
* `text` - Texto do botão (padrão: "Fale conosco no WhatsApp")
* `style` - "theme" (cor do tema) ou "whatsapp" (verde tradicional)
* `class` - Classe CSS adicional

= Configurações Avançadas =

**Variável CSS principal:**
```css
:root {
    --base-color: #your-brand-color;
}
```

**Personalização de elementos:**
```css
/* Botão flutuante */
.wcb-button { /* seus estilos */ }

/* Modal */
.wcb-modal-content { /* seus estilos */ }

/* Formulário */
.wcb-form-container { /* seus estilos */ }
```

== Support ==

= Documentação =

* **DOCUMENTATION.md** - Documentação técnica completa
* **THEME-INTEGRATION.md** - Guia de integração com temas
* Código bem documentado com comentários detalhados

= Suporte Técnico =

Para suporte técnico ou dúvidas sobre implementação:

1. ✅ Consulte a documentação incluída
2. ✅ Verifique o arquivo de troubleshooting
3. ✅ Analise os logs de erro (WP_DEBUG)
4. ✅ Entre em contato com o desenvolvedor

= Requisitos do Sistema =

* **WordPress**: 5.0 ou superior
* **PHP**: 7.4 ou superior  
* **MySQL**: 5.6 ou superior
* **Memória**: 128MB recomendado
* **Plugins recomendados**: Contact Form 7, Advanced Custom Fields

= Compatibilidade Testada =

* ✅ WordPress 6.0 - 6.4
* ✅ PHP 7.4 - 8.2
* ✅ Contact Form 7 5.x
* ✅ Advanced Custom Fields 5.x - 6.x
* ✅ Principais temas do mercado
* ✅ Plugins de cache populares

== Privacy Policy ==

= Dados Coletados =

Este plugin coleta e armazena localmente:

* **Dados pessoais**: Nome, email, telefone (via formulários)
* **Dados técnicos**: Device type, user agent, timestamps
* **Dados de navegação**: URL origem, título da página, slug
* **Dados de interação**: Cliques, envios, redirecionamentos

= Armazenamento =

* ✅ **Local**: Todos os dados ficam no banco WordPress
* ✅ **Seguro**: Sanitização e escape adequados
* ✅ **Controlado**: Admin tem controle total
* ❌ **Externo**: Não enviamos dados para serviços externos

= Compartilhamento =

Dados são compartilhados apenas quando:
* **WhatsApp**: Redirecionamento do usuário (ação consciente)
* **Email**: Notificações configuradas pelo admin
* **Exportação**: Ação manual do administrador

= Direitos dos Usuários =

* **Acesso**: Visualização através do painel admin
* **Retificação**: Edição manual pelo administrador  
* **Exclusão**: Função de deletar contatos
* **Portabilidade**: Exportação em CSV
* **Consentimento**: Respeita campos de aceite do CF7

== Credits ==

**Desenvolvido por Manus AI**

* 🎯 **Foco**: Simplicidade e funcionalidade completa
* ⚡ **Performance**: Código otimizado e escalável  
* 🎨 **Design**: Integração harmoniosa com temas
* 🔧 **Flexibilidade**: Sistema de prioridades e mapeamento
* 📊 **Analytics**: Métricas completas para otimização

**Tecnologias utilizadas:**
* WordPress APIs e padrões
* Chart.js para gráficos
* CSS3 com variáveis e color-mix()
* JavaScript ES6+ com jQuery
* PHP 7.4+ com orientação a objetos

**Inspiração:**
* Necessidades reais de negócios digitais
* Feedback de desenvolvedores e usuários
* Melhores práticas de UX e conversão
* Padrões de acessibilidade web