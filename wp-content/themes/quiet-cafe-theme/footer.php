<!-- ═══════════════════════════════════════
     SITE FOOTER
═══════════════════════════════════════ -->
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-inner">

        <!-- Logo -->
        <div class="footer-logo" aria-label="<?php bloginfo( 'name' ); ?>">
            <?php
            $name  = get_bloginfo( 'name' );
            $parts = explode( ' ', $name, 3 );
            $last  = array_pop( $parts );
            echo 'The Quiet <span>Café</span>';
            ?>
        </div>

        <!-- Copyright -->
        <div class="site-info">
            <p>
                &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                <?php bloginfo( 'name' ); ?>.
                <?php esc_html_e( 'All rights reserved.', 'quiet-cafe' ); ?>
            </p>
        </div>

        <!-- Footer Nav -->
        <nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'quiet-cafe' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'container'      => false,
                'depth'          => 1,
                'fallback_cb'    => 'qc_footer_fallback_menu',
                'items_wrap'     => '%3$s',
            ] );
            ?>
        </nav>

    </div><!-- .footer-inner -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>

<?php
function qc_footer_fallback_menu() {
    $links = [
        home_url( '/' )    => __( 'Home', 'quiet-cafe' ),
        '#menu'            => __( 'Menu', 'quiet-cafe' ),
        '#reservations'    => __( 'Reservations', 'quiet-cafe' ),
        '#location'        => __( 'Location', 'quiet-cafe' ),
        '#contact'         => __( 'Contact', 'quiet-cafe' ),
    ];
    foreach ( $links as $url => $label ) {
        echo '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
    }
}
