
        // Navigation between sections
        document.querySelectorAll('.menu-item').forEach(item => {
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
                const sectionId = this.getAttribute('href').substring(1);
                document.getElementById(sectionId).style.display = 'block';
            });
        });

        // Show dashboard by default
        document.getElementById('dashboard').style.display = 'block';

        // Modal functions
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function hideModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });

        // Auto-refresh online users count
function refreshOnlineUsers() {
    fetch('api/get_stats.php') // You'll need to create this API endpoint
        .then(response => response.json())
        .then(data => {
            if(data.online_users !== undefined) {
                document.querySelector('#dashboard .card-info h3').textContent = data.online_users;
            }
        })
        .catch(error => console.error('Error refreshing stats:', error));
}

// Refresh every 30 seconds
setInterval(refreshOnlineUsers, 30000);


        // Your existing JavaScript for mobile menu, animations, etc.
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });