document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const templateForm = document.getElementById('templateForm');
    const selectedTemplateInput = document.getElementById('selectedTemplate');
    const templateNameInput = document.getElementById('templateName');
    const templateContent = document.getElementById('templateContent');
    const previewBtn = document.getElementById('previewBtn');
    const availableVariablesEl = document.getElementById('availableVariables');
    const templateSelector = document.getElementById('templateSelector');
    let currentTemplate = null;
    let currentPlaceholders = [];

    // Initialize TinyMCE if it exists
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#templateContent',
            plugins: 'code link lists table',
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                      alignleft aligncenter alignright alignjustify | \
                      bullist numlist outdent indent | removeformat | code',
            height: 400,
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    }

    // Template selection change handler
    if (templateSelector) {
        templateSelector.addEventListener('change', function(e) {
            const selectedTemplateId = e.target.value;
            if (selectedTemplateId) {
                loadTemplate(selectedTemplateId);
            } else {
                resetTemplateForm();
            }
        });
    }

    // Load template data
    async function loadTemplate(templateId) {
        try {
            const response = await fetch(`/email-templates/preview`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ template: templateId })
            });

            if (!response.ok) {
                throw new Error('Failed to load template');
            }

            const data = await response.json();
            
            // Update form fields
            if (templateNameInput) {
                templateNameInput.value = data.templateName || '';
            }
            
            if (templateContent) {
                if (typeof tinymce !== 'undefined' && tinymce.get('templateContent')) {
                    tinymce.get('templateContent').setContent(data.content || '');
                } else {
                    templateContent.value = data.content || '';
                }
            }
            
            // Update placeholders
            updateAvailableVariables(data.placeholders || []);
            
            // Store current template
            currentTemplate = templateId;
            
        } catch (error) {
            console.error('Error loading template:', error);
            alert('Failed to load template. Please try again.');
        }
    }

    // Update available variables in the UI
    function updateAvailableVariables(placeholders) {
        currentPlaceholders = Array.isArray(placeholders) ? placeholders : [];
        const container = document.getElementById('availableVariables');
        
        if (!container) return;
        
        if (currentPlaceholders.length > 0) {
            const variablesHtml = currentPlaceholders.map(placeholder => {
                const placeholderValue = `{{${placeholder}}}`;
                return `
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2 mb-2 cursor-pointer hover:bg-blue-200" 
                          onclick="insertAtCaret('templateContent', '${placeholderValue.replace(/'/g, "\\'")}')">
                        {{${placeholder}}}
                    </span>`;
            }).join('');
            
            container.innerHTML = `
                <span class="text-xs font-medium text-gray-500">Click to insert:</span>
                ${variablesHtml}
            `;
        } else {
            container.innerHTML = '<span class="text-xs text-gray-500">No variables available for this template.</span>';
        }
    }

    // Reset template form
    function resetTemplateForm() {
        if (templateNameInput) templateNameInput.value = '';
        if (templateContent) {
            if (typeof tinymce !== 'undefined' && tinymce.get('templateContent')) {
                tinymce.get('templateContent').setContent('');
            } else {
                templateContent.value = '';
            }
        }
        updateAvailableVariables([]);
        currentTemplate = null;
    }

    // Global function to insert text at cursor position
    window.insertAtCaret = function(textAreaId, text) {
        const textarea = document.getElementById(textAreaId);
        if (!textarea) return;
        
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const value = textarea.value;
        
        textarea.value = value.substring(0, start) + text + value.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + text.length;
        textarea.focus();
        
        // Trigger input event for any listeners
        const event = new Event('input', { bubbles: true });
        textarea.dispatchEvent(event);
        
        // If using TinyMCE, update the editor
        if (typeof tinymce !== 'undefined' && tinymce.get(textAreaId)) {
            const editor = tinymce.get(textAreaId);
            editor.insertContent(text);
            editor.focus();
        }
    };

    // Preview button handler
    if (previewBtn) {
        previewBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!currentTemplate) {
                alert('Please select a template first');
                return;
            }
            
            // Get content based on whether TinyMCE is active
            let content = '';
            if (typeof tinymce !== 'undefined' && tinymce.get('templateContent')) {
                content = tinymce.get('templateContent').getContent();
            } else if (templateContent) {
                content = templateContent.value;
            }
            
            // Create a form and submit it to preview
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/email-templates/preview';
            form.target = '_blank';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            // Add template content
            const contentInput = document.createElement('input');
            contentInput.type = 'hidden';
            contentInput.name = 'content';
            contentInput.value = content;
            form.appendChild(contentInput);
            
            // Add template ID
            const templateInput = document.createElement('input');
            templateInput.type = 'hidden';
            templateInput.name = 'template';
            templateInput.value = currentTemplate;
            form.appendChild(templateInput);
            
            // Add form to document and submit
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        });
    }
});
