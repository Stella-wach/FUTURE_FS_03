<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'quiet-cafe' ); ?></a>

<!-- ═══════════════════════════════════════
     SITE HEADER
═══════════════════════════════════════ -->
<header id="masthead" class="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo / Site Title -->
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?> – <?php esc_html_e( 'Home', 'quiet-cafe' ); ?>">
                    <span class="site-title">
                        <?php
                        $name  = get_bloginfo( 'name' );
                        $parts = explode( ' ', $name, 3 );
                        // Italicize the last word in amber
                        $last  = array_pop( $parts );
                        echo esc_html( implode( ' ', $parts ) ) . ' <span>' . esc_html( $last ) . '</span>';
                        ?>
                    </span>
                </a>
            <?php endif; ?>
        </div><!-- .site-branding -->

        <!-- Primary Navigation -->
        <nav id="site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'quiet-cafe' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location'  => 'primary',
                'menu_id'         => 'primary-menu',
                'container'       => false,
                'fallback_cb'     => 'qc_fallback_menu',
                'items_wrap'      => '<ul id="%1$s" role="list">%3$s</ul>',
            ] );
            ?>
        </nav>

        <!-- Mobile Toggle -->
        <button class="menu-toggle" id="menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'quiet-cafe' ); ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div><!-- .header-inner -->
</header><!-- #masthead -->

<?php
/**
 * Fallback menu if no nav menu is assigned.
 */
function qc_fallback_menu() {
    echo '<ul role="list">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'quiet-cafe' ) . '</a></li>';
    echo '<li><a href="#menu">'         . esc_html__( 'Menu', 'quiet-cafe' )         . '</a></li>';
    echo '<li><a href="#reservations">' . esc_html__( 'Reservations', 'quiet-cafe' ) . '</a></li>';
    echo '<li><a href="#location">'     . esc_html__( 'Location', 'quiet-cafe' )     . '</a></li>';
    echo '<li class="menu-cta"><a href="#contact">' . esc_html__( 'Contact', 'quiet-cafe' ) . '</a></li>';
    echo '</ul>';
}
