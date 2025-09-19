# Como Adicionar Novos Tipos de Serviço

## 📋 Processo para Adicionar Novas Opções

### 1. **Acessar o Painel WordPress**
- Ir em: **Campos Personalizados > Grupos de Campos**
- Localizar: **"Dados do Cliente"**
- Clicar em **"Editar"**

### 2. **Encontrar o Campo "Tipo de Serviço"**
- Localizar o campo com label **"Tipo de Serviço"**
- Clicar para editar o campo

### 3. **Adicionar Nova Opção nas Escolhas**
- Na seção **"Escolhas"**, adicionar nova linha:
- **Formato**: `chave : Texto que Aparece`
- **Exemplo**: `edicao_vfx : Edição VFX`

### 4. **Opções Atuais no Sistema**
```
design : Design Gráfico
social_media : Social Media
branding : Branding
web : Web Design
video : Produção de Vídeo
edicao_vfx : Edição VFX
desenvolvimento_sites : Desenvolvimento de Sites
cobertura_eventos : Cobertura de Eventos
producao_conteudo : Produção de Conteúdo
banco_conteudo : Banco de Conteúdo
```

### 5. **Formato Correto**
- **Chave**: sempre em minúsculas, com underscore (ex: `nova_opcao`)
- **Valor**: texto que aparece no select (ex: `Nova Opção`)
- **Separador**: ` : ` (dois pontos com espaços)

### 6. **Lista Completa Atual**
```
design : Design Gráfico
social_media : Social Media
branding : Branding
web : Web Design
video : Produção de Vídeo
edicao_vfx : Edição VFX
desenvolvimento_sites : Desenvolvimento de Sites
cobertura_eventos : Cobertura de Eventos
producao_conteudo : Produção de Conteúdo
banco_conteudo : Banco de Conteúdo
```

## 🔄 **Após Fazer as Alterações**

### 1. **Salvar o Campo**
- Clicar em **"Atualizar"** no campo
- Salvar o grupo de campos

### 2. **Sincronizar (se necessário)**
- Ir em: **Campos Personalizados > Sincronizar**
- Clicar em **"Sincronizar"** no grupo "Dados do Cliente"

### 3. **Testar**
- Criar/editar uma entrega
- Verificar se a nova opção aparece no select
- Testar se salva corretamente

## ⚠️ **Cuidados Importantes**

- **Chaves únicas**: não repetir chaves existentes
- **Formato**: sempre usar underscore na chave
- **Teste**: sempre testar após alterações
- **Backup**: fazer backup antes de grandes alterações

## 🎯 **Como o Código Funciona**

O código já está preparado para:
- ✅ **Pegar qualquer valor** do select automaticamente
- ✅ **Converter chaves** em textos amigáveis
- ✅ **Funcionar com novas opções** sem alterar código
- ✅ **Fallback** para valores não mapeados

## 📞 **Suporte**

Em caso de dúvidas:
1. Verificar se a chave está no formato correto
2. Testar criando uma nova entrega
3. Verificar se aparece no frontend
4. Contatar desenvolvedor se necessário
