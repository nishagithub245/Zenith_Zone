// <!-- JavaScript for toggling the visibility of the list -->

document.getElementById('toggleButton').addEventListener('click', function() {
    var biddersList = document.getElementById('biddersList');
    var button = document.getElementById('toggleButton');

    // Toggle the visibility of the bidders list
    if (biddersList.classList.contains('hidden')) {
        biddersList.classList.remove('hidden');
        button.textContent = 'Hide Bidder List'; // Change button text
    } else {
        biddersList.classList.add('hidden');
        button.textContent = 'Show Bidder List'; // Change button text back
    }
});

