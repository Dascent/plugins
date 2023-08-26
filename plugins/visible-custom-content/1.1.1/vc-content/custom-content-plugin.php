<?php
/**
 * Plugin Name: Visibility Custom Content 
 * Plugin URI: https://dascent.github.io/plugins/
 * Description: A simple plugin to show different content to registered and non-registered users using shortcodes.
 * Version: v1.1.1
 * Author: Dascent
 * Author URI: https://cssmfc.github.io/dan/
 * Text Domain: custom-content
 * Domain Path: /languages/
 **/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load plugin text domain for translation
function custom_content_load_textdomain() {
    load_plugin_textdomain('custom-content', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'custom_content_load_textdomain');

// Load plugin JS
function custom_content_load_admin_scripts($hook) {
    if ($hook == 'toplevel_page_custom-content-description') {
        wp_enqueue_script('custom-content-admin-script', plugin_dir_url(__FILE__) . 'js/vcs-content-admin.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'custom_content_load_admin_scripts');



// v1.1.1
function custom_content_block_enqueue_assets() {
  wp_enqueue_script(
    'custom-content-block',
    plugin_dir_url(__FILE__) . 'blocks/custom-content-block.js',
    array('wp-blocks', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-element')
  );
}
add_action('enqueue_block_editor_assets', 'custom_content_block_enqueue_assets');



// Funcție recursivă pentru interpretarea corectă a shortcodurilor
function recursive_do_shortcode($content) {
    return do_shortcode($content);
}

// Shortcode function
function custom_content_shortcode($atts, $content = null) {
    if (is_user_logged_in()) {
        $interpreted_content = recursive_do_shortcode($content); // Interpretarea corectă a shortcodurilor în interior
        return $interpreted_content;
    } else {
        $non_registered_content = get_option('custom_content_non_registered', __('This content is visible only to registered users.', 'custom-content'));
        return $non_registered_content;
    }
}
add_shortcode('custom_content', 'custom_content_shortcode');


// Add description and usage instructions page
function custom_content_plugin_description() {
    add_menu_page(
        __('Custom Content Plugin', 'custom-content'),
        __('Custom Content', 'custom-content'),
        'manage_options',
        'custom-content-description',
        'custom_content_plugin_page',
        'dashicons-lock', // Icon for the menu item
        30 // Position in the menu
    );
}
add_action('admin_menu', 'custom_content_plugin_description');


// Plugin page content
function custom_content_plugin_page() {
    $non_registered_content = get_option('custom_content_non_registered', __('This content is visible only to registered users.', 'custom-content'));

    echo "<div class='wrap'><h1 class='cchdr'><span>" . esc_html__('Custom Content Plugin', 'custom-content') . "</span></h1>";
	

    // Adaugă o secțiune de informații
    echo "<div class='plvcz-info'>";
	echo "<div class='versiune-git'>" . get_plugin_version_from_da() . "</div>";
    echo "<h2>" . esc_html__('Plugin Information', 'custom-content') . "</h2>";
    echo "<p>" . esc_html__('This plugin allows you to show different content to registered and non-registered users using shortcodes.', 'custom-content') . "</p>";
    echo "<p>" . esc_html__('Registered users will see the content that you provide within the shortcode tags, while non-registered users will see the content you set in the plugin settings.', 'custom-content') . "</p>";
	
	
	  // Instrucțiuni de utilizare a codului scurt
    echo "<h2>" . esc_html__('Shortcode Usage', 'custom-content') . "</h2>";
    echo "<p>" . esc_html__('To display content visible only to registered users, use the following shortcode:', 'custom-content') . "</p>";
    echo "<pre class='plvcz-cod'><span>[custom_content]</span>Your content here<span>[/custom_content]</span></pre>";
	echo "<p>". esc_html__('Content outside the tags of the shortcode will be visible along with the content you set up below.', 'custom-content') . "</p>";
    echo "</div>";

    echo "<form method='post' action=''>";
    echo "<h2>" . esc_html__('Non-Registered User Content', 'custom-content') . "</h2>";
	
	// Adaugă un select pentru presetări
	echo "<div>";
	echo "<p>";
    echo "<label for='preset-select'>" . esc_html__('Select a Preset:', 'custom-content') . "</label>";
	echo "</p> ";
	echo "<div class='editorinfo'>". esc_html__('Choose from available presets or add your own content using the Editor tool', 'custom-content') . "</div>";
	echo "</div>";
    echo "<select id='preset-select'>";
    echo "<option value=''>-- " . esc_html__('Select a preset', 'custom-content') . " --</option>";
    echo "<option value='preset1'>" . esc_html__('Preset 1 - Access Upload', 'custom-content') . "</option>";
    echo "<option value='preset2'>" . esc_html__('Preset 2 - Download File', 'custom-content') . "</option>";
    echo "<option value='preset3'>" . esc_html__('Preset 3 - Access Content', 'custom-content') . "</option>";
    echo "<option value='preset4'>" . esc_html__('Preset 4 - Play or Download Media File', 'custom-content') . "</option>";
	echo "<option value='preset5'>" . esc_html__('Preset 5 - View Content', 'custom-content') . "</option>";
	echo "<option value='preset6'>" . esc_html__('Preset 6 - View Image', 'custom-content') . "</option>";
    echo "</select>";

 // Include editorul standard pentru postări
    wp_editor($non_registered_content, 'custom_content_non_registered', array(
        'media_buttons' => false,
        'textarea_name' => 'custom_content_non_registered',
    ));
echo "<div class='editorinfo'>". esc_html__('Native WP editor is supporting most of the HTML and inline css markup language along with other shortcodes', 'custom-content') . "</div>";
    echo "<p><input type='submit' class='button button-primary' value='" . esc_attr__('Save Changes', 'custom-content') . "' /></p>";
    echo "</form>";
	

	

	
	
	

    // Adaugă un banner
    echo "<div class='plvcz-banner'>";
    echo "<a href='https://lenani.ro'><img src='" . plugin_dir_url(__FILE__) . "admin/vcs-lenaniart.gif' alt='Plugin Banner' /></a>";
    echo "</div>";
	
	// Adaugă cod html
    echo "<div class='plvcz-dazinfo'>";
    echo "<div class='plvcz-dazinfo-inner'>";
	echo "<h4 class='plvcz-dazinfo-support'>". esc_html__('Support this project', 'custom-content') . "</h4>";
	echo "<p>". esc_html__('Yes we need your support and here are a few ways you can get involved:', 'custom-content') . "</p>";
	echo "<ul>";
	echo "<li>". esc_html__('&bull; Help with translation of these plugins.', 'custom-content') . "</li>";
	echo "<li>". esc_html__('&bull; Help with further developing of these plugins.', 'custom-content') . "</li>";
	echo "<li>" . esc_html__('&bull; Contribute with donation via', 'custom-content') . ' <a href="https://www.paypal.com/paypalme/Lenani">PayPal/LenaniArt</a> ' . esc_html__('or via Bank Transfer', 'custom-content') . "</li>";

	echo "</ul>";
	echo "</div>";
	echo "<div class='plvcz-dazinfo-inner'>";
	echo "<h4 class='plvcz-dazinfo-support'>". esc_html__('Documentation', 'custom-content') . "</h4>";
	echo "<p>" . esc_html__('All info and documentation is available', 'custom-content') . ' <a href="#">on GitHub</a> ' . esc_html__('repository as open source.', 'custom-content') . "</p>";
	echo "<ul>";
	echo "<li>" . esc_html__('&bull; Report issues -', 'custom-content') . ' <a href="https://github.com/Dascent/plugins/issues">issues section</a> ' . esc_html__('on GitHub', 'custom-content') . "</li>";
	echo "<li>" . esc_html__('&bull; Open suggestions -', 'custom-content') . ' <a href="https://github.com/Dascent/plugins/discussions">discussions section</a> ' . esc_html__('on GitHub', 'custom-content') . "</li>";
	echo "<li>" . esc_html__('&bull; Contributor\'s page -', 'custom-content') . ' <a href="https://github.com/Dascent/plugins/blob/main/Contributor.md">credits</a> ' . esc_html__('.', 'custom-content') . "</li>";

	echo "</ul>";
    echo "</div>";
	echo "<div class='flfix'>&nbsp;</div>";
	echo "<div id='versiune'>";
	echo "<div class='clfix'>" . esc_html__('Download version:', 'custom-content') . " " . get_plugin_version_from_github() . "</div>";
echo "</div>";
	echo "</div>";

    echo "</div>"; // Închide div-ul wrap
}


function get_plugin_version_from_github() {
    $github_version_url = 'https://dascent.github.io/plugins/plugins/visible-custom-content/v.txt'; // Înlocuiți cu URL-ul real către fișierul de versiune
    $github_version = file_get_contents($github_version_url);
    return $github_version;
}

//Versiune Dascent
function get_plugin_version_from_da() {
    $da_version_url = 'https://dascent.github.io/plugins/plugins/visible-custom-content/version.html'; // Înlocuiți cu URL-ul real către fișierul de versiune
    $da_version = file_get_contents($da_version_url);
    return $da_version;
}



// Save settings
function custom_content_save_settings() {
    if (isset($_POST['custom_content_non_registered'])) {
        update_option('custom_content_non_registered', wp_kses_post($_POST['custom_content_non_registered']));
    }
	if (isset($_POST['custom_content_css'])) {
        update_option('custom_content_css', wp_kses_post($_POST['custom_content_css']));
    }
}
add_action('admin_init', 'custom_content_save_settings');


// Adăugați link-ul către pagina Setări în lista de acțiuni a pluginului
function custom_content_settings_link($links) {
    // Link-ul către pagina Setări a pluginului
    $settings_link = '<a href="admin.php?page=custom-content-description">' . esc_html__('Settings', 'custom-content') . '</a>';
    
    // Adăugați link-ul în lista de acțiuni a pluginului
    array_push($links, $settings_link);
    
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'custom_content_settings_link');





// Load plugin CSS
function custom_content_load_admin_styles($hook) {
    if ($hook == 'toplevel_page_custom-content-description') {
        wp_enqueue_style('custom-content-admin-style', plugin_dir_url(__FILE__) . 'css/custom-content-admin.css');
    }
}
add_action('admin_enqueue_scripts', 'custom_content_load_admin_styles');

