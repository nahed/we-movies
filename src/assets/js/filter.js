import $ from 'jquery';
import { initializeModal, closeModal } from './modal';

$(document).ready(function() {
    initializeModal();
    // When any checkbox is clicked
    $('.genre-checkbox').on('change', function() {
        // Get all checked checkboxes
        var selectedGenres = [];
        $('.genre-checkbox:checked').each(function() {
            selectedGenres.push($(this).attr('id')); // Collect the checked genre IDs
        });

        // Convert array to a comma-separated string
        var genreString = selectedGenres.join(',');

        // Send the selected genres to the endpoint using AJAX
        $.ajax({
            url: '/movies/genre/filter', 
            type: 'GET',
            data: { genres: genreString }, // Send the genres as a parameter
            success: function(response) {
                // Load the response into the target div
                
                document.getElementById('movie-list').innerHTML = response;
                initializeModal();
            },
            error: function() {
                alert('Failed to load movies');
            }
        });
    });
});

