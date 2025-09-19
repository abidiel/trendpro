
## 🔜 Funcionalidades Pendentes (Backlog)

### 🧩 1. Expansão do mapeamento por slug
- Adicionar campos de personalização no painel:
  - Texto do popup (específico por página).
  - Mensagem base do WhatsApp (específica por página).
- Aplicar esses dados dinamicamente no modal e na mensagem enviada.

---

### 🧩 2. Exportação Inteligente
- Adicionar exportação apenas dos contatos **selecionados** via checkbox no painel.

---

### 🧩 3. Visual do botão "Ver"
- Estilizar o botão “Ver”.
- Exibir os dados com cards colapsáveis:
  - Dados principais.
  - Dados do formulário.

---

### 🧩 4. Refinar o mapeamento por tipo de conteúdo
- Aprimorar seleção por:
  - **Categorias de CPTs** (custom post types).
  - **Páginas específicas do blog**.
- Usar `select2` para autocompletar os valores com mais precisão.

---

## 📂 Estrutura das Tabelas Criadas

### `wp_whatsapp_contacts`
Campos principais:
- `id`
- `name`, `email`, `phone`
- `page_title`, `page_url`, `page_slug`
- `device_type`, `user_agent`
- `submit_time`
- `form_data` (JSON com os campos do formulário)

### `wp_whatsapp_analytics`
- Ainda usada parcialmente.
- Suporte completo à análise será repensado em próximas versões.

---

## 🧪 Testes Realizados

- ✅ Modal abre via botão com `.wcb-open-modal`.
- ✅ Formulário é exibido corretamente por mapeamento de slug.
- ✅ Campos ocultos são preenchidos corretamente.
- ✅ Leads são salvos no banco.
- ✅ Exportação funciona com todos os campos.
- ✅ Dados são exibidos no painel de administração.

---
