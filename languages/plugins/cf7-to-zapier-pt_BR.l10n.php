<?php
return ['x-generator'=>'GlotPress/4.0.1','translation-revision-date'=>'2025-01-27 13:01:21+0000','plural-forms'=>'nplurals=2; plural=n > 1;','project-id-version'=>'Plugins - CF7 to Webhook - Stable (latest release)','language'=>'pt_BR','messages'=>['
Hey! How are you?

"CF7 to Webhook" has a built-in feature that detects when a webhook fails and notifies you with this automated email.

- Form: [FORM]
- Webhook: [WEBHOOK]
- Error: [EXCEPTION]

Request Method:
[REQUEST_METHOD]

Request Headers:
[REQUEST_HEADERS]

Request Body:
[REQUEST_BODY]

Response Code:
[RESPONSE_CODE]

Response Message:
[RESPONSE_MESSAGE]

Response Headers:
[RESPONSE_HEADERS]

Response Body:
[RESPONSE_BODY]

--

You\'ll receive one notification for each webhook with errors.
Other webhooks maybe were successful.

Please, be careful sharing this data (even in WordPress official support forum).
It may contain sensitive data.
            '=>'
Olá! Como você está?

O plugin "CF7 para Webhook" possui uma funcionalidade que detecta quando um gatilho (webhook) falha e notifica você através desse e-mail automático.

- De: [FORM]
- Webhook: [WEBHOOK]
- Erro: [EXCEPTION]

Requisição - Método:
[REQUEST_METHOD]

Requisição - Cabeçalhos:
[REQUEST_HEADERS]

Requisição - Corpo:
[REQUEST_BODY]

Resposta - Código:
[RESPONSE_CODE]

Resposta - Mensagem:
[RESPONSE_MESSAGE]

Resposta - Cabeçalhos:
[RESPONSE_HEADERS]

Resposta - Corpo:
[RESPONSE_BODY]

--

Você receberá uma notificação para cada webhook com erro.
Outros webhooks podem ter funcionado sem problemas.

Seja cuidado ao compartilhar dados (mesmo no fórum de suporte do WordPress).
Esses dados podem ser sensíveis.
            ','Check FAQ from plugin page.'=>'Veja as Perguntas Frequentes na página do plugin.','How to make multiple webhooks optionals?'=>'Como fazer múltiplos webhooks opcionais?','Webhook returned a error code.'=>'Webhook retornou um código de erro.','Webhook has method GET but body is not a JSON to be passed as query params.'=>'Webhook foi configurado como GET mas os dados enviados não são um JSON válido para ser passado como parâmetro da URL.','[%s] Webhook Error on Form %s'=>'[%s] Erro do Webhook no Formulário %s','Choose a template'=>'Escolha um modelo','Continue'=>'Continuar','Cancel'=>'Cancelar','Yes'=>'Sim','No'=>'Não','Save to load preview.'=>'Salve para carregar a previsão.','This action will replace "Body" and remove "Special Mail Tags" and "Headers".'=>'Essa ação ira substituir o "Corpo" e remover as configurações "Special Mail Tags" e "Cabeçalhos".','This action will replace "Headers" and "Body" and remove "Special Mail Tags".'=>'Essa ação ira substituir os "Cabeçalhos" e o "Corpo" e remover a configuração "Special Mail Tags".','This template has documentation. Want to open (another tab)?'=>'Esse modelo possui documentação. Gostaria de lê-la (em outra aba)?','Default'=>'Padrão','ask a question!'=>'faça uma pergunta!','Or...'=>'Ou...','You can check more information or search for help.'=>'Você pode ver mais informações ou procurar por ajuda.','FAQ'=>'Perguntas frequentes','Send data in your URL.'=>'Envie dados para sua URL','Help'=>'Ajuda','The URL should point to HTTP response status code documentation in your language.<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Status" target="_blank">HTTP codes</a> (separated by comma) to be considered success. Other codes will trigger a error notification.'=>'<a href="https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Status" target="_blank">Códigos HTTP</a> (separados por vírgula) que são considerados sucesso. Outros códigos irão disparar um e-mail de notificação de erro.','Success Codes'=>'Códigos de Sucesso','One or more emails (separated by comma) to be notified on webhook error.'=>'Um ou mais e-mails (separados por vírgula) para serem notificados em caso de falha.','Notification'=>'Notificação','How we handle errors.'=>'Como lidamos com erros.','Errors'=>'Erros','We will send your form data as plain/text:'=>'Enviaremos os dados do seu formulário como plain/text:','Example: %s'=>'Exemplo: %s','To create your own body, you can replace values like in mail body (case sensitive).'=>'Para criar o corpo da sua requisição, você pode substituir tags de e-mail pelos valores (diferencia maiúsculas)','REMEMBER:'=>'LEMBRE:','This can break your integration (check your quotes).'=>'Isso pode quebrar sua integração (verifique suas aspas duplas).','When you need customize your request.'=>'Quando você precisa personalizar sua requisição.','Body'=>'Corpo','When you need authentication/authorization.'=>'Quando você precisa de autenticação.','Headers'=>'Cabeçalhos','Choose a HTTP method. In general, you should not change this.'=>'Escolha um método HTTP. Em geral, você não deve alterar isso.','If you select GET, we will send your data as "query params" (if your body is not a valid JSON we will trigger a error).'=>'Se você escolher GET, iremos enviar os dados como "parâmetros de URL" (se o seu corpo não for um JSON válido iremos disparar um erro).','BE CAREFUL!'=>'TENHA CUIDADO!','When you are not making a POST.'=>'Quando você não está fazendo um POST.','Method'=>'Método','Advanced settings'=>'Configurações avançadas','When you need more information.'=>'Quando você precisa de mais informação.','Check to send file content insted of a link'=>'Marque para enviar o conteúdo dos arquivos no lugar da URL','Send content'=>'Enviar conteúdo','Define how you want to send files.'=>'Defina como iremos enviar arquivos.','Files'=>'Arquivos','You can choose a template from community to update your header/body settings.'=>'Você pode escolher um modelo da comunidade para atualizar as configurações dos cabeçalhos e do corpo.','Template'=>'Modelo','Settings'=>'Configurações','Use Contact Form 7 as a trigger to any Webhook.'=>'Use Contact Form 7 como um gatilho (trigger) para qualquer webhook.','You can change field name with webhook config: %s'=>'Você pode alterar o nome do campo com a configuração "webhook": %s','This is just a example of field names and will not reflect data or customizations.'=>'Esse é apenas um exemplo que não leva em consideração os dados ou personalizações.','Use this shortcode: [hidden utm_source default:get]'=>'Utilize esse shortcode: [hidden utm_source default:get]','To get utm_source: https://example.com/?utm_source=example'=>'Para conseguir o valor de "utm_source": https://example.com/?utm_source=example','The URL should point to CF7 documentation.You can add URL parameters using <a href="https://contactform7.com/hidden-field/" target="_blank">Hidden Fields</a> with <a href="https://contactform7.com/getting-default-values-from-the-context/" target="_blank">default values</a> in your form.'=>'Você pode adicionar parâmetros da URL usando <a href="https://contactform7.com/hidden-field/" target="_blank">campos escondidos</a> com um <a href="https://contactform7.com/getting-default-values-from-the-context/" target="_blank">valor padrão</a> no seu formulário.','URL Params'=>'Parâmetros da URL','One header by line, separated by colon. Example: %s'=>'Um cabeçalho por linha, separados por vírgula. Por exemplo: %s','The URL should point to HTTP Headers documentation in your language.You can add <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers" target="_blank">HTTP Headers</a> to your webhook request.'=>'Você pode adicionar <a href="https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Headers" target="_blank">Cabeçalhos HTTP</a> à requisição enviada para o webhook.','The URL should point to CF7 documentation (someday it can be translated).You can add <a href="https://contactform7.com/special-mail-tags/" target="_blank">Special Mail Tags</a> or <a href="https://contactform7.com/selectable-recipient-with-pipes/" target="_blank">labels from selectable with pipes</a> to the data sent to webhook.'=>'Você pode adicionar <a href="https://contactform7.com/special-mail-tags/" target="_blank">Special Mail Tags</a> ou <a href="https://contactform7.com/selectable-recipient-with-pipes/" target="_blank">rótulos de seletores com "pipes"</a> aos dados enviados para o webhook.','And use placeholders to be replaced by form data: %s'=>'E use "placeholder" para serem trocados por dados do formulário: %s','You can add multiple webhook: one per line'=>'Você pode adicionar múltiplos webhooks: um por linha','leave a review'=>'deixar uma avaliação','make a donation'=>'fazer uma doação','You can %s or %s.'=>'Você pode %s ou %s.','Give your support!'=>'Dê seu apoio!','http://mariovalney.com/me'=>'https://mariovalney.com/sobre','Mário Valney'=>'Mário Valney','https://github.com/mariovalney/cf7-to-zapier'=>'https://github.com/mariovalney/cf7-to-zapier','Send to Webhook'=>'Enviar para o Webhook','To integrate you should insert your webhook URL below. For example, into Zapier you can create a trigger using "Webhooks" app and choose "Catch Hook" option.'=>'Para integrar, você deve adicionar a URL do webhoook abaixo. Por exemplo, no Zapier, você pode criar um gatilho (trigger) escolhendo o app "Webhooks" e a opção "Catch Hook".','Webhook'=>'Webhook','CF7 to Webhook'=>'CF7 to Webhook','Or add a second word to pass as key to Webhook: %s'=>'Ou adicione uma segunda palavra para enviá-la como nome do campo para o Webhook: %s','Insert Special Tags like in mail body: %s'=>'Insira as Special Tags como no corpo do e-mail: %s','Special Mail Tags'=>'Special Mail Tags','Do it now?'=>'Fazer isso agora?','You need to install/activate %s Contact Form 7%s plugin to use %s CF7 to Webhook %s'=>'Você precisa instalar/ativar o plugin %s Contact Form 7%s para usar o %s CF7 to Webhook %s','We will send your form data as JSON:'=>'Enviaremos os dados do seu formulário como JSON:','Send CF7 mail as usually'=>'Enviar o e-mail do CF7 normalmente','Send Mail'=>'Enviar E-mail','You should insert webhook URL here to finish configuration.'=>'Você precisa inserir a URL do webhook aqui, para finalizar a configuração.','Webhook URL'=>'URL do Webhook','Integrate'=>'Integrar','In these options you can activate or deactivate Webhook integration.'=>'Nessas opções você pode ativer ou desativar a integração com o Webhook.']];