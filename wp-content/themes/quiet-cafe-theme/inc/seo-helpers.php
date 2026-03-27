<?php
/**
 * inc/seo-helpers.php
 *
 * Adds Open Graph + Twitter Card meta tags,
 * and a canonical URL, when Yoast/RankMath are NOT active.
 *
 * If a full SEO plugin is active, this skips gracefully.
 *
 * @package QuietCafe
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Don't load if a dedicated SEO plugin is handling it.
 */
function qc_should_load_seo_helpers() {
    return ! defined( 'WPSEO_VERSION' ) // Yoast
        && ! defined( 'RANK_MATH_VERSION' ); // RankMath
}

if ( qc_should_load_seo_helpers() ) :

function qc_output_seo_meta() {
    global $post;

    $site_name   = get_bloginfo( 'name' );
    $tagline     = get_bloginfo( 'description' );
    $site_url    = home_url( '/' );

    // ── Title ──────────────────────────────────────────
    if ( is_front_page() ) {
        $title = $site_name . ( $tagline ? ' — ' . $tagline : '' );
        $desc  = $tagline ?: 'A specialty coffee café in Westlands, Nairobi. Cozy atmosphere, single-origin roasts, and house-baked pastries.';
        $url   = $site_url;
        $type  = 'website';
    } elseif ( is_singular() ) {
        $title = get_the_title() . ' — ' . $site_name;
        $desc  = has_excerpt( $post->ID ) ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( strip_shortcodes( $post->post_content ), 25 );
        $url   = get_permalink();
        $type  = 'article';
    } elseif ( is_archive() ) {
        $title = wp_title( '—', false, 'right' ) . $site_name;
        $desc  = strip_tags( get_the_archive_description() ) ?: $tagline;
        $url   = get_pagenum_link();
        $type  = 'website';
    } else {
        $title = $site_name;
        $desc  = $tagline;
        $url   = home_url( add_query_arg( [] ) );
        $type  = 'website';
    }

    $desc = esc_attr( wp_trim_words( $desc, 30 ) );
    $url  = esc_url( $url );

    // ── Image ──────────────────────────────────────────
    $image = '';
    if ( is_singular() && has_post_thumbnail( $post->ID ) ) {
        $img   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'qc-hero' );
        $image = $img ? $img[0] : '';
    }
    if ( ! $image && has_custom_logo() ) {
        $image = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
    }
    if ( ! $image ) {
        $image = QC_URI . '/assets/images/og-default.jpg'; // place a 1200×630 image here
    }

    // ── Output ─────────────────────────────────────────
    ?>
    <!-- SEO: Canonical -->
    <link rel="canonical" href="<?php echo esc_url( $url ); ?>" />

    <!-- SEO: Meta Description -->
    <meta name="description" content="<?php echo $desc; ?>" />

    <!-- Open Graph -->
    <meta property="og:type"        content="<?php echo esc_attr( $type ); ?>" />
    <meta property="og:url"         content="<?php echo esc_url( $url ); ?>" />
    <meta property="og:title"       content="<?php echo esc_attr( $title ); ?>" />
    <meta property="og:description" content="<?php echo $desc; ?>" />
    <meta property="og:site_name"   content="<?php echo esc_attr( $site_name ); ?>" />
    <?php if ( $image ) : ?>
    <meta property="og:image"       content="<?php echo esc_url( $image ); ?>" />
    <meta property="og:image:width"  content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt"   content="<?php echo esc_attr( $site_name ); ?>" />
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="<?php echo esc_attr( $title ); ?>" />
    <meta name="twitter:description" content="<?php echo $desc; ?>" />
    <?php if ( $image ) : ?>
    <meta name="twitter:image"       content="<?php echo esc_url( $image ); ?>" />
    <?php endif; ?>
    <?php if ( qc_mod( 'qc_twitter', '' ) ) : ?>
    <meta name="twitter:site"        content="<?php echo esc_attr( '@' . ltrim( qc_mod( 'qc_twitter', '' ), '@https://twitter.com/@x.com/' ) ); ?>" />
    <?php endif; ?>

    <!-- Geo / Business -->
    <meta name="geo.region"      content="KE-30" />
    <meta name="geo.placename"   content="Nairobi" />
    <meta name="geo.position"    content="-1.2641;36.8019" />
    <meta name="ICBM"            content="-1.2641, 36.8019" />
    <?php
}
add_action( 'wp_head', 'qc_output_seo_meta', 1 );


/**
 * Remove the default WP title tag when we handle it ourselves.
 * (Only relevant if theme doesn't use add_theme_support('title-tag'))
 */
// remove_action( 'wp_head', '_wp_render_title_tag', 1 );

endif; // qc_should_load_seo_helpers
