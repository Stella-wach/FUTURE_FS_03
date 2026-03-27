<?php
/**
 * 404.php – Page Not Found template
 * @package QuietCafe
 */
get_header();
?>

<main id="main-content" class="content-area" role="main">
    <div class="error-404" style="min-height:70vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:4rem 2rem">

        <span style="font-size:5rem;display:block;margin-bottom:1rem" aria-hidden="true">☕</span>

        <span class="section-tag" style="justify-content:center">
            <?php esc_html_e( 'Error 404', 'quiet-cafe' ); ?>
        </span>

        <h1 style="font-size:clamp(2.5rem,5vw,4rem);margin-bottom:1rem">
            <?php esc_html_e( 'Looks like this cup', 'quiet-cafe' ); ?><br>
            <em><?php esc_html_e( 'ran empty.', 'quiet-cafe' ); ?></em>
        </h1>

        <p style="max-width:440px;margin-bottom:2.5rem;font-size:1rem">
            <?php esc_html_e( 'The page you\'re looking for has moved, been removed, or never existed. Let\'s get you back to something warm.', 'quiet-cafe' ); ?>
        </p>

        <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
                <?php esc_html_e( '← Back to Home', 'quiet-cafe' ); ?>
            </a>
            <a href="<?php echo esc_url( home_url( '/#menu' ) ); ?>" class="btn btn--outline">
                <?php esc_html_e( 'See Our Menu', 'quiet-cafe' ); ?>
            </a>
        </div>

        <div style="margin-top:3rem;padding:2rem;background:var(--qc-light-amber);border-radius:var(--qc-radius);max-width:420px;width:100%">
            <p style="font-size:.85rem;margin-bottom:.8rem;color:var(--qc-espresso);font-weight:500">
                <?php esc_html_e( 'Or search for something:', 'quiet-cafe' ); ?>
            </p>
            <?php get_search_form(); ?>
        </div>

    </div>
</main>

<?php get_footer(); ?>
