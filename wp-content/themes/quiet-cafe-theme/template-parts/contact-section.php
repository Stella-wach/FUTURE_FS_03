<?php
/**
 * Template Part: Contact Section
 * @package QuietCafe
 */

$phone    = qc_mod( 'qc_phone',     '+254 700 000 000' );
$email    = qc_mod( 'qc_email',     'hello@thequietcafe.co.ke' );
$whatsapp = qc_mod( 'qc_whatsapp',  'https://wa.me/254700000000' );
$ig       = qc_mod( 'qc_instagram', '#' );
$fb       = qc_mod( 'qc_facebook',  '#' );
$tw       = qc_mod( 'qc_twitter',   '#' );
?>

<span class="section-tag"><?php esc_html_e( 'Say Hello', 'quiet-cafe' ); ?></span>
<h2><?php esc_html_e( 'We\'d Love to Hear', 'quiet-cafe' ); ?> <em><?php esc_html_e( 'From You', 'quiet-cafe' ); ?></em></h2>
<p><?php esc_html_e( 'Questions, feedback, or just want to share how your morning went? We\'re here.', 'quiet-cafe' ); ?></p>

<div class="contact-cards" role="list">
    <div class="contact-card" role="listitem">
        <span class="contact-card__icon" aria-hidden="true">📞</span>
        <strong><?php esc_html_e( 'Call Us', 'quiet-cafe' ); ?></strong>
        <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
    </div>
    <div class="contact-card" role="listitem">
        <span class="contact-card__icon" aria-hidden="true">✉️</span>
        <strong><?php esc_html_e( 'Email Us', 'quiet-cafe' ); ?></strong>
        <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
    </div>
    <div class="contact-card" role="listitem">
        <span class="contact-card__icon" aria-hidden="true">💬</span>
        <strong><?php esc_html_e( 'WhatsApp', 'quiet-cafe' ); ?></strong>
        <a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener">
            <?php esc_html_e( 'Message Us →', 'quiet-cafe' ); ?>
        </a>
    </div>
</div>

<div class="social-links" aria-label="<?php esc_attr_e( 'Social media links', 'quiet-cafe' ); ?>">
    <a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'quiet-cafe' ); ?>">📷</a>
    <a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'quiet-cafe' ); ?>">📘</a>
    <a href="<?php echo esc_url( $tw ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Twitter / X', 'quiet-cafe' ); ?>">🐦</a>
    <a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'WhatsApp', 'quiet-cafe' ); ?>">💬</a>
</div>
