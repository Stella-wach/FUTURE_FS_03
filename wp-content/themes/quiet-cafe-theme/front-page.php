<?php
/**
 * Front Page Template
 *
 * Used when "Front page displays: A static page" is set,
 * OR as the home template if no static page is configured.
 *
 * @package QuietCafe
 */

get_header();
?>

<main id="main-content" role="main">

    <!-- ═══════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════ -->
    <section id="home" class="hero" aria-label="<?php esc_attr_e( 'Welcome to The Quiet Café', 'quiet-cafe' ); ?>">

        <div class="hero__left">

            <span class="hero__eyebrow" aria-hidden="true">
                <?php echo esc_html( qc_mod( 'qc_hero_eyebrow', 'Est. 2018 · Nairobi' ) ); ?>
            </span>

            <h1 class="hero__title">
                <?php
                $headline = qc_mod( 'qc_hero_headline', 'Where Every Sip Finds Stillness.' );
                // Split on last word to italicize
                $words    = explode( ' ', $headline );
                $last     = array_pop( $words );
                echo esc_html( implode( ' ', $words ) ) . '<br><em>' . esc_html( $last ) . '</em>';
                ?>
            </h1>

            <p class="hero__subtitle">
                <?php echo esc_html( qc_mod( 'qc_hero_subtitle', 'A sanctuary for slow mornings, honest conversations, and coffee that cares.' ) ); ?>
            </p>

            <div class="hero__actions">
                <a href="#reservations" class="btn btn--primary">
                    <?php echo esc_html( qc_mod( 'qc_hero_cta1', __( 'Reserve a Table', 'quiet-cafe' ) ) ); ?>
                </a>
                <a href="#menu" class="btn btn--outline">
                    <?php echo esc_html( qc_mod( 'qc_hero_cta2', __( 'Explore Menu', 'quiet-cafe' ) ) ); ?>
                </a>
            </div>

            <div class="hero__stats" role="list" aria-label="<?php esc_attr_e( 'Café highlights', 'quiet-cafe' ); ?>">
                <div class="hero__stat" role="listitem">
                    <strong><?php echo esc_html( qc_mod( 'qc_stat1_num', '12+' ) ); ?></strong>
                    <span><?php echo esc_html( qc_mod( 'qc_stat1_label', __( 'Brew Origins', 'quiet-cafe' ) ) ); ?></span>
                </div>
                <div class="hero__stat" role="listitem">
                    <strong><?php echo esc_html( qc_mod( 'qc_stat2_num', '200+' ) ); ?></strong>
                    <span><?php echo esc_html( qc_mod( 'qc_stat2_label', __( 'Weekly Guests', 'quiet-cafe' ) ) ); ?></span>
                </div>
                <div class="hero__stat" role="listitem">
                    <strong><?php echo esc_html( qc_mod( 'qc_stat3_num', '4.9★' ) ); ?></strong>
                    <span><?php echo esc_html( qc_mod( 'qc_stat3_label', __( 'Avg. Rating', 'quiet-cafe' ) ) ); ?></span>
                </div>
            </div>

        </div><!-- .hero__left -->

        <div class="hero__right" aria-hidden="true">
            <div class="hero__bg-slab"></div>

            <div class="hero__img-main">
                <?php
                $hero_img_id = get_theme_mod( 'qc_hero_main_image' );
                if ( $hero_img_id ) {
                    echo wp_get_attachment_image( $hero_img_id, 'qc-hero', false, [ 'alt' => esc_attr__( 'Expertly crafted latte', 'quiet-cafe' ) ] );
                } else {
                ?>
                <img
                    src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&q=80"
                    alt="<?php esc_attr_e( 'Expertly crafted latte on a marble counter', 'quiet-cafe' ); ?>"
                    loading="eager"
                    width="800"
                    height="1067"
                />
                <?php } ?>
            </div>

            <div class="hero__img-accent">
                <?php
                $accent_id = get_theme_mod( 'qc_hero_accent_image' );
                if ( $accent_id ) {
                    echo wp_get_attachment_image( $accent_id, 'qc-card', false, [ 'alt' => '' ] );
                } else {
                ?>
                <img
                    src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=500&q=80"
                    alt=""
                    loading="lazy"
                    width="500"
                    height="375"
                />
                <?php } ?>
            </div>

            <div class="hero__award" aria-label="<?php esc_attr_e( 'Specialty Coffee Award 2024', 'quiet-cafe' ); ?>">
                Specialty<br>Coffee<br>Award<br>2024
            </div>
        </div><!-- .hero__right -->

    </section><!-- #home -->


    <!-- ═══════════════════════════════════════
         MARQUEE TICKER
    ═══════════════════════════════════════ -->
    <div class="marquee-bar" role="marquee" aria-label="<?php esc_attr_e( 'Key features', 'quiet-cafe' ); ?>">
        <div class="marquee-bar__track" aria-hidden="true">
            <?php
            $items = [
                __( 'Ethically Sourced Beans', 'quiet-cafe' ),
                __( 'Single Origin Roasts',    'quiet-cafe' ),
                __( 'Plant-Based Options',     'quiet-cafe' ),
                __( 'House-Baked Pastries',    'quiet-cafe' ),
                __( 'Free WiFi',               'quiet-cafe' ),
                __( 'Dog Friendly',            'quiet-cafe' ),
                // Duplicate for seamless loop
                __( 'Ethically Sourced Beans', 'quiet-cafe' ),
                __( 'Single Origin Roasts',    'quiet-cafe' ),
                __( 'Plant-Based Options',     'quiet-cafe' ),
                __( 'House-Baked Pastries',    'quiet-cafe' ),
                __( 'Free WiFi',               'quiet-cafe' ),
                __( 'Dog Friendly',            'quiet-cafe' ),
            ];
            foreach ( $items as $item ) {
                echo '<span class="marquee-bar__item">' . esc_html( $item ) . '</span>';
            }
            ?>
        </div>
    </div>


    <!-- ═══════════════════════════════════════
         ABOUT SECTION
    ═══════════════════════════════════════ -->
    <section id="about" class="about-section" aria-label="<?php esc_attr_e( 'About The Quiet Café', 'quiet-cafe' ); ?>">

        <div class="about-section__visual">
            <?php
            $about_img_id = get_theme_mod( 'qc_about_image' );
            if ( $about_img_id ) {
                echo wp_get_attachment_image( $about_img_id, 'full', false, [ 'alt' => esc_attr__( 'Inside The Quiet Café', 'quiet-cafe' ) ] );
            } else {
            ?>
            <img
                src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900&q=80"
                alt="<?php esc_attr_e( 'Warm café interior with exposed brick walls and Edison bulbs', 'quiet-cafe' ); ?>"
                loading="lazy"
                width="900"
                height="600"
            />
            <?php } ?>
            <div class="about-section__overlay" aria-hidden="true"></div>
            <blockquote class="about-section__quote">
                <?php echo esc_html( qc_mod( 'qc_about_quote', '"The best coffee is the kind you linger over — no rush, no noise, just warmth."' ) ); ?>
            </blockquote>
        </div>

        <div class="about-section__content reveal">
            <span class="section-tag"><?php esc_html_e( 'Our Story', 'quiet-cafe' ); ?></span>
            <h2><?php esc_html_e( 'A Café Built for', 'quiet-cafe' ); ?> <em><?php esc_html_e( 'Slowness', 'quiet-cafe' ); ?></em></h2>

            <?php
            // Display the page content if this is a static front page
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            else :
            ?>
            <p><?php esc_html_e( 'Born from a love of unhurried mornings and real community, The Quiet Café opened its doors in 2018 with one simple idea: a place where time slows down just enough for life to happen.', 'quiet-cafe' ); ?></p>
            <p><?php esc_html_e( 'Every bean is selected with intention. Every cup is crafted by hand. Every corner of our space was designed to feel like home — yours.', 'quiet-cafe' ); ?></p>
            <?php endif; ?>

            <div class="about-section__features" role="list">
                <?php
                $features = [
                    [ 'icon' => '☕', 'title' => __( 'Specialty Roasts',    'quiet-cafe' ), 'desc' => __( 'Single-origin beans from 12 countries',   'quiet-cafe' ) ],
                    [ 'icon' => '🌿', 'title' => __( 'Sustainably Sourced', 'quiet-cafe' ), 'desc' => __( 'Direct trade, fair wages, real impact',     'quiet-cafe' ) ],
                    [ 'icon' => '🍞', 'title' => __( 'Baked Daily',         'quiet-cafe' ), 'desc' => __( 'Pastries made fresh every morning',         'quiet-cafe' ) ],
                    [ 'icon' => '🎵', 'title' => __( 'Curated Ambiance',    'quiet-cafe' ), 'desc' => __( 'Analog sounds, zero notifications',         'quiet-cafe' ) ],
                ];
                foreach ( $features as $f ) : ?>
                <div class="feature-item" role="listitem">
                    <div class="feature-item__icon" aria-hidden="true"><?php echo esc_html( $f['icon'] ); ?></div>
                    <div>
                        <strong><?php echo esc_html( $f['title'] ); ?></strong>
                        <span><?php echo esc_html( $f['desc'] ); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div><!-- .about-section__content -->

    </section><!-- #about -->


    <!-- ═══════════════════════════════════════
         MENU SECTION
    ═══════════════════════════════════════ -->
    <section id="menu" class="menu-section" aria-label="<?php esc_attr_e( 'Our Menu', 'quiet-cafe' ); ?>">
        <?php get_template_part( 'template-parts/menu', 'section' ); ?>
    </section><!-- #menu -->


    <!-- ═══════════════════════════════════════
         GALLERY STRIP
    ═══════════════════════════════════════ -->
    <?php get_template_part( 'template-parts/gallery', 'strip' ); ?>


    <!-- ═══════════════════════════════════════
         RESERVATIONS SECTION
    ═══════════════════════════════════════ -->
    <section id="reservations" class="reservations-section" aria-label="<?php esc_attr_e( 'Make a Reservation', 'quiet-cafe' ); ?>">
        <?php get_template_part( 'template-parts/reservations', 'form' ); ?>
    </section><!-- #reservations -->


    <!-- ═══════════════════════════════════════
         LOCATION SECTION
    ═══════════════════════════════════════ -->
    <section id="location" class="location-section" aria-label="<?php esc_attr_e( 'Our Location', 'quiet-cafe' ); ?>">
        <?php get_template_part( 'template-parts/location', 'info' ); ?>
    </section><!-- #location -->


    <!-- ═══════════════════════════════════════
         CONTACT SECTION
    ═══════════════════════════════════════ -->
    <section id="contact" class="contact-section" aria-label="<?php esc_attr_e( 'Contact Us', 'quiet-cafe' ); ?>">
        <?php get_template_part( 'template-parts/contact', 'section' ); ?>
    </section><!-- #contact -->

</main><!-- #main-content -->

<?php get_footer(); ?>
