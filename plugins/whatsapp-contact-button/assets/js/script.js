/**
 * WhatsApp Contact Button - Frontend JavaScript
 * v1.1.2 - Correção captura de dados da página home
 */

(function ($) {
  "use strict";

  let wcbSessionId = "";
  let wcbContactId = null;
  let wcbHasRedirected = false;
  let wcbPageData = null; // Cache dos dados da página

  $(document).ready(function () {
    // Verificar se jQuery está disponível
    if (typeof $ === 'undefined') {
      console.error('WCB: jQuery não está disponível');
      return;
    }
    
    wcbSessionId = wcbGenerateSessionId();

    if (!wcb_data || !wcb_data.whatsapp_number) {
      return;
    }

    // NOVO: Capturar e cachear dados da página no load
    wcbCachePageData();

    wcbShowButton();
    wcbBindEvents();
    wcbInitAccessibility();
    wcbSetupCF7Integration();
    wcbFillHiddenFields();
  });

  /**
   * NOVA FUNÇÃO: Capturar e cachear dados da página com fallbacks robustos
   */
  function wcbCachePageData() {
    // Prioridade 1: Dados fornecidos pelo PHP (mais confiáveis)
    if (wcb_data && wcb_data.page_data && wcb_data.page_data.title) {
      wcbPageData = {
        title: wcb_data.page_data.title,
        url: wcb_data.page_data.url,
        slug: wcb_data.page_data.slug
      };
      // console.log("WCB: Using PHP page data:", wcbPageData);
      return;
    }

    // Prioridade 2: Captura manual com fallbacks inteligentes
    let title = "";
    let url = window.location.href;
    let slug = "";

    // Detectar se é página inicial
    const isHomePage = window.location.pathname === "/" || 
                      window.location.pathname === "" ||
                      window.location.pathname === "/index.php";

    if (isHomePage) {
      // Para página inicial, usar estratégias específicas
      slug = "front-page";
      
      // Tentar diferentes fontes para o título da home
      title = $('meta[property="og:title"]').attr('content') ||
              $('title').text() ||
              $('h1').first().text() ||
              document.title ||
              "Página Inicial";
              
      // Limpar título se for genérico demais
      if (title.includes('|') || title.includes('-')) {
        title = title.split(/[|\-]/)[0].trim();
      }
    } else {
      // Para páginas internas
      slug = window.location.pathname.split("/").filter(Boolean).pop() || "page";
      title = $('h1').first().text() ||
              $('title').text() ||
              document.title ||
              "Página";
    }

    wcbPageData = {
      title: title.trim(),
      url: url,
      slug: slug
    };

    // console.log("WCB: Using manual page data:", wcbPageData);
  }

  /**
   * NOVA FUNÇÃO: Obter dados da página (com recaptura se necessário)
   */
  function wcbGetPageData() {
    // Se não temos dados em cache, recapturar
    if (!wcbPageData) {
      wcbCachePageData();
    }
    return wcbPageData;
  }

  function wcbShowButton() {
    // Verificar se jQuery está disponível
    if (typeof $ === 'undefined') {
      console.warn('WCB: jQuery não está disponível para showButton');
      return;
    }
    
    const $button = $("#wcb-whatsapp-button");

    if ($button.length) {
      $button.on("click", function (e) {
        e.preventDefault();
        
        // Verificar modo de operação
        if (wcb_data && wcb_data.button_mode === 'direct') {
          wcbHandleDirectMode();
        } else {
          wcbTrackEvent("click");
          wcbOpenModal();
        }
      });

      setTimeout(function () {
        $button.fadeIn(300);
      }, 1000);
    }
  }

  /**
   * NOVA FUNÇÃO: Lidar com modo direto
   */
  function wcbHandleDirectMode() {
    // Rastrear clique se habilitado
    if (wcb_data.track_direct_clicks) {
      wcbTrackEvent("click");
    }

    // Obter mensagem direta
    const directMessage = wcb_data.direct_message || '';
    
    if (!directMessage) {
      console.error('WCB: Mensagem direta não configurada');
      return;
    }

    // Construir URL do WhatsApp
    const whatsappNumber = wcb_data.whatsapp_number;
    if (!whatsappNumber) {
      console.error('WCB: Número do WhatsApp não configurado');
      return;
    }

    const encodedMessage = encodeURIComponent(directMessage);
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

    // Mostrar loading brevemente
    wcbShowDirectLoading();

    // Redirecionar após um pequeno delay
    setTimeout(function() {
      window.open(whatsappUrl, '_blank');
      wcbHideDirectLoading();
    }, 500);
  }

  /**
   * NOVA FUNÇÃO: Mostrar loading para modo direto
   */
  function wcbShowDirectLoading() {
    const $button = $("#wcb-whatsapp-button");
    
    // CORREÇÃO: Garantir que o botão mantenha suas dimensões e posição
    $button.css({
      'width': '60px',
      'height': '60px',
      'position': 'fixed',
      'border-radius': '50%',
      'bottom': '20px',
      'right': '20px',
      'top': 'auto',
      'left': 'auto'
    });
    
    $button.addClass('wcb-loading');
    
    // Apenas desabilitar o botão para evitar cliques múltiplos
    $button.prop('disabled', true);
  }

  /**
   * NOVA FUNÇÃO: Esconder loading para modo direto
   */
  function wcbHideDirectLoading() {
    const $button = $("#wcb-whatsapp-button");
    $button.removeClass('wcb-loading');
    
    // CORREÇÃO: Remover estilos inline que podem estar causando problemas
    $button.css({
      'width': '',
      'height': '',
      'position': '',
      'border-radius': '',
      'bottom': '',
      'right': '',
      'top': '',
      'left': ''
    });
    
    // Reabilitar o botão
    $button.prop('disabled', false);
  }

  /**
   * NOVA FUNÇÃO: Validar se formulário está configurado corretamente
   */
  function wcbValidateForm() {
    // Verificar se jQuery está disponível
    if (typeof $ === 'undefined') {
      console.warn('WCB: jQuery não está disponível');
      return true;
    }
    
    const $form = $('.wcb-form-container form');
    if ($form.length === 0) return true;
    
    const hasRequiredField = $form.find('input[name="wcb_whatsapp_form"]').length > 0;
    
    if (!hasRequiredField) {
      // Mostrar aviso para o usuário
      $form.before(
        '<div class="wcb-user-notice" style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 10px 0; border-radius: 4px;">' +
        '<strong>⚠️ Aviso:</strong> Este formulário não está configurado corretamente para o plugin WhatsApp. ' +
        'Entre em contato com o administrador do site.' +
        '</div>'
      );
      return false;
    }
    return true;
  }

  function wcbBindEvents() {
    // Verificar se jQuery está disponível
    if (typeof $ === 'undefined') {
      console.warn('WCB: jQuery não está disponível para bindEvents');
      return;
    }
    
    // NOVO: Validar formulário ao carregar
    wcbValidateForm();

    $(document).on(
      "click",
      ".wcb-modal-close, .wcb-modal-overlay",
      wcbCloseModal
    );

    $(document).on("keydown", function (e) {
      if (e.keyCode === 27) {
        wcbCloseModal();
      }
    });

    $(document).on("click", ".wcb-modal-content", function (e) {
      e.stopPropagation();
    });

    $(document).on("click", '[onclick="wcbOpenModal()"]', function (e) {
      e.preventDefault();
      wcbTrackEvent("click");
      wcbOpenModal();
    });

    $(document).on("click", ".wcb-open-modal", function (e) {
      e.preventDefault();
      wcbTrackEvent("click");
      wcbOpenModal();
    });
  }

  function wcbOpenModal() {
    // Verificar se jQuery está disponível
    if (typeof $ === 'undefined') {
      console.warn('WCB: jQuery não está disponível para openModal');
      return;
    }
    
    const $modal = $("#wcb-modal");

    if ($modal.length) {
      $modal.addClass("wcb-modal-open");
      $("body").addClass("wcb-modal-open");

      setTimeout(function () {
        wcbInitializeCF7InModal();
        wcbStartDuplicationObserver();
        
        // IMPORTANTE: Preencher campos novamente ao abrir modal
        wcbFillFieldsInModal();
        
        $modal.find('input[type="text"], input[type="email"]').first().focus();
      }, 300);
    }
  }

  /**
   * NOVA FUNÇÃO: Preencher campos especificamente no modal
   */
  function wcbFillFieldsInModal() {
    const pageData = wcbGetPageData();
    
    // Preencher os campos hidden no modal
    const $modal = $("#wcb-modal");
    $modal.find('input[name="wcb_page_title"]').val(pageData.title);
    $modal.find('input[name="wcb_page_url"]').val(pageData.url);
    $modal.find('input[name="wcb_page_slug"]').val(pageData.slug);
    
    // Também preencher por classe (fallback)
    $(".wcb-page-title").val(pageData.title);
    $(".wcb-page-url").val(pageData.url);
    $(".wcb-page-slug").val(pageData.slug);

    // console.log("WCB: Fields filled in modal:", {
    //   title: pageData.title,
    //   url: pageData.url,
    //   slug: pageData.slug,
    //   modal_title_field: $modal.find('input[name="wcb_page_title"]').val(),
    //   modal_url_field: $modal.find('input[name="wcb_page_url"]').val(),
    //   modal_slug_field: $modal.find('input[name="wcb_page_slug"]').val()
    // });
  }

  /**
   * Observer para detectar e remover duplicações automaticamente
   */
  function wcbStartDuplicationObserver() {
    if (window.wcbObserver) {
      window.wcbObserver.disconnect();
    }

    const targetNode = document.querySelector("#wcb-modal");
    if (!targetNode) return;

    const config = { childList: true, subtree: true };

    window.wcbObserver = new MutationObserver(function (mutationsList) {
      for (let mutation of mutationsList) {
        if (mutation.type === "childList") {
          mutation.addedNodes.forEach(function (node) {
            if (node.nodeType === Node.ELEMENT_NODE) {
              if (
                node.classList?.contains("wpcf7-spinner") ||
                node.classList?.contains("wpcf7-validation-errors") ||
                node.querySelector?.(".wpcf7-spinner, .wpcf7-validation-errors")
              ) {
                setTimeout(() => {
                  wcbRemoveAllDuplicates();
                }, 50);
              }
            }
          });
        }
      }
    });

    window.wcbObserver.observe(targetNode, config);
    // console.log("WCB: Duplication observer started");
  }

  function wcbCloseModal() {
    // Verificar se jQuery está disponível
    if (typeof $ === 'undefined') {
      console.warn('WCB: jQuery não está disponível para closeModal');
      return;
    }
    
    const $modal = $("#wcb-modal");

    if ($modal.length) {
      $modal.removeClass("wcb-modal-open");
      $("body").removeClass("wcb-modal-open");

      // Limpar estados de erro ao fechar
      wcbClearFormErrors();

      // Parar observer e limpar duplicações
      if (window.wcbObserver) {
        window.wcbObserver.disconnect();
      }
      wcbRemoveAllDuplicates();
    }
  }

  /**
   * Inicializar CF7 adequadamente no modal
   */
  function wcbInitializeCF7InModal() {
    const $modal = $("#wcb-modal");
    const $form = $modal.find(".wpcf7-form");

    if ($form.length) {
      // CORREÇÃO: Não re-inicializar CF7 - apenas configurar acceptance
      wcbEnsureAcceptanceBehavior($form);

      // Limpar qualquer duplicação existente antes de configurar
      wcbRemoveAllDuplicates();

      // console.log("WCB: Modal CF7 configured without re-initialization");
    }
  }

  /**
   * Remover TODAS as duplicações (SEM interferir na visibilidade do spinner)
   */
  function wcbRemoveAllDuplicates() {
    // CORREÇÃO: Não remover spinners - apenas verificar se há muitos
    const $spinners = $(".wpcf7-spinner");
    if ($spinners.length > 2) {
      // Só remover se houver mais de 2 (mantém os originais)
      $spinners.slice(2).remove();
      console.log("WCB: Removed excess spinners, kept 2");
    }

    // Remover mensagens de erro duplicadas
    const $errorMessages = $(".wpcf7-validation-errors");
    if ($errorMessages.length > 1) {
      $errorMessages.not(":first").remove();
    }

    // Remover loading customizado duplicado
    const $loadings = $("#wcb-loading, .wcb-loading");
    $loadings.not(":first").remove();

    // console.log(
    //   "WCB: Duplicates checked - Spinners:",
    //   $spinners.length,
    //   "Messages:",
    //   $errorMessages.length
    // );
  }

  /**
   * Garantir comportamento nativo de acceptance
   */
  function wcbEnsureAcceptanceBehavior($form) {
    const $acceptanceInputs = $form.find(
      '.wpcf7-acceptance input[type="checkbox"]'
    );
    const $submitButton = $form.find(
      'input[type="submit"], button[type="submit"]'
    );

    if ($acceptanceInputs.length && $submitButton.length) {
      // Função para verificar estado dos acceptance
      function updateSubmitButton() {
        let allAccepted = true;

        $acceptanceInputs.each(function () {
          if (!$(this).is(":checked")) {
            allAccepted = false;
            return false; // break
          }
        });

        // Habilitar/desabilitar botão conforme acceptance
        $submitButton.prop("disabled", !allAccepted);

        if (allAccepted) {
          $submitButton.removeClass("wcb-disabled-submit");
        } else {
          $submitButton.addClass("wcb-disabled-submit");
        }
      }

      // Verificar estado inicial
      updateSubmitButton();

      // Monitorar mudanças nos checkboxes
      $acceptanceInputs.on("change", updateSubmitButton);

      // Log para debug
      // console.log(
      //   "WCB: Acceptance behavior configured for",
      //   $acceptanceInputs.length,
      //   "checkboxes"
      // );
    }
  }

  /**
   * Configurar validação customizada
   */
  function wcbSetupFormValidation($form) {
    // Validação em tempo real apenas para feedback visual melhorado
    // Não interferir com validação nativa do CF7

    $form.find('input[type="email"]').on("blur", function () {
      const $field = $(this);
      if ($field.val() && !$field.hasClass("wpcf7-not-valid")) {
        // Só validar se CF7 não já marcou como inválido
        wcbValidateEmailField($field);
      }
    });

    // Remover nossas mensagens quando CF7 começar a validar
    $form.on("wpcf7submit", function () {
      wcbClearFormErrors();
    });
  }

  /**
   * Validar formulário (apenas campos obrigatórios - acceptance é nativo)
   */
  function wcbValidateFormFields($form) {
    let isValid = true;
    let firstErrorField = null;

    // Limpar erros anteriores
    wcbClearFormErrors();

    // Validar apenas campos obrigatórios (acceptance é tratado nativamente)
    $form
      .find("input[required], textarea[required], select[required]")
      .each(function () {
        const $field = $(this);
        if (!wcbValidateRequiredField($field)) {
          isValid = false;
          if (!firstErrorField) {
            firstErrorField = $field;
          }
        }
      });

    // Validar email se preenchido
    const $emailField = $form.find('input[type="email"]');
    if ($emailField.length && $emailField.val()) {
      if (!wcbValidateEmailField($emailField)) {
        isValid = false;
        if (!firstErrorField) {
          firstErrorField = $emailField;
        }
      }
    }

    // Focar no primeiro campo com erro
    if (!isValid && firstErrorField) {
      firstErrorField.focus();

      // Mostrar mensagem de erro geral
      wcbShowFormError(
        "Por favor, corrija os campos destacados antes de enviar."
      );
    }

    return isValid;
  }

  /**
   * Validar campo obrigatório
   */
  window.wcbValidateRequiredField = function ($field) {
    const value = $field.val().trim();
    const isValid = value.length > 0;

    if (!isValid) {
      wcbAddFieldError($field, "Este campo é obrigatório.");
    } else {
      wcbRemoveFieldError($field);
    }

    return isValid;
  };

  /**
   * Validar campo de email
   */
  window.wcbValidateEmailField = function ($field) {
    const email = $field.val().trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(email);

    if (!isValid) {
      wcbAddFieldError($field, "Por favor, insira um email válido.");
    } else {
      wcbRemoveFieldError($field);
    }

    return isValid;
  };

  /**
   * Adicionar erro visual ao campo
   */
  window.wcbAddFieldError = function ($field, message) {
    const $wrapper = $field.closest(
      ".wpcf7-form-control-wrap, .form-group, label"
    );

    // Remover erro anterior se existir
    $wrapper.find(".wcb-field-error").remove();

    // Adicionar classe de erro
    $field.addClass("wcb-field-error-input");

    // Adicionar mensagem de erro
    $wrapper.append(`<span class="wcb-field-error">${message}</span>`);
  };

  /**
   * Remover erro visual do campo
   */
  window.wcbRemoveFieldError = function ($field) {
    const $wrapper = $field.closest(
      ".wpcf7-form-control-wrap, .form-group, label"
    );

    $field.removeClass("wcb-field-error-input");
    $wrapper.find(".wcb-field-error").remove();
  };

  /**
   * Limpar todos os erros do formulário
   */
  window.wcbClearFormErrors = function () {
    const $modal = $("#wcb-modal");

    $modal.find(".wcb-field-error").remove();
    $modal.find(".wcb-field-error-input").removeClass("wcb-field-error-input");
    $modal.find(".wcb-form-error-message").remove();
  };

  /**
   * Mostrar erro geral do formulário
   */
  window.wcbShowFormError = function (message) {
    const $modal = $("#wcb-modal");
    const $formContainer = $modal.find(".wcb-form-container");

    // Remover mensagem anterior
    $formContainer.find(".wcb-form-error-message").remove();

    // Adicionar nova mensagem
    $formContainer.prepend(`
      <div class="wcb-form-error-message">
        <span class="wcb-error-icon">⚠️</span>
        ${message}
      </div>
    `);

    // Remover após 5 segundos
    setTimeout(() => {
      $formContainer.find(".wcb-form-error-message").fadeOut();
    }, 5000);
  };

  function wcbTrackEvent(eventType, contactId = null) {
    const pageData = wcbGetPageData();
    
    // CORREÇÃO: Usar dados do cache em vez de wcb_data.page_data
    // console.log("wcbTrackEvent chamada:", {
    //   eventType: eventType,
    //   pageData: pageData
    // });

    $.ajax({
      url: wcb_data.ajax_url,
      type: "POST",
      data: {
        action: "wcb_track_event",
        nonce: wcb_data.nonce,
        event_type: eventType,
        page_title: pageData.title,
        page_url: pageData.url,
        page_slug: pageData.slug,
        session_id: wcbSessionId,
        contact_id: contactId,
      },
    });
  }

  function wcbSetupCF7Integration() {
    // CORREÇÃO: Usar namespace único e limpar antes
    $(document).off(
      "wpcf7mailsent.wcb wpcf7invalid.wcb wpcf7submit.wcb wpcf7beforesubmit.wcb"
    );

    // Event ANTES do submit para limpar duplicações
    $(document).on("wpcf7beforesubmit.wcb", function (event) {
      const formElement = event.target;
      const isWhatsAppForm =
        $(formElement).find('input[name="wcb_whatsapp_form"]').length > 0;

      if (isWhatsAppForm) {
        // IMPORTANTE: Garantir que campos estão preenchidos antes do submit
        wcbFillFieldsInModal();
        
        // Limpar TUDO antes do CF7 processar
        wcbRemoveAllDuplicates();
        $("#wcb-loading").hide();
        $(".wcb-form-error-message").remove();
      }
    });

    // Event para formulário enviado com sucesso
    $(document).on("wpcf7mailsent.wcb", function (event) {
      if (wcbHasRedirected) return;
      wcbHasRedirected = true;

      const formElement = event.target;
      const isWhatsAppForm =
        $(formElement).find('input[name="wcb_whatsapp_form"]').length > 0;

      if (isWhatsAppForm) {
        // FORÇA: Limpar duplicações após sucesso
        wcbRemoveAllDuplicates();

        setTimeout(function () {
          $.ajax({
            url: wcb_data.ajax_url,
            type: "POST",
            data: {
              action: "wcb_process_cf7_submission",
              nonce: wcb_data.nonce,
            },
            success: function (response) {
              if (response.success && response.data.whatsapp_url) {
                wcbContactId = response.data.contact_id;
                wcbTrackEvent("redirect", wcbContactId);

                setTimeout(function () {
                  window.open(response.data.whatsapp_url, "_blank");
                  wcbCloseModal();
                }, 1000);
              } else {
                console.log(
                  "WCB Error:",
                  response.data.message || wcb_data.strings.error
                );
              }
            },
            error: function () {
              console.log("WCB Error:", wcb_data.strings.error);
            },
          });
        }, 1000);
      }
    });

    // Event para formulário com erro de validação
    $(document).on("wpcf7invalid.wcb", function (event) {
      const formElement = event.target;
      const isWhatsAppForm =
        $(formElement).find('input[name="wcb_whatsapp_form"]').length > 0;

      if (isWhatsAppForm) {
        // FORÇA: Limpar duplicações após erro
        setTimeout(() => {
          wcbRemoveAllDuplicates();

          const $errorFields = $(formElement).find(".wpcf7-not-valid");
          if ($errorFields.length > 0) {
            $errorFields.first().focus();
          }
        }, 100);
      }
    });

    // Event para tentativa de submit
    $(document).on("wpcf7submit.wcb", function (event) {
      const formElement = event.target;
      const isWhatsAppForm =
        $(formElement).find('input[name="wcb_whatsapp_form"]').length > 0;

      if (isWhatsAppForm) {
        // Limpar duplicações durante submit
        wcbRemoveAllDuplicates();
        wcbTrackEvent("submit");
      }
    });
  }

  function wcbShowLoading() {
    // REMOVIDO: Para evitar duplicação com CF7
    // O CF7 já tem seu próprio sistema de loading
    // console.log("WCB: Using CF7 native loading instead of custom");
  }

  function wcbHideLoading() {
    // FORÇA: Esconder qualquer elemento de loading
    const $loading = $("#wcb-loading");
    if ($loading.length) {
      $loading.removeClass("wcb-loading-show").hide();
    }
  }

  function wcbShowError(message) {
    // Usar a mensagem nativa do CF7 em vez da nossa para evitar duplicação
    console.log("WCB Error:", message);
  }

  function wcbFillHiddenFields() {
    // Preencher campos inicialmente (para casos fora do modal)
    const pageData = wcbGetPageData();
    
    $(".wcb-page-title").val(pageData.title);
    $(".wcb-page-url").val(pageData.url);
    $(".wcb-page-slug").val(pageData.slug);

    // console.log("WCB: Initial fields filled:", pageData);
  }

  function wcbGenerateSessionId() {
    return "wcb_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9);
  }

  function wcbInitAccessibility() {
    $("#wcb-whatsapp-button").attr({
      "aria-label": "Abrir chat do WhatsApp",
      role: "button",
      tabindex: "0",
    });

    $("#wcb-whatsapp-button").on("keydown", function (e) {
      if (e.keyCode === 13 || e.keyCode === 32) {
        e.preventDefault();
        $(this).click();
      }
    });

    $("#wcb-modal").attr({
      role: "dialog",
      "aria-modal": "true",
      "aria-labelledby": "wcb-modal-title",
    });

    $(".wcb-modal-header h3").attr("id", "wcb-modal-title");
  }

  // Expose to global
  window.wcbOpenModal = wcbOpenModal;
})(jQuery);