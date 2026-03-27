<?php
/**
 * sidebar.php – Blog sidebar with widgets
 * @package QuietCafe
 */

if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'quiet-cafe' ); ?>">
    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
</aside>
