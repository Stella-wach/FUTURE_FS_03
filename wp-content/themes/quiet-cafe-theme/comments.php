<?php
/**
 * comments.php – Comments list and form
 * @package QuietCafe
 */

if ( post_password_required() ) {
    echo '<p>' . esc_html__( 'This post is password-protected. Enter the password to view comments.', 'quiet-cafe' ) . '</p>';
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title" style="font-size:1.5rem;margin-bottom:2rem">
            <?php
            printf(
                esc_html( _nx(
                    '%1$s comment on "%2$s"',
                    '%1$s comments on "%2$s"',
                    get_comments_number(),
                    'comments title',
                    'quiet-cafe'
                ) ),
                number_format_i18n( get_comments_number() ),
                '<em>' . get_the_title() . '</em>'
            );
            ?>
        </h2>

        <ol class="comment-list" style="list-style:none;padding:0">
            <?php
            wp_list_comments( [
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'qc_comment_callback',
            ] );
            ?>
        </ol>

        <?php the_comments_pagination( [ 'prev_text' => '←', 'next_text' => '→' ] ); ?>

    <?php endif; ?>

    <?php
    // Comment form styling
    $args = [
        'title_reply'          => '<span style="font-family:var(--qc-font-display);font-size:1.4rem">' . esc_html__( 'Leave a Comment', 'quiet-cafe' ) . '</span>',
        'title_reply_to'       => esc_html__( 'Reply to %s', 'quiet-cafe' ),
        'cancel_reply_link'    => esc_html__( 'Cancel', 'quiet-cafe' ),
        'label_submit'         => esc_html__( 'Post Comment', 'quiet-cafe' ),
        'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn btn--primary" style="margin-top:.5rem" value="%4$s">%4$s</button>',
        'comment_notes_before' => '',
        'fields' => [
            'author' => '<div class="comment-form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem"><p class="comment-form-author"><label for="author" style="display:block;font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600;margin-bottom:.35rem">' . esc_html__( 'Name', 'quiet-cafe' ) . ' <span aria-hidden="true">*</span></label><input id="author" name="author" type="text" style="width:100%;padding:.8rem 1rem;border:1.5px solid #e0d5c5;font-family:inherit;border-radius:2px" required autocomplete="name" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email" style="display:block;font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600;margin-bottom:.35rem">' . esc_html__( 'Email', 'quiet-cafe' ) . ' <span aria-hidden="true">*</span></label><input id="email" name="email" type="email" style="width:100%;padding:.8rem 1rem;border:1.5px solid #e0d5c5;font-family:inherit;border-radius:2px" required autocomplete="email" /></p></div>',
            'url'    => '',
            'cookies'=> '',
        ],
        'comment_field' => '<p><label for="comment" style="display:block;font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600;margin-bottom:.35rem">' . esc_html__( 'Your Comment', 'quiet-cafe' ) . ' <span aria-hidden="true">*</span></label><textarea id="comment" name="comment" rows="5" style="width:100%;padding:.8rem 1rem;border:1.5px solid #e0d5c5;font-family:inherit;border-radius:2px;resize:vertical" required aria-required="true"></textarea></p>',
    ];
    comment_form( $args );
    ?>

</div><!-- #comments -->

<?php
/**
 * Custom comment callback for clean markup
 */
function qc_comment_callback( $comment, $args, $depth ) {
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-item' ); ?> style="padding:1.5rem 0;border-bottom:1px solid var(--qc-light-amber)">
        <article>
            <header style="display:flex;gap:1rem;align-items:flex-start;margin-bottom:.8rem">
                <div style="flex-shrink:0;border-radius:50%;overflow:hidden">
                    <?php echo get_avatar( $comment, 48, '', '', [ 'class' => 'comment-avatar' ] ); ?>
                </div>
                <div>
                    <strong style="display:block;font-size:.9rem">
                        <?php comment_author_link(); ?>
                    </strong>
                    <time datetime="<?php comment_time( 'c' ); ?>" style="font-size:.78rem;color:var(--qc-muted)">
                        <?php comment_date(); ?> <?php esc_html_e( 'at', 'quiet-cafe' ); ?> <?php comment_time(); ?>
                    </time>
                </div>
                <div style="margin-left:auto">
                    <?php
                    comment_reply_link( array_merge( $args, [
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<span style="font-size:.78rem;">',
                        'after'     => '</span>',
                    ] ) );
                    ?>
                </div>
            </header>
            <?php if ( '0' === $comment->comment_approved ) : ?>
            <p style="font-size:.82rem;color:var(--qc-muted);font-style:italic"><?php esc_html_e( 'Your comment is awaiting moderation.', 'quiet-cafe' ); ?></p>
            <?php endif; ?>
            <div class="comment-content" style="font-size:.92rem;line-height:1.75">
                <?php comment_text(); ?>
            </div>
        </article>
    <?php
    // Note: </li> is handled by wp_list_comments
}
