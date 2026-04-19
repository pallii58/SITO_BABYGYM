<?php
/**
 * Template principale (sito reale per chi non è in manutenzione).
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="primary" class="site-main">
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    }
} else {
    ?>
    <p class="no-results"><?php echo esc_html__('Nessun contenuto da mostrare.', 'babygym'); ?></p>
    <?php
}
?>
</main>
<?php
get_footer();
