<?php
/**
 * single.php – Single post template
 * @package QuietCafe
 */
get_header();
?>
<main id="main-content" class="content-area" role="main">
    <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <span class="section-tag" style="color:var(--qc-amber)"><?php esc_html_e( 'From the Blog', 'quiet-cafe' ); ?></span>
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <div class="entry-meta">
                <?php printf( esc_html__( 'Published on %s', 'quiet-cafe' ), get_the_date() ); ?>
                <?php if ( get_the_author() ) printf( esc_html__( ' by %s', 'quiet-cafe' ), get_the_author() ); ?>
            </div>
        </header>
        <?php if ( has_post_thumbnail() ) : ?>
        <figure style="margin:2rem 0">
            <?php the_post_thumbnail( 'qc-hero', [ 'style' => 'width:100%;border-radius:var(--qc-radius)' ] ); ?>
        </figure>
        <?php endif; ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>
    <?php
        the_post_navigation( [
            'prev_text' => '← ' . __( 'Previous Post', 'quiet-cafe' ),
            'next_text' => __( 'Next Post', 'quiet-cafe' ) . ' →',
        ] );
        if ( comments_open() ) comments_template();
    endwhile;
    ?>
</main>
<?php get_footer(); ?>
