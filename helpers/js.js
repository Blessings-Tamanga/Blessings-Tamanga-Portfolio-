
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing scripts');
    
    // Navigation between sections
    const menuItems = document.querySelectorAll('.menu-item');
    if (menuItems.length > 0) {
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all menu items
                document.querySelectorAll('.menu-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                // Add active class to clicked menu item
                this.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('section').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Show the selected section
                const sectionId = this.getAttribute('href')?.substring(1);
                if (sectionId && document.getElementById(sectionId)) {
                    document.getElementById(sectionId).style.display = 'block';
                }
            });
        });
    }

    // Show dashboard by default
    const dashboardSection = document.getElementById('dashboard');
    if (dashboardSection) {
        dashboardSection.style.display = 'block';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            hideModal(event.target.id);
        }
    });

    // Close modal when clicking close button
    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                hideModal(modal.id);
            }
        });
    });

    // Real-time preview updates
    const subjectInput = document.getElementById('reply_subject');
    const messageInput = document.getElementById('reply_message');
    
    if (subjectInput) {
        subjectInput.addEventListener('input', function() {
            const previewSubject = document.getElementById('preview_subject');
            if (previewSubject) {
                previewSubject.textContent = this.value;
            }
        });
    }
    
    // Add helpful default text when focusing on message
    if (messageInput) {
        messageInput.addEventListener('focus', function() {
            if (this.value === '') {
                const nameInput = document.getElementById('reply_to_name');
                if (nameInput && nameInput.value) {
                    this.value = `Dear ${nameInput.value},\n\nThank you for your message. I appreciate you reaching out to me through my portfolio website.\n\n`;
                }
            }
        });
    }

    // Cancel button functionality
    const cancelButtons = document.querySelectorAll('[onclick*="hideModal"]');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const onclick = this.getAttribute('onclick');
            if (onclick) {
                const match = onclick.match(/hideModal\('([^']+)'\)/);
                if (match && match[1]) {
                    hideModal(match[1]);
                }
            }
        });
    });
});

// Modal functions - defined globally so they can be called from onclick attributes
function showModal(modalId) {
    console.log('Showing modal:', modalId);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Modal not found:', modalId);
    }
}

function hideModal(modalId) {
    console.log('Hiding modal:', modalId);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Function to open reply modal with message details
function openReplyModal(message_id, name, email, subject) {
    console.log('Opening reply modal for:', email);
    
    try {
        // Set form values with null checks
        const messageIdInput = document.getElementById('reply_message_id');
        const emailInput = document.getElementById('reply_to_email');
        const nameInput = document.getElementById('reply_to_name');
        const subjectInput = document.getElementById('reply_subject');
        const previewEmail = document.getElementById('preview_to_email');
        const previewSubject = document.getElementById('preview_subject');
        const messageInput = document.getElementById('reply_message');
        
        if (messageIdInput) messageIdInput.value = message_id;
        if (emailInput) emailInput.value = email;
        if (nameInput) nameInput.value = name;
        if (subjectInput) subjectInput.value = 'Re: ' + subject;
        if (previewEmail) previewEmail.textContent = email;
        if (previewSubject) previewSubject.textContent = 'Re: ' + subject;
        
        // Set default message
        if (messageInput) {
            messageInput.value = `Dear ${name},\n\nThank you for your message. `;
        }
        
        // Hide messages modal and show reply modal
        hideModal('messagesModal');
        showModal('replyModal');
        
        // Focus on the message textarea
        setTimeout(() => {
            if (messageInput) {
                messageInput.focus();
            }
        }, 300);
        
    } catch (error) {
        console.error('Error in openReplyModal:', error);
        alert('Error opening reply modal. Check console for details.');
    }
}

// Simple test function to check if modals work
function testModals() {
    console.log('Testing modals...');
    console.log('Messages modal exists:', !!document.getElementById('messagesModal'));
    console.log('Reply modal exists:', !!document.getElementById('replyModal'));
    console.log('Reply form elements:');
    console.log('- reply_message_id:', !!document.getElementById('reply_message_id'));
    console.log('- reply_to_email:', !!document.getElementById('reply_to_email'));
    console.log('- reply_to_name:', !!document.getElementById('reply_to_name'));
    console.log('- reply_subject:', !!document.getElementById('reply_subject'));
    console.log('- reply_message:', !!document.getElementById('reply_message'));
}

// Run test on load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(testModals, 1000);
});



//


// Education Image Preview
document.addEventListener('DOMContentLoaded', function() {
    const educationImageInput = document.getElementById('educationImageInput');
    const educationPreview = document.getElementById('educationPreview');
    const educationImagePreview = document.getElementById('educationImagePreview');
    
    if (educationImageInput) {
        educationImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    educationPreview.src = e.target.result;
                    educationImagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Drag and drop functionality
    const uploadArea = document.querySelector('.file-upload-area');
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#4a6fa5';
            this.style.background = '#f0f4f8';
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ddd';
            this.style.background = '#f9f9f9';
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ddd';
            this.style.background = '#f9f9f9';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                educationImageInput.files = files;
                const event = new Event('change');
                educationImageInput.dispatchEvent(event);
            }
        });
    }
});

// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    // Project tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(tabId + '-tab').classList.add('active');
        });
    });
});

// Modal functions
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});

// Project modal (would be populated via AJAX in real implementation)
function openProjectModal(projectId) {
    // For now, show a simple modal
    document.getElementById('projectModalTitle').textContent = 'Project Details';
    document.getElementById('projectModalContent').innerHTML = `
        <div class="modal-project-details">
            <div class="text-center mb-4">
                <i class="fas fa-code fa-3x text-primary mb-3"></i>
                <h4>Project ID: ${projectId}</h4>
                <p class="text-muted">Project details would be loaded here</p>
            </div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                In a full implementation, this would fetch project details from the server.
            </div>
        </div>
    `;
    showModal('projectModal');
}

// Business modal (would be populated via AJAX in real implementation)
function openBusinessModal(businessId) {
    // For now, show a simple modal
    document.getElementById('businessModalTitle').textContent = 'Business Details';
    document.getElementById('businessModalContent').innerHTML = `
        <div class="modal-business-details">
            <div class="text-center mb-4">
                <i class="fas fa-building fa-3x text-primary mb-3"></i>
                <h4>Business ID: ${businessId}</h4>
                <p class="text-muted">Business details would be loaded here</p>
            </div>
            <div class="business-info">
                <p>This modal would show:</p>
                <ul>
                    <li>Full business description</li>
                    <li>Contact information</li>
                    <li>Services offered</li>
                    <li>Success stories</li>
                </ul>
            </div>
        </div>
    `;
    
    // Show learn more button
    const learnMoreBtn = document.getElementById('businessLearnMoreBtn');
    learnMoreBtn.href = 'https://example.com/business-' + businessId;
    learnMoreBtn.style.display = 'inline-block';
    
    showModal('businessModal');
}