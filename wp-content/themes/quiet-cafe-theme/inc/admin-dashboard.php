<?php
/**
 * inc/admin-dashboard.php
 *
 * Adds:
 *  1. A custom Dashboard widget showing today's reservations
 *  2. Admin columns for the Reservations CPT
 *  3. A quick-glance admin bar node
 *  4. Admin CSS for a polished look
 *
 * @package QuietCafe
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─────────────────────────────────────────
   1. DASHBOARD WIDGET
───────────────────────────────────────── */
function qc_register_dashboard_widget() {
    wp_add_dashboard_widget(
        'qc_reservations_widget',
        __( '☕ The Quiet Café — Today\'s Reservations', 'quiet-cafe' ),
        'qc_render_dashboard_widget'
    );
}
add_action( 'wp_dashboard_setup', 'qc_register_dashboard_widget' );

function qc_render_dashboard_widget() {
    $today = date( 'Y-m-d' );

    $args = [
        'post_type'      => 'qc_reservation',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => '_qc_res_date',
                'value'   => $today,
                'compare' => '=',
            ],
        ],
        'meta_key'       => '_qc_res_time',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ];

    $reservations = new WP_Query( $args );

    echo '<div style="font-family:\'DM Sans\',sans-serif">';

    // Today's date header
    echo '<p style="font-size:.82rem;color:#888;margin-bottom:.8rem">';
    echo esc_html( date( 'l, F j, Y' ) );
    echo '</p>';

    if ( $reservations->have_posts() ) {
        echo '<p style="color:#C8641A;font-weight:600;margin-bottom:1rem">';
        printf(
            esc_html( _n( '%d reservation today', '%d reservations today', $reservations->found_posts, 'quiet-cafe' ) ),
            intval( $reservations->found_posts )
        );
        echo '</p>';

        echo '<table style="width:100%;border-collapse:collapse;font-size:.82rem">';
        echo '<thead><tr style="border-bottom:2px solid #F3DDB8">';
        echo '<th style="text-align:left;padding:.4rem .6rem;font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:#888">' . esc_html__( 'Time', 'quiet-cafe' ) . '</th>';
        echo '<th style="text-align:left;padding:.4rem .6rem;font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:#888">' . esc_html__( 'Guest', 'quiet-cafe' ) . '</th>';
        echo '<th style="text-align:left;padding:.4rem .6rem;font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:#888">' . esc_html__( 'Party', 'quiet-cafe' ) . '</th>';
        echo '<th style="text-align:left;padding:.4rem .6rem;font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:#888">' . esc_html__( 'Phone', 'quiet-cafe' ) . '</th>';
        echo '</tr></thead><tbody>';

        $row = 0;
        while ( $reservations->have_posts() ) {
            $reservations->the_post();
            $id     = get_the_ID();
            $name   = get_post_meta( $id, '_qc_res_name',   true );
            $phone  = get_post_meta( $id, '_qc_res_phone',  true );
            $time   = get_post_meta( $id, '_qc_res_time',   true );
            $guests = get_post_meta( $id, '_qc_res_guests', true );
            $bg     = $row % 2 === 0 ? '#fff' : '#FDFAF4';
            $row++;

            echo '<tr style="background:' . esc_attr( $bg ) . ';border-bottom:1px solid #F3DDB8">';
            echo '<td style="padding:.5rem .6rem;font-weight:600;color:#C8641A">' . esc_html( $time ) . '</td>';
            echo '<td style="padding:.5rem .6rem">' . esc_html( $name ) . '</td>';
            echo '<td style="padding:.5rem .6rem">' . esc_html( $guests ) . '</td>';
            echo '<td style="padding:.5rem .6rem"><a href="tel:' . esc_attr( preg_replace('/\s/', '', $phone ) ) . '" style="color:inherit">' . esc_html( $phone ) . '</a></td>';
            echo '</tr>';
        }
        wp_reset_postdata();
        echo '</tbody></table>';

    } else {
        echo '<div style="text-align:center;padding:1.5rem;background:#FDFAF4;border-radius:4px">';
        echo '<span style="font-size:2rem;display:block;margin-bottom:.5rem">🌙</span>';
        echo '<p style="color:#7a5a40;font-size:.88rem">' . esc_html__( 'No reservations for today.', 'quiet-cafe' ) . '</p>';
        echo '</div>';
    }

    // Quick links
    echo '<div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #F3DDB8;display:flex;gap:.8rem;flex-wrap:wrap">';
    echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=qc_reservation' ) ) . '" style="font-size:.78rem;color:#C8641A">' . esc_html__( 'All Reservations →', 'quiet-cafe' ) . '</a>';
    echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=qc_menu_item' ) ) . '" style="font-size:.78rem;color:#C8641A">' . esc_html__( 'Manage Menu Items →', 'quiet-cafe' ) . '</a>';
    echo '<a href="' . esc_url( admin_url( 'customize.php' ) ) . '" style="font-size:.78rem;color:#C8641A">' . esc_html__( 'Customizer →', 'quiet-cafe' ) . '</a>';
    echo '</div>';

    echo '</div>';
}


/* ─────────────────────────────────────────
   2. CUSTOM ADMIN COLUMNS — RESERVATIONS
───────────────────────────────────────── */
function qc_reservation_columns( $columns ) {
    return [
        'cb'           => $columns['cb'],
        'title'        => __( 'Reservation', 'quiet-cafe' ),
        'qc_res_name'  => __( 'Guest Name', 'quiet-cafe' ),
        'qc_res_date'  => __( 'Date', 'quiet-cafe' ),
        'qc_res_time'  => __( 'Time', 'quiet-cafe' ),
        'qc_res_guests'=> __( 'Guests', 'quiet-cafe' ),
        'qc_res_phone' => __( 'Phone', 'quiet-cafe' ),
        'date'         => __( 'Submitted', 'quiet-cafe' ),
    ];
}
add_filter( 'manage_qc_reservation_posts_columns', 'qc_reservation_columns' );

function qc_reservation_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'qc_res_name':
            echo esc_html( get_post_meta( $post_id, '_qc_res_name', true ) );
            break;
        case 'qc_res_date':
            $date = get_post_meta( $post_id, '_qc_res_date', true );
            echo $date ? '<strong>' . esc_html( date( 'D, M j Y', strtotime( $date ) ) ) . '</strong>' : '—';
            break;
        case 'qc_res_time':
            echo '<span style="color:#C8641A;font-weight:600">' . esc_html( get_post_meta( $post_id, '_qc_res_time', true ) ) . '</span>';
            break;
        case 'qc_res_guests':
            echo esc_html( get_post_meta( $post_id, '_qc_res_guests', true ) );
            break;
        case 'qc_res_phone':
            $ph = get_post_meta( $post_id, '_qc_res_phone', true );
            echo $ph ? '<a href="tel:' . esc_attr( preg_replace('/\s/', '', $ph) ) . '">' . esc_html( $ph ) . '</a>' : '—';
            break;
    }
}
add_action( 'manage_qc_reservation_posts_custom_column', 'qc_reservation_column_data', 10, 2 );

// Make date column sortable
function qc_reservation_sortable_columns( $columns ) {
    $columns['qc_res_date'] = 'qc_res_date';
    $columns['qc_res_time'] = 'qc_res_time';
    return $columns;
}
add_filter( 'manage_edit-qc_reservation_sortable_columns', 'qc_reservation_sortable_columns' );


/* ─────────────────────────────────────────
   3. ADMIN BAR — TODAY'S RESERVATION COUNT
───────────────────────────────────────── */
function qc_admin_bar_node( $wp_admin_bar ) {
    if ( ! current_user_can( 'edit_posts' ) ) return;

    $today = date( 'Y-m-d' );
    $count = (int) ( new WP_Query( [
        'post_type'      => 'qc_reservation',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'meta_query'     => [ [ 'key' => '_qc_res_date', 'value' => $today ] ],
    ] ) )->found_posts;

    $wp_admin_bar->add_node( [
        'id'    => 'qc-today',
        'title' => '☕ ' . sprintf(
            esc_html( _n( '%d Reservation Today', '%d Reservations Today', $count, 'quiet-cafe' ) ),
            $count
        ),
        'href'  => admin_url( 'edit.php?post_type=qc_reservation' ),
        'meta'  => [ 'title' => __( 'View all reservations', 'quiet-cafe' ) ],
    ] );
}
add_action( 'admin_bar_menu', 'qc_admin_bar_node', 100 );


/* ─────────────────────────────────────────
   4. ADMIN STYLES
───────────────────────────────────────── */
function qc_admin_styles() {
    $screen = get_current_screen();
    echo '<style>
        /* Admin brand colour accents */
        #adminmenu .wp-has-current-submenu .wp-submenu-head,
        #adminmenu li.current a.menu-top,
        #adminmenu li a.menu-top:focus,
        .folded #adminmenu li.current a.menu-top { background: #C8641A !important; }

        /* Dashboard widget header */
        #qc_reservations_widget .hndle { background: #1C0F0A; color: #FAF6EE; }
        #qc_reservations_widget .hndle span { color: #FAF6EE; }
        #qc_reservations_widget .handlediv { color: #FAF6EE; }

        /* Reservation list table */
        .post-type-qc_reservation .column-qc_res_date { font-weight: 600; }

        /* Menu item post type icon */
        #adminmenu .menu-icon-qc_menu_item div.wp-menu-image::before { content: "\\f534"; }

        /* Quick action notice */
        .qc-admin-notice {
            border-left: 4px solid #C8641A;
            background: #fff8f0;
            padding: 10px 14px;
        }
    </style>';
}
add_action( 'admin_head', 'qc_admin_styles' );


/* ─────────────────────────────────────────
   5. ADMIN NOTICE — SETUP GUIDE
   (only shown once, on first activation)
───────────────────────────────────────── */
function qc_setup_admin_notice() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( get_option( 'qc_setup_notice_dismissed' ) ) return;

    echo '<div class="notice qc-admin-notice is-dismissible" id="qc-setup-notice">';
    echo '<p><strong>☕ ' . esc_html__( 'Welcome to The Quiet Café theme!', 'quiet-cafe' ) . '</strong></p>';
    echo '<p>' . wp_kses_post( sprintf(
        __( 'Get started: %1$sCustomize your site%2$s, or %3$sadd your first menu item%4$s. See the %5$sREADME%6$s for full setup instructions.', 'quiet-cafe' ),
        '<a href="' . esc_url( admin_url( 'customize.php' ) ) . '">', '</a>',
        '<a href="' . esc_url( admin_url( 'post-new.php?post_type=qc_menu_item' ) ) . '">', '</a>',
        '<a href="' . esc_url( admin_url( 'themes.php?page=quiet-cafe-readme' ) ) . '">', '</a>'
    ) ) . '</p>';
    echo '<button type="button" class="notice-dismiss" onclick="
        fetch(\'' . esc_url( admin_url( 'admin-ajax.php' ) ) . '?action=qc_dismiss_notice&nonce=' . wp_create_nonce( 'qc_dismiss' ) . '\');
        this.closest(\'.notice\').remove();
    "><span class=\'screen-reader-text\'>' . esc_html__( 'Dismiss notice', 'quiet-cafe' ) . '</span></button>';
    echo '</div>';
}
add_action( 'admin_notices', 'qc_setup_admin_notice' );

function qc_dismiss_setup_notice() {
    check_ajax_referer( 'qc_dismiss', 'nonce' );
    update_option( 'qc_setup_notice_dismissed', true );
    wp_die();
}
add_action( 'wp_ajax_qc_dismiss_notice', 'qc_dismiss_setup_notice' );
