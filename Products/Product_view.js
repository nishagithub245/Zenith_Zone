
    function updateQuantity(action) {
        // Select the input element for quantity
        const input = document.querySelector('.quantity input[type="number"]');
        let currentValue = parseInt(input.value);

        // Check if the current value is a valid number
        if (isNaN(currentValue)) {
            currentValue = 1;
        }

        // Increment or decrement based on the action
        if (action === 'increment') {
            // Increment up to the max value
            if (currentValue < parseInt(input.max)) {
                currentValue += 1;
            }
        } else if (action === 'decrement') {
            // Decrement down to the min value
            if (currentValue > parseInt(input.min)) {
                currentValue -= 1;
            }
        }

        // Update the input's value
        input.value = currentValue;
    }

    function toggleImagePreview() {
        const imgElement = document.getElementById('bigImg');
        const isPreview = imgElement.classList.contains('preview-mode');

        if (isPreview) {
            // Exit preview mode
            imgElement.classList.remove('preview-mode');
            imgElement.style.position = '';
            imgElement.style.width = '300px';
            imgElement.style.height = '300px';
            imgElement.style.top = '';
            imgElement.style.left = '';
            imgElement.style.transform = '';
            imgElement.style.zIndex = '';
            imgElement.style.objectFit = 'cover';
            imgElement.style.backgroundColor = '';
            document.body.style.overflow = ''; // Restore body scroll
        } else {
            // Enter preview mode
            imgElement.classList.add('preview-mode');
            imgElement.style.position = 'fixed';
            imgElement.style.width = '80%';
            imgElement.style.height = '80%';
            imgElement.style.top = '50%';
            imgElement.style.left = '50%';
            imgElement.style.transform = 'translate(-50%, -50%)';
            imgElement.style.zIndex = '1000';
            imgElement.style.objectFit = 'contain';
            imgElement.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            document.body.style.overflow = 'hidden'; // Prevent body scroll in preview mode
        }
    }