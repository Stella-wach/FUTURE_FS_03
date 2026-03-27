<?php
/**
 * Template Name: Full Menu Page
 * Template Post Type: page
 *
 * A standalone, full-width menu page — assign this template
 * to any Page in WP Admin → Page → Page Attributes → Template.
 *
 * @package QuietCafe
 */
get_header();
?>

<main id="main-content" role="main">

    <!-- Page Hero -->
    <div style="background:var(--qc-espresso);padding:8rem 5rem 4rem;text-align:center;position:relative;overflow:hidden">
        <div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1400&q=60') center/cover no-repeat;opacity:.12" aria-hidden="true"></div>
        <div style="position:relative;z-index:1">
            <span class="section-tag" style="justify-content:center;color:var(--qc-gold)"><?php esc_html_e( 'The Quiet Café', 'quiet-cafe' ); ?></span>
            <h1 style="color:var(--qc-cream)">
                <?php esc_html_e( 'Our', 'quiet-cafe' ); ?> <em style="color:var(--qc-amber)"><?php esc_html_e( 'Full Menu', 'quiet-cafe' ); ?></em>
            </h1>
            <p style="color:rgba(255,255,255,.65);max-width:520px;margin:1rem auto 0;font-size:1rem">
                <?php esc_html_e( 'Everything we make is crafted with care, using the best ingredients we can source. Ask your barista about today\'s specials.', 'quiet-cafe' ); ?>
            </p>
        </div>
    </div>

    <!-- Menu Content -->
    <section class="menu-section" id="menu" style="padding-top:4rem" aria-label="<?php esc_attr_e( 'Full menu', 'quiet-cafe' ); ?>">
        <?php get_template_part( 'template-parts/menu', 'section' ); ?>
    </section>

    <!-- Allergen Notice -->
    <div style="background:var(--qc-light-amber);padding:2.5rem 5rem;text-align:center">
        <p style="font-size:.85rem;color:var(--qc-muted);max-width:700px;margin:0 auto">
            <strong style="color:var(--qc-espresso)"><?php esc_html_e( 'Allergen Information:', 'quiet-cafe' ); ?></strong>
            <?php esc_html_e( 'Our kitchen handles nuts, gluten, dairy, soy, and eggs. Please inform your barista of any allergies or dietary requirements before ordering. We\'ll do our very best to accommodate you.', 'quiet-cafe' ); ?>
        </p>
    </div>

    <!-- CTA: Reservations -->
    <div style="background:var(--qc-warm-red);padding:4rem 5rem;text-align:center">
        <span class="section-tag" style="justify-content:center;color:rgba(255,255,255,.65)"><?php esc_html_e( 'Ready to visit?', 'quiet-cafe' ); ?></span>
        <h2 style="color:#fff;margin-bottom:1.5rem">
            <?php esc_html_e( 'Reserve Your', 'quiet-cafe' ); ?> <em style="color:var(--qc-blush)"><?php esc_html_e( 'Table', 'quiet-cafe' ); ?></em>
        </h2>
        <a href="<?php echo esc_url( home_url( '/#reservations' ) ); ?>" class="btn btn--white">
            <?php esc_html_e( 'Make a Reservation', 'quiet-cafe' ); ?>
        </a>
    </div>

</main>

<?php get_footer(); ?>
