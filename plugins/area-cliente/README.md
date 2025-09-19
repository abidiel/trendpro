# Área do Cliente

Sistema MVP de área do cliente para entrega de materiais via WordPress.

## Visão Geral

Sistema simples de área do cliente para entrega de materiais via WordPress, utilizando:
- CPT (Custom Post Type) para clientes
- Sistema nativo de senha do WordPress
- Campos ACF para estruturação de dados
- Classes Crafto Helpers para styling
- Links diretos para downloads (Dropbox)

## Estrutura do Plugin

```
area-cliente/
├── area-cliente.php                    // Plugin principal
├── acf-fields.json                     // Campos ACF para importação
└── README.md                           // Esta documentação
```

## Funcionalidades

### Custom Post Type
- **Nome**: `area_cliente`
- **Slug**: `cliente`
- **URL**: `/cliente/nome-da-empresa`
- **Suporte**: title, password
- **Público**: Sim, mas não indexável
- **Archive**: Não

### Campos ACF

#### Grupo Principal: "Dados do Cliente"
**Localização**: Post Type = area_cliente

##### Aba: Informações Gerais
- **cliente_nome** (Text) - Nome do Cliente (Obrigatório)
- **cliente_logo** (Image) - Logo do Cliente (Return Format: Array)

##### Aba: Entregas
- **entregas** (Repeater) - Entregas Realizadas
  - **titulo** (Text) - Título da Entrega (Obrigatório)
  - **descricao** (Textarea) - Descrição
  - **servico** (Text) - Tipo de Serviço (campo livre)
  - **banner** (Image) - Banner/Preview (Return Format: Array)
  - **links_download** (Repeater) - Links de Download
    - **titulo** (Text) - Título do Link (ex: "Arquivos Brutos")
    - **url** (URL) - URL do Link

## Templates

### single-area_cliente.php
Template principal que exibe:
- Header com logo e nome do cliente
- Grid responsivo de entregas (3 colunas desktop, 2 tablet, 1 mobile)
- Cards com banner, título, descrição e múltiplos botões de download
- Verificação de senha antes de exibir conteúdo

### template-parts/password-form.php
Formulário customizado para autenticação:
- Design responsivo com classes Crafto
- Validação de senha
- Mensagens de erro
- Animações CSS

## Segurança

- **Meta robots**: `noindex, nofollow` em todas as páginas
- **Proteção por senha**: Sistema nativo do WordPress
- **Verificação de acesso**: `post_password_required()` no template
- **Links seguros**: Links diretos para Dropbox/Google Drive

## Workflow de Uso

### Para o Admin (TrendPro)
1. Acessar Admin → Área do Cliente
2. Adicionar Novo Cliente
3. Preencher nome e logo
4. Definir senha forte
5. Adicionar entregas no repeater
6. Publicar

### Para o Cliente
1. Receber URL + senha via email/WhatsApp
2. Acessar URL: `/cliente/nome-empresa/`
3. Inserir senha
4. Visualizar entregas em grid
5. Clicar para baixar arquivos

## Classes CSS Utilizadas

### Container e Layout
- `.area-cliente` - Container principal
- `.cliente-header` - Header do cliente
- `.entregas-grid` - Grid de entregas
- `.entrega-card` - Card individual

### Classes Crafto Helpers
- `.fs-*` - Font sizes (fs-14, fs-16, fs-18, fs-24, fs-32)
- `.fw-*` - Font weights (fw-500, fw-600)
- `.bg-*` - Backgrounds (bg-white, bg-base-color)
- `.text-*` - Text colors (text-dark-gray, text-medium-gray, text-white)
- `.border-radius-*` - Border radius (border-radius-10px, border-radius-20px)
- `.p-*` - Padding (p-15px, p-30px, p-50px)
- `.mb-*` - Margin bottom (mb-15px, mb-20px, mb-30px)
- `.w-100` - Width 100%

## Estrutura de Dados

### Exemplo de Post
```
Post ID: 123
Post Type: area_cliente
Post Title: "Empresa ABC"
Post Slug: "empresa-abc"
Post Password: "senha123"
Post Status: "publish"

Meta Fields (ACF):
- cliente_nome: "Empresa ABC Ltda"
- cliente_logo: [array com dados da imagem]
- entregas: [
    {
      titulo: "Logo + Manual de Marca",
      descricao: "Identidade visual completa",
      servico: "branding",
      banner: [array com dados da imagem],
      links_download: [
        {
          titulo: "Arquivos Brutos",
          url: "https://dropbox.com/sh/abc123"
        },
        {
          titulo: "Materiais Editados", 
          url: "https://dropbox.com/sh/def456"
        }
      ]
    }
  ]
```

## Instalação

1. Fazer upload da pasta `area-cliente` para `/wp-content/plugins/`
2. Ativar o plugin no painel administrativo
3. **Importar campos ACF**:
   - Acessar ACF → Tools → Import Field Groups
   - Fazer upload do arquivo `acf-fields.json`
   - Clicar em "Import"
4. Os templates devem estar no tema ativo

## Requisitos

- WordPress 5.0+
- Advanced Custom Fields Pro
- Tema com suporte a templates customizados
- Classes CSS Crafto Helpers (opcional, mas recomendado)

## Desenvolvimento

### Estrutura do Plugin
- **Classe principal**: `AreaCliente`
- **Hook de ativação**: Flush rewrite rules
- **Campos ACF**: Importados via JSON
- **Templates**: No tema ativo

### Hooks Utilizados
- `init` - Registrar CPT
- `wp_head` - Adicionar meta robots
- `template_redirect` - Verificar proteção por senha

## Integrações Futuras (Fase 2)

### Dropbox Embed
- API Dropbox para preview de arquivos
- Embed de pastas compartilhadas
- Download direto via API

### Notificações
- Email automático para novas entregas
- WhatsApp via API (Twilio/Evolution)

### Analytics
- Tracking de downloads
- Relatórios de acesso por cliente

## Considerações de Segurança

- Senhas fortes obrigatórias
- Links temporários para downloads (futuro)
- Logs de acesso (futuro)
- Proteção contra força bruta
- HTTPS obrigatório

## Performance

- Lazy loading nas imagens
- Otimização de tamanhos de imagem
- Cache de templates
- CDN para assets estáticos

## Suporte

Para dúvidas ou problemas, entre em contato com a equipe de desenvolvimento.

---

*Plugin desenvolvido para TrendPro - Sistema MVP Área do Cliente v1.0.0*
