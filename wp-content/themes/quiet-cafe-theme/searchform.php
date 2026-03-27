<?php
/**
 * searchform.php – Custom search form
 * Called via get_search_form()
 * @package QuietCafe
 */
$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo $unique_id; ?>" class="sr-only">
        <?php esc_html_e( 'Search', 'quiet-cafe' ); ?>
    </label>
    <div style="display:flex;gap:.5rem">
        <input
            type="search"
            id="<?php echo $unique_id; ?>"
            class="search-field"
            placeholder="<?php esc_attr_e( 'Search…', 'quiet-cafe' ); ?>"
            value="<?php echo get_search_query(); ?>"
            name="s"
            style="flex:1;padding:.75rem 1rem;border:1.5px solid #e0d5c5;font-family:inherit;font-size:.9rem;border-radius:2px;outline:none"
        />
        <button type="submit" class="search-submit btn btn--primary" style="padding:.75rem 1.2rem;font-size:.8rem">
            <span class="sr-only"><?php esc_html_e( 'Search', 'quiet-cafe' ); ?></span>
            <span aria-hidden="true">→</span>
        </button>
    </div>
</form>
