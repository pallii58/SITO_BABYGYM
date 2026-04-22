<?php
/**
 * Admin tab template: Corsi.
 *
 * Variabili attese:
 * - array<string,string> $options
 * - array<int,string>    $carousel_urls
 */
?>
<div class="wrap">
    <h1>Impostazioni Corsi</h1>
    <form method="post" action="options.php">
        <?php settings_fields('babygym_corsi_settings'); ?>

        <h2>Carosello foto</h2>
        <p>Carica immagini solo da Media Library.</p>
        <input type="hidden" name="babygym_corsi_options[carousel_images]" id="babygym-corsi-carousel-images" value="<?php echo esc_attr($options['carousel_images']); ?>">
        <p>
            <button type="button" class="button" id="babygym-corsi-add-carousel-image">Aggiungi da Media Library</button>
            <button type="button" class="button" id="babygym-corsi-clear-carousel-image">Svuota elenco</button>
        </p>
        <div id="babygym-corsi-carousel-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;max-width:860px;margin-bottom:1rem;">
            <?php foreach ($carousel_urls as $url) : ?>
                <div style="position:relative;border:1px solid #d0d7de;border-radius:8px;padding:4px;background:#fff;">
                    <img src="<?php echo esc_url($url); ?>" alt="" style="display:block;width:100%;height:90px;object-fit:cover;border-radius:6px;">
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Orari per sede e corso</h2>
        <p>Puoi aggiungere nuove sedi, nuovi corsi e nuovi orari liberamente.</p>
        <input type="hidden" name="babygym_corsi_options[schedule_rows]" id="babygym-corsi-schedule-rows" value="<?php echo esc_attr($options['schedule_rows']); ?>">
        <table class="widefat striped" style="max-width:1100px;margin:0 0 1rem;">
            <thead>
                <tr>
                    <th>Sede</th>
                    <th>Corso</th>
                    <th>Giorno</th>
                    <th>Orari</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="babygym-corsi-schedule-body"></tbody>
        </table>
        <p>
            <button type="button" class="button button-secondary" id="babygym-corsi-add-schedule-row">Aggiungi riga orario</button>
        </p>

        <?php submit_button('Salva impostazioni Corsi'); ?>
    </form>
</div>
<script>
    window.addEventListener('load', function () {
        const carouselInput = document.getElementById('babygym-corsi-carousel-images');
        const carouselGrid = document.getElementById('babygym-corsi-carousel-grid');
        const addCarouselBtn = document.getElementById('babygym-corsi-add-carousel-image');
        const clearCarouselBtn = document.getElementById('babygym-corsi-clear-carousel-image');
        const scheduleHidden = document.getElementById('babygym-corsi-schedule-rows');
        const scheduleBody = document.getElementById('babygym-corsi-schedule-body');
        const addScheduleBtn = document.getElementById('babygym-corsi-add-schedule-row');
        if (!carouselInput || !carouselGrid || !addCarouselBtn || !scheduleHidden || !scheduleBody) {
            return;
        }

        const parseUrls = () =>
            carouselInput.value
                .split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean);

        const renderCarouselGrid = () => {
            const urls = parseUrls();
            carouselGrid.innerHTML = '';
            urls.forEach((url, index) => {
                const item = document.createElement('div');
                item.style.cssText = 'position:relative;border:1px solid #d0d7de;border-radius:8px;padding:4px;background:#fff;';
                const img = document.createElement('img');
                img.src = url;
                img.alt = '';
                img.style.cssText = 'display:block;width:100%;height:90px;object-fit:cover;border-radius:6px;';
                item.appendChild(img);
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.textContent = '×';
                remove.setAttribute('aria-label', 'Rimuovi foto');
                remove.style.cssText = 'position:absolute;top:6px;right:6px;width:22px;height:22px;border:0;border-radius:999px;background:#dc2626;color:#fff;cursor:pointer;font-weight:700;line-height:1;';
                remove.addEventListener('click', () => {
                    const current = parseUrls();
                    current.splice(index, 1);
                    carouselInput.value = current.join('\n');
                    renderCarouselGrid();
                });
                item.appendChild(remove);
                carouselGrid.appendChild(item);
            });
        };

        addCarouselBtn.addEventListener('click', () => {
            if (!window.wp || !window.wp.media) {
                alert('Media Library non disponibile. Ricarica la pagina admin.');
                return;
            }
            const frame = window.wp.media({
                title: 'Seleziona foto per carosello corsi',
                button: { text: 'Usa queste foto' },
                library: { type: 'image' },
                multiple: true
            });
            frame.on('select', () => {
                const selection = frame.state().get('selection').toJSON();
                const existing = parseUrls();
                selection.forEach((media) => {
                    if (media.url && !existing.includes(media.url)) {
                        existing.push(media.url);
                    }
                });
                carouselInput.value = existing.join('\n');
                renderCarouselGrid();
            });
            frame.open();
        });

        if (clearCarouselBtn) {
            clearCarouselBtn.addEventListener('click', () => {
                carouselInput.value = '';
                renderCarouselGrid();
            });
        }
        renderCarouselGrid();

        const parseScheduleRows = () => {
            return scheduleHidden.value
                .split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean)
                .map((line) => {
                    const parts = line.split('|');
                    return {
                        location: (parts[0] || '').trim(),
                        course: (parts[1] || '').trim(),
                        day: (parts[2] || '').trim(),
                        times: (parts[3] || '').trim(),
                    };
                });
        };

        const syncScheduleHidden = () => {
            const rows = Array.from(scheduleBody.querySelectorAll('tr'));
            const serialized = rows.map((row) => {
                const getValue = (name) => {
                    const input = row.querySelector(`[data-field="${name}"]`);
                    return input ? input.value.trim() : '';
                };
                const location = getValue('location');
                const course = getValue('course');
                const day = getValue('day');
                const times = getValue('times');
                if (!location || !course || !day || !times) return '';
                return [location, course, day, times].join('|');
            }).filter(Boolean);
            scheduleHidden.value = serialized.join('\n');
        };

        const addScheduleRow = (rowData = { location: '', course: '', day: '', times: '' }) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="text" class="regular-text" data-field="location" value="${rowData.location.replace(/"/g, '&quot;')}" placeholder="Es. Via Vespucci 36, Torino"></td>
                <td><input type="text" class="regular-text" data-field="course" value="${rowData.course.replace(/"/g, '&quot;')}" placeholder="Es. BUGS (4-10 mesi)"></td>
                <td><input type="text" class="regular-text" data-field="day" value="${rowData.day.replace(/"/g, '&quot;')}" placeholder="Es. Mercoledì"></td>
                <td><input type="text" class="regular-text" data-field="times" value="${rowData.times.replace(/"/g, '&quot;')}" placeholder="Es. 10.00 - 11.00, 15.30 - 16.30"></td>
                <td><button type="button" class="button-link-delete" data-action="remove">Rimuovi</button></td>
            `;
            tr.addEventListener('input', syncScheduleHidden);
            const removeBtn = tr.querySelector('[data-action="remove"]');
            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    tr.remove();
                    syncScheduleHidden();
                });
            }
            scheduleBody.appendChild(tr);
            syncScheduleHidden();
        };

        const initialRows = parseScheduleRows();
        if (initialRows.length === 0) {
            addScheduleRow();
        } else {
            initialRows.forEach(addScheduleRow);
        }
        if (addScheduleBtn) {
            addScheduleBtn.addEventListener('click', () => addScheduleRow());
        }
    });
</script>
