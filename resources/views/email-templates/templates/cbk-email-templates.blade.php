<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBK Email Templates</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        
        .template-selector {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .template-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .template-btn {
            padding: 10px 20px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .template-btn:hover {
            background: #1e3a8a;
        }
        
        .template-btn.active {
            background: #dc2626;
        }
        
        .email-template {
            display: none;
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .email-template.active {
            display: block;
        }
        
        /* Header Styles */
        .email-header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        
        .logo {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        
        .tagline {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* Content Styles */
        .email-content {
            padding: 40px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1e40af;
        }
        
        .message-body {
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .highlight-box {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .cta-button {
            display: inline-block;
            background: #dc2626;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            transition: background 0.3s;
        }
        
        .cta-button:hover {
            background: #b91c1c;
        }
        
        .account-details {
            background: #f9fafb;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #059669;
            text-align: center;
            margin: 20px 0;
        }
        
        /* Footer Styles */
        .email-footer {
            background: #374151;
            color: #d1d5db;
            padding: 30px 40px;
            text-align: center;
            font-size: 14px;
        }
        
        .footer-content {
            margin-bottom: 20px;
        }
        
        .contact-info {
            margin: 15px 0;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            color: #9ca3af;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .disclaimer {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #4b5563;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .email-header, .email-content, .email-footer {
                padding: 20px;
            }
            
            .template-buttons {
                flex-direction: column;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }

        /* Template Editor Styles */
        .template-editor {
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .template-variables {
            margin: 20px 0;
            padding: 15px;
            background: #f8fafc;
            border-radius: 5px;
        }

        .variable-badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            padding: 3px 8px;
            border-radius: 4px;
            margin: 3px;
            font-size: 12px;
            cursor: pointer;
        }

        .variable-badge:hover {
            background: #bae6fd;
        }

        .code-editor {
            width: 100%;
            min-height: 300px;
            font-family: 'Courier New', monospace;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="template-selector">
        <h1>CBK Professional Email Templates</h1>
        <div class="template-buttons">
            <button type="button" class="template-btn active" data-template="welcome">Welcome Email</button>
            <button type="button" class="template-btn" data-template="statement">Account Statement</button>
            <button type="button" class="template-btn" data-template="transaction">Transaction Alert</button>
            <button type="button" class="template-btn" data-template="loan">Loan Approval</button>
            <button type="button" class="template-btn" data-template="security">Security Notice</button>
        </div>
    </div>

    <!-- Template 1: Welcome Email -->
    <div class="email-template active" id="welcome-template">
        <div class="email-header">
            <div class="logo">CBK</div>
            <div class="tagline">Commercial Bank of Kenya</div>
        </div>
        
        <div class="email-content">
            <div class="greeting">Welcome to CBK, {{ $customer_name ?? 'Valued Customer' }}!</div>
            
            <div class="message-body">
                <p>We are delighted to welcome you to the Commercial Bank of Kenya family. Your account has been successfully created and is ready for use.</p>
                
                <div class="highlight-box">
                    <strong>Your Account Details:</strong><br>
                    Account Number: <strong>{{ $account_number ?? '****-****-1234' }}</strong><br>
                    Account Type: <strong>{{ $account_type ?? 'Savings Account' }}</strong>
                </div>
                
                <p>To get started, please activate your account by clicking the button below:</p>
                
                <a href="{{ $activation_link ?? '#' }}" class="cta-button">Activate Account</a>
                
                <p>Our team is here to support you every step of the way. For any assistance, please don't hesitate to contact us.</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-content">
                <div class="contact-info">
                    <strong>Commercial Bank of Kenya</strong><br>
                    Customer Service: +254 (0) 20 3276100<br>
                    Email: customercare@cbk.co.ke
                </div>
                
                <div class="social-links">
                    <a href="#">Facebook</a> |
                    <a href="#">Twitter</a> |
                    <a href="#">LinkedIn</a> |
                    <a href="#">Instagram</a>
                </div>
            </div>
            
            <div class="disclaimer">
                This email is confidential and may contain legally privileged information. If you are not the intended recipient, please notify us immediately and delete this email. CBK is regulated by the Central Bank of Kenya.
            </div>
        </div>
    </div>

    <!-- Template 2: Account Statement -->
    <div class="email-template" id="statement-template">
        <div class="email-header">
            <div class="logo">CBK</div>
            <div class="tagline">Commercial Bank of Kenya</div>
        </div>
        
        <div class="email-content">
            <div class="greeting">Your Monthly Statement is Ready</div>
            
            <div class="message-body">
                <p>Dear {{ $customer_name ?? 'Valued Customer' }},</p>
                
                <p>Your account statement for {{ $statement_period ?? 'January 2025' }} is now available for download.</p>
                
                <div class="account-details">
                    <div class="detail-row">
                        <span>Account Number:</span>
                        <span><strong>{{ $account_number ?? '****-****-1234' }}</strong></span>
                    </div>
                    <div class="detail-row">
                        <span>Statement Period:</span>
                        <span>{{ $statement_period ?? '01/01/2025 - 31/01/2025' }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Opening Balance:</span>
                        <span>KSH {{ number_format($opening_balance ?? 50000, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Closing Balance:</span>
                        <span><strong>KSH {{ number_format($closing_balance ?? 75000, 2) }}</strong></span>
                    </div>
                </div>
                
                <a href="{{ $statement_link ?? '#' }}" class="cta-button">Download Statement</a>
                
                <p>For any queries regarding your statement, please contact our customer service team.</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-content">
                <div class="contact-info">
                    <strong>Commercial Bank of Kenya</strong><br>
                    Customer Service: +254 (0) 20 3276100<br>
                    Email: customercare@cbk.co.ke
                </div>
                
                <div class="social-links">
                    <a href="#">Facebook</a> |
                    <a href="#">Twitter</a> |
                    <a href="#">LinkedIn</a> |
                    <a href="#">Instagram</a>
                </div>
            </div>
            
            <div class="disclaimer">
                This email is confidential and may contain legally privileged information. If you are not the intended recipient, please notify us immediately and delete this email. CBK is regulated by the Central Bank of Kenya.
            </div>
        </div>
    </div>

    <!-- Template 3: Transaction Alert -->
    <div class="email-template" id="transaction-template">
        <div class="email-header">
            <div class="logo">CBK</div>
            <div class="tagline">Commercial Bank of Kenya</div>
        </div>
        
        <div class="email-content">
            <div class="greeting">Transaction Alert</div>
            
            <div class="message-body">
                <p>Dear {{ $customer_name ?? 'Valued Customer' }},</p>
                
                <p>This is to notify you of a recent transaction on your account:</p>
                
                <div class="highlight-box">
                    <div class="amount">{{ $transaction_type ?? 'Credit' }}: KSH {{ number_format($amount ?? 25000, 2) }}</div>
                </div>
                
                <div class="account-details">
                    <div class="detail-row">
                        <span>Transaction Date:</span>
                        <span>{{ $transaction_date ?? now()->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Transaction Type:</span>
                        <span>{{ $transaction_type ?? 'Online Transfer' }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Reference Number:</span>
                        <span>{{ $reference_number ?? 'CBK'.rand(100000, 999999) }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Available Balance:</span>
                        <span><strong>KSH {{ number_format($available_balance ?? 125000, 2) }}</strong></span>
                    </div>
                </div>
                
                <p><strong>Note:</strong> If you did not authorize this transaction, please contact us immediately using the details below.</p>
                
                <a href="{{ $dispute_link ?? '#' }}" class="cta-button">Report Unauthorized Transaction</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-content">
                <div class="contact-info">
                    <strong>Commercial Bank of Kenya</strong><br>
                    24/7 Fraud Hotline: +254 (0) 700 222 444<br>
                    Customer Service: +254 (0) 20 3276100<br>
                    Email: customercare@cbk.co.ke
                </div>
                
                <div class="social-links">
                    <a href="#">Facebook</a> |
                    <a href="#">Twitter</a> |
                    <a href="#">LinkedIn</a> |
                    <a href="#">Instagram</a>
                </div>
            </div>
            
            <div class="disclaimer">
                This is an automated security alert. Do not reply to this email. For security concerns, contact us through official channels only. CBK is regulated by the Central Bank of Kenya.
            </div>
        </div>
    </div>

    <!-- Template 4: Loan Approval -->
    <div class="email-template" id="loan-template">
        <div class="email-header">
            <div class="logo">CBK</div>
            <div class="tagline">Commercial Bank of Kenya</div>
        </div>
        
        <div class="email-content">
            <div class="greeting">🎉 Congratulations! Your Loan Has Been Approved</div>
            
            <div class="message-body">
                <p>Dear {{ $customer_name ?? 'Valued Customer' }},</p>
                
                <p>We are pleased to inform you that your loan application has been approved. Below are the details of your approved loan:</p>
                
                <div class="highlight-box">
                    <div class="amount">Approved Amount: KSH {{ number_format($loan_amount ?? 500000, 2) }}</div>
                </div>
                
                <div class="account-details">
                    <div class="detail-row">
                        <span>Loan Type:</span>
                        <span>{{ $loan_type ?? 'Personal Loan' }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Interest Rate:</span>
                        <span>{{ $interest_rate ?? '12%' }} per annum</span>
                    </div>
                    <div class="detail-row">
                        <span>Loan Term:</span>
                        <span>{{ $loan_term ?? '36' }} months</span>
                    </div>
                    <div class="detail-row">
                        <span>Monthly Repayment:</span>
                        <span><strong>KSH {{ number_format($monthly_payment ?? 16597, 2) }}</strong></span>
                    </div>
                    <div class="detail-row">
                        <span>Loan Reference:</span>
                        <span>{{ $loan_reference ?? 'LN'.date('Y').rand(10000, 99999) }}</span>
                    </div>
                </div>
                
                <p>To proceed with the loan disbursement, please visit your nearest CBK branch with the required documentation or accept the terms through our online banking platform.</p>
                
                <a href="{{ $accept_loan_link ?? '#' }}" class="cta-button">Accept Loan Terms</a>
                
                <p>We look forward to serving your financial needs. Thank you for choosing CBK.</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-content">
                <div class="contact-info">
                    <strong>Commercial Bank of Kenya</strong><br>
                    Loan Department: +254 (0) 20 3276150<br>
                    Customer Service: +254 (0) 20 3276100<br>
                    Email: loans@cbk.co.ke
                </div>
                
                <div class="social-links">
                    <a href="#">Facebook</a> |
                    <a href="#">Twitter</a> |
                    <a href="#">LinkedIn</a> |
                    <a href="#">Instagram</a>
                </div>
            </div>
            
            <div class="disclaimer">
                This email is confidential and may contain legally privileged information. Terms and conditions apply. CBK is regulated by the Central Bank of Kenya.
            </div>
        </div>
    </div>

    <!-- Template 5: Security Notice -->
    <div class="email-template" id="security-template">
        <div class="email-header">
            <div class="logo">CBK</div>
            <div class="tagline">Commercial Bank of Kenya</div>
        </div>
        
        <div class="email-content">
            <div class="greeting">Important Security Notice</div>
            
            <div class="message-body">
                <p>Dear {{ $customer_name ?? 'Valued Customer' }},</p>
                
                <p>We have detected {{ $security_event ?? 'unusual activity' }} on your account and wanted to ensure your account security.</p>
                
                <div class="highlight-box" style="border-left-color: #dc2626; background: #fef2f2;">
                    <strong>Security Alert Details:</strong><br>
                    Event: {{ $security_event ?? 'Multiple login attempts' }}<br>
                    Date & Time: {{ $event_time ?? now()->format('d M Y, H:i') }}<br>
                    Location: {{ $location ?? 'Nairobi, Kenya' }}<br>
                    IP Address: {{ $ip_address ?? '41.***.***.***' }}
                </div>
                
                <p><strong>What you should do:</strong></p>
                <ul>
                    <li>If this was you, no further action is required</li>
                    <li>If this wasn't you, please change your password immediately</li>
                    <li>Review your recent account activity</li>
                    <li>Enable two-factor authentication if not already active</li>
                </ul>
                
                <a href="{{ $secure_account_link ?? '#' }}" class="cta-button" style="background: #dc2626;">Secure My Account</a>
                
                <p><strong>Remember:</strong> CBK will never ask for your login credentials, PIN, or personal information via email or phone calls.</p>
                
                <div class="highlight-box">
                    <strong>Need Help?</strong><br>
                    If you suspect unauthorized access to your account, please contact our 24/7 security hotline immediately at <strong>+254 (0) 700 CBK HELP</strong>
                </div>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-content">
                <div class="contact-info">
                    <strong>Commercial Bank of Kenya</strong><br>
                    24/7 Security Hotline: +254 (0) 700 CBK HELP<br>
                    Customer Service: +254 (0) 20 3276100<br>
                    Email: security@cbk.co.ke
                </div>
                
                <div class="social-links">
                    <a href="#">Facebook</a> |
                    <a href="#">Twitter</a> |
                    <a href="#">LinkedIn</a> |
                    <a href="#">Instagram</a>
                </div>
            </div>
            
            <div class="disclaimer">
                This is an automated security alert. Do not reply to this email. For security concerns, contact us through official channels only. CBK is regulated by the Central Bank of Kenya.
            </div>
        </div>
    </div>

    <!-- Template Editor -->
    <div class="template-editor">
        <h2>Template Editor</h2>
        
        <div class="template-variables">
            <h3>Available Variables</h3>
            <div id="variableList">
                <!-- Variables will be populated by JavaScript -->
            </div>
        </div>
        
        <div class="form-group">
            <label for="templateName">Template Name</label>
            <input type="text" id="templateName" class="form-control" placeholder="Enter template name">
        </div>
        
        <div class="form-group">
            <label for="templateSubject">Email Subject</label>
            <input type="text" id="templateSubject" class="form-control" placeholder="Enter email subject">
        </div>
        
        <div class="form-group">
            <label for="templateContent">Email Content (HTML)</label>
            <textarea id="templateContent" class="code-editor" placeholder="Email content in HTML format"></textarea>
        </div>
        
        <div class="form-group">
            <button type="button" id="saveTemplate" class="btn btn-primary">Save Template</button>
            <button type="button" id="previewTemplate" class="btn btn-secondary">Preview</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const templateButtons = document.querySelectorAll('.template-btn');
            const templates = document.querySelectorAll('.email-template');
            const templateContent = document.getElementById('templateContent');
            const templateName = document.getElementById('templateName');
            const templateSubject = document.getElementById('templateSubject');
            const variableList = document.getElementById('variableList');
            
            // Template variables mapping
            const templateVariables = {
                'welcome': ['customer_name', 'account_number', 'account_type', 'activation_link'],
                'statement': ['customer_name', 'account_number', 'statement_period', 'opening_balance', 'closing_balance', 'statement_link'],
                'transaction': ['customer_name', 'transaction_type', 'amount', 'transaction_date', 'reference_number', 'available_balance', 'dispute_link'],
                'loan': ['customer_name', 'loan_amount', 'loan_type', 'interest_rate', 'loan_term', 'monthly_payment', 'loan_reference', 'accept_loan_link'],
                'security': ['customer_name', 'security_event', 'event_time', 'location', 'ip_address', 'secure_account_link']
            };
            
            // Human-readable variable names
            const variableLabels = {
                'customer_name': 'Customer Name',
                'account_number': 'Account Number',
                'account_type': 'Account Type',
                'activation_link': 'Activation Link',
                'statement_period': 'Statement Period',
                'opening_balance': 'Opening Balance',
                'closing_balance': 'Closing Balance',
                'statement_link': 'Statement Link',
                'transaction_type': 'Transaction Type',
                'amount': 'Amount',
                'transaction_date': 'Transaction Date',
                'reference_number': 'Reference Number',
                'available_balance': 'Available Balance',
                'dispute_link': 'Dispute Link',
                'loan_amount': 'Loan Amount',
                'loan_type': 'Loan Type',
                'interest_rate': 'Interest Rate',
                'loan_term': 'Loan Term',
                'monthly_payment': 'Monthly Payment',
                'loan_reference': 'Loan Reference',
                'accept_loan_link': 'Accept Loan Link',
                'security_event': 'Security Event',
                'event_time': 'Event Time',
                'location': 'Location',
                'ip_address': 'IP Address',
                'secure_account_link': 'Secure Account Link'
            };
            
            // Show template function
            function showTemplate(templateId) {
                // Hide all templates
                templates.forEach(template => template.classList.remove('active'));
                
                // Show selected template
                const selectedTemplate = document.getElementById(`${templateId}-template`);
                if (selectedTemplate) {
                    selectedTemplate.classList.add('active');
                    
                    // Update the editor with the selected template's HTML
                    const templateHtml = selectedTemplate.outerHTML;
                    templateContent.value = templateHtml;
                    
                    // Update template name and subject
                    const templateTitle = document.querySelector(`.template-btn[data-template="${templateId}"]`).textContent.trim();
                    templateName.value = templateTitle;
                    templateSubject.value = templateTitle;
                    
                    // Update available variables
                    updateVariables(templateId);
                }
            }
            
            // Update variables list
            function updateVariables(templateId) {
                const variables = templateVariables[templateId] || [];
                let html = '';
                
                variables.forEach(varName => {
                    const label = variableLabels[varName] || varName;
                    html += `<span class="variable-badge" data-var="${varName}">${label}</span>`;
                });
                
                variableList.innerHTML = html || '<p>No variables available for this template.</p>';
                
                // Add click event to variable badges
                document.querySelectorAll('.variable-badge').forEach(badge => {
                    badge.addEventListener('click', function() {
                        const varName = this.getAttribute('data-var');
                        insertVariable(varName);
                    });
                });
            }
            
            // Insert variable at cursor position
            function insertVariable(varName) {
                const textarea = templateContent;
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value;
                const before = text.substring(0, start);
                const after = text.substring(end, text.length);
                
                textarea.value = before + '{{ $' + varName + ' }}' + after;
                
                // Set cursor position after the inserted variable
                const newCursorPos = start + ('{{ $' + varName + ' }}').length;
                textarea.setSelectionRange(newCursorPos, newCursorPos);
                
                // Focus back on the textarea
                textarea.focus();
            }
            
            // Add event listeners to template buttons
            templateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    templateButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Show the selected template
                    const templateId = this.getAttribute('data-template');
                    showTemplate(templateId);
                });
            });
            
            // Save template handler
            document.getElementById('saveTemplate').addEventListener('click', function() {
                const name = templateName.value.trim();
                const subject = templateSubject.value.trim();
                const content = templateContent.value.trim();
                
                if (!name) {
                    alert('Please enter a template name');
                    return;
                }
                
                if (!content) {
                    alert('Please enter template content');
                    return;
                }
                
                // Here you would typically send this data to your server
                console.log('Saving template:', { name, subject, content });
                
                // Show success message
                alert('Template saved successfully!');
            });
            
            // Preview template handler
            document.getElementById('previewTemplate').addEventListener('click', function() {
                const content = templateContent.value.trim();
                if (!content) {
                    alert('No content to preview');
                    return;
                }
                
                // Open preview in new window
                const previewWindow = window.open('', '_blank');
                previewWindow.document.write(content);
                previewWindow.document.close();
            });
            
            // Initialize with the first template
            if (templateButtons.length > 0) {
                showTemplate(templateButtons[0].getAttribute('data-template'));
            }
        });
    </script>
</body>
</html>
