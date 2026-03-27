<?php
/**
 * inc/schema.php
 *
 * Outputs JSON-LD structured data (Schema.org) for:
 *  - LocalBusiness / CafeOrCoffeeShop
 *  - WebSite (SiteSearch)
 *  - BreadcrumbList (inner pages)
 *
 * Helps Google understand the business, show rich results,
 * and display opening hours, address, and ratings in search.
 *
 * @package QuietCafe
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output JSON-LD on every page load.
 */
function qc_output_schema() {
    // ── LocalBusiness ──────────────────────────────────
    $name    = get_bloginfo( 'name' );
    $desc    = get_bloginfo( 'description' );
    $url     = home_url( '/' );
    $logo    = has_custom_logo() ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '';
    $phone   = qc_mod( 'qc_phone',   '+254 700 000 000' );
    $email   = qc_mod( 'qc_email',   'hello@thequietcafe.co.ke' );
    $address = qc_mod( 'qc_address', '14 Woodvale Grove, Westlands, Nairobi' );
    $ig      = qc_mod( 'qc_instagram', '' );
    $fb      = qc_mod( 'qc_facebook',  '' );

    $same_as = array_filter( [ $ig, $fb ] );

    $local_business = [
        '@context'       => 'https://schema.org',
        '@type'          => [ 'CafeOrCoffeeShop', 'LocalBusiness' ],
        'name'           => $name,
        'description'    => $desc ?: 'A cozy specialty coffee café in Westlands, Nairobi.',
        'url'            => $url,
        'telephone'      => $phone,
        'email'          => $email,
        'address'        => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => '14 Woodvale Grove',
            'addressLocality' => 'Westlands',
            'addressRegion'   => 'Nairobi',
            'postalCode'      => '00800',
            'addressCountry'  => 'KE',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => -1.2641,
            'longitude' => 36.8019,
        ],
        'openingHoursSpecification' => [
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ],
                'opens'     => '07:00',
                'closes'    => '20:00',
            ],
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Saturday',
                'opens'     => '08:00',
                'closes'    => '21:00',
            ],
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Sunday',
                'opens'     => '09:00',
                'closes'    => '18:00',
            ],
        ],
        'priceRange'      => 'KES 250–950',
        'currenciesAccepted' => 'KES',
        'paymentAccepted'    => 'Cash, Card, M-Pesa',
        'servesCuisine'   => [ 'Coffee', 'Café Food', 'Pastries', 'Smoothies' ],
        'amenityFeature'  => [
            [ '@type' => 'LocationFeatureSpecification', 'name' => 'Wi-Fi',               'value' => true ],
            [ '@type' => 'LocationFeatureSpecification', 'name' => 'Outdoor Seating',      'value' => true ],
            [ '@type' => 'LocationFeatureSpecification', 'name' => 'Parking',              'value' => true ],
            [ '@type' => 'LocationFeatureSpecification', 'name' => 'Takeaway',             'value' => true ],
            [ '@type' => 'LocationFeatureSpecification', 'name' => 'Wheelchair Accessible','value' => true ],
        ],
        'hasMap' => 'https://maps.google.com/?q=' . rawurlencode( $address ),
    ];

    if ( $logo ) {
        $local_business['image'] = $logo;
        $local_business['logo']  = [ '@type' => 'ImageObject', 'url' => $logo ];
    }

    if ( ! empty( $same_as ) ) {
        $local_business['sameAs'] = array_values( $same_as );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $local_business, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . '</script>' . "\n";

    // ── WebSite / SiteSearch ──────────────────────────
    $website_schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        'url'             => $url,
        'name'            => $name,
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => $url . '?s={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $website_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";

    // ── BreadcrumbList (single posts & pages) ─────────
    if ( is_singular() && ! is_front_page() ) {
        $breadcrumb = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'name'     => __( 'Home', 'quiet-cafe' ),
                    'item'     => home_url( '/' ),
                ],
                [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => html_entity_decode( get_the_title() ),
                    'item'     => get_permalink(),
                ],
            ],
        ];

        echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'qc_output_schema' );


/**
 * Output a Menu schema when on the menu page or section.
 * Reads from CPT if available, otherwise uses static data.
 */
function qc_output_menu_schema() {
    // Only output on front page or a page using the menu template
    if ( ! is_front_page() && ! is_page_template( 'page-menu.php' ) ) return;

    $menu_sections = [];
    $categories    = get_terms( [ 'taxonomy' => 'qc_menu_category', 'hide_empty' => true ] );

    if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
        foreach ( $categories as $cat ) {
            $items_query = qc_get_menu_items( $cat->slug );
            $items       = [];

            if ( $items_query->have_posts() ) {
                while ( $items_query->have_posts() ) {
                    $items_query->the_post();
                    $price = get_post_meta( get_the_ID(), '_qc_price', true );
                    $items[] = [
                        '@type'       => 'MenuItem',
                        'name'        => get_the_title(),
                        'description' => get_the_excerpt(),
                        'offers'      => $price ? [
                            '@type'         => 'Offer',
                            'price'         => preg_replace( '/[^0-9.]/', '', $price ),
                            'priceCurrency' => 'KES',
                        ] : null,
                    ];
                }
                wp_reset_postdata();
            }

            if ( ! empty( $items ) ) {
                $menu_sections[] = [
                    '@type'           => 'MenuSection',
                    'name'            => $cat->name,
                    'hasMenuItem'     => $items,
                ];
            }
        }
    }

    if ( empty( $menu_sections ) ) return;

    $menu_schema = [
        '@context'       => 'https://schema.org',
        '@type'          => 'Menu',
        'name'           => get_bloginfo( 'name' ) . ' Menu',
        'url'            => home_url( '/#menu' ),
        'hasMenuSection' => $menu_sections,
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $menu_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'qc_output_menu_schema', 11 );
