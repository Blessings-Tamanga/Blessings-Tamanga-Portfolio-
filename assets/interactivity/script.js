
        // Your existing JavaScript for mobile menu, animations, etc.
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });

        // Animate skill circles when they come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const circles = entry.target.querySelectorAll('.circle');
                    circles.forEach(circle => {
                        const progress = circle.getAttribute('data-progress');
                        circle.style.background = `conic-gradient(#4a6fa5 ${progress * 3.6}deg, #e9ecef 0deg)`;
                    });
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('#skills').forEach(section => {
            observer.observe(section);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

             // Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    // Project tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            console.log('Switching to tab:', tabId);
            
            // Remove active class from all buttons and contents
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            const targetTab = document.getElementById(tabId + '-tab');
            if (targetTab) {
                targetTab.classList.add('active');
            } else {
                console.error('Tab content not found:', tabId + '-tab');
            }
        });
    });

    // Debug: Log available tabs
    console.log('Available tabs:');
    tabContents.forEach(tab => {
        console.log('-', tab.id, 'has', tab.querySelectorAll('.project-card').length, 'projects');
    });
});

// Enhanced modal functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Modal not found:', modalId);
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Enhanced project modal
function openProjectModal(projectId) {
    console.log('Opening project modal for ID:', projectId);
    
    document.getElementById('projectModalTitle').textContent = 'Project Details';
    document.getElementById('projectModalContent').innerHTML = `
        <div class="modal-project-details">
            <div class="text-center mb-4">
                <i class="fas fa-code fa-3x text-primary mb-3"></i>
                <h4>Project ID: ${projectId}</h4>
                <p class="text-muted">Project details would be loaded here via AJAX</p>
            </div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                This would fetch detailed project information from the server including:
                <ul class="mt-2">
                    <li>Full description</li>
                    <li>Technologies used</li>
                    <li>Project timeline</li>
                    <li>Challenges and solutions</li>
                    <li>Screenshots and demos</li>
                </ul>
            </div>
        </div>
    `;
    showModal('projectModal');
}

// Enhanced business modal
function openBusinessModal(businessId) {
    console.log('Opening business modal for ID:', businessId);
    
    document.getElementById('businessModalTitle').textContent = 'Business Details';
    document.getElementById('businessModalContent').innerHTML = `
        <div class="modal-business-details">
            <div class="text-center mb-4">
                <i class="fas fa-building fa-3x text-primary mb-3"></i>
                <h4>Business ID: ${businessId}</h4>
                <p class="text-muted">Business details would be loaded here via AJAX</p>
            </div>
            <div class="business-info">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    This would fetch detailed business information including:
                    <ul class="mt-2">
                        <li>Full business description</li>
                        <li>Services and offerings</li>
                        <li>Contact information</li>
                        <li>Success stories</li>
                        <li>Testimonials</li>
                    </ul>
                </div>
            </div>
        </div>
    `;
    
    // Show learn more button
    const learnMoreBtn = document.getElementById('businessLearnMoreBtn');
    learnMoreBtn.href = '#business-' + businessId;
    learnMoreBtn.style.display = 'inline-block';
    
    showModal('businessModal');
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        hideModal(event.target.id);
    }
});


// Enhanced Theme Toggler Functionality
class ThemeManager {
  constructor() {
    this.themeToggle = document.getElementById('themeToggle');
    this.init();
  }

  init() {
    this.loadTheme();
    this.bindEvents();
  }

  loadTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    const theme = savedTheme === 'system' ? (prefersDark ? 'dark' : 'light') : savedTheme;
    
    this.setTheme(theme);
    this.updateTogglePosition(theme);
  }

  setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    
    const metaThemeColor = document.querySelector("meta[name=theme-color]");
    if (metaThemeColor) {
      metaThemeColor.setAttribute("content", theme === 'dark' ? '#1A1A2E' : '#4a6fa5');
    }
  }

  updateTogglePosition(theme) {
    if (this.themeToggle) {
      this.themeToggle.checked = theme === 'dark';
    }
  }

  bindEvents() {
    if (this.themeToggle) {
      this.themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
      });
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme === 'system') {
        this.setTheme(e.matches ? 'dark' : 'light');
      }
    });
  }
}

// Initialize theme manager
document.addEventListener('DOMContentLoaded', () => {
  new ThemeManager();
});