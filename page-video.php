<?php
/**
 * Pagina "Video".
 *
 * Crea una pagina WordPress con permalink "video" per usare questo template.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $embed_srcs = function_exists('babygym_get_video_embed_src_list') ? babygym_get_video_embed_src_list() : [];

    $yt_handle = function_exists('babygym_get_youtube_channel_handle') ? babygym_get_youtube_channel_handle() : 'babygym5384';
    $yt_videos_url = 'https://www.youtube.com/@' . rawurlencode($yt_handle) . '/videos';

    ?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page video-page">
        <section class="video-page__hero filosofia-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html(get_the_title() ?: __('Video', 'babygym')); ?></h1>
            <p class="filosofia-lead video-page__lead"><?php echo esc_html__('Tutti i video del nostro canale YouTube: aggiornati automaticamente quando pubblichiamo qualcosa di nuovo.', 'babygym'); ?></p>
            <p class="video-page__channel-link-wrap">
                <a class="btn-primary video-page__channel-link" href="<?php echo esc_url($yt_videos_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Canale Baby Gym su YouTube', 'babygym'); ?></a>
            </p>
        </section>

        <?php if ([] !== $embed_srcs) : ?>
            <section class="video-page__gallery card" aria-label="<?php echo esc_attr__('Galleria video', 'babygym'); ?>">
                <h2 class="video-page__section-title video-page__section-title--accent"><?php echo esc_html__('Tutti i video', 'babygym'); ?></h2>
                <div class="video-grid">
                    <?php foreach ($embed_srcs as $index => $src) : ?>
                        <div class="video-embed video-embed--card">
                            <iframe
                                class="video-embed__iframe"
                                src="<?php echo esc_url($src); ?>"
                                title="<?php echo esc_attr(sprintf(/* translators: %d: video ordinal */ __('Video Baby Gym %d', 'babygym'), (int) $index + 1)); ?>"
                                loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen
                            ></iframe>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ([] === $embed_srcs) : ?>
            <section class="video-page__empty card card--soft">
                <p class="video-page__empty-text"><?php echo esc_html__('Al momento non siamo riusciti a caricare i video del canale. Riprova tra poco.', 'babygym'); ?></p>
                <?php if (current_user_can('edit_theme_options')) : ?>
                    <p class="video-page__hint">
                        <?php
                        echo wp_kses_post(
                            sprintf(
                                /* translators: %s: Appearance > Customize link */
                                __('Controlla in %s → Pagina Video (YouTube) l’handle del canale e, se vuoi l’elenco completo, la chiave Data API.', 'babygym'),
                                '<a href="' . esc_url(admin_url('customize.php?autofocus[section]=babygym_video_section')) . '">' . esc_html__('Personalizza', 'babygym') . '</a>'
                            )
                        );
                        ?>
                    </p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if (trim((string) get_the_content()) !== '') : ?>
            <section class="video-page__editorial card">
                <div class="entry-content entry-content--video"><?php the_content(); ?></div>
            </section>
        <?php endif; ?>
    </article>
</main>
    <?php
endwhile;

get_footer();
