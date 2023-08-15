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
// Funcția pentru înregistrarea custom post type
function lenani_dream_register_custom_post_type() {
    $labels = array(
        'name' => __('Interpretări Vise', 'lenani-dream'),
        'singular_name' => __('Interpretare Vis', 'lenani-dream'),
        'add_new' => __('Adaugă Interpretare', 'lenani-dream'),
        'add_new_item' => __('Adăugare Interpretare', 'lenani-dream'),
        'edit_item' => __('Editare Interpretare Vis', 'lenani-dream'),
        'new_item' => __('Nouă Interpretare Vis', 'lenani-dream'),
        'view_item' => __('Vizualizare Interpretare Vis', 'lenani-dream'),
        'search_items' => __('Căutare Interpretări Vise', 'lenani-dream'),
        'not_found' => __('Nicio interpretare găsită', 'lenani-dream'),
        'not_found_in_trash' => __('Nicio interpretare găsită în coșul de gunoi', 'lenani-dream')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => array('title', 'editor', 'thumbnail', 'dream_tag'), // Folosim "dream_tag" în loc de "tags"
    );

    register_post_type('dream_interpretation', $args);
}
add_action('init', 'lenani_dream_register_custom_post_type');



// Funcția pentru înregistrarea suportului pentru etichete
function lenani_dream_add_tags_support() {
    register_taxonomy_for_object_type('post_tag', 'dream_interpretation');
}
add_action('init', 'lenani_dream_add_tags_support');

