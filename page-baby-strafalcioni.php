<?php
/**
 * Pagina "Baby Strafalcioni" — citazioni divertenti.
 * Slug WP consigliato: baby-strafalcioni
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$babygym_straf_quotes = [
    ['who' => 'Paolo', 'quote' => 'mi sono SPIANTATO'],
    ['who' => 'Ginevra', 'quote' => 'io faccio le PRESSIONI (= flessioni, piegamenti)'],
    ['who' => 'Lezercules', 'quote' => 'cosa sono i TITANI? UNA GRANDE NAVE'],
    ['who' => 'Simone', 'quote' => 'ieri sono andato all’ORCO BOTANICO'],
    ['who' => 'Valentina', 'quote' => 'ho fatto il DUESIMO salto'],
    ['who' => 'Marco', 'quote' => 'la mia maestra E’ ANDATA INCINTA'],
    ['who' => 'Luisa', 'quote' => '«Mamma, ma perché Gesù lo chiamano il RE DENTONE?»'],
    ['who' => 'Enrica', 'quote' => '«A me piace molto il gelato FRAGOLA e MANIGLIA»'],
    ['who' => 'Arianna', 'quote' => '«Io mi sposo Fabio perché mi fa il solletico»'],
    ['who' => 'Giorigia', 'quote' => '«Voglio bene al mio maialino e allora l’ho CUORATO»'],
    ['who' => 'Giorgia', 'quote' => '«Con la carta crespa mi faccio il GERRISENO»'],
    ['who' => 'Simone', 'quote' => '«…le spie dell’ ES.PI.AI»'],
    ['who' => 'Giulia', 'quote' => '«al mare la mamma mi mette il LATTE SALVAGENTE»'],
    ['who' => 'Giorgia', 'quote' => '«Ho magiato un MALANDRINO»'],
    ['who' => 'Enrica', 'quote' => '«Ci divertiamo un sacco: oggi abbiamo fatto Baby Gym e domani facciamo anche PSICO COMICITA’»'],
    ['who' => 'Sara', 'quote' => '«ieri ho visto il film di SANTA CLOWN»'],
    ['who' => 'Luca', 'quote' => '«Mamma guarda quel trattore, sta trattorando»'],
    ['who' => 'Davide', 'quote' => '«Ho mangiato i FICHI NINJA»'],
    ['who' => 'Martina', 'quote' => '«Dopo aver fatto Baby Gym mi fanno tanto male i POLPONI»'],
    ['who' => 'Davide', 'quote' => '«Ieri sera ho visto i FUOCHI DENTIFRICIO»'],
    ['who' => 'Giorgia', 'quote' => '«Domani non vado a scuola perché devo fare il BACINO nel braccio»'],
    ['who' => 'Francesco', 'quote' => '«Ieri ho proprio riso a SPANCIAGOLA»'],
    ['who' => 'Simone (e l’istruttore)', 'quote' => 'L’istruttore dice: «Medusa in inglese si dice Jellyfish e non è un pesce» — Simone: «Certo, se no sarebbe GELLYPESC»'],
    ['who' => 'Federica (e l’istruttore)', 'quote' => 'Istruttore: «Dalla mucca nasce il vitellino, dalla scrofa nasce il porcellino, e il coniglio nasce dal…» — Federica: «Il coniglio NASCE DAL PRATO»'],
];

?>
<main id="primary" class="site-main site-main--wide">
    <article class="filosofia-page baby-straf-page">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <section class="baby-straf-hero filosofia-hero card card--centered">
                <p class="feste-eyebrow"><?php echo esc_html__('Baby Gym Torino', 'babygym'); ?></p>
                <h1 class="feste-hero__title"><?php echo esc_html(get_the_title() ?: __('Baby Strafalcioni', 'babygym')); ?></h1>
                <p class="filosofia-lead baby-straf-hero__lead"><?php echo esc_html__('Le citazioni più simpatiche (e più «creative»!) raccolte in anni di lezioni, giochi e risate.', 'babygym'); ?></p>
            </section>

            <?php if (get_the_content()) : ?>
                <section class="baby-straf-editorial card">
                    <div class="entry-content baby-straf-editorial__body">
                        <?php the_content(); ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="baby-straf-section card" aria-label="<?php echo esc_attr__('Elenco citazioni', 'babygym'); ?>">
                <h2 class="baby-straf-section__title"><?php echo esc_html__('Le perle della settimana (e non solo)', 'babygym'); ?></h2>
                <ul class="baby-straf-list">
                    <?php foreach ($babygym_straf_quotes as $row) : ?>
                        <li class="baby-straf-card">
                            <span class="baby-straf-card__who"><?php echo esc_html((string) ($row['who'] ?? '')); ?></span>
                            <blockquote class="baby-straf-card__quote"><?php echo esc_html((string) ($row['quote'] ?? '')); ?></blockquote>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php
        endwhile;
        ?>
    </article>
</main>
<?php
get_footer();
