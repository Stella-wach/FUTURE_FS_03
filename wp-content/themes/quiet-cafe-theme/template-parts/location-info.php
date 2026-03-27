<?php
/**
 * Template Part: Location Info
 * @package QuietCafe
 */

$maps_url = qc_mod( 'qc_maps_embed', '' );
$address  = qc_mod( 'qc_address', '14 Woodvale Grove, Westlands, Nairobi' );
$phone    = qc_mod( 'qc_phone',   '+254 700 000 000' );
$email    = qc_mod( 'qc_email',   'hello@thequietcafe.co.ke' );
?>

<!-- Map -->
<div class="location-section__map reveal" role="region" aria-label="<?php esc_attr_e( 'Café location map', 'quiet-cafe' ); ?>">
    <?php if ( $maps_url ) : ?>
        <iframe
            src="<?php echo esc_url( $maps_url ); ?>"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="<?php esc_attr_e( 'The Quiet Café location on Google Maps', 'quiet-cafe' ); ?>"
        ></iframe>
    <?php else : ?>
        <div style="width:100%;height:100%;background:linear-gradient(135deg,#c8a87a,#7a5030);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.8rem;text-align:center;padding:2rem;">
            <span style="font-size:3rem" aria-hidden="true">📍</span>
            <strong style="font-family:var(--qc-font-display);color:#fff;font-size:1.2rem"><?php bloginfo( 'name' ); ?></strong>
            <p style="color:rgba(255,255,255,.85);font-size:.9rem"><?php echo esc_html( $address ); ?></p>
            <a href="https://maps.google.com/?q=<?php echo esc_attr( urlencode( $address ) ); ?>"
               target="_blank" rel="noopener noreferrer"
               style="color:rgba(255,255,255,.7);font-size:.82rem;text-decoration:underline;">
                <?php esc_html_e( 'Open in Google Maps →', 'quiet-cafe' ); ?>
            </a>
            <p style="color:rgba(255,255,255,.4);font-size:.72rem;margin-top:.5rem">
                <?php esc_html_e( 'Add your Google Maps embed URL in Appearance → Customize → Location & Contact', 'quiet-cafe' ); ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- Info -->
<div class="reveal">
    <span class="section-tag"><?php esc_html_e( 'Find Us', 'quiet-cafe' ); ?></span>
    <h2><?php esc_html_e( 'We\'re in the Heart of', 'quiet-cafe' ); ?> <em><?php esc_html_e( 'Westlands', 'quiet-cafe' ); ?></em></h2>

    <div class="location-detail">
        <div class="location-detail__icon" aria-hidden="true">📍</div>
        <div>
            <strong><?php esc_html_e( 'Address', 'quiet-cafe' ); ?></strong>
            <span><?php echo nl2br( esc_html( $address ) ); ?></span>
        </div>
    </div>

    <div class="location-detail">
        <div class="location-detail__icon" aria-hidden="true">📞</div>
        <div>
            <strong><?php esc_html_e( 'Phone', 'quiet-cafe' ); ?></strong>
            <span><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></span>
        </div>
    </div>

    <div class="location-detail">
        <div class="location-detail__icon" aria-hidden="true">✉️</div>
        <div>
            <strong><?php esc_html_e( 'Email', 'quiet-cafe' ); ?></strong>
            <span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span>
        </div>
    </div>

    <div class="location-detail">
        <div class="location-detail__icon" aria-hidden="true">🚗</div>
        <div>
            <strong><?php esc_html_e( 'Parking', 'quiet-cafe' ); ?></strong>
            <span><?php esc_html_e( 'Free parking available in the building basement. Validated for café guests.', 'quiet-cafe' ); ?></span>
        </div>
    </div>
</div>
