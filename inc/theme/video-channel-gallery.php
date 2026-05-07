<?php
/**
 * Galleria video da canale YouTube (lista upload dinamica).
 *
 * - Con chiave API: YouTube Data API v3 (tutti i video dell’uploads playlist).
 * - Senza chiave: feed Atom del canale (dopo aver risolto il channel UUID dalla pagina @handle).
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Durata cache elenco embed (secondi).
 */
function babygym_youtube_video_cache_ttl(): int
{
    $ttl = (int) apply_filters('babygym_youtube_video_cache_ttl', HOUR_IN_SECONDS);
    return max(120, min($ttl, DAY_IN_SECONDS));
}

/**
 * Handle canale configurato nel Customizer (senza @).
 */
function babygym_get_youtube_channel_handle(): string
{
    $h = trim((string) get_theme_mod('babygym_youtube_channel_handle', 'babygym5384'));
    $h = ltrim($h, '@');
    $h = preg_replace('/[^a-zA-Z0-9_.-]/', '', $h) ?: 'babygym5384';

    return $h;
}

/**
 * Lista URL embed (/embed/VIDEO_ID?rel=0) per la galleria, ordine pubblicazione (recenti prima di solito da API/RSS).
 *
 * @return list<string>
 */
function babygym_get_video_embed_src_list(): array
{
    static $memo = null;
    if ($memo !== null) {
        return $memo;
    }

    $handle      = babygym_get_youtube_channel_handle();
    $api_key     = trim((string) get_theme_mod('babygym_youtube_api_key', ''));
    $cache_parts = [$handle, 'v2', substr(hash('sha256', $api_key), 0, 12)];
    $cache_key   = 'babygym_yt_gallery_' . md5(implode('|', $cache_parts));

    $cached = get_transient($cache_key);
    if (is_array($cached)) {
        $memo = babygym_youtube_normalize_embed_list($cached);
        return $memo;
    }

    $ids = [];
    if ('' !== $api_key) {
        $ids = babygym_youtube_fetch_uploads_via_api($handle, $api_key);
    }
    if ([] === $ids) {
        $cid = babygym_youtube_resolve_channel_id($handle);
        if (null !== $cid) {
            $ids = babygym_youtube_fetch_uploads_via_rss($cid);
        }
    }

    $memo = babygym_youtube_normalize_embed_list($ids);
    set_transient($cache_key, $memo, babygym_youtube_video_cache_ttl());

    return $memo;
}

/**
 * @param list<string> $list
 * @return list<string>
 */
function babygym_youtube_normalize_embed_list(array $list): array
{
    $embeds = [];
    foreach ($list as $item) {
        $item = trim((string) $item);
        if ('' === $item) {
            continue;
        }
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $item)) {
            $embeds[] = 'https://www.youtube.com/embed/' . $item . '?rel=0';
            continue;
        }
        $src = babygym_parse_video_embed_src($item);
        if (null !== $src) {
            $embeds[] = strpos($src, '?') !== false ? $src : ($src . '?rel=0');
        }
    }

    return array_values(array_unique($embeds));
}

/**
 * Risolve UC… configurato tramite filtro/map (offline o pagina cambiata).
 */
function babygym_youtube_resolve_channel_id_from_override(string $handle, string $t_key): ?string
{
    $override = apply_filters(
        'babygym_youtube_channel_id_override',
        [
            'babygym5384' => 'UCc02VpRFYFd1lIMZ0_NxnYA',
        ],
        $handle
    );
    if (! is_array($override) || ! isset($override[$handle])) {
        return null;
    }

    $cid = (string) $override[$handle];
    if (! preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $cid)) {
        return null;
    }

    set_transient($t_key, $cid, 7 * DAY_IN_SECONDS);

    return $cid;
}

/**
 * Risolve Channel ID UC… dalla pagina canale (/ @handle ).
 */
function babygym_youtube_resolve_channel_id(string $handle): ?string
{
    $handle = strtolower($handle);
    $t_key  = 'babygym_yt_ucid_' . md5($handle);
    $cached = get_transient($t_key);
    if (is_string($cached) && preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $cached)) {
        return $cached;
    }

    $url  = 'https://www.youtube.com/@' . rawurlencode($handle);
    $resp = wp_remote_get($url, [
        'timeout' => 18,
        'headers' => [
            'Accept-Language' => 'it,it-IT;q=0.9,en;q=0.8',
            'User-Agent'      => 'Mozilla/5.0 (compatible; BABYGYM-WordPress/1.0; +' . esc_url_raw(home_url('/')) . ')',
        ],
    ]);

    if (is_wp_error($resp)) {
        return babygym_youtube_resolve_channel_id_from_override($handle, $t_key);
    }

    $body = (string) wp_remote_retrieve_body($resp);
    if ('' === $body) {
        return babygym_youtube_resolve_channel_id_from_override($handle, $t_key);
    }

    // JSON inline (ytInitial…)
    $patterns = [
        '/\"channelId\":\"(UC[a-zA-Z0-9_-]{22})\"/',
        '/\"browseId\":\"(UC[a-zA-Z0-9_-]{22})\"/',
        '/\"externalId\":\"(UC[a-zA-Z0-9_-]{22})\"/',
        '/\\/channel\\/(UC[a-zA-Z0-9_-]{22})/',
    ];
    foreach ($patterns as $re) {
        if (preg_match($re, $body, $m)) {
            $cid = $m[1];
            set_transient($t_key, $cid, 7 * DAY_IN_SECONDS);
            return $cid;
        }
    }

    return babygym_youtube_resolve_channel_id_from_override($handle, $t_key);
}

/**
 * Elimina transient YouTube galleria e risoluzione UC (Customizer, deploy).
 */
function babygym_purge_youtube_video_cache(): void
{
    global $wpdb;

    $names = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
            '_transient_babygym_yt_%',
            '_transient_timeout_babygym_yt_%',
        ),
    );

    if (! is_array($names)) {
        return;
    }

    foreach ($names as $name) {
        delete_option((string) $name);
    }
}

add_action('customize_save_after', static function (): void {
    babygym_purge_youtube_video_cache();
});

/**
 * @return list<string> video IDs
 */
function babygym_youtube_fetch_uploads_via_rss(string $channel_id): array
{
    if (! preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $channel_id)) {
        return [];
    }

    $feed = 'https://www.youtube.com/feeds/videos.xml?channel_id=' . rawurlencode($channel_id);
    $resp = wp_remote_get($feed, [
        'timeout' => 18,
        'headers' => [
            'Accept' => 'application/atom+xml,application/xml,text/xml;q=0.9,*/*;q=0.8',
        ],
    ]);

    if (is_wp_error($resp) || wp_remote_retrieve_response_code($resp) !== 200) {
        return [];
    }

    $xml_body = wp_remote_retrieve_body($resp);
    if ('' === $xml_body) {
        return [];
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    if (! @$dom->loadXML($xml_body)) {
        return [];
    }

    $xp    = new DOMXPath($dom);
    $nodes = $xp->query('//*[local-name()="videoId"]');

    $ids = [];
    if ($nodes instanceof DOMNodeList) {
        foreach ($nodes as $n) {
            $id = trim($n->textContent ?? '');
            if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $id)) {
                $ids[] = $id;
            }
        }
    }

    return array_values(array_unique($ids));
}

/**
 * @return list<string> video IDs
 */
function babygym_youtube_fetch_uploads_via_api(string $handle, string $api_key): array
{
    $handle = strtolower(ltrim($handle, '@'));

    $ch_url = add_query_arg(
        [
            'part'       => 'contentDetails',
            'forHandle'  => rawurlencode($handle),
            'key'        => $api_key,
        ],
        'https://www.googleapis.com/youtube/v3/channels'
    );

    $ch_resp = wp_remote_get($ch_url, ['timeout' => 15]);

    if (is_wp_error($ch_resp) || wp_remote_retrieve_response_code($ch_resp) !== 200) {
        return [];
    }

    $ch_json = json_decode((string) wp_remote_retrieve_body($ch_resp), true);
    if (! is_array($ch_json)) {
        return [];
    }

    $items = $ch_json['items'] ?? [];
    if (! isset($items[0]['contentDetails']['relatedPlaylists']['uploads'])) {
        return [];
    }

    $playlist_id = (string) $items[0]['contentDetails']['relatedPlaylists']['uploads'];

    return babygym_youtube_api_playlist_collect_ids($playlist_id, $api_key);
}

/**
 * @return list<string> video IDs
 */
function babygym_youtube_api_playlist_collect_ids(string $playlist_id, string $api_key): array
{
    $ids        = [];
    $page_token = '';

    for ($guard = 0; $guard < 40; $guard++) {
        $args = [
            'part'       => 'contentDetails',
            'playlistId' => $playlist_id,
            'maxResults' => 50,
            'key'        => $api_key,
        ];
        if ('' !== $page_token) {
            $args['pageToken'] = $page_token;
        }

        $url = add_query_arg($args, 'https://www.googleapis.com/youtube/v3/playlistItems');

        $resp = wp_remote_get($url, ['timeout' => 18]);
        if (is_wp_error($resp) || wp_remote_retrieve_response_code($resp) !== 200) {
            break;
        }

        $data = json_decode((string) wp_remote_retrieve_body($resp), true);
        if (! is_array($data) || empty($data['items'])) {
            break;
        }

        foreach ($data['items'] as $row) {
            $vid = (string) ($row['contentDetails']['videoId'] ?? '');
            if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $vid)) {
                $ids[] = $vid;
            }
        }

        $page_token = isset($data['nextPageToken']) ? (string) $data['nextPageToken'] : '';
        if ('' === $page_token) {
            break;
        }
    }

    return array_values(array_unique($ids));
}
