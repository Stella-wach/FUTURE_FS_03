<?php
/**
 * Template Part: content-post.php
 * Reusable article card used in index.php, archive.php, search.php
 * @package QuietCafe
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> style="border:1px solid var(--qc-light-amber);border-radius:var(--qc-radius);overflow:hidden;transition:box-shadow .25s ease">

    <?php if ( has_post_thumbnail() ) : ?>
    <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php the_post_thumbnail( 'qc-card', [ 'style' => 'width:100%;height:215px;object-fit:cover;display:block;transition:transform .4s ease', 'class' => 'post-card__image' ] ); ?>
    </a>
    <?php endif; ?>

    <div style="padding:1.5rem">

        <!-- Category pill -->
        <?php
        $cats = get_the_category();
        if ( $cats ) :
            $cat = $cats[0];
        ?>
        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
           style="display:inline-block;font-size:.68rem;letter-spacing:.12em;text-transform:uppercase;background:var(--qc-light-amber);color:var(--qc-amber);padding:.25rem .7rem;border-radius:2px;text-decoration:none;margin-bottom:.6rem;font-weight:600">
            <?php echo esc_html( $cat->name ); ?>
        </a>
        <?php endif; ?>

        <!-- Title -->
        <h2 style="font-size:1.15rem;line-height:1.25;margin-bottom:.5rem">
            <a href="<?php the_permalink(); ?>"
               style="color:var(--qc-espresso);text-decoration:none"
               onmouseover="this.style.color='var(--qc-amber)'"
               onmouseout="this.style.color='var(--qc-espresso)'">
                <?php the_title(); ?>
            </a>
        </h2>

        <!-- Excerpt -->
        <p style="font-size:.85rem;line-height:1.65;margin-bottom:1.2rem"><?php the_excerpt(); ?></p>

        <!-- Footer: date + read more -->
        <div style="display:flex;align-items:center;justify-content:space-between;font-size:.76rem">
            <time datetime="<?php echo get_the_date( 'c' ); ?>" style="color:var(--qc-muted)">
                <?php echo get_the_date(); ?>
            </time>
            <a href="<?php the_permalink(); ?>"
               style="color:var(--qc-amber);font-weight:500;letter-spacing:.06em;text-decoration:none;text-transform:uppercase;font-size:.72rem"
               aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'quiet-cafe' ), get_the_title() ) ); ?>">
                <?php esc_html_e( 'Read →', 'quiet-cafe' ); ?>
            </a>
        </div>

    </div>
</article>
