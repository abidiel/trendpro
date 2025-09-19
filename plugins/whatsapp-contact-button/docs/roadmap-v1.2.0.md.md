# 🚀 Prompt para Próximo Chat - WhatsApp Contact Button v1.2.0

## 📋 Contexto do Projeto

O WhatsApp Contact Button é um plugin WordPress completo (v1.1.1) com sistema de captura de leads via CF7, analytics avançados, mapeamento por página e integração harmoniosa com temas. Acabamos de finalizar a **correção crítica do sistema de validação CF7** e agora vamos implementar as **próximas funcionalidades do roadmap v1.2.0**.

---

## 🎯 Funcionalidades Prioritárias v1.2.0

### 🔧 **1. Máscaras Automáticas nos Campos CF7**
- Detectar campos de telefone automaticamente
- Aplicar máscara brasileira (11) 99999-9999
- Integração não-invasiva com CF7
- Funcionar tanto no modal quanto em formulários normais

### 🎨 **2. Visual Cards no Modal "Ver" Contato**
**Problema atual:** Dados duplicados e campos ocultos expostos
**Solução:** Cards organizados e dados limpos
- Separar dados pessoais dos dados do formulário
- Esconder campos técnicos (wcb_*, campos ocultos)
- Design em cards modernos com melhor hierarquia visual
- CSS aprimorado para toda a modal

### 📊 **3. Exportação Selecionados**
- Checkboxes para seleção múltipla na lista de contatos
- Botão "Exportar Selecionados" 
- Contador de itens selecionados
- Validação mínima de seleção

### 🕵️ **4. Rastreamento de Origem da Visita**
**Campos ocultos a adicionar:**
- `utm_source` - Fonte da campanha
- `utm_medium` - Meio da campanha  
- `utm_campaign` - Nome da campanha
- `document.referrer` - Site de origem
- Salvar no banco de dados
- Exibir nos detalhes do contato
- Incluir na exportação CSV

### 📧 **5. Teste Sistema de Email**
- Configurar WP Mail SMTP
- Testar notificações automáticas
- Validar funcionamento em produção

### 📋 **6. Correção Exportação CSV**
**Problema atual:** Campos select aparecem como "Array" na coluna Observações
```
Event Type: Array. Event Date: 2050-02-18. Event Location: Floripa SC. Budget: Array. Your Message: Evento corporativo em floripa
```
**Solução:** 
- Detectar campos do tipo array/select
- Extrair valores corretos dos arrays
- Formatar adequadamente na exportação
- Testar com diferentes tipos de campo CF7

---

## 🔧 Melhorias da Interface Admin

### **Aba Contatos:**
- **Filtros:** Corrigir sobreposição de seta no texto
- **Paginação:** Estilizar paginação atual + mostrar total por página
- **Seleção:** Contador de itens selecionados
- **Modal "Ver":** Cards organizados sem duplicação de dados

### **Aba Analytics:**
- **Cores:** Migrar de fundo escuro para visual light padrão WordPress
- **Bug Top Páginas:** Corrigir linha vazia sem nome de página
- **Exportação Analytics:** Botão para exportar dados filtrados em CSV

### **Aba Configurações:**
- **Texto do Popup:** Permitir formatação HTML (negrito, quebras de linha)
- **Preview:** Respeitar formatação no frontend

---

## 🐛 Bugs Identificados para Correção

### **1. Top Páginas Analytics**
```html
<!-- Linha problemática: -->
<td><strong></strong></td>  <!-- Nome vazio -->
<td>206</td>
<td>136</td>
```
**Investigar:** Query que retorna page_title vazio

### **2. Formatação Texto Popup**
**Problema:** Ignora espaços e HTML
**Solução:** Processar HTML adequadamente e aplicar formatação

### **3. Exportação CSV - Campos Select**
**Problema:** Campos select/radio/checkbox aparecem como "Array"
```
Event Type: Array
Budget: Array
```
**Debug necessário:**
- Verificar como CF7 armazena dados de select
- Analisar estrutura do JSON no banco
- Implementar parser adequado para diferentes tipos de campo

---

## 📦 Estrutura de Entrega

### **Arquivos que serão enviados:**
1. **Manual técnico:** `manual_plugin_whatsapp.md`
2. **Documentação completa:** `documentation.md`, `readme.txt`, `theme-integration.md`
3. **Arquivos do plugin:** Todos os arquivos PHP, JS, CSS conforme necessário
4. **Contexto completo:** Status atual v1.1.1 e roadmap detalhado

### **Padrões a seguir:**
- **Commits semânticos:** `feat:`, `fix:`, `refactor:`
- **Documentação:** Atualizar conforme implementações
- **Testes:** Validar cada funcionalidade antes de avançar
- **Compatibilidade:** WordPress 5.0+, PHP 7.4+, CF7 5.x

---

## 🎯 Objetivo da Sessão

Implementar **todas as funcionalidades v1.2.0** de forma organizada e eficiente, mantendo a qualidade e padrões estabelecidos na v1.1.1. Priorizar UX, performance e integração harmoniosa com o ecossistema WordPress.

**Vamos transformar o plugin em uma solução ainda mais completa e profissional!** 🚀

---

## 📋 Checklist de Implementação

- [ ] Máscaras automáticas CF7
- [ ] Cards organizados modal "Ver"  
- [ ] Exportação selecionados
- [ ] Rastreamento origem visita
- [ ] Correção exportação CSV (campos select)
- [ ] Teste sistema email
- [ ] Melhorias interface admin
- [ ] Correção bugs identificados
- [ ] Atualização documentação
- [ ] Testes funcionais completos

---

## 🔍 Áreas de Investigação Técnica

### **1. Estrutura CF7 Form Data**
Analisar como diferentes tipos de campo são armazenados:
```php
// Exemplo atual no banco:
'form_data' => '{"your-name":"João","event-type":["Social"],"budget":["5000-10000"]}'

// Objetivo: Extrair valores corretos dos arrays
```

### **2. Parser de Campos CF7**
Implementar lógica para diferentes tipos:
- Text/Email/Tel: string simples
- Select/Radio: array com valor selecionado
- Checkbox: array com valores marcados
- Textarea: string com quebras de linha

### **3. Otimização de Queries**
Revisar queries analytics que retornam dados vazios e otimizar performance.

---

**Ready to build v1.2.0!** ⚡