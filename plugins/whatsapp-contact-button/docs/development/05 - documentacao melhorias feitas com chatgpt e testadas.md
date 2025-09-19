
# 📌 Plugin: WhatsApp Contact Button — Documentação Atualizada

## 📖 Visão Geral

O plugin **WhatsApp Contact Button** exibe um botão flutuante no site que, ao ser clicado, abre um modal com um formulário (via Contact Form 7). Após o envio, o usuário é redirecionado automaticamente para o WhatsApp com uma mensagem personalizada. Além disso, os dados são salvos em um painel administrativo, com visualização e exportação de leads.

---

## ✅ Melhorias Implementadas

### 1. 🧠 Correção do Salvamento no Banco de Dados
- Corrigido o problema de dados que não estavam sendo salvos corretamente.
- Agora os envios do formulário são registrados na tabela personalizada `wp_whatsapp_contacts`.

---

### 2. 🧾 Campos Ocultos Automatizados
- Adição automática de campos ocultos em formulários exibidos via modal:
  - `wcb_page_title`
  - `wcb_page_url`
  - `wcb_page_slug`
- Preenchimento dinâmico via JavaScript.

---

### 3. 💬 Atalhos com Classe `.wcb-open-modal`
- Qualquer botão com a classe `.wcb-open-modal` abre o modal do WhatsApp.
- Permite utilizar o mesmo modal para múltiplos CTAs do site.
- Ação validada e testada com formulários dinâmicos.

---

### 4. 🔎 Painel de Contatos — Visualização de Detalhes
- Implementada funcionalidade “Ver” para cada lead.
- Exibe todos os dados básicos e os campos do formulário em cards separados.
- Os dados são carregados via AJAX.

---

### 5. 📤 Exportação de Leads
- Implementada exportação de todos os leads para CSV.
- Inclui:
  - Nome, Telefone, E-mail, Página, URL, Dispositivo, Data, Status.
  - Todos os **campos personalizados** do formulário.
- Campo de notas removido por não estar em uso.
- Campo adicional (ex: "Data do Evento") é incluído automaticamente na exportação se presente no formulário.

---

### 6. 🌐 Rastreamento da Origem da Visita
- Inclusão automática no formulário dos campos:
  - `utm_source`
  - `utm_medium`
  - `utm_campaign`
  - `document.referrer`
- Os dados são salvos no banco e exibidos no painel do contato e exportação CSV.

---

### 7. 🛠️ Texto do Modal e Mensagem Base via ACF
- O plugin agora utiliza os campos definidos via **ACF nas Opções do Tema**:
  - `whatsapp_texto_popup` → Texto exibido no modal.
  - `whatsapp_mensagem_base` → Mensagem enviada via WhatsApp.
- Status dos campos é exibido (ex: “✅ Configurado”).
- Planejamento futuro de personalização por slug.

---


## ⚠️ Funcionalidades Parcialmente Funcionais

### 8. 📊 Aba de Analytics
- ✅ A aba já está implementada.
- ⚠️ **Gráficos ainda não funcionam corretamente.**
- ⚠️ **Ranking de páginas que geram leads ainda não está disponível**, mas será adicionado.

---

### 9. 📧 Notificação por E-mail
- ✅ Funcionalidade já está implementada no plugin.
- ⚠️ Ainda **não foi testada** por depender da configuração de SMTP no servidor.
- Previsto envio automático para o admin após novo contato.
