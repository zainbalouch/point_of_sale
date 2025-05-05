<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add this script to handle the Enter key press
        document.addEventListener('keydown', function(event) {
            // Check if the key pressed was Enter
            if (event.key === 'Enter') {
                // Don't do this in textareas where Enter should create a new line
                if (event.target.tagName.toLowerCase() === 'textarea') {
                    return;
                }

                // Prevent the default action (form submission)
                event.preventDefault();

                // Find the next focusable element
                const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
                const focusable = Array.from(document.querySelectorAll(focusableElements))
                    .filter(element => !element.disabled && element.offsetParent !== null);

                const index = focusable.indexOf(document.activeElement);

                // Focus the next element if found, otherwise focus the first element
                if (index > -1 && index < focusable.length - 1) {
                    focusable[index + 1].focus();
                } else if (focusable.length > 0) {
                    focusable[0].focus();
                }
            }
        });
    });
</script>
