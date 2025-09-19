/**
 * WhatsApp Contact Button - Admin JavaScript
 * Version: 1.0.0
 */

(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        wcbAdminInit();
    });
    
    /**
     * Initialize admin functionality
     */
    function wcbAdminInit() {
        wcbInitContactsTab();
        wcbInitSettingsTab();
        wcbInitAnalyticsTab();
        wcbInitFormMappings();
    }
    
    /**
     * Initialize contacts tab functionality
     */
    function wcbInitContactsTab() {
        // Select all checkbox
        $('#cb-select-all').on('change', function() {
            $('input[name="contact_ids[]"]').prop('checked', this.checked);
        });
        
        // Individual checkboxes
        $(document).on('change', 'input[name="contact_ids[]"]', function() {
            const totalCheckboxes = $('input[name="contact_ids[]"]').length;
            const checkedCheckboxes = $('input[name="contact_ids[]"]:checked').length;
            
            $('#cb-select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
        });
        
        // Status change
        $('.wcb-status-select').on('change', function() {
            const contactId = $(this).data('contact-id');
            const newStatus = $(this).val();
            
            wcbUpdateContactStatus(contactId, newStatus);
        });
        
        // View contact
        $(document).on('click', '.wcb-view-contact', function () {
        const contactId = $(this).data('contact-id');
        console.log('Clicou no contato ID:', contactId); // debug opcional
        wcbViewContact(contactId);
        });

        
        // Delete contact
        $('.wcb-delete-contact').on('click', function() {
            const contactId = $(this).data('contact-id');
            
            if (confirm(wcb_admin_data.strings.confirm_delete)) {
                wcbDeleteContact(contactId);
            }
        });
        
        // Export contacts
        $('#wcb-export-contacts').on('click', function() {
            wcbExportContacts();
        });
        
        // Bulk actions form
        $('#wcb-contacts-form').on('submit', function(e) {
            const action = $('select[name="action"]').val();
            const selectedContacts = $('input[name="contact_ids[]"]:checked');
            
            if (action === '-1') {
                e.preventDefault();
                alert(wcb_admin_data.strings.no_contacts_selected);
                return;
            }
            
            if (selectedContacts.length === 0) {
                e.preventDefault();
                alert(wcb_admin_data.strings.no_contacts_selected);
                return;
            }
            
            if (action === 'delete') {
                if (!confirm(wcb_admin_data.strings.confirm_delete_multiple)) {
                    e.preventDefault();
                    return;
                }
            }
        });
    }
    
    /**
     * Initialize settings tab functionality
     */
    function wcbInitSettingsTab() {
        // Working hours toggle
        $('input[name*="[enabled]"]').on('change', function() {
            const row = $(this).closest('tr');
            const timeInputs = row.find('input[type="time"]');
            
            if (this.checked) {
                timeInputs.prop('disabled', false);
            } else {
                timeInputs.prop('disabled', true);
            }
        });
        
        // Initialize working hours state
        $('input[name*="[enabled]"]').each(function() {
            $(this).trigger('change');
        });
        
        // Test notification
        $('#wcb-test-notification').on('click', function() {
            wcbTestNotification();
        });
    }
    
    /**
     * Initialize analytics tab functionality
     */
    function wcbInitAnalyticsTab() {
        // Date range change
        $('.wcb-analytics-filters input[type="date"]').on('change', function() {
            // Auto-submit form when date changes
            $(this).closest('form').submit();
        });
        
        // Load analytics charts
        wcbLoadAnalyticsCharts();
    }
    
    /**
     * Initialize form mappings functionality
     */
    function wcbInitFormMappings() {
        let mappingIndex = $('.wcb-form-mapping-row').length;
        
        // Add new mapping
        $('#wcb-add-mapping').on('click', function() {
            const template = $('#wcb-form-mapping-template').html();
            const newRow = template.replace(/INDEX/g, mappingIndex);
            
            $('#wcb-form-mappings-container').append(newRow);
            mappingIndex++;
        });
        
        // Remove mapping
        $(document).on('click', '.wcb-remove-mapping', function() {
            $(this).closest('.wcb-form-mapping-row').remove();
        });
    }
    
    /**
     * Update contact status
     */
    function wcbUpdateContactStatus(contactId, status) {
        $.ajax({
            url: wcb_admin_data.ajax_url,
            type: 'POST',
            data: {
                action: 'wcb_update_contact_status',
                nonce: wcb_admin_data.nonce,
                contact_id: contactId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    wcbShowMessage(response.data.message, 'success');
                } else {
                    wcbShowMessage(response.data.message, 'error');
                }
            },
            error: function() {
                wcbShowMessage(wcb_admin_data.strings.error_occurred, 'error');
            }
        });
    }
    
    /**
     * View contact details
     */
    function wcbViewContact(contactId) {
        // For now, just show a simple modal with contact ID
        // This can be enhanced to load full contact details via AJAX
        const modal = $('#wcb-contact-modal');
        const details = $('#wcb-contact-details');
        
        details.html('<p>Carregando detalhes do contato #' + contactId + '...</p>');
        modal.show();
        
        // Load contact details via AJAX (to be implemented)
        wcbLoadContactDetails(contactId);
    }
    
function wcbLoadContactDetails(contactId) {
    const details = $('#wcb-contact-details');
    details.html('<p>Carregando...</p>');

$.ajax({
    url: wcb_admin_data.ajax_url,
    type: 'POST',
    data: {
        action: 'wcb_get_contact_details',
        contact_id: contactId,
        nonce: wcb_admin_data.nonce
    },
    success: function (response) {
        if (response.success) {
            const data = response.data;
            let html = `
                <div class="wcb-contact-detail"><strong>ID:</strong> #${data.id}</div>
                <div class="wcb-contact-detail"><strong>Nome:</strong> ${data.name}</div>
                <div class="wcb-contact-detail"><strong>Email:</strong> ${data.email}</div>
                <div class="wcb-contact-detail"><strong>Telefone:</strong> ${data.phone}</div>
                <div class="wcb-contact-detail"><strong>Página:</strong> <a href="${data.page_url}" target="_blank">${data.page_title}</a></div>
                <div class="wcb-contact-detail"><strong>Slug:</strong> ${data.page_slug}</div>
                <div class="wcb-contact-detail"><strong>Dispositivo:</strong> ${data.device_type}</div>
                <div class="wcb-contact-detail"><strong>Data:</strong> ${data.submit_time}</div>
                <hr>
                <h4>Dados do formulário:</h4>
            `;

            if (data.form_data && typeof data.form_data === 'object') {
                for (const [key, value] of Object.entries(data.form_data)) {
                    html += `<div class="wcb-contact-detail"><strong>${key}:</strong> ${value}</div>`;
                }
            }

            $('#wcb-contact-details').html(html);
        } else {
            $('#wcb-contact-details').html('<div class="wcb-contact-detail error">Erro: ' + (response.data?.message || 'Erro ao carregar contato.') + '</div>');
        }
    },
    error: function () {
        $('#wcb-contact-details').html('<div class="wcb-contact-detail error">Erro ao comunicar com o servidor.</div>');
    }
});

}


    
    /**
     * Delete contact
     */
    function wcbDeleteContact(contactId) {
        $.ajax({
            url: wcb_admin_data.ajax_url,
            type: 'POST',
            data: {
                action: 'wcb_delete_contact',
                nonce: wcb_admin_data.nonce,
                contact_id: contactId
            },
            success: function(response) {
                if (response.success) {
                    // Remove row from table
                    $(`button[data-contact-id="${contactId}"]`).closest('tr').fadeOut(300, function() {
                        $(this).remove();
                    });
                    wcbShowMessage(response.data.message, 'success');
                } else {
                    wcbShowMessage(response.data.message, 'error');
                }
            },
            error: function() {
                wcbShowMessage(wcb_admin_data.strings.error_occurred, 'error');
            }
        });
    }
    
    /**
     * Export contacts
     */
    function wcbExportContacts() {
        const form = $('#wcb-contacts-form');
        const formData = form.serialize();
        
        // Get current filters
        const filters = {
            status: $('select[name="status"]').val(),
            page_slug: $('select[name="page_slug"]').val(),
            date_from: $('input[name="date_from"]').val(),
            date_to: $('input[name="date_to"]').val(),
            search: $('input[name="search"]').val()
        };
        
        $.ajax({
            url: wcb_admin_data.ajax_url,
            type: 'POST',
            data: {
                action: 'wcb_export_contacts',
                nonce: wcb_admin_data.nonce,
                ...filters
            },
            success: function(response) {
                if (response.success) {
                    // Create download link
                    const link = document.createElement('a');
                    link.href = response.data.download_url;
                    link.download = '';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    wcbShowMessage(response.data.message, 'success');
                } else {
                    wcbShowMessage(response.data.message, 'error');
                }
            },
            error: function() {
                wcbShowMessage(wcb_admin_data.strings.error_occurred, 'error');
            }
        });
    }
    
    /**
     * Test notification email
     */
    function wcbTestNotification() {
        $.ajax({
            url: wcb_admin_data.ajax_url,
            type: 'POST',
            data: {
                action: 'wcb_test_notification',
                nonce: wcb_admin_data.nonce
            },
            success: function(response) {
                if (response.success) {
                    wcbShowMessage(response.data.message, 'success');
                } else {
                    wcbShowMessage(response.data.message, 'error');
                }
            },
            error: function() {
                wcbShowMessage(wcb_admin_data.strings.error_occurred, 'error');
            }
        });
    }
    
    /**
     * Load analytics charts
     */
    function wcbLoadAnalyticsCharts() {
        // Charts are loaded via inline JavaScript in the PHP file
        // This function can be used for dynamic chart updates
    }
    
    /**
     * Show admin message
     */
    function wcbShowMessage(message, type) {
        const messageHtml = `
            <div class="notice notice-${type} is-dismissible">
                <p>${message}</p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        `;
        
        // Remove existing messages
        $('.notice.wcb-message').remove();
        
        // Add new message
        $('.wrap h1').after(messageHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('.notice.wcb-message').fadeOut();
        }, 5000);
    }
    
    /**
     * Modal functionality
     */
    $(document).on('click', '.wcb-modal-close, .wcb-modal-overlay', function() {
        $('.wcb-modal').hide();
    });
    
    $(document).on('click', '.wcb-modal-content', function(e) {
        e.stopPropagation();
    });
    
    /**
     * Responsive table handling
     */
    function wcbHandleResponsiveTables() {
        const tables = $('.wp-list-table');
        
        tables.each(function() {
            const table = $(this);
            const wrapper = table.parent();
            
            if (table.outerWidth() > wrapper.width()) {
                wrapper.css('overflow-x', 'auto');
            }
        });
    }
    
    // Handle responsive tables on window resize
    $(window).on('resize', wcbHandleResponsiveTables);
    wcbHandleResponsiveTables(); // Initial call
    
    /**
     * Form validation
     */
    function wcbValidateSettings() {
        let isValid = true;
        
        // Validate notification emails
        const emailsTextarea = $('textarea[name="wcb_notification_emails"]');
        if (emailsTextarea.length) {
            const emails = emailsTextarea.val().split('\n');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            emails.forEach(function(email) {
                email = email.trim();
                if (email && !emailRegex.test(email)) {
                    wcbShowMessage(`Email inválido: ${email}`, 'error');
                    isValid = false;
                }
            });
        }
        
        return isValid;
    }
    
    // Validate settings form on submit
    $('.wcb-settings-tab form').on('submit', function(e) {
        if (!wcbValidateSettings()) {
            e.preventDefault();
        }
    });
    
    /**
     * Auto-save functionality for quick settings
     */
    function wcbAutoSave(setting, value) {
        $.ajax({
            url: wcb_admin_data.ajax_url,
            type: 'POST',
            data: {
                action: 'wcb_auto_save_setting',
                nonce: wcb_admin_data.nonce,
                setting: setting,
                value: value
            },
            success: function(response) {
                if (response.success) {
                    // Show subtle success indicator
                    wcbShowSaveIndicator(true);
                } else {
                    wcbShowSaveIndicator(false);
                }
            }
        });
    }
    
    /**
     * Show save indicator
     */
    function wcbShowSaveIndicator(success) {
        const indicator = success ? '✓ Salvo' : '✗ Erro';
        const color = success ? '#46b450' : '#dc3232';
        
        const $indicator = $('<span class="wcb-save-indicator">')
            .text(indicator)
            .css({
                color: color,
                marginLeft: '10px',
                fontSize: '12px'
            });
        
        // Remove existing indicators
        $('.wcb-save-indicator').remove();
        
        // Add indicator
        $('.wcb-settings-tab .button-primary').after($indicator);
        
        // Fade out after 2 seconds
        setTimeout(function() {
            $indicator.fadeOut();
        }, 2000);
    }
    
    /**
     * Keyboard shortcuts
     */
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + S to save settings
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
            e.preventDefault();
            $('.wcb-settings-tab form .button-primary').click();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.wcb-modal').hide();
        }
    });
    
    /**
     * Tooltips for help text
     */
    function wcbInitTooltips() {
        $('[data-tooltip]').each(function() {
            const $element = $(this);
            const tooltipText = $element.data('tooltip');
            
            $element.on('mouseenter', function() {
                const $tooltip = $('<div class="wcb-tooltip">')
                    .text(tooltipText)
                    .css({
                        position: 'absolute',
                        background: '#333',
                        color: '#fff',
                        padding: '5px 10px',
                        borderRadius: '4px',
                        fontSize: '12px',
                        zIndex: 9999,
                        whiteSpace: 'nowrap'
                    });
                
                $('body').append($tooltip);
                
                const offset = $element.offset();
                $tooltip.css({
                    top: offset.top - $tooltip.outerHeight() - 5,
                    left: offset.left + ($element.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
                });
            });
            
            $element.on('mouseleave', function() {
                $('.wcb-tooltip').remove();
            });
        });
    }
    
    // Initialize tooltips
    wcbInitTooltips();
    
})(jQuery);

