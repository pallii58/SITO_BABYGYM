<?php
/**
 * Admin tab template: Feste.
 *
 * Variabili attese:
 * - array<string,string> $options
 * - array<int,string>    $carousel_urls
 */
?>
<div class="wrap">
    <h1>Impostazioni Feste</h1>
    <form method="post" action="options.php">
        <?php settings_fields('babygym_feste_settings'); ?>

        <h2>Carosello foto</h2>
        <p>Carica immagini solo da Media Library.</p>
        <input type="hidden" name="babygym_feste_options[carousel_images]" id="babygym-carousel-images" value="<?php echo esc_attr($options['carousel_images']); ?>">
        <p>
            <button type="button" class="button" id="babygym-add-carousel-image">Aggiungi da Media Library</button>
            <button type="button" class="button" id="babygym-clear-carousel-image">Svuota elenco</button>
        </p>
        <div id="babygym-carousel-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;max-width:860px;margin-bottom:1rem;">
            <?php foreach ($carousel_urls as $url) : ?>
                <div style="position:relative;border:1px solid #d0d7de;border-radius:8px;padding:4px;background:#fff;">
                    <img src="<?php echo esc_url($url); ?>" alt="" style="display:block;width:100%;height:90px;object-fit:cover;border-radius:6px;">
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Orari</h2>
        <p>Aggiungi liberamente nuovi giorni e nuove fasce orarie: la pagina pubblica si aggiorna in automatico.</p>
        <input type="hidden" name="babygym_feste_options[schedule_rows]" id="babygym-schedule-rows" value="<?php echo esc_attr($options['schedule_rows'] ?? ''); ?>">
        <table class="widefat striped" style="max-width:980px;margin:0 0 1rem;">
            <thead>
                <tr>
                    <th>Giorno</th>
                    <th>Da</th>
                    <th>A</th>
                    <th>Nota opzionale</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="babygym-schedule-body"></tbody>
        </table>
        <p>
            <button type="button" class="button button-secondary" id="babygym-add-schedule-row">Aggiungi fascia oraria</button>
        </p>
        <hr>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(420px,1fr));gap:24px;align-items:start;">
            <section>
                <h3>Slot in settimana</h3>
                <table class="form-table" role="presentation">
                    <?php babygym_render_time_range_row('Slot in settimana', 'weekday_slot_start', 'weekday_slot_end', $options); ?>
                    <?php babygym_render_setting_row('Giorni in settimana (testo)', 'weekday_days', $options); ?>
                </table>
            </section>

            <section>
                <h2>Prezzi</h2>
                <p>Inserisci solo importi numerici: i testi prezzo vengono composti in automatico.</p>
                <table class="form-table" role="presentation">
                    <?php babygym_render_number_row('Bimbi inclusi', 'included_children', $options, 1); ?>
                    <?php babygym_render_number_row('Quota festa non iscritti (EUR)', 'non_members_party_price', $options, 0); ?>
                    <?php babygym_render_number_row('Quota festa iscritti (EUR)', 'members_party_price', $options, 0); ?>
                    <?php babygym_render_number_row('Quota iscrizione/assicurazione (EUR)', 'insurance_fee', $options, 0); ?>
                    <?php babygym_render_setting_row('Nota iscritti', 'members_note', $options); ?>
                    <?php
                    $extra_child_from = max(2, ((int) ($options['included_children'] ?? '15')) + 1);
                    babygym_render_number_row(sprintf('Supplemento dal %d° bimbo (EUR)', $extra_child_from), 'extra_child_fee', $options, 0);
                    ?>
                    <?php babygym_render_number_row('Fuori Torino - trasporto (EUR)', 'offsite_transport_fee', $options, 0); ?>
                    <?php babygym_render_number_row('Formula senza attrezzature (EUR)', 'no_equipment_fixed_fee', $options, 0); ?>
                </table>
            </section>
        </div>

        <?php submit_button('Salva impostazioni Feste'); ?>
    </form>
</div>
<script>
    window.addEventListener('load', function () {
        const btn = document.getElementById('babygym-add-carousel-image');
        const clearBtn = document.getElementById('babygym-clear-carousel-image');
        const hiddenInput = document.getElementById('babygym-carousel-images');
        const grid = document.getElementById('babygym-carousel-grid');
        const scheduleHidden = document.getElementById('babygym-schedule-rows');
        const scheduleBody = document.getElementById('babygym-schedule-body');
        const addScheduleBtn = document.getElementById('babygym-add-schedule-row');
        if (!btn || !hiddenInput || !grid) {
            return;
        }

        const parseUrls = () =>
            hiddenInput.value
                .split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean);

        const renderGrid = () => {
            const urls = parseUrls();
            grid.innerHTML = '';
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
                    hiddenInput.value = current.join('\n');
                    renderGrid();
                });
                item.appendChild(remove);
                grid.appendChild(item);
            });
        };

        const openMediaLibrary = () => {
            if (!window.wp || !window.wp.media) {
                alert('Media Library non disponibile. Ricarica la pagina admin.');
                return;
            }

            const frame = window.wp.media({
                title: 'Seleziona foto per carosello',
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
                hiddenInput.value = existing.join('\n');
                renderGrid();
            });

            frame.open();
        };

        btn.addEventListener('click', openMediaLibrary);
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                hiddenInput.value = '';
                renderGrid();
            });
        }
        renderGrid();

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
                        label: (parts[1] || '').trim(),
                        start: (parts[2] || '').trim(),
                        end: (parts[3] || '').trim(),
                        note: (parts[4] || '').trim(),
                    };
                });
        };

        const syncScheduleHidden = () => {
            if (!scheduleHidden || !scheduleBody) return;
            const rows = Array.from(scheduleBody.querySelectorAll('tr'));
            const serialized = rows
                .map((row) => {
                    const getValue = (name) => {
                        const input = row.querySelector(`[data-field="${name}"]`);
                        return input ? input.value.trim() : '';
                    };
                    const day = getValue('day');
                    const label = 'Fascia';
                    const start = getValue('start');
                    const end = getValue('end');
                    const note = getValue('note');
                    if (!day || !label || !start || !end) return '';
                    return [day, label, start, end, note].join('|');
                })
                .filter(Boolean);
            scheduleHidden.value = serialized.join('\n');
        };

        const addScheduleRow = (rowData = { day: '', label: '', start: '', end: '', note: '' }) => {
            if (!scheduleBody) return;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="text" class="regular-text" data-field="day" value="${rowData.day.replace(/"/g, '&quot;')}" placeholder="Es. Sabato"></td>
                <td><input type="time" data-field="start" value="${rowData.start.replace(/"/g, '&quot;')}"></td>
                <td><input type="time" data-field="end" value="${rowData.end.replace(/"/g, '&quot;')}"></td>
                <td><input type="text" class="regular-text" data-field="note" value="${rowData.note.replace(/"/g, '&quot;')}" placeholder="Opzionale"></td>
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

        if (scheduleHidden && scheduleBody) {
            const initialRows = parseScheduleRows();
            if (initialRows.length === 0) {
                addScheduleRow();
            } else {
                initialRows.forEach(addScheduleRow);
            }
        }
        if (addScheduleBtn) {
            addScheduleBtn.addEventListener('click', () => addScheduleRow());
        }
    });
</script>
