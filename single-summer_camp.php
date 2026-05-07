<?php
/**
 * Single template Summer Camp.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page summer-camp-single">
        <?php
        while (have_posts()) :
            the_post();
            $post_id       = get_the_ID();
            $locandina_url = (string) get_post_meta($post_id, '_babygym_summer_camp_locandina_url', true);
            $gallery_raw   = (string) get_post_meta($post_id, '_babygym_summer_camp_gallery', true);
            $eta           = (string) get_post_meta($post_id, '_babygym_summer_camp_eta', true);
            $indirizzo     = (string) get_post_meta($post_id, '_babygym_summer_camp_indirizzo', true);
            $settimane     = (string) get_post_meta($post_id, '_babygym_summer_camp_settimane', true);
            $orario        = (string) get_post_meta($post_id, '_babygym_summer_camp_orario', true);
            $post_orario   = (string) get_post_meta($post_id, '_babygym_summer_camp_post_orario', true);
            $iscrizioni_entro = (string) get_post_meta($post_id, '_babygym_summer_camp_iscrizioni_entro', true);
            $note = (string) get_post_meta($post_id, '_babygym_summer_camp_note', true);
            $quota_assicurazione = (string) get_post_meta($post_id, '_babygym_summer_camp_quota_assicurazione_iscrizione', true);
            $descrizione   = (string) get_post_meta($post_id, '_babygym_summer_camp_descrizione', true);
            $gallery_urls  = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gallery_raw) ?: [])));
            $promo_videos  = babygym_summer_camp_get_promo_videos($post_id);

            $babygym_portal_registration = 'https://bgmsweb.azurewebsites.net/webregistration';
            $babygym_portal_login        = 'https://bgmsweb.azurewebsites.net/login';
            ?>
            <section class="filosofia-hero card card--centered">
                <p class="feste-eyebrow"><?php echo esc_html__('Summer Camp', 'babygym'); ?></p>
                <h1 class="feste-hero__title"><?php the_title(); ?></h1>
            </section>

            <section class="card summer-camp-product">
                <div class="summer-camp-product__media">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="summer-camp-single__cover">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ([] !== $gallery_urls) : ?>
                        <div class="summer-camp-single__gallery-carousel" data-summer-camp-single-carousel>
                            <button type="button" class="feste-carousel__nav feste-carousel__nav--prev" data-single-carousel-prev aria-label="<?php echo esc_attr__('Foto precedente', 'babygym'); ?>">
                                <span aria-hidden="true">&lsaquo;</span>
                            </button>
                            <div class="summer-camp-single__gallery-track" data-single-carousel-track>
                                <?php foreach ($gallery_urls as $gallery_url) : ?>
                                    <figure class="summer-camp-single__gallery-slide">
                                        <img src="<?php echo esc_url($gallery_url); ?>" alt="">
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="feste-carousel__nav feste-carousel__nav--next" data-single-carousel-next aria-label="<?php echo esc_attr__('Foto successiva', 'babygym'); ?>">
                                <span aria-hidden="true">&rsaquo;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="summer-camp-product__info">
                    <?php if ('' !== trim($descrizione)) : ?>
                        <div class="summer-camp-product__lead"><?php echo wp_kses_post(nl2br(esc_html($descrizione))); ?></div>
                    <?php endif; ?>

                    <div class="summer-camp-single__content">
                        <?php the_content(); ?>
                    </div>

                    <?php if ('' !== trim($eta) || '' !== trim($indirizzo) || '' !== trim($settimane) || '' !== trim($orario) || '' !== trim($post_orario) || '' !== trim($iscrizioni_entro) || '' !== trim($quota_assicurazione)) : ?>
                        <div class="summer-camp-single__details">
                            <h2><?php echo esc_html__('Informazioni camp', 'babygym'); ?></h2>
                            <ul class="corsi-list">
                                <?php if ('' !== trim($eta)) : ?>
                                    <li><strong><?php echo esc_html__('ETA\'', 'babygym'); ?>:</strong> <?php echo esc_html($eta); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($indirizzo)) : ?>
                                    <li><strong><?php echo esc_html__('INDIRIZZO', 'babygym'); ?>:</strong> <?php echo esc_html($indirizzo); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($settimane)) : ?>
                                    <li><strong><?php echo esc_html__('SETTIMANE', 'babygym'); ?>:</strong> <?php echo esc_html($settimane); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($orario)) : ?>
                                    <li><strong><?php echo esc_html__('ORARIO', 'babygym'); ?>:</strong> <?php echo esc_html($orario); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($post_orario)) : ?>
                                    <li><strong><?php echo esc_html__('POST', 'babygym'); ?>:</strong> <?php echo esc_html($post_orario); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($iscrizioni_entro)) : ?>
                                    <li><strong><?php echo esc_html__('ISCRIZIONI ENTRO', 'babygym'); ?>:</strong> <?php echo esc_html($iscrizioni_entro); ?></li>
                                <?php endif; ?>
                                <?php if ('' !== trim($quota_assicurazione)) : ?>
                                    <li><strong><?php echo esc_html__('QUOTA ASSICURAZIONE/ISCRIZIONE', 'babygym'); ?>:</strong> <?php echo esc_html($quota_assicurazione); ?></li>
                                <?php endif; ?>
                            </ul>

                            <div class="summer-camp-single__enroll">
                                <button
                                    type="button"
                                    class="btn-primary summer-camp-single__enroll-btn"
                                    data-enroll-modal-open
                                    aria-haspopup="dialog"
                                    aria-controls="babygym-summer-enroll-dialog"
                                ><?php echo esc_html__('Iscriviti', 'babygym'); ?></button>
                            </div>
                        </div>
                    <?php else : ?>

                        <div class="summer-camp-single__enroll summer-camp-single__enroll--standalone">
                            <button
                                type="button"
                                class="btn-primary summer-camp-single__enroll-btn"
                                data-enroll-modal-open
                                aria-haspopup="dialog"
                                aria-controls="babygym-summer-enroll-dialog"
                            ><?php echo esc_html__('Iscriviti', 'babygym'); ?></button>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if ([] !== $promo_videos) : ?>
                    <div class="summer-camp-single__videos" role="region" aria-label="<?php echo esc_attr__('Video Summer Camp', 'babygym'); ?>">
                        <?php foreach ($promo_videos as $i => $promo_video) : ?>
                            <div class="summer-camp-single__video video-embed video-embed--card">
                                <?php if ('iframe' === $promo_video['type']) : ?>
                                    <iframe
                                        class="video-embed__iframe"
                                        src="<?php echo esc_url($promo_video['src']); ?>"
                                        title="<?php echo esc_attr($promo_video['iframe_title'] ?? get_the_title()); ?>"
                                        loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen
                                    ></iframe>
                                <?php else : ?>
                                    <video class="video-embed__native" controls playsinline preload="metadata" src="<?php echo esc_url($promo_video['url']); ?>"></video>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ('' !== trim($note)) : ?>
                    <div class="summer-camp-single__details summer-camp-single__notes">
                        <h2><?php echo esc_html__('NOTE', 'babygym'); ?></h2>
                        <p><?php echo wp_kses_post(nl2br(esc_html($note))); ?></p>
                    </div>
                <?php endif; ?>
            </section>

            <?php if ('' !== trim($indirizzo)) : ?>
                <section class="card">
                    <h2 class="text-center"><?php echo esc_html__('Dove si svolge', 'babygym'); ?></h2>
                    <div class="contatti-map summer-camp-single__map">
                        <iframe
                            src="<?php echo esc_url('https://www.google.com/maps?q=' . rawurlencode($indirizzo) . '&output=embed'); ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                            title="<?php echo esc_attr__('Mappa Summer Camp', 'babygym'); ?>"
                        ></iframe>
                    </div>
                </section>
            <?php endif; ?>

            <section class="card summer-camp-single__details summer-camp-single__details--centered">
                <h2><?php echo esc_html__('Per iscrizioni ed informazioni', 'babygym'); ?></h2>
                <p><strong><?php echo esc_html__('BABY GYM s.r.l. S.S.D.', 'babygym'); ?></strong></p>
                <p><?php echo esc_html__('Tel. 011/503484 - 347 3038255', 'babygym'); ?></p>
                <p><?php echo esc_html__('e-mail: babygymonlinetorino@gmail.com', 'babygym'); ?></p>
                <p><strong><?php echo esc_html__('ISCRIZIONI APERTE ANCHE AGLI ESTERNI', 'babygym'); ?></strong></p>
            </section>

            <dialog id="babygym-summer-enroll-dialog" class="babygym-enroll-dialog" aria-labelledby="babygym-enroll-modal-title">
                <button type="button" class="babygym-enroll-dialog__close" data-enroll-modal-close aria-label="<?php echo esc_attr__('Chiudi', 'babygym'); ?>">&times;</button>
                <h2 id="babygym-enroll-modal-title" class="babygym-enroll-dialog__title"><?php echo esc_html__('Iscrizione', 'babygym'); ?></h2>
                <p class="babygym-enroll-dialog__lead"><?php echo esc_html__('Hai già un account sul portale oppure è la tua prima registrazione?', 'babygym'); ?></p>
                <ul class="babygym-enroll-dialog__hints" role="list">
                    <li><?php echo esc_html__('Se hai già un account, accedi per completare l’iscrizione.', 'babygym'); ?></li>
                    <li><?php echo esc_html__('Se sei nuovo, registrati per creare il tuo profilo.', 'babygym'); ?></li>
                </ul>
                <div class="site-header__auth babygym-enroll-dialog__auth" role="group" aria-label="<?php echo esc_attr__('Accesso portale iscrizioni', 'babygym'); ?>">
                    <a class="site-header__auth-btn site-header__auth-btn--register" href="<?php echo esc_url($babygym_portal_registration); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Registrati', 'babygym'); ?></a>
                    <a class="site-header__auth-btn site-header__auth-btn--login" href="<?php echo esc_url($babygym_portal_login); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Accedi', 'babygym'); ?></a>
                </div>
            </dialog>
        <?php endwhile; ?>
    </article>
</main>
<script>
    window.addEventListener('load', function () {
        document.querySelectorAll('[data-summer-camp-single-carousel]').forEach(function (carousel) {
            const track = carousel.querySelector('[data-single-carousel-track]');
            const prev = carousel.querySelector('[data-single-carousel-prev]');
            const next = carousel.querySelector('[data-single-carousel-next]');
            if (!track || !prev || !next) return;

            const step = () => Math.max(320, track.clientWidth);
            prev.addEventListener('click', () => {
                track.scrollBy({ left: -step(), behavior: 'smooth' });
            });
            next.addEventListener('click', () => {
                track.scrollBy({ left: step(), behavior: 'smooth' });
            });
        });
    });

    (function () {
        const dialog = document.getElementById('babygym-summer-enroll-dialog');
        if (!dialog || typeof dialog.showModal !== 'function') {
            return;
        }
        document.querySelectorAll('[data-enroll-modal-open]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                dialog.showModal();
            });
        });
        const closeBtn = dialog.querySelector('[data-enroll-modal-close]');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                dialog.close();
            });
        }
        dialog.addEventListener('click', function (event) {
            if (event.target === dialog) {
                dialog.close();
            }
        });
    })();
</script>
<?php
get_footer();
