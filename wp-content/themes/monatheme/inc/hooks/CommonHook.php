<?php
if (! defined('ABSPATH')) {
   die;
}

// After setup theme
add_action('after_setup_theme', function () {
   // regsiter menu
   register_nav_menus(
      [
         'header-menu-pc' => __('Header Menu PC', 'monamedia'),
         'header-menu-mb' => __('Header Menu Mobile', 'monamedia'),
      ]
   );
});

/**
 * Add param to admin url when use ajax
 * 
 * @param string $url The complete admin area URL including scheme and path.
 * @param string $path Path relative to the admin area URL. Blank string if no path is specified.
 * @param int|null $blog_id Site ID, or null for the current site
 * 
 * @return string
 */
add_filter('admin_url', function ($url, $path, $blog_id) {
   if ($path === 'admin-ajax.php' && ! is_admin()) {
      $url .= '?mona-ajax';
   }

   return $url;
}, 999, 3);

// Register css
add_action('wp_enqueue_scripts', function () {
   if (is_404()) {
      wp_enqueue_style('mona-404', MONA_THEME_PATH_URI . '/assets/css/404.css');
   }
   wp_enqueue_style('mona-reset', MONA_THEME_PATH_URI . '/assets/css/reset.css', [], MONA_THEME_VERSION);
   // Tailwind - CDN cho dev, build cho production
   if (WP_DEBUG) {
      // Team dùng CDN khi dev
      wp_enqueue_style('mona-tailwind-cdn', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4');
   } else {
      // Build file khi production
      wp_enqueue_style('mona-tailwind', MONA_THEME_PATH_URI . '/assets/css/tailwind.output.css', [], MONA_THEME_VERSION);
   }
   wp_enqueue_style('mona-style', MONA_THEME_PATH_URI . '/assets/css/style.css', [], MONA_THEME_VERSION);
   wp_enqueue_style('mona-backdoor', MONA_THEME_PATH_URI . '/assets/css/backdoor.css', [], MONA_THEME_VERSION);
   wp_enqueue_style('mona-main-style', get_stylesheet_uri());
   wp_enqueue_style('mona-custom', MONA_THEME_PATH_URI . '/assets/css/mona-custom.css');
   wp_enqueue_style('mona-notification', MONA_THEME_PATH_URI . '/assets/css/notification.css');
}, 10);

// Register js
add_action('wp_enqueue_scripts', function () {
   wp_add_inline_script('jquery-core', 'window.$=jQuery');
   wp_enqueue_script(
      'mona-swiper',
      MONA_THEME_PATH_URI . '/assets/library/swiper/swiper-bundle.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-aos',
      MONA_THEME_PATH_URI . '/assets/library/aos/aos.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-select2',
      MONA_THEME_PATH_URI . '/assets/library/select2/select2.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-flatpickr',
      MONA_THEME_PATH_URI . '/assets/library/flatpickr/flatpickr.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-SmoothScroll',
      MONA_THEME_PATH_URI . '/assets/library/smoothscroll/SmoothScroll.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-splitting',
      MONA_THEME_PATH_URI . '/assets/library/splitting/splitting.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-fancybox',
      MONA_THEME_PATH_URI . '/assets/library/fancybox/fancybox.umd.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-gsap',
      MONA_THEME_PATH_URI . '/assets/library/gsap/gsap.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-ScrollTrigger',
      MONA_THEME_PATH_URI . '/assets/library/gsap/ScrollTrigger.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-ukiyo',
      MONA_THEME_PATH_URI . '/assets/library/ukiyo/ukiyo.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-splide',
      MONA_THEME_PATH_URI . '/assets/library/splide/splide.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-splide-extension',
      MONA_THEME_PATH_URI . '/assets/library/splide/splide-extension-auto-scroll.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-vanilla',
      MONA_THEME_PATH_URI . '/assets/library/vanilatilt/vanilla-tilt.min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-jquery.ripples',
      MONA_THEME_PATH_URI . '/assets/library/ripples/jquery.ripples-min.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-main',
      MONA_THEME_PATH_URI . '/assets/scripts/main.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   wp_enqueue_script(
      'mona-backend',
      MONA_THEME_PATH_URI . '/assets/scripts/mona-frontend.js',
      array('jquery'),
      MONA_THEME_VERSION,
      array(
         'in_footer' => true,
      )
   );

   $params = apply_filters('mona_ajax_params', [
      'siteURL'   => get_site_url(),
      'ajaxURL'   => admin_url('admin-ajax.php'),
      'ajaxNonce' => wp_create_nonce('mona-ajax-security'),
   ]);

   wp_localize_script('mona-backend', 'mona_params', $params);

   if (is_front_page()) {
      wp_enqueue_script(
         'mona-home',
         MONA_THEME_PATH_URI . '/assets/scripts/home.js',
         array('jquery'),
         MONA_THEME_VERSION,
         array(
            'in_footer' => true,
         )
      );
   }
}, 10);

// Change script type to module
add_filter('script_loader_tag', function ($tag, $handle) {
   // Handlers
   $handlers = apply_filters('mona_script_to_module', [
      'mona-main',
      'mona-backend',
   ]);

   if (in_array($handle, $handlers)) {
      $tag = str_replace('<script', '<script type="module"', $tag);
   }

   return $tag;
}, 10, 2);

// Preconnect google font
add_action('wp_head', function () {
?>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
<?php
}, 1);

// Override query posts
add_action('pre_get_posts', function (WP_Query $query) {
   if (! $query->is_admin() && $query->is_main_query()) {
      if ($query->is_category() || $query->is_tag() || $query->is_home()) {
         $paged = max(get_query_var('paged'), 1);
         $posts_per_page = wp_is_mobile() ? MONA_POSTS_PER_PAGE : 9;

         $query->set('posts_per_page', $posts_per_page);
         $query->set('offset', ($paged - 1) * $posts_per_page);
      }
   }
}, 10, 1);

// Override body class
add_filter('mona_main_classes', function (array $classes) {
   if (is_page_template('page-template/template-policy.php')) {
      $classes[] = 'page-policy';
   } elseif (is_page_template('page-template/template-contact.php')) {
      $classes[] = 'page-contact';
   } elseif (is_page_template('page-template/template-about.php')) {
      $classes[] = 'page-about';
   } elseif (is_singular('post')) {
      $classes[] = 'page-news';
   } elseif (is_front_page()) {
      $classes[] = 'page-home';
   } elseif (is_page() && ! is_page_template() && ! is_front_page() && ! is_home()) {
      $classes[] = 'page-policy';
   }

   return $classes;
}, 10, 1);

add_action('template_redirect', function () {
   global $mona_current_permalink;

   $mona_current_permalink = mona_get_current_permalink();
});
