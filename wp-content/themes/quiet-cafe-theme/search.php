<?php
/**
 * search.php – Search results template
 * @package QuietCafe
 */
get_header();
?>

<main id="main-content" class="content-area" role="main">

    <header style="margin-bottom:3rem;padding-bottom:2rem;border-bottom:1px solid var(--qc-light-amber)">
        <span class="section-tag"><?php esc_html_e( 'Search Results', 'quiet-cafe' ); ?></span>
        <h1>
            <?php
            printf(
                /* translators: %s = search query */
                esc_html__( 'Results for: %s', 'quiet-cafe' ),
                '<em>' . esc_html( get_search_query() ) . '</em>'
            );
            ?>
        </h1>
        <?php if ( have_posts() ) : ?>
        <p style="margin-top:.5rem;font-size:.9rem">
            <?php printf( esc_html( _n( '%d result found', '%d results found', $wp_query->found_posts, 'quiet-cafe' ) ), intval( $wp_query->found_posts ) ); ?>
        </p>
        <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>

        <div class="posts-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:2rem">
            <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> style="border:1px solid var(--qc-light-amber);border-radius:var(--qc-radius);overflow:hidden">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php the_post_thumbnail( 'qc-card', [ 'style' => 'width:100%;height:200px;object-fit:cover;display:block' ] ); ?>
                </a>
                <?php endif; ?>
                <div style="padding:1.5rem">
                    <p style="font-size:.75rem;color:var(--qc-muted);margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.08em">
                        <?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?>
                    </p>
                    <h2 style="font-size:1.15rem;margin-bottom:.5rem">
                        <a href="<?php the_permalink(); ?>" style="color:var(--qc-espresso)"><?php the_title(); ?></a>
                    </h2>
                    <p style="font-size:.85rem"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn--outline" style="margin-top:1rem;font-size:.75rem;padding:.55rem 1.1rem">
                        <?php esc_html_e( 'Read More', 'quiet-cafe' ); ?>
                    </a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <div style="margin-top:3rem;display:flex;justify-content:center">
            <?php the_posts_pagination( [ 'mid_size' => 2 ] ); ?>
        </div>

    <?php else : ?>

        <div style="text-align:center;padding:3rem 2rem;background:var(--qc-light-amber);border-radius:var(--qc-radius)">
            <span style="font-size:3rem;display:block;margin-bottom:1rem" aria-hidden="true">🔍</span>
            <h2 style="margin-bottom:.8rem"><?php esc_html_e( 'Nothing found', 'quiet-cafe' ); ?></h2>
            <p style="margin-bottom:1.5rem">
                <?php esc_html_e( 'No results for that search. Try different keywords, or explore the menu below.', 'quiet-cafe' ); ?>
            </p>
            <?php get_search_form(); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary" style="margin-top:1.5rem">
                <?php esc_html_e( '← Back to Home', 'quiet-cafe' ); ?>
            </a>
        </div>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
