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
// Funcția pentru afișarea formularului de căutare
function lenani_dream_search_form() {
    ob_start(); // Start bufferizarea pentru a returna conținutul generat în loc să-l afișăm imediat
    ?>
    <form id="lenani-dream-search-form">
        <input type="text" name="search_term" placeholder="<?php _e('Introduceți termenul căutat...', 'lenani-dream'); ?>" />
        <input type="text" name="tags" placeholder="<?php _e('Etichete (tags)...', 'lenani-dream'); ?>" /> <!-- Adăugăm câmpul pentru etichete -->
        <div id="lenani-dream-search-results"></div>
    </form>
    <?php
    return ob_get_clean(); // Returnează conținutul generat
}
add_shortcode('lenani_dream_search', 'lenani_dream_search_form');

// Funcția pentru afișarea scripturilor JavaScript în frontend
function lenani_dream_enqueue_frontend_scripts() {
    // Încărcați scriptul jQuery (dacă nu este deja încărcat)
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }

    // Încărcați scriptul JavaScript personalizat pentru căutare
    wp_enqueue_script('lenani-dream-main', plugin_dir_url(__FILE__) . 'js/lenani-dream-main.js', array('jquery'), '1.0.0', true);

    // Localizarea textelor afișate în frontend pentru traducere
    wp_localize_script('lenani-dream-main', 'lenani_dream_ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'search_nonce' => wp_create_nonce('lenani_dream_search_nonce'), // Adăugați un nonce pentru securitate
    ));
}
add_action('wp_enqueue_scripts', 'lenani_dream_enqueue_frontend_scripts');
