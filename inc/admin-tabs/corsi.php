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
        <p>Gestione guidata: scegli (o crea) prima la sede, poi il corso, poi modifica gli orari del corso selezionato.</p>
        <input type="hidden" name="babygym_corsi_options[schedule_rows]" id="babygym-corsi-schedule-rows" value="<?php echo esc_attr($options['schedule_rows']); ?>">

        <div style="display:grid;gap:14px;max-width:1100px;margin:0 0 1rem;">
            <div style="display:flex;gap:8px;align-items:center;font-weight:700;">
                <span id="corsi-step-indicator">Fase 1 di 3</span>
            </div>
            <div id="corsi-step-1" style="padding:12px;border:1px solid #dcdcde;border-radius:8px;background:#fff;">
                    <strong>1) Seleziona sede</strong>
                    <p style="margin:.5rem 0;">
                        <select id="babygym-corsi-location-select" class="regular-text"></select>
                    </p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <input type="text" id="babygym-corsi-new-location" class="regular-text" placeholder="Nuova sede">
                        <button type="button" class="button" id="babygym-corsi-add-location">Aggiungi sede</button>
                    </div>
                    <p style="margin:.9rem 0 0;">
                        <button type="button" class="button button-primary" id="corsi-next-to-step-2">Continua al corso</button>
                    </p>
            </div>
            <div id="corsi-step-2" style="padding:12px;border:1px solid #dcdcde;border-radius:8px;background:#fff;" hidden>
                    <strong>2) Seleziona corso</strong>
                    <p style="margin:.5rem 0;">
                        <select id="babygym-corsi-course-select" class="regular-text"></select>
                    </p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <input type="text" id="babygym-corsi-new-course" class="regular-text" placeholder="Nuovo corso">
                        <button type="button" class="button" id="babygym-corsi-add-course">Aggiungi corso</button>
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:.7rem;">
                        <button type="button" class="button" id="babygym-corsi-toggle-course-status">Disattiva corso</button>
                        <button type="button" class="button button-link-delete" id="babygym-corsi-delete-course">Elimina corso</button>
                    </div>
                    <p style="display:flex;gap:8px;margin:.9rem 0 0;">
                        <button type="button" class="button" id="corsi-back-to-step-1">Indietro</button>
                        <button type="button" class="button button-primary" id="corsi-next-to-step-3">Continua agli orari</button>
                    </p>
            </div>
            <div id="corsi-step-3" style="padding:12px;border:1px solid #dcdcde;border-radius:8px;background:#fff;" hidden>
                <strong>3) Orari del corso selezionato</strong>
                <table class="widefat striped" style="margin:.7rem 0;">
                    <thead>
                        <tr>
                            <th style="width:25%;">Giorno</th>
                            <th>Orari</th>
                            <th style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody id="babygym-corsi-schedule-body"></tbody>
                </table>
                <button type="button" class="button button-secondary" id="babygym-corsi-add-schedule-row">Aggiungi orario</button>
                <p style="margin:.9rem 0 0;">
                    <button type="button" class="button" id="corsi-back-to-step-2">Indietro</button>
                </p>
            </div>
        </div>

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
        const locationSelect = document.getElementById('babygym-corsi-location-select');
        const courseSelect = document.getElementById('babygym-corsi-course-select');
        const newLocationInput = document.getElementById('babygym-corsi-new-location');
        const newCourseInput = document.getElementById('babygym-corsi-new-course');
        const addLocationBtn = document.getElementById('babygym-corsi-add-location');
        const addCourseBtn = document.getElementById('babygym-corsi-add-course');
        const toggleCourseStatusBtn = document.getElementById('babygym-corsi-toggle-course-status');
        const deleteCourseBtn = document.getElementById('babygym-corsi-delete-course');
        const stepIndicator = document.getElementById('corsi-step-indicator');
        const step1 = document.getElementById('corsi-step-1');
        const step2 = document.getElementById('corsi-step-2');
        const step3 = document.getElementById('corsi-step-3');
        const nextToStep2Btn = document.getElementById('corsi-next-to-step-2');
        const nextToStep3Btn = document.getElementById('corsi-next-to-step-3');
        const backToStep1Btn = document.getElementById('corsi-back-to-step-1');
        const backToStep2Btn = document.getElementById('corsi-back-to-step-2');
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

        const parseScheduleRows = () =>
            scheduleHidden.value
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
                        status: ((parts[4] || 'active').trim() === 'inactive') ? 'inactive' : 'active',
                    };
                });
        let scheduleRows = parseScheduleRows();
        const manualLocations = new Set();
        const manualCoursesByLocation = {};
        let selectedLocation = '';
        let selectedCourse = '';

        const serializeRows = () => {
            scheduleHidden.value = scheduleRows
                .filter((row) => row.location && row.course && row.day && row.times && row.status)
                .map((row) => [row.location, row.course, row.day, row.times, row.status].join('|'))
                .join('\n');
        };

        const getLocations = () => {
            const values = new Set(scheduleRows.map((row) => row.location).filter(Boolean));
            manualLocations.forEach((location) => values.add(location));
            return [...values];
        };

        const getCoursesByLocation = (location) => {
            const values = new Set(scheduleRows.filter((row) => row.location === location).map((row) => row.course).filter(Boolean));
            (manualCoursesByLocation[location] || []).forEach((course) => values.add(course));
            return [...values];
        };

        const fillSelect = (select, values, emptyLabel) => {
            if (!select) return;
            select.innerHTML = '';
            if (values.length === 0) {
                const empty = document.createElement('option');
                empty.value = '';
                empty.textContent = emptyLabel;
                select.appendChild(empty);
                return;
            }
            values.forEach((value) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = value;
                select.appendChild(option);
            });
        };

        const renderScheduleTable = () => {
            scheduleBody.innerHTML = '';
            if (!selectedLocation || !selectedCourse) {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="3">Seleziona una sede e un corso.</td>`;
                scheduleBody.appendChild(row);
                return;
            }

            const scoped = scheduleRows.filter((row) => row.location === selectedLocation && row.course === selectedCourse);
            if (scoped.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="3">Nessun orario presente per questo corso.</td>`;
                scheduleBody.appendChild(row);
                return;
            }

            scoped.forEach((rowData) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="text" class="regular-text" value="${rowData.day.replace(/"/g, '&quot;')}" data-field="day"></td>
                    <td><input type="text" class="regular-text" value="${rowData.times.replace(/"/g, '&quot;')}" data-field="times"></td>
                    <td><button type="button" class="button-link-delete" data-action="remove">Rimuovi</button></td>
                `;
                row.querySelector('[data-field="day"]').addEventListener('input', (event) => {
                    rowData.day = event.target.value.trim();
                    serializeRows();
                });
                row.querySelector('[data-field="times"]').addEventListener('input', (event) => {
                    rowData.times = event.target.value.trim();
                    serializeRows();
                });
                row.querySelector('[data-action="remove"]').addEventListener('click', () => {
                    scheduleRows = scheduleRows.filter((item) => item !== rowData);
                    serializeRows();
                    updateWizard();
                });
                scheduleBody.appendChild(row);
            });
        };

        const updateWizard = () => {
            const locations = getLocations();
            if (!locations.includes(selectedLocation)) {
                selectedLocation = locations[0] || '';
            }
            fillSelect(locationSelect, locations, 'Nessuna sede');
            if (locationSelect) locationSelect.value = selectedLocation;

            const courses = selectedLocation ? getCoursesByLocation(selectedLocation) : [];
            if (!courses.includes(selectedCourse)) {
                selectedCourse = courses[0] || '';
            }
            fillSelect(courseSelect, courses, 'Nessun corso');
            if (courseSelect) courseSelect.value = selectedCourse;

            const courseRows = scheduleRows.filter((row) => row.location === selectedLocation && row.course === selectedCourse);
            const isInactiveCourse = courseRows.length > 0 && courseRows.every((row) => row.status === 'inactive');
            if (toggleCourseStatusBtn) {
                toggleCourseStatusBtn.textContent = isInactiveCourse ? 'Riattiva corso' : 'Disattiva corso';
                toggleCourseStatusBtn.disabled = !selectedLocation || !selectedCourse;
            }
            if (deleteCourseBtn) {
                deleteCourseBtn.disabled = !selectedLocation || !selectedCourse;
            }

            renderScheduleTable();
            serializeRows();
        };

        let currentStep = 1;
        const setStep = (step) => {
            currentStep = step;
            if (stepIndicator) {
                stepIndicator.textContent = `Fase ${step} di 3`;
            }
            if (step1) step1.hidden = step !== 1;
            if (step2) step2.hidden = step !== 2;
            if (step3) step3.hidden = step !== 3;
        };

        if (locationSelect) {
            locationSelect.addEventListener('change', () => {
                selectedLocation = locationSelect.value;
                selectedCourse = '';
                updateWizard();
            });
        }

        if (courseSelect) {
            courseSelect.addEventListener('change', () => {
                selectedCourse = courseSelect.value;
                updateWizard();
            });
        }

        if (addLocationBtn && newLocationInput) {
            addLocationBtn.addEventListener('click', () => {
                const value = newLocationInput.value.trim();
                if (!value) return;
                manualLocations.add(value);
                selectedLocation = value;
                newLocationInput.value = '';
                updateWizard();
            });
        }

        if (addCourseBtn && newCourseInput) {
            addCourseBtn.addEventListener('click', () => {
                const value = newCourseInput.value.trim();
                if (!selectedLocation || !value) return;
                manualLocations.add(selectedLocation);
                if (!manualCoursesByLocation[selectedLocation]) {
                    manualCoursesByLocation[selectedLocation] = new Set();
                }
                manualCoursesByLocation[selectedLocation].add(value);
                selectedCourse = value;
                newCourseInput.value = '';
                updateWizard();
            });
        }

        if (toggleCourseStatusBtn) {
            toggleCourseStatusBtn.addEventListener('click', () => {
                if (!selectedLocation || !selectedCourse) return;
                scheduleRows = scheduleRows.map((row) => {
                    if (row.location === selectedLocation && row.course === selectedCourse) {
                        return { ...row, status: row.status === 'inactive' ? 'active' : 'inactive' };
                    }
                    return row;
                });
                updateWizard();
            });
        }

        if (deleteCourseBtn) {
            deleteCourseBtn.addEventListener('click', () => {
                if (!selectedLocation || !selectedCourse) return;
                const firstConfirm = window.confirm(`Vuoi davvero eliminare il corso "${selectedCourse}" dalla sede "${selectedLocation}"?`);
                if (!firstConfirm) {
                    return;
                }
                const secondConfirm = window.confirm('Conferma definitiva: questa azione è irreversibile. Procedere con l\'eliminazione?');
                if (!secondConfirm) {
                    return;
                }
                scheduleRows = scheduleRows.filter((row) => !(row.location === selectedLocation && row.course === selectedCourse));
                selectedCourse = '';
                updateWizard();
            });
        }

        if (nextToStep2Btn) {
            nextToStep2Btn.addEventListener('click', () => {
                if (!selectedLocation) return;
                setStep(2);
            });
        }
        if (nextToStep3Btn) {
            nextToStep3Btn.addEventListener('click', () => {
                if (!selectedCourse) return;
                setStep(3);
            });
        }
        if (backToStep1Btn) {
            backToStep1Btn.addEventListener('click', () => setStep(1));
        }
        if (backToStep2Btn) {
            backToStep2Btn.addEventListener('click', () => setStep(2));
        }

        if (addScheduleBtn) {
            addScheduleBtn.addEventListener('click', () => {
                if (!selectedLocation || !selectedCourse) {
                    return;
                }
                scheduleRows.push({
                    location: selectedLocation,
                    course: selectedCourse,
                    day: '',
                    times: '',
                    status: 'active',
                });
                updateWizard();
            });
        }

        updateWizard();
        setStep(1);
    });
</script>
