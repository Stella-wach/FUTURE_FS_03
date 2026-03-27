<?php
/**
 * The Quiet Café – functions.php
 *
 * Theme setup, asset enqueueing, custom post types,
 * widget areas, navigation menus, and theme helpers.
 *
 * @package QuietCafe
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─────────────────────────────────────────
   CONSTANTS
───────────────────────────────────────── */
define( 'QC_VERSION', '1.0.0' );
define( 'QC_DIR',     get_template_directory() );
define( 'QC_URI',     get_template_directory_uri() );

/* ─────────────────────────────────────────
   THEME SETUP
───────────────────────────────────────── */
function qc_setup() {
    // Translations
    load_theme_textdomain( 'quiet-cafe', QC_DIR . '/languages' );

    // HTML5 support
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );

    // Title tag
    add_theme_support( 'title-tag' );

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'qc-hero',    1200, 800,  true );
    add_image_size( 'qc-card',    600,  400,  true );
    add_image_size( 'qc-gallery', 400,  560,  true );
    add_image_size( 'qc-strip',   400,  280,  true );

    // Custom logo
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Custom background
    add_theme_support( 'custom-background', [
        'default-color' => 'FAF6EE',
    ] );

    // Selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Block editor color palette
    add_theme_support( 'editor-color-palette', [
        [ 'name' => __( 'Espresso',    'quiet-cafe' ), 'slug' => 'espresso',    'color' => '#1C0F0A' ],
        [ 'name' => __( 'Amber',       'quiet-cafe' ), 'slug' => 'amber',       'color' => '#C8641A' ],
        [ 'name' => __( 'Warm Red',    'quiet-cafe' ), 'slug' => 'warm-red',    'color' => '#B03A2E' ],
        [ 'name' => __( 'Gold',        'quiet-cafe' ), 'slug' => 'gold',        'color' => '#D4A247' ],
        [ 'name' => __( 'Sage',        'quiet-cafe' ), 'slug' => 'sage',        'color' => '#5C6B4A' ],
        [ 'name' => __( 'Cream',       'quiet-cafe' ), 'slug' => 'cream',       'color' => '#FAF6EE' ],
        [ 'name' => __( 'Light Amber', 'quiet-cafe' ), 'slug' => 'light-amber', 'color' => '#F3DDB8' ],
    ] );

    // Feed links
    add_theme_support( 'automatic-feed-links' );

    // Nav menus
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'quiet-cafe' ),
        'footer'  => __( 'Footer Navigation',  'quiet-cafe' ),
        'mobile'  => __( 'Mobile Navigation',  'quiet-cafe' ),
    ] );
}
add_action( 'after_setup_theme', 'qc_setup' );

/* ─────────────────────────────────────────
   ENQUEUE SCRIPTS & STYLES
───────────────────────────────────────── */
function qc_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'qc-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&family=Cormorant+Garamond:ital,wght@0,300;1,300;1,400&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'quiet-cafe-style',
        get_stylesheet_uri(),
        [ 'qc-fonts' ],
        QC_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'quiet-cafe-main',
        QC_URI . '/assets/js/main.js',
        [],
        QC_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script( 'quiet-cafe-main', 'qcData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'qc_reservation' ),
        'strings' => [
            'reservationSuccess' => __( '✓ Reservation Confirmed!', 'quiet-cafe' ),
            'reservationError'   => __( 'Something went wrong. Please try again.', 'quiet-cafe' ),
        ],
    ] );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'qc_enqueue_assets' );

/* ─────────────────────────────────────────
   WIDGET AREAS (SIDEBARS)
───────────────────────────────────────── */
function qc_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Blog Sidebar', 'quiet-cafe' ),
        'id'            => 'sidebar-blog',
        'description'   => __( 'Widgets in the blog sidebar.', 'quiet-cafe' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer Area 1', 'quiet-cafe' ),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer Area 2', 'quiet-cafe' ),
        'id'            => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'qc_widgets_init' );

/* ─────────────────────────────────────────
   CUSTOM POST TYPE: MENU ITEMS
───────────────────────────────────────── */
function qc_register_post_types() {
    register_post_type( 'qc_menu_item', [
        'labels' => [
            'name'               => __( 'Menu Items',     'quiet-cafe' ),
            'singular_name'      => __( 'Menu Item',      'quiet-cafe' ),
            'add_new_item'       => __( 'Add New Item',   'quiet-cafe' ),
            'edit_item'          => __( 'Edit Menu Item', 'quiet-cafe' ),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-coffee',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'menu-item' ],
    ] );
}
add_action( 'init', 'qc_register_post_types' );

/* ─────────────────────────────────────────
   CUSTOM TAXONOMY: MENU CATEGORY
───────────────────────────────────────── */
function qc_register_taxonomies() {
    register_taxonomy( 'qc_menu_category', 'qc_menu_item', [
        'labels' => [
            'name'          => __( 'Menu Categories', 'quiet-cafe' ),
            'singular_name' => __( 'Menu Category',   'quiet-cafe' ),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'menu-category' ],
    ] );
}
add_action( 'init', 'qc_register_taxonomies' );

/* ─────────────────────────────────────────
   CUSTOM META BOXES: MENU ITEM DETAILS
───────────────────────────────────────── */
function qc_add_menu_meta_boxes() {
    add_meta_box(
        'qc_menu_details',
        __( 'Menu Item Details', 'quiet-cafe' ),
        'qc_render_menu_meta_box',
        'qc_menu_item',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'qc_add_menu_meta_boxes' );

function qc_render_menu_meta_box( $post ) {
    wp_nonce_field( 'qc_save_menu_item', 'qc_menu_nonce' );
    $price = get_post_meta( $post->ID, '_qc_price', true );
    $emoji = get_post_meta( $post->ID, '_qc_emoji', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="qc_price"><?php esc_html_e( 'Price (KES)', 'quiet-cafe' ); ?></label></th>
            <td><input type="text" id="qc_price" name="qc_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="qc_emoji"><?php esc_html_e( 'Emoji Icon', 'quiet-cafe' ); ?></label></th>
            <td><input type="text" id="qc_emoji" name="qc_emoji" value="<?php echo esc_attr( $emoji ); ?>" class="small-text" placeholder="☕" /></td>
        </tr>
    </table>
    <?php
}

function qc_save_menu_meta( $post_id ) {
    if ( ! isset( $_POST['qc_menu_nonce'] ) || ! wp_verify_nonce( $_POST['qc_menu_nonce'], 'qc_save_menu_item' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['qc_price'] ) ) update_post_meta( $post_id, '_qc_price', sanitize_text_field( $_POST['qc_price'] ) );
    if ( isset( $_POST['qc_emoji'] ) ) update_post_meta( $post_id, '_qc_emoji', sanitize_text_field( $_POST['qc_emoji'] ) );
}
add_action( 'save_post_qc_menu_item', 'qc_save_menu_meta' );

/* ─────────────────────────────────────────
   AJAX: RESERVATION FORM HANDLER
───────────────────────────────────────── */
function qc_handle_reservation() {
    check_ajax_referer( 'qc_reservation', 'nonce' );

    $name   = sanitize_text_field( $_POST['name']   ?? '' );
    $phone  = sanitize_text_field( $_POST['phone']  ?? '' );
    $date   = sanitize_text_field( $_POST['date']   ?? '' );
    $time   = sanitize_text_field( $_POST['time']   ?? '' );
    $guests = sanitize_text_field( $_POST['guests'] ?? '' );
    $notes  = sanitize_textarea_field( $_POST['notes'] ?? '' );

    if ( ! $name || ! $phone || ! $date || ! $time || ! $guests ) {
        wp_send_json_error( [ 'message' => __( 'Please fill in all required fields.', 'quiet-cafe' ) ] );
    }

    // Save reservation as post
    $post_id = wp_insert_post( [
        'post_title'  => "Reservation: {$name} — {$date} {$time}",
        'post_type'   => 'qc_reservation',
        'post_status' => 'publish',
    ] );

    if ( $post_id ) {
        update_post_meta( $post_id, '_qc_res_name',   $name );
        update_post_meta( $post_id, '_qc_res_phone',  $phone );
        update_post_meta( $post_id, '_qc_res_date',   $date );
        update_post_meta( $post_id, '_qc_res_time',   $time );
        update_post_meta( $post_id, '_qc_res_guests', $guests );
        update_post_meta( $post_id, '_qc_res_notes',  $notes );
    }

    // Email notification to admin
    $admin_email = get_option( 'admin_email' );
    $subject     = sprintf( __( 'New Reservation — %s, %s at %s', 'quiet-cafe' ), $name, $date, $time );
    $body        = sprintf(
        "New reservation request:\n\nName: %s\nPhone: %s\nDate: %s\nTime: %s\nGuests: %s\nNotes: %s",
        $name, $phone, $date, $time, $guests, $notes
    );
    wp_mail( $admin_email, $subject, $body );

    wp_send_json_success( [ 'message' => __( '✓ Reservation Confirmed!', 'quiet-cafe' ) ] );
}
add_action( 'wp_ajax_qc_reservation',        'qc_handle_reservation' );
add_action( 'wp_ajax_nopriv_qc_reservation', 'qc_handle_reservation' );

/* ─────────────────────────────────────────
   CUSTOM POST TYPE: RESERVATIONS (admin)
───────────────────────────────────────── */
function qc_register_reservation_cpt() {
    register_post_type( 'qc_reservation', [
        'labels'      => [ 'name' => __( 'Reservations', 'quiet-cafe' ), 'singular_name' => __( 'Reservation', 'quiet-cafe' ) ],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-calendar-alt',
        'supports'    => [ 'title' ],
        'show_in_rest'=> false,
    ] );
}
add_action( 'init', 'qc_register_reservation_cpt' );

/* ─────────────────────────────────────────
   THEME CUSTOMIZER
───────────────────────────────────────── */
function qc_customize_register( $wp_customize ) {

    // ── Panel: The Quiet Café Settings
    $wp_customize->add_panel( 'qc_panel', [
        'title'    => __( 'The Quiet Café', 'quiet-cafe' ),
        'priority' => 30,
    ] );

    // Section: Hero
    $wp_customize->add_section( 'qc_hero', [
        'title' => __( 'Hero Section', 'quiet-cafe' ),
        'panel' => 'qc_panel',
    ] );

    $qc_hero_settings = [
        'qc_hero_eyebrow'  => [ 'default' => 'Est. 2018 · Nairobi',              'label' => 'Eyebrow Text' ],
        'qc_hero_headline' => [ 'default' => 'Where Every Sip Finds Stillness.', 'label' => 'Headline' ],
        'qc_hero_subtitle' => [ 'default' => 'A sanctuary for slow mornings, honest conversations, and coffee that cares.', 'label' => 'Subtitle' ],
        'qc_hero_cta1'     => [ 'default' => 'Reserve a Table',   'label' => 'Button 1 Text' ],
        'qc_hero_cta2'     => [ 'default' => 'Explore Menu',      'label' => 'Button 2 Text' ],
        'qc_stat1_num'     => [ 'default' => '12+',               'label' => 'Stat 1 Number' ],
        'qc_stat1_label'   => [ 'default' => 'Brew Origins',      'label' => 'Stat 1 Label' ],
        'qc_stat2_num'     => [ 'default' => '200+',              'label' => 'Stat 2 Number' ],
        'qc_stat2_label'   => [ 'default' => 'Weekly Guests',     'label' => 'Stat 2 Label' ],
        'qc_stat3_num'     => [ 'default' => '4.9★',              'label' => 'Stat 3 Number' ],
        'qc_stat3_label'   => [ 'default' => 'Avg. Rating',       'label' => 'Stat 3 Label' ],
    ];

    foreach ( $qc_hero_settings as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => __( $args['label'], 'quiet-cafe' ), 'section' => 'qc_hero', 'type' => 'text' ] );
    }

    // Section: About
    $wp_customize->add_section( 'qc_about', [
        'title' => __( 'About Section', 'quiet-cafe' ),
        'panel' => 'qc_panel',
    ] );
    $wp_customize->add_setting( 'qc_about_quote', [
        'default'           => '"The best coffee is the kind you linger over — no rush, no noise, just warmth."',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'qc_about_quote', [
        'label'   => __( 'Pull Quote', 'quiet-cafe' ),
        'section' => 'qc_about',
        'type'    => 'textarea',
    ] );

    // Section: Location
    $wp_customize->add_section( 'qc_location', [
        'title' => __( 'Location & Contact', 'quiet-cafe' ),
        'panel' => 'qc_panel',
    ] );

    $qc_loc_settings = [
        'qc_address'    => [ 'default' => '14 Woodvale Grove, Westlands, Nairobi', 'label' => 'Street Address' ],
        'qc_phone'      => [ 'default' => '+254 700 000 000',                      'label' => 'Phone Number' ],
        'qc_email'      => [ 'default' => 'hello@thequietcafe.co.ke',              'label' => 'Email Address', 'sanitize' => 'sanitize_email' ],
        'qc_maps_embed' => [ 'default' => '',                                      'label' => 'Google Maps Embed URL (src= value only)', 'sanitize' => 'esc_url_raw' ],
        'qc_instagram'  => [ 'default' => '#', 'label' => 'Instagram URL',  'sanitize' => 'esc_url_raw' ],
        'qc_facebook'   => [ 'default' => '#', 'label' => 'Facebook URL',   'sanitize' => 'esc_url_raw' ],
        'qc_twitter'    => [ 'default' => '#', 'label' => 'Twitter/X URL',  'sanitize' => 'esc_url_raw' ],
        'qc_whatsapp'   => [ 'default' => 'https://wa.me/254700000000', 'label' => 'WhatsApp URL', 'sanitize' => 'esc_url_raw' ],
    ];

    foreach ( $qc_loc_settings as $id => $args ) {
        $sanitize = $args['sanitize'] ?? 'sanitize_text_field';
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => $sanitize ] );
        $wp_customize->add_control( $id, [ 'label' => __( $args['label'], 'quiet-cafe' ), 'section' => 'qc_location', 'type' => 'text' ] );
    }
}
add_action( 'customize_register', 'qc_customize_register' );

/* ─────────────────────────────────────────
   HELPER: GET MENU ITEMS BY CATEGORY
───────────────────────────────────────── */
function qc_get_menu_items( $category_slug = '' ) {
    $args = [
        'post_type'      => 'qc_menu_item',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ];

    if ( $category_slug ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'qc_menu_category',
            'field'    => 'slug',
            'terms'    => $category_slug,
        ] ];
    }

    return new WP_Query( $args );
}

/* ─────────────────────────────────────────
   HELPER: THEME MOD WITH FALLBACK
───────────────────────────────────────── */
function qc_mod( $key, $fallback = '' ) {
    return get_theme_mod( $key, $fallback );
}

/* ─────────────────────────────────────────
   BODY CLASSES
───────────────────────────────────────── */
function qc_body_classes( $classes ) {
    if ( is_singular() ) $classes[] = 'is-singular';
    if ( is_front_page() ) $classes[] = 'is-front-page';
    return $classes;
}
add_filter( 'body_class', 'qc_body_classes' );

/* ─────────────────────────────────────────
   EXCERPT LENGTH
───────────────────────────────────────── */
add_filter( 'excerpt_length', fn() => 22, 999 );
add_filter( 'excerpt_more',   fn() => '…' );

/* ─────────────────────────────────────────
   REMOVE EMOJI SCRIPTS (PERFORMANCE)
───────────────────────────────────────── */
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );

/* ─────────────────────────────────────────
   LOAD INC/ MODULES
───────────────────────────────────────── */
$qc_includes = [
    '/inc/schema.php',
    '/inc/seo-helpers.php',
    '/inc/admin-dashboard.php',
    '/inc/enqueue-block-editor.php',
];

foreach ( $qc_includes as $file ) {
    $path = QC_DIR . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}
