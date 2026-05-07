<?php
/**
 * BABYGYM theme bootstrap.
 *
 * @package BABYGYM
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once get_theme_file_path('inc/theme/setup.php');
require_once get_theme_file_path('inc/theme/contact-form.php');
require_once get_theme_file_path('inc/theme/maintenance.php');
require_once get_theme_file_path('inc/theme/assets.php');
require_once get_theme_file_path('inc/theme/video-customizer.php');
require_once get_theme_file_path('inc/theme/video-channel-gallery.php');

require_once get_theme_file_path('inc/utils/time.php');

require_once get_theme_file_path('inc/cpt/summer-camp.php');

require_once get_theme_file_path('inc/admin/helpers/fields.php');
require_once get_theme_file_path('inc/admin/enqueue-media.php');
require_once get_theme_file_path('inc/admin/feste.php');
require_once get_theme_file_path('inc/admin/corsi.php');
require_once get_theme_file_path('inc/admin/galleria.php');

require_once get_theme_file_path('inc/admin/summer-camp-order.php');
