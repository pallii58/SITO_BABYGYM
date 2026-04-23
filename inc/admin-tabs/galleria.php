<?php
/**
 * Admin tab template: Galleria.
 *
 * Variabili attese:
 * - array<string,string> $options
 * - array<int,string>    $gallery_urls
 */
?>
<div class="wrap">
    <h1>Impostazioni Galleria</h1>
    <form method="post" action="options.php">
        <?php settings_fields('babygym_galleria_settings'); ?>

        <h2>Foto Galleria</h2>
        <p>Seleziona solo immagini dalla Media Library: verranno mostrate automaticamente in /galleria.</p>
        <input type="hidden" name="babygym_galleria_options[gallery_images]" id="babygym-galleria-images" value="<?php echo esc_attr($options['gallery_images'] ?? ''); ?>">
        <p>
            <button type="button" class="button" id="babygym-add-galleria-image">Aggiungi da Media Library</button>
            <button type="button" class="button" id="babygym-clear-galleria-image">Svuota elenco</button>
        </p>
        <div id="babygym-galleria-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;max-width:860px;margin-bottom:1rem;">
            <?php foreach ($gallery_urls as $url) : ?>
                <div style="position:relative;border:1px solid #d0d7de;border-radius:8px;padding:4px;background:#fff;">
                    <img src="<?php echo esc_url($url); ?>" alt="" style="display:block;width:100%;height:90px;object-fit:cover;border-radius:6px;">
                </div>
            <?php endforeach; ?>
        </div>

        <?php submit_button('Salva Galleria'); ?>
    </form>
</div>
<script>
    window.addEventListener('load', function () {
        const btn = document.getElementById('babygym-add-galleria-image');
        const clearBtn = document.getElementById('babygym-clear-galleria-image');
        const hiddenInput = document.getElementById('babygym-galleria-images');
        const grid = document.getElementById('babygym-galleria-grid');
        if (!btn || !hiddenInput || !grid) return;

        const parseUrls = () => (hiddenInput.value || '')
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
                title: 'Seleziona foto per galleria',
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
    });
</script>
