jQuery(document).ready(function($) {
    // Înregistrăm evenimentul keyup pe câmpul de căutare
    $('#lenani-dream-search-form input[name="search_term"]').on('keyup', function() {
        var search_term = $(this).val().trim();

        // Verificăm dacă termenul de căutare nu este gol
        if (search_term !== '') {
            // Efectuăm cererea AJAX către server pentru căutarea instant
            $.ajax({
                url: lenani_dream_ajax_params.ajax_url,
                type: 'GET',
                dataType: 'json',
                data: {
                    action: 'lenani_dream_search',
                    search_term: search_term
                },
                success: function(response) {
                    // Gestionăm răspunsul de la server și afișăm rezultatele sugerate
                    if (response.success) {
                        var results = response.data;
                        var html = '';
                        if (results.length > 0) {
                            for (var i = 0; i < results.length; i++) {
                                html += '<div class="lenani-dream-search-result">';
                                html += '<div class="lenani-dream-thumbnail">';
                                html += '<img src="' + results[i].thumbnail + '" alt="' + results[i].title + '" />';
                                html += '</div>';
                                html += '<div class="lenani-dream-content">';
                                html += '<h3><a href="' + results[i].link + '">' + results[i].title + '</a></h3>';
                                html += '<div class="excerpt"><p>' + results[i].excerpt + '</p></div>';
                                html += '<div class="read-more"><a class="lenani-dream-read-more" href="' + results[i].link + '">Read More</a></div>';
                                html += '</div>';
                                html += '</div>';
                            }
                        } else {
                            // Afisam un mesaj daca nu exista rezultate
                            html += '<p>No results found.</p>';
                        }
                        $('#lenani-dream-search-results').html(html);
                    } else {
                        $('#lenani-dream-search-results').html('<p>Error: ' + response.data + '</p>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#lenani-dream-search-results').html('<p>Error: ' + error + '</p>');
                }
            });
        } else {
            // Dacă termenul de căutare este gol, nu efectuăm cererea AJAX și golim rezultatele
            $('#lenani-dream-search-results').html('');
        }
    });
});
