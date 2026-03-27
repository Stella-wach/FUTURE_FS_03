<?php
/**
 * inc/enqueue-block-editor.php
 *
 * Loads theme fonts and editor styles inside
 * the Gutenberg block editor so what you see
 * in the editor matches the front-end.
 *
 * @package QuietCafe
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue editor-specific stylesheet.
 */
function qc_block_editor_assets() {
    // Google Fonts in editor
    wp_enqueue_style(
        'qc-editor-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&family=Cormorant+Garamond:ital,wght@0,300;1,300;1,400&display=swap',
        [],
        null
    );

    // Editor stylesheet
    wp_enqueue_style(
        'qc-block-editor-style',
        QC_URI . '/assets/css/editor-style.css',
        [ 'qc-editor-fonts' ],
        QC_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'qc_block_editor_assets' );

/**
 * Register editor stylesheet via add_editor_style() so Classic
 * Editor (TinyMCE) also gets theme styles.
 */
function qc_classic_editor_styles() {
    add_editor_style( [
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&display=swap',
        'assets/css/editor-style.css',
    ] );
}
add_action( 'after_setup_theme', 'qc_classic_editor_styles' );
