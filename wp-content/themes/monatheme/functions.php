<?php
declare(strict_types=1);

/**
 * The template for displaying index.
 *
 * @package MONA.Media / Website
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme information
define( 'MONA_THEME_VERSION', '4.3.0' );
define( 'MONA_THEME_PATH', get_template_directory() );
define( 'MONA_THEME_PATH_URI', get_template_directory_uri() );
define( 'MONA_THEME_INC_PATH', MONA_THEME_PATH . '/inc' );
define( 'MONA_THEME_CONFIG_PATH', MONA_THEME_PATH . '/configs' );
define( 'MONA_SITE_URL', get_option( 'siteurl' ) );

// Define theme page
define( 'MONA_PAGE_HOME', get_option( 'page_on_front', true ) );
define( 'MONA_PAGE_BLOG', get_option( 'page_for_posts', true ) );
define( 'MONA_CUSTOM_LOGO', get_theme_mod('custom_logo') );
define( 'MONA_POSTS_PER_PAGE', get_option('posts_per_page', 6) );


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/inc/init.php';
