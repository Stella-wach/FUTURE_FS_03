<?php
/**
 * index.php – Blog / Archive fallback template
 * @package QuietCafe
 */
get_header();
?>

<main id="main-content" class="content-area" role="main">

    <?php if ( have_posts() ) : ?>

        <header class="page-header" style="margin-bottom:3rem">
            <?php
            if ( is_home() && ! is_front_page() ) {
                single_post_title( '<h1 class="page-title">', '</h1>' );
            } elseif ( is_archive() ) {
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
            } elseif ( is_search() ) {
                printf(
                    '<h1 class="page-title">' . esc_html__( 'Results for: %s', 'quiet-cafe' ) . '</h1>',
                    get_search_query()
                );
            }
            ?>
        </header>

        <div class="posts-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:2rem">
            <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> style="border:1px solid var(--qc-light-amber);border-radius:var(--qc-radius);overflow:hidden">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php the_post_thumbnail( 'qc-card', [ 'style' => 'width:100%;height:220px;object-fit:cover;display:block' ] ); ?>
                </a>
                <?php endif; ?>
                <div style="padding:1.5rem">
                    <div class="entry-meta" style="font-size:.78rem;color:var(--qc-muted);margin-bottom:.5rem">
                        <?php echo get_the_date(); ?>
                    </div>
                    <h2 style="font-size:1.2rem;margin-bottom:.5rem">
                        <a href="<?php the_permalink(); ?>" style="color:var(--qc-espresso)"><?php the_title(); ?></a>
                    </h2>
                    <p style="font-size:.88rem"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn--outline" style="margin-top:1rem;font-size:.75rem;padding:.6rem 1.2rem">
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

        <div style="text-align:center;padding:4rem 2rem">
            <h2><?php esc_html_e( 'Nothing found', 'quiet-cafe' ); ?></h2>
            <p><?php esc_html_e( 'Try a different search or head back home.', 'quiet-cafe' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary" style="margin-top:1.5rem">
                <?php esc_html_e( '← Back to Home', 'quiet-cafe' ); ?>
            </a>
        </div>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
