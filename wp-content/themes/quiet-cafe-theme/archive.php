<?php
/**
 * archive.php – Category, tag, date, author archives
 * @package QuietCafe
 */
get_header();
?>

<main id="main-content" class="content-area" role="main">

    <?php if ( have_posts() ) : ?>

        <header style="margin-bottom:3rem;padding-bottom:2rem;border-bottom:1px solid var(--qc-light-amber)">
            <?php
            if ( is_category() ) :
                echo '<span class="section-tag">' . esc_html__( 'Category', 'quiet-cafe' ) . '</span>';
            elseif ( is_tag() ) :
                echo '<span class="section-tag">' . esc_html__( 'Tag', 'quiet-cafe' ) . '</span>';
            elseif ( is_author() ) :
                echo '<span class="section-tag">' . esc_html__( 'Author', 'quiet-cafe' ) . '</span>';
            elseif ( is_date() ) :
                echo '<span class="section-tag">' . esc_html__( 'Archive', 'quiet-cafe' ) . '</span>';
            endif;

            the_archive_title( '<h1>', '</h1>' );
            the_archive_description( '<p style="margin-top:.5rem;color:var(--qc-muted)">', '</p>' );
            ?>
        </header>

        <div class="posts-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:2rem">
            <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> style="border:1px solid var(--qc-light-amber);border-radius:var(--qc-radius);overflow:hidden;transition:box-shadow .25s">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php the_post_thumbnail( 'qc-card', [ 'style' => 'width:100%;height:210px;object-fit:cover;display:block' ] ); ?>
                </a>
                <?php endif; ?>
                <div style="padding:1.5rem">
                    <p style="font-size:.75rem;color:var(--qc-muted);margin-bottom:.4rem"><?php echo get_the_date(); ?></p>
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
        <p><?php esc_html_e( 'Nothing to show here yet.', 'quiet-cafe' ); ?></p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
