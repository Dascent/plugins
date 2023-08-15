<?php
/**
 * Plugin Name: Lenani Dream Interpretation
 * Plugin URI: https://dascent.github.io/plugins/lenani-dream
 * Description: A plugin for dream interpretation.
 * Version: 1.0.0
 * Author: Dascent
 * Author URI: https://lenani.ro
 * Text Domain: lenani-dream
 * Domain Path: /languages
 */
// Funcția pentru adăugarea rutinei AJAX
function lenani_dream_add_ajax_handler() {
    add_action('wp_ajax_lenani_dream_search', 'lenani_dream_ajax_search');
    add_action('wp_ajax_nopriv_lenani_dream_search', 'lenani_dream_ajax_search');
}
add_action('wp_loaded', 'lenani_dream_add_ajax_handler');

// Funcția pentru căutarea instant folosind AJAX
function lenani_dream_ajax_search() {
    // Verificăm dacă este setat parametrul de căutare sau etichetele (tags)
    if (isset($_GET['search_term']) || isset($_GET['tags'])) {
        $search_term = isset($_GET['search_term']) ? sanitize_text_field($_GET['search_term']) : '';
        $tags = isset($_GET['tags']) ? sanitize_text_field($_GET['tags']) : '';

        // Efectuați căutarea în custom post type "dream_interpretation"
        $args = array(
            'post_type' => 'dream_interpretation',
            's' => $search_term,
            'tag' => $tags,
            'posts_per_page' => 5 // Numărul maxim de rezultate afișate
        );

        $query = new WP_Query($args);

        $results = array();
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); // Obțineți URL-ul thumbnail-ului
            $results[] = array(
                'title' => get_the_title(),
                'link' => get_permalink(),
                'content' => get_the_excerpt(),
                'thumbnail' => $thumbnail // Adăugați URL-ul thumbnail-ului în rezultate
            );
        }

        wp_send_json_success($results);
    } else {
        wp_send_json_error('Invalid search term or tags.');
    }

    // Încheiem execuția și ieșim din script
    wp_die();
}
