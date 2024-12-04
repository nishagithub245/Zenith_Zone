
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.getElementById('btn');
            const content = document.querySelector('.content');

            // Close sidebar if clicked outside of the sidebar
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 1023 && menuBtn.checked && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    menuBtn.checked = false; // Uncheck to close the sidebar
                }
            });

            // Prevent the click from closing the sidebar if clicked inside the sidebar
            sidebar.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent click from propagating to the document
            });

            // Add event listeners for dynamic content loading
            const buttons = document.querySelectorAll('.sidebar-button');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.dataset.action; // Get the action from the data-action attribute
                    loadContent(action); // Load content dynamically
                });
            });

            // Edit Profile Button Event Listener
            const editProfileButton = document.getElementById('editProfileButton');
            if (editProfileButton) {
                editProfileButton.addEventListener('click', function() {
                    loadContent('edit_profile'); // Trigger content load for edit_profile
                });
            }
        });
