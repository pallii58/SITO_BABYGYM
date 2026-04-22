<?php
/**
 * Metabox template: Summer Camp details.
 *
 * Variabili attese:
 * - string $locandina_url
 * - string $gallery_raw
 * - string $descrizione
 * - string $eta
 * - string $indirizzo
 * - string $settimane
 * - string $iscrizioni_entro
 * - array<int,string> $gallery_urls
 * - string $schedule_rows_raw
 */
?>
<table class="form-table" role="presentation">
    <tr>
        <th scope="row"><label for="babygym-summer-camp-locandina-url"><?php esc_html_e('Locandina', 'babygym'); ?></label></th>
        <td>
            <input type="hidden" id="babygym-summer-camp-locandina-url" name="babygym_summer_camp_locandina_url" value="<?php echo esc_attr($locandina_url); ?>">
            <p>
                <button type="button" class="button button-primary" id="babygym-summer-camp-pick-locandina"><?php esc_html_e('Seleziona locandina', 'babygym'); ?></button>
                <button type="button" class="button" id="babygym-summer-camp-clear-locandina"><?php esc_html_e('Rimuovi locandina', 'babygym'); ?></button>
            </p>
            <div id="babygym-summer-camp-locandina-preview" style="max-width:420px;margin-top:10px;">
                <?php if ('' !== $locandina_url) : ?>
                    <?php if (preg_match('/\.pdf($|\?)/i', $locandina_url)) : ?>
                        <a href="<?php echo esc_url($locandina_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__('Anteprima PDF locandina', 'babygym'); ?></a>
                    <?php else : ?>
                        <img src="<?php echo esc_url($locandina_url); ?>" alt="" style="display:block;width:100%;height:auto;max-height:220px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;">
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="babygym-summer-camp-gallery"><?php esc_html_e('Galleria', 'babygym'); ?></label></th>
        <td>
            <textarea class="large-text" rows="4" id="babygym-summer-camp-gallery" name="babygym_summer_camp_gallery" hidden><?php echo esc_textarea($gallery_raw); ?></textarea>
            <p>
                <button type="button" class="button button-primary" id="babygym-summer-camp-pick-gallery"><?php esc_html_e('Seleziona immagini', 'babygym'); ?></button>
                <button type="button" class="button" id="babygym-summer-camp-clear-gallery"><?php esc_html_e('Svuota galleria', 'babygym'); ?></button>
            </p>
            <div id="babygym-summer-camp-gallery-preview" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:8px;max-width:760px;margin-top:10px;">
                <?php foreach ($gallery_urls as $gallery_url) : ?>
                    <img src="<?php echo esc_url($gallery_url); ?>" alt="" style="width:100%;height:90px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;">
                <?php endforeach; ?>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="babygym-summer-camp-eta"><?php esc_html_e('ETA\'', 'babygym'); ?></label></th>
        <td>
            <input type="text" class="regular-text" id="babygym-summer-camp-eta" name="babygym_summer_camp_eta" value="<?php echo esc_attr($eta); ?>" placeholder="3 - 7 anni">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="babygym-summer-camp-indirizzo"><?php esc_html_e('INDIRIZZO', 'babygym'); ?></label></th>
        <td>
            <input type="text" class="regular-text" id="babygym-summer-camp-indirizzo" name="babygym_summer_camp_indirizzo" value="<?php echo esc_attr($indirizzo); ?>" placeholder="Via Rosolino Pilo, 24">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="babygym-summer-camp-settimane"><?php esc_html_e('SETTIMANE', 'babygym'); ?></label></th>
        <td>
            <input type="text" class="regular-text" id="babygym-summer-camp-settimane" name="babygym_summer_camp_settimane" value="<?php echo esc_attr($settimane); ?>" placeholder="dal 1 al 31 LUGLIO">
        </td>
    </tr>
    <tr>
        <th scope="row"></th>
        <td>
            <h2 style="margin:0 0 .8rem;"><?php esc_html_e('Orari', 'babygym'); ?></h2>
            <input type="hidden" id="babygym-summer-camp-schedule-rows" name="babygym_summer_camp_schedule_rows" value="<?php echo esc_attr($schedule_rows_raw); ?>">
            <table class="widefat striped" style="max-width:980px;margin:0 0 1rem;">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Giorno', 'babygym'); ?></th>
                        <th><?php esc_html_e('Da', 'babygym'); ?></th>
                        <th><?php esc_html_e('A', 'babygym'); ?></th>
                        <th><?php esc_html_e('Nota opzionale', 'babygym'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="babygym-schedule-body"></tbody>
            </table>
            <p><button type="button" class="button button-secondary" id="babygym-add-schedule-row"><?php esc_html_e('Aggiungi orario', 'babygym'); ?></button></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="babygym-summer-camp-iscrizioni-entro"><?php esc_html_e('ISCRIZIONI ENTRO', 'babygym'); ?></label></th>
        <td>
            <input type="text" class="regular-text" id="babygym-summer-camp-iscrizioni-entro" name="babygym_summer_camp_iscrizioni_entro" value="<?php echo esc_attr($iscrizioni_entro); ?>" placeholder="fine maggio">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="babygym-summer-camp-descrizione"><?php esc_html_e('Descrizione', 'babygym'); ?></label></th>
        <td>
            <textarea class="large-text" rows="4" id="babygym-summer-camp-descrizione" name="babygym_summer_camp_descrizione"><?php echo esc_textarea($descrizione); ?></textarea>
        </td>
    </tr>
</table>
<script>
    window.addEventListener('load', function () {
        if (!window.wp || !window.wp.media) return;
        const locandinaInput = document.getElementById('babygym-summer-camp-locandina-url');
        const locandinaPreview = document.getElementById('babygym-summer-camp-locandina-preview');
        const clearLocandinaBtn = document.getElementById('babygym-summer-camp-clear-locandina');
        const galleryInput = document.getElementById('babygym-summer-camp-gallery');
        const galleryPreview = document.getElementById('babygym-summer-camp-gallery-preview');
        const pickLocandinaBtn = document.getElementById('babygym-summer-camp-pick-locandina');
        const pickGalleryBtn = document.getElementById('babygym-summer-camp-pick-gallery');
        const clearGalleryBtn = document.getElementById('babygym-summer-camp-clear-gallery');
        const scheduleHidden = document.getElementById('babygym-summer-camp-schedule-rows');
        const scheduleBody = document.getElementById('babygym-schedule-body');
        const addScheduleRowBtn = document.getElementById('babygym-add-schedule-row');

        const renderLocandinaPreview = () => {
            if (!locandinaPreview || !locandinaInput) return;
            const url = (locandinaInput.value || '').trim();
            if (!url) {
                locandinaPreview.innerHTML = '';
                return;
            }
            if (/\.pdf($|\?)/i.test(url)) {
                locandinaPreview.innerHTML = `<a href="${url}" target="_blank" rel="noopener noreferrer">Anteprima PDF locandina</a>`;
                return;
            }
            locandinaPreview.innerHTML = `<img src="${url}" alt="" style="display:block;width:100%;height:auto;max-height:220px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;">`;
        };

        const parseGalleryUrls = () => (galleryInput?.value || '')
            .split(/\r?\n/)
            .map((line) => line.trim())
            .filter(Boolean);

        const renderGalleryPreview = () => {
            if (!galleryPreview) return;
            galleryPreview.innerHTML = '';
            parseGalleryUrls().forEach((url) => {
                const img = document.createElement('img');
                img.src = url;
                img.alt = '';
                img.style.cssText = 'width:100%;height:90px;object-fit:cover;border:1px solid #dcdcde;border-radius:8px;';
                galleryPreview.appendChild(img);
            });
        };

        const parseScheduleRows = () => {
            if (!scheduleHidden) return [];
            return scheduleHidden.value
                .split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean)
                .map((line) => {
                    const parts = line.split('|');
                    return {
                        day: (parts[0] || '').trim(),
                        start: (parts[1] || '').trim(),
                        end: (parts[2] || '').trim(),
                        note: (parts[3] || '').trim(),
                    };
                })
                .filter((row) => row.day && row.start && row.end);
        };
        let scheduleRows = parseScheduleRows();

        const serializeScheduleRows = () => {
            if (!scheduleHidden) return;
            scheduleHidden.value = scheduleRows
                    .filter((row) => row.day && row.start && row.end)
                    .map((row) => [row.day, row.start, row.end, row.note || ''].join('|'))
                .join('\n');
        };

        const renderScheduleTable = () => {
            if (!scheduleBody) return;
            scheduleBody.innerHTML = '';
            scheduleRows.forEach((rowData) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="text" class="regular-text" data-field="day" value="${rowData.day.replace(/"/g, '&quot;')}" placeholder="Es. Sabato"></td>
                    <td><input type="time" data-field="start" value="${rowData.start.replace(/"/g, '&quot;')}"></td>
                    <td><input type="time" data-field="end" value="${rowData.end.replace(/"/g, '&quot;')}"></td>
                    <td><input type="text" class="regular-text" data-field="note" value="${rowData.note.replace(/"/g, '&quot;')}" placeholder="Opzionale"></td>
                    <td><button type="button" class="button-link-delete" data-action="remove">Rimuovi</button></td>
                `;
                row.querySelector('[data-field="day"]').addEventListener('input', (event) => {
                    rowData.day = event.target.value.trim();
                    serializeScheduleRows();
                });
                row.querySelector('[data-field="start"]').addEventListener('input', (event) => {
                    rowData.start = event.target.value.trim();
                    serializeScheduleRows();
                });
                row.querySelector('[data-field="end"]').addEventListener('input', (event) => {
                    rowData.end = event.target.value.trim();
                    serializeScheduleRows();
                });
                row.querySelector('[data-field="note"]').addEventListener('input', (event) => {
                    rowData.note = event.target.value.trim();
                    serializeScheduleRows();
                });
                row.querySelector('[data-action="remove"]').addEventListener('click', () => {
                    scheduleRows = scheduleRows.filter((item) => item !== rowData);
                    serializeScheduleRows();
                    renderScheduleTable();
                });
                scheduleBody.appendChild(row);
            });
        };

        if (pickLocandinaBtn && locandinaInput) {
            pickLocandinaBtn.addEventListener('click', () => {
                const frame = window.wp.media({
                    title: 'Seleziona locandina',
                    button: { text: 'Usa file' },
                    library: { type: ['image', 'application/pdf'] },
                    multiple: false
                });
                frame.on('select', () => {
                    const file = frame.state().get('selection').first().toJSON();
                    if (file?.url) {
                        locandinaInput.value = file.url;
                        renderLocandinaPreview();
                    }
                });
                frame.open();
            });
        }

        if (clearLocandinaBtn && locandinaInput) {
            clearLocandinaBtn.addEventListener('click', () => {
                locandinaInput.value = '';
                renderLocandinaPreview();
            });
        }

        if (pickGalleryBtn && galleryInput) {
            pickGalleryBtn.addEventListener('click', () => {
                const frame = window.wp.media({
                    title: 'Seleziona immagini galleria',
                    button: { text: 'Aggiungi immagini' },
                    library: { type: 'image' },
                    multiple: true
                });
                frame.on('select', () => {
                    const selection = frame.state().get('selection').toJSON();
                    const existing = parseGalleryUrls();
                    selection.forEach((item) => {
                        if (item?.url && !existing.includes(item.url)) {
                            existing.push(item.url);
                        }
                    });
                    galleryInput.value = existing.join('\n');
                    renderGalleryPreview();
                });
                frame.open();
            });
        }

        if (clearGalleryBtn && galleryInput) {
            clearGalleryBtn.addEventListener('click', () => {
                galleryInput.value = '';
                renderGalleryPreview();
            });
        }

        if (addScheduleRowBtn) {
            addScheduleRowBtn.addEventListener('click', () => {
                scheduleRows.push({ day: '', start: '', end: '', note: '' });
                serializeScheduleRows();
                renderScheduleTable();
            });
        }

        if (galleryInput) galleryInput.addEventListener('input', renderGalleryPreview);
        renderLocandinaPreview();
        renderGalleryPreview();
        renderScheduleTable();
        serializeScheduleRows();
    });
</script>
