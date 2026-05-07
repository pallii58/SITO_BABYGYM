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
    $featured   = $embed_srcs[0] ?? null;
    $rest       = [] === $embed_srcs ? [] : array_slice($embed_srcs, 1);

    ?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page video-page">
        <section class="video-page__hero filosofia-hero card card--centered">
            <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
            <h1 class="feste-hero__title"><?php echo esc_html(get_the_title() ?: __('Video', 'babygym')); ?></h1>
            <p class="filosofia-lead video-page__lead"><?php echo esc_html__('Scopri il Baby Gym in movimento: i nostri allenamenti, le feste e i momenti in palestra.', 'babygym'); ?></p>
        </section>

        <?php if (null !== $featured) : ?>
            <section class="video-page__featured card card--soft" aria-label="<?php echo esc_attr__('Video in primo piano', 'babygym'); ?>">
                <h2 class="video-page__section-title"><?php echo esc_html__('In evidenza', 'babygym'); ?></h2>
                <div class="video-embed video-embed--featured">
                    <iframe
                        class="video-embed__iframe"
                        src="<?php echo esc_url($featured); ?>"
                        title="<?php echo esc_attr__('Video Baby Gym in evidenza', 'babygym'); ?>"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                    ></iframe>
                </div>
            </section>
        <?php endif; ?>

        <?php if ([] !== $rest) : ?>
            <section class="video-page__library card" aria-label="<?php echo esc_attr__('Altri video', 'babygym'); ?>">
                <h2 class="video-page__section-title"><?php echo esc_html__('Altri video', 'babygym'); ?></h2>
                <div class="video-grid">
                    <?php foreach ($rest as $index => $src) : ?>
                        <div class="video-embed video-embed--card">
                            <iframe
                                class="video-embed__iframe"
                                src="<?php echo esc_url($src); ?>"
                                title="<?php echo esc_attr(sprintf(/* translators: %d: video number */ __('Video Baby Gym %d', 'babygym'), (int) $index + 2)); ?>"
                                loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen
                            ></iframe>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (null === $featured && [] === $rest) : ?>
            <section class="video-page__empty card card--soft">
                <p class="video-page__empty-text"><?php echo esc_html__('Presto pubblicheremo i nostri video. Torna a trovarci.', 'babygym'); ?></p>
                <?php if (current_user_can('edit_theme_options')) : ?>
                    <p class="video-page__hint">
                        <?php
                        echo wp_kses_post(
                            sprintf(
                                /* translators: %s: Appearance > Customize link */
                                __('Per aggiungere embed: vai su %s → Pagina Video e incolla gli URL (uno per riga).', 'babygym'),
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
