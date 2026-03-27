<?php
/**
 * Template Part: Reservations Form
 * @package QuietCafe
 */
?>

<!-- Info Panel -->
<div class="reservations-section__info">
    <span class="section-tag"><?php esc_html_e( 'Book Your Seat', 'quiet-cafe' ); ?></span>
    <h2 style="color:#fff"><?php esc_html_e( 'Reserve Your', 'quiet-cafe' ); ?> <em style="color:var(--qc-blush)"><?php esc_html_e( 'Table', 'quiet-cafe' ); ?></em></h2>
    <p><?php esc_html_e( 'Whether it\'s a solo morning, a working lunch, or a celebration — we\'ll set the scene. Reservations recommended on weekends.', 'quiet-cafe' ); ?></p>

    <div class="hours-table" role="table" aria-label="<?php esc_attr_e( 'Opening hours', 'quiet-cafe' ); ?>">
        <?php
        $hours = [
            __( 'Mon – Fri', 'quiet-cafe' ) => __( '7:00 AM – 8:00 PM', 'quiet-cafe' ),
            __( 'Saturday',  'quiet-cafe' ) => __( '8:00 AM – 9:00 PM', 'quiet-cafe' ),
            __( 'Sunday',    'quiet-cafe' ) => __( '9:00 AM – 6:00 PM', 'quiet-cafe' ),
        ];
        foreach ( $hours as $day => $time ) : ?>
        <div class="hours-row" role="row">
            <strong role="cell"><?php echo esc_html( $day ); ?></strong>
            <span role="cell"><?php echo esc_html( $time ); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div><!-- .reservations-section__info -->

<!-- Form Panel -->
<div class="reservations-section__form">
    <h3><?php esc_html_e( 'Make a Reservation', 'quiet-cafe' ); ?></h3>
    <p><?php esc_html_e( 'Fill in the details below and we\'ll confirm within 2 hours.', 'quiet-cafe' ); ?></p>

    <?php
    // Check if Contact Form 7 is active — use it if available
    if ( function_exists( 'wpcf7' ) && $cf7_id = get_theme_mod( 'qc_cf7_reservation_id' ) ) :
        echo do_shortcode( '[contact-form-7 id="' . esc_attr( $cf7_id ) . '" title="Reservation"]' );
    else :
    // Native AJAX form
    ?>
    <form class="qc-form" id="qc-reservation-form" novalidate aria-label="<?php esc_attr_e( 'Reservation form', 'quiet-cafe' ); ?>">
        <?php wp_nonce_field( 'qc_reservation', 'qc_nonce' ); ?>

        <div class="form-row">
            <div class="form-group">
                <label for="res-name"><?php esc_html_e( 'Full Name', 'quiet-cafe' ); ?> <span aria-hidden="true">*</span></label>
                <input
                    type="text"
                    id="res-name"
                    name="name"
                    placeholder="<?php esc_attr_e( 'Jane Wanjiku', 'quiet-cafe' ); ?>"
                    required
                    autocomplete="name"
                    aria-required="true"
                />
            </div>
            <div class="form-group">
                <label for="res-phone"><?php esc_html_e( 'Phone Number', 'quiet-cafe' ); ?> <span aria-hidden="true">*</span></label>
                <input
                    type="tel"
                    id="res-phone"
                    name="phone"
                    placeholder="+254 7XX XXX XXX"
                    required
                    autocomplete="tel"
                    aria-required="true"
                />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="res-date"><?php esc_html_e( 'Date', 'quiet-cafe' ); ?> <span aria-hidden="true">*</span></label>
                <input
                    type="date"
                    id="res-date"
                    name="date"
                    required
                    aria-required="true"
                />
            </div>
            <div class="form-group">
                <label for="res-time"><?php esc_html_e( 'Time', 'quiet-cafe' ); ?> <span aria-hidden="true">*</span></label>
                <select id="res-time" name="time" required aria-required="true">
                    <option value=""><?php esc_html_e( 'Select time', 'quiet-cafe' ); ?></option>
                    <?php
                    $times = [ '7:00 AM','7:30 AM','8:00 AM','8:30 AM','9:00 AM','9:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','1:00 PM','1:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM','5:00 PM','5:30 PM','6:00 PM','6:30 PM','7:00 PM','7:30 PM' ];
                    foreach ( $times as $t ) echo '<option>' . esc_html( $t ) . '</option>';
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="res-guests"><?php esc_html_e( 'Number of Guests', 'quiet-cafe' ); ?> <span aria-hidden="true">*</span></label>
            <select id="res-guests" name="guests" required aria-required="true">
                <option value=""><?php esc_html_e( 'Select guests', 'quiet-cafe' ); ?></option>
                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                <option><?php printf( _n( '%d Guest', '%d Guests', $i, 'quiet-cafe' ), $i ); ?></option>
                <?php endfor; ?>
                <option><?php esc_html_e( '6+ Guests', 'quiet-cafe' ); ?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="res-notes"><?php esc_html_e( 'Special Requests', 'quiet-cafe' ); ?> <span style="opacity:.5;font-size:.85em">(<?php esc_html_e( 'optional', 'quiet-cafe' ); ?>)</span></label>
            <textarea
                id="res-notes"
                name="notes"
                placeholder="<?php esc_attr_e( 'Dietary needs, occasion, seating preference…', 'quiet-cafe' ); ?>"
                aria-label="<?php esc_attr_e( 'Special requests', 'quiet-cafe' ); ?>"
            ></textarea>
        </div>

        <div id="qc-form-message" role="alert" aria-live="polite" style="display:none;margin-bottom:.8rem;padding:.8rem;border-radius:2px;font-size:.88rem;"></div>

        <button type="submit" class="btn--submit" id="qc-submit-btn">
            <?php esc_html_e( 'Confirm Reservation →', 'quiet-cafe' ); ?>
        </button>
    </form>
    <?php endif; ?>

</div><!-- .reservations-section__form -->
