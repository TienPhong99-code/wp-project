<?php
defined('ABSPATH') || exit;

/**
 * Load files
 */
return [
    // classes
    MONA_THEME_INC_PATH . '/classes/class.Mona_SetupTheme.php',
    MONA_THEME_INC_PATH . '/classes/walkers/class.Mona_Walker_Nav_Menu_Desktop.php',
    MONA_THEME_INC_PATH . '/classes/walkers/class.Mona_Walker_Nav_Menu_Mobile.php',

    // Functions
    MONA_THEME_INC_PATH . '/functions/CommonFunction.php',
    MONA_THEME_INC_PATH . '/functions/ImageFunction.php',
    MONA_THEME_INC_PATH . '/functions/PaginationFunction.php',
    MONA_THEME_INC_PATH . '/functions/PostFunction.php',
    MONA_THEME_INC_PATH . '/functions/TaxonomyFunction.php',
    MONA_THEME_INC_PATH . '/functions/CommentFunction.php',
    MONA_THEME_INC_PATH . '/functions/ACFFunction.php',

    // Hooks
    MONA_THEME_INC_PATH . '/hooks/CommonHook.php',
    MONA_THEME_INC_PATH . '/hooks/ImageHook.php',
    MONA_THEME_INC_PATH . '/hooks/PostHook.php',
    MONA_THEME_INC_PATH . '/hooks/AjaxHook.php',
    MONA_THEME_INC_PATH . '/hooks/ShortcodeHook.php',

    // Caches
    MONA_THEME_INC_PATH . '/caches/MenuCache.php',

    // Ajax
    MONA_THEME_INC_PATH . '/ajax/PostAjax.php',

    // ACF
    MONA_THEME_INC_PATH . '/acf/FooterACF.php',
    MONA_THEME_INC_PATH . '/acf/GeneralACF.php',
    MONA_THEME_INC_PATH . '/acf/MenuACF.php',
    MONA_THEME_INC_PATH . '/acf/SidebarACF.php',
    MONA_THEME_INC_PATH . '/acf/ContactACF.php',
    MONA_THEME_INC_PATH . '/acf/AboutACF.php',
    MONA_THEME_INC_PATH . '/acf/BlogACF.php',
    MONA_THEME_INC_PATH . '/acf/HomeACF.php',
];