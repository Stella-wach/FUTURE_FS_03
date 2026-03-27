<?php
/**
 * Template Part: Menu Section
 * @package QuietCafe
 */

// Get menu categories
$categories = get_terms( [
    'taxonomy'   => 'qc_menu_category',
    'hide_empty' => true,
] );

// Fallback static data if no CPT items exist yet
$fallback = [
    'coffee' => [
        [ 'emoji' => '☕', 'name' => 'Espresso',          'desc' => 'Pure, concentrated, unapologetically bold. Our house blend, pulled to perfection.',                  'price' => 'KES 350' ],
        [ 'emoji' => '🥛', 'name' => 'Flat White',         'desc' => 'Velvety microfoam meets rich double ristretto. The purist\'s daily ritual.',                         'price' => 'KES 480' ],
        [ 'emoji' => '🌊', 'name' => 'Cold Brew',          'desc' => 'Steeped 18 hours, silky-smooth, served over crystal ice.',                                           'price' => 'KES 520' ],
        [ 'emoji' => '🍵', 'name' => 'Matcha Latte',       'desc' => 'Ceremonial grade matcha, oat milk, a whisper of honey. Gentle energy.',                             'price' => 'KES 550' ],
        [ 'emoji' => '✨', 'name' => 'Signature Pour-Over', 'desc' => 'Rotating single-origin. Ask your barista today\'s provenance — always a story.',                    'price' => 'KES 600' ],
        [ 'emoji' => '🍫', 'name' => 'Mocha',              'desc' => 'Dark Kenyan chocolate, double espresso, steamed milk. Comfort in a cup.',                           'price' => 'KES 490' ],
    ],
    'food' => [
        [ 'emoji' => '🥐', 'name' => 'Butter Croissant', 'desc' => 'Laminated dough, 72 layers, baked until amber. Best the moment it cools.',             'price' => 'KES 350' ],
        [ 'emoji' => '🍳', 'name' => 'Avocado Toast',    'desc' => 'Sourdough, smashed avo, chilli flakes, lemon zest, a perfect egg.',                    'price' => 'KES 750' ],
        [ 'emoji' => '🫐', 'name' => 'Acai Bowl',        'desc' => 'Wild blueberry base, granola, fresh fruit, agave. Eat with your eyes first.',          'price' => 'KES 850' ],
        [ 'emoji' => '🧀', 'name' => 'Cheese Scone',     'desc' => 'Gruyère-studded, fresh from the oven, butter on the side.',                            'price' => 'KES 300' ],
        [ 'emoji' => '🥗', 'name' => 'Grain Bowl',       'desc' => 'Quinoa, roasted veg, tahini dressing, seeds. Light but deeply satisfying.',            'price' => 'KES 950' ],
        [ 'emoji' => '🍰', 'name' => 'Olive Oil Cake',   'desc' => 'Lemon, almond, a drizzle of honey. The kind of cake that needs no occasion.',          'price' => 'KES 400' ],
    ],
    'drinks' => [
        [ 'emoji' => '🌸', 'name' => 'Hibiscus Lemonade',     'desc' => 'House-brewed hibiscus, fresh lemon, raw cane sugar. Tart, vibrant, alive.',        'price' => 'KES 400' ],
        [ 'emoji' => '🫖', 'name' => 'Masala Chai',            'desc' => 'Cardamom, ginger, black pepper, full-fat milk. Warming from the inside.',         'price' => 'KES 420' ],
        [ 'emoji' => '🥤', 'name' => 'Mango Smoothie',         'desc' => 'Kenyan mangoes, coconut milk, turmeric. Thick, tropical, totally addictive.',     'price' => 'KES 480' ],
        [ 'emoji' => '🍵', 'name' => 'Herbal Infusions',       'desc' => 'Camomile, peppermint, rooibos. Loose leaf. Served in a beautiful pot.',           'price' => 'KES 380' ],
        [ 'emoji' => '🫧', 'name' => 'Butterfly Pea Latte',   'desc' => 'Colour-changing magic. Lemon, oat milk, butterfly pea flower.',                   'price' => 'KES 520' ],
        [ 'emoji' => '🍋', 'name' => 'Sparkling Water',        'desc' => 'Chilled, lightly effervescent, with cucumber or mint.',                           'price' => 'KES 250' ],
    ],
];

$tab_labels = [
    'coffee' => __( 'Coffee',  'quiet-cafe' ),
    'food'   => __( 'Food',    'quiet-cafe' ),
    'drinks' => __( 'Drinks',  'quiet-cafe' ),
];
?>

<div class="menu-section__header">
    <div>
        <span class="section-tag"><?php esc_html_e( 'What We Serve', 'quiet-cafe' ); ?></span>
        <h2 style="color:var(--qc-cream)"><?php esc_html_e( 'Our', 'quiet-cafe' ); ?> <em><?php esc_html_e( 'Menu', 'quiet-cafe' ); ?></em></h2>
    </div>

    <div class="menu-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Menu categories', 'quiet-cafe' ); ?>">
        <?php $first = true; foreach ( $tab_labels as $slug => $label ) : ?>
        <button
            class="menu-tab <?php echo $first ? 'is-active' : ''; ?>"
            role="tab"
            data-tab="<?php echo esc_attr( $slug ); ?>"
            aria-selected="<?php echo $first ? 'true' : 'false'; ?>"
            aria-controls="menu-panel-<?php echo esc_attr( $slug ); ?>"
            id="menu-tab-<?php echo esc_attr( $slug ); ?>"
        >
            <?php echo esc_html( $label ); ?>
        </button>
        <?php $first = false; endforeach; ?>
    </div>
</div>

<?php
$first = true;
foreach ( $tab_labels as $slug => $label ) :
    $use_cpt = false;
    if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
        foreach ( $categories as $cat ) {
            if ( $cat->slug === $slug ) { $use_cpt = true; break; }
        }
    }
?>
<div
    id="menu-panel-<?php echo esc_attr( $slug ); ?>"
    class="menu-panel <?php echo $first ? 'is-active' : ''; ?>"
    role="tabpanel"
    aria-labelledby="menu-tab-<?php echo esc_attr( $slug ); ?>"
>
    <?php if ( $use_cpt ) :
        $query = qc_get_menu_items( $slug );
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                $price = get_post_meta( get_the_ID(), '_qc_price', true );
                $emoji = get_post_meta( get_the_ID(), '_qc_emoji', true ) ?: '☕';
    ?>
    <article class="menu-card">
        <span class="menu-card__emoji" aria-hidden="true"><?php echo esc_html( $emoji ); ?></span>
        <div class="menu-card__name"><?php the_title(); ?></div>
        <p class="menu-card__desc"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
        <?php if ( $price ) : ?>
        <span class="menu-card__price"><?php echo esc_html( $price ); ?></span>
        <?php endif; ?>
    </article>
    <?php
            endwhile;
            wp_reset_postdata();
        endif;

    else :
        // Use static fallback data
        foreach ( $fallback[ $slug ] as $item ) :
    ?>
    <article class="menu-card">
        <span class="menu-card__emoji" aria-hidden="true"><?php echo esc_html( $item['emoji'] ); ?></span>
        <div class="menu-card__name"><?php echo esc_html( $item['name'] ); ?></div>
        <p class="menu-card__desc"><?php echo esc_html( $item['desc'] ); ?></p>
        <span class="menu-card__price"><?php echo esc_html( $item['price'] ); ?></span>
    </article>
    <?php
        endforeach;
    endif;
    ?>
</div>
<?php
    $first = false;
endforeach;
