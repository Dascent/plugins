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

// Evităm accesul direct la fișierul plugin-ului
if (!defined('ABSPATH')) {
    exit;
}

// Încărcăm fișierele principale ale plugin-ului
require_once plugin_dir_path(__FILE__) . 'lenani-dream-custom-post-type.php';
require_once plugin_dir_path(__FILE__) . 'lenani-dream-ajax.php';
require_once plugin_dir_path(__FILE__) . 'lenani-dream-frontend-scripts.php';

// Acțiunea de configurare la activarea plugin-ului
function lenani_dream_activate_plugin() {
    // Implementați acțiunile de configurare aici, dacă este necesar
}
register_activation_hook(__FILE__, 'lenani_dream_activate_plugin');

// Încărcați fișierele JS și CSS necesare
function lenani_dream_enqueue_assets() {
    // Încărcați fișierele JS
    wp_enqueue_script('lenani-dream-main', plugin_dir_url(__FILE__) . 'js/lenani-dream-main.js', array('jquery'), '1.0.0', true);

    // Încărcați fișierele CSS
    wp_enqueue_style('lenani-dream-style', plugin_dir_url(__FILE__) . 'css/lenani-dream-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'lenani_dream_enqueue_assets');


// Încărcați fișierele JS și CSS pentru backend (opțional)
function lenani_dream_admin_enqueue_assets() {
    // Încărcați fișierele JS pentru backend (dacă aveți nevoie)
    wp_enqueue_script('lenani-dream-admin', plugin_dir_url(__FILE__) . 'js/lenani-dream-admin.js', array('jquery'), '1.0.0', true);

    // Încărcați fișierele CSS pentru backend (dacă aveți nevoie)
    wp_enqueue_style('lenani-dream-admin-style', plugin_dir_url(__FILE__) . 'css/lenani-dream-admin-style.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'lenani_dream_admin_enqueue_assets');

