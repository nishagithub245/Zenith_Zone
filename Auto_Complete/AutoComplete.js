$(document).ready(function() {
    // Bind the keyup event on the search input field
    $('#searchInput, #searchInputMobile').keyup(function() {
        var query = $(this).val(); // Get the query from the input field
        
        // If the query is empty, hide the suggestions
        if (query.length > 0) {
            $.ajax({
                url: '../Auto_Complete/AutoComplete.php', // The PHP file that handles the database query
                type: 'GET',
                data: { term: query }, // Send the user input as the search term
                success: function(data) {
                    // Parse the response JSON data
                    let items = JSON.parse(data);
                    // Empty the suggestion list before appending new suggestions
                    $('#searchSuggestions, #searchSuggestionsMobile').empty();
                    // Append the suggestions to the suggestions box
                    $.each(items, function(i, item) {
                        $('#searchSuggestions, #searchSuggestionsMobile').append($('<li>').text(item));
                    });
                    // Show the suggestions box
                    $('#searchSuggestions, #searchSuggestionsMobile').show();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    $('#searchSuggestions, #searchSuggestionsMobile').hide(); // Hide suggestions on error
                }
            });
        } else {
            $('#searchSuggestions, #searchSuggestionsMobile').hide(); // Hide suggestions if query is empty
        }
    });

    // Handle click on suggestion item
    $(document).on("click", "#searchSuggestions li, #searchSuggestionsMobile li", function() {
        // Set the input field's value to the selected suggestion
        $(".input-field").val($(this).text());
        // Hide the suggestions box after selection
        $('#searchSuggestions, #searchSuggestionsMobile').hide();
    });
});
