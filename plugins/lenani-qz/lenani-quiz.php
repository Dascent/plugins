<?php
/**
 * Plugin Name: Lenani Quiz
 * Plugin URI: https://lenani.ro/plugins/lenani-quiz
 * Description: A plugin for adding quizzes to WordPress.
 * Version: 1.0.0
 * Author: Dascent
 * Author URI: https://lenani.ro
 * Text Domain: lenani-quiz
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

function lenani_quiz_enqueue_assets() {
    wp_enqueue_style('lenani-quiz-style', plugin_dir_url(__FILE__) . 'css/lenani-quiz-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'lenani_quiz_enqueue_assets');

function lenani_quiz_register_post_type() {
    $labels = array(
        'name' => __('Quizzes', 'lenani-quiz'),
        'singular_name' => __('Quiz', 'lenani-quiz'),
        'add_new' => __('Add New', 'lenani-quiz'),
        'add_new_item' => __('Add New Quiz', 'lenani-quiz'),
        'edit_item' => __('Edit Quiz', 'lenani-quiz'),
        'new_item' => __('New Quiz', 'lenani-quiz'),
        'view_item' => __('View Quiz', 'lenani-quiz'),
        'search_items' => __('Search Quizzes', 'lenani-quiz'),
        'not_found' => __('No quizzes found', 'lenani-quiz'),
        'not_found_in_trash' => __('No quizzes found in trash', 'lenani-quiz')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-clipboard',
        'supports' => array('title', 'editor'),
        'show_in_menu' => true, // Set this option to "true"
    );
    register_post_type('lenani_quiz', $args);
}
add_action('init', 'lenani_quiz_register_post_type');

function lenani_quiz_add_metabox() {
    add_meta_box('lenani_quiz_questions', __('Quiz Questions', 'lenani-quiz'), 'lenani_quiz_render_metabox', 'lenani_quiz', 'normal', 'high');
}
add_action('add_meta_boxes', 'lenani_quiz_add_metabox');

function lenani_quiz_render_metabox($post) {
    ?>
    <div id="quiz-questions-wrapper">
        <!-- Dynamic content will be added here -->
    </div>
    <input type="button" id="add-question" class="button" value="<?php esc_attr_e('Add Question', 'lenani-quiz'); ?>">
    <script>
        jQuery(document).ready(function($) {
            var wrapper = $('#quiz-questions-wrapper');
            var questionIndex = 0;

            $('#add-question').click(function() {
                var newQuestion = '<div class="question">';
                newQuestion += '<h3><?php esc_html_e('Question', 'lenani-quiz'); ?> ' + (questionIndex + 1) + '</h3>';
                newQuestion += '<label for="question-' + questionIndex + '"><?php esc_html_e('Question Content', 'lenani-quiz'); ?></label>';
                newQuestion += '<textarea id="question-' + questionIndex + '" name="questions[' + questionIndex + '][content]" rows="3" required></textarea>';

                for (var i = 1; i <= 3; i++) {
                    newQuestion += '<label for="answer-' + questionIndex + '-' + i + '"><?php esc_html_e('Answer', 'lenani-quiz'); ?> ' + i + '</label>';
                    newQuestion += '<input type="text" id="answer-' + questionIndex + '-' + i + '" name="questions[' + questionIndex + '][answers][' + (i - 1) + ']" required>';
                    newQuestion += '<input type="radio" name="questions[' + questionIndex + '][correct_answer]" value="' + (i - 1) + '"> <?php esc_html_e('Correct', 'lenani-quiz'); ?><br>';
                }

                newQuestion += '<label for="image-' + questionIndex + '"><?php esc_html_e('Image', 'lenani-quiz'); ?></label>';
                newQuestion += '<input type="file" id="image-' + questionIndex + '" name="questions[' + questionIndex + '][image]">';

                newQuestion += '</div>';
                questionIndex++;

                wrapper.append(newQuestion);
            });
        });
    </script>
    <?php
}

function lenani_quiz_save_metabox($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['lenani_quiz_metabox_nonce']) || !wp_verify_nonce($_POST['lenani_quiz_metabox_nonce'], 'lenani_quiz_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['questions'])) {
        $questions = array();
        
        foreach ($_POST['questions'] as $question_data) {
            $question = array(
                'content' => sanitize_text_field($question_data['content']),
                'answers' => array_map('sanitize_text_field', $question_data['answers']),
                'correct_answer' => intval($question_data['correct_answer']),
                'image' => isset($question_data['image']) ? sanitize_text_field($question_data['image']) : '',
            );

            $questions[] = $question;
        }

        update_post_meta($post_id, '_quiz_questions', $questions);
    }
}
add_action('save_post', 'lenani_quiz_save_metabox');

function lenani_quiz_shortcode($atts) {
    ob_start();
    
    // Get the current quiz's ID
    global $post;
    $quiz_id = $post->ID;
    
    // Get quiz questions from post meta
    $questions = get_post_meta($quiz_id, '_quiz_questions', true);

    // Display quiz questions and answers here
    if (!empty($questions)) {
        foreach ($questions as $index => $question) {
            echo '<div class="question">';
            echo '<h3>Question ' . ($index + 1) . '</h3>';
            echo '<p>' . esc_html($question['content']) . '</p>';
            
            echo '<ul>';
            foreach ($question['answers'] as $answer) {
                echo '<li>' . esc_html($answer) . '</li>';
            }
            echo '</ul>';
            
            if (!empty($question['image'])) {
                echo '<img src="' . esc_url($question['image']) . '" alt="Question Image">';
            }
            
            echo '</div>';
        }
    }

    return ob_get_clean();
}

function lenani_quiz_load_textdomain() {
    load_plugin_textdomain('lenani-quiz', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'lenani_quiz_load_textdomain');
