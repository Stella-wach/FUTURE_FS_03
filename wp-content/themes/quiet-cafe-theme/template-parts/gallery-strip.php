<?php
/**
 * Template Part: Gallery Strip
 * @package QuietCafe
 */

$gallery_images = get_theme_mod( 'qc_gallery_images', [] );

$fallback_imgs = [
    [ 'src' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400&q=80', 'alt' => __( 'Latte art close-up', 'quiet-cafe' ) ],
    [ 'src' => 'https://images.unsplash.com/photo-1453614512568-c4024d13c247?w=400&q=80', 'alt' => __( 'Café interior seating', 'quiet-cafe' ) ],
    [ 'src' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=400&q=80', 'alt' => __( 'Fresh pastries on counter', 'quiet-cafe' ) ],
    [ 'src' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=400&q=80', 'alt' => __( 'Barista preparing espresso', 'quiet-cafe' ) ],
    [ 'src' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=400&q=80', 'alt' => __( 'Coffee beans close-up', 'quiet-cafe' ) ],
];
?>
<div class="gallery-strip" role="region" aria-label="<?php esc_attr_e( 'Café photo gallery', 'quiet-cafe' ); ?>">
    <?php if ( ! empty( $gallery_images ) ) :
        foreach ( array_slice( $gallery_images, 0, 5 ) as $img_id ) :
    ?>
    <div class="gallery-strip__cell">
        <?php echo wp_get_attachment_image( $img_id, 'qc-strip', false, [ 'loading' => 'lazy' ] ); ?>
    </div>
    <?php endforeach;
    else :
        foreach ( $fallback_imgs as $img ) : ?>
    <div class="gallery-strip__cell">
        <img src="<?php echo esc_url( $img['src'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" loading="lazy" width="400" height="280" />
    </div>
    <?php endforeach;
    endif; ?>
</div>
