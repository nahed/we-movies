export function initializeModal() {
    // Select all elements with the class 'btn'
    const testElements = document.getElementsByClassName('btn');

    // Loop through the collection and add an event listener to each element
    for (let i = 0; i < testElements.length; i++) {
        testElements[i].addEventListener('click', function(event) {
            event.preventDefault();

            // Get the modal and popupBody elements
            var modal = document.getElementById('myModal');
            var popupBody = document.getElementById('popupBody');
            const href = this.getAttribute('href'); // Get the href attribute from the clicked element

            // Fetch the content using AJAX
            fetch(href) // Use the dynamic href instead of a hardcoded URL
                .then(response => response.text())
                .then(data => {
                    popupBody.innerHTML = data; // Load the response into the modal
                    modal.style.display = "block"; // Show the modal
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    }
}

initializeModal();

export function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none"; // Hide the modal
}

// Set up event listener for the close button
document.querySelector('.close').onclick = closeModal;

// Set up event listener to close the modal when clicking outside of it
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target === modal) {
        closeModal(); // Hide the modal
    }
};






