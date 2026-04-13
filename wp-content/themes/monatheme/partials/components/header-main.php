<?php
/**
 * Header Main Component
 * Design: KienA Figma – Node 94:36827
 */

defined('ABSPATH') || exit;

$lang_vi = get_field('header_lang_vi', 'option') ?: home_url('/');
$lang_en = get_field('header_lang_en', 'option') ?: '#';
?>
<header class="hd">
    <div class="hd-wr">
        <div class="container">
            <div class="flex items-center justify-between py-4">

                <!-- Logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>"
                   class="block relative w-41.5 h-13 shrink-0">
                    <div class="absolute inset-[0_0_34.21%_0]">
                        <img class="block w-full h-full object-contain object-left"
                             src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/header-logo.svg"
                             alt="KIENA"
                             loading="lazy">
                    </div>
                    <div class="absolute inset-[81.09%_0_0_0]">
                        <img class="block w-full h-full object-contain object-left"
                             src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/header-logo-tagline.svg"
                             alt="Creating Values For Life"
                             loading="lazy">
                    </div>
                </a>

                <!-- Right navigation -->
                <div class="flex items-center gap-8">

                    <!-- Language switcher -->
                    <div class="flex items-center gap-2">
                        <a href="<?php echo esc_url($lang_vi); ?>"
                           class="font-bold text-[14px] leading-normal text-[#283377] tracking-[-0.56px] uppercase whitespace-nowrap">VI</a>
                        <span class="block w-px h-4 bg-[#BCC0D5]"></span>
                        <a href="<?php echo esc_url($lang_en); ?>"
                           class="font-bold text-[14px] leading-normal text-[#BCC0D5] tracking-[-0.56px] uppercase whitespace-nowrap">EN</a>
                    </div>

                    <!-- Menu button -->
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-[14px] leading-normal text-[#283377] tracking-[-0.56px] uppercase">MENU</span>
                        <button class="hamburger bg-[#283377] rounded-lg px-3 py-2 flex items-center justify-center"
                                id="hamburger"
                                type="button"
                                aria-label="Mở menu">
                            <div class="w-6 h-6">
                                <img class="block w-full h-full"
                                     src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-hamburger.svg"
                                     alt=""
                                     loading="lazy">
                            </div>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu overlay -->
    <div class="mobile-overlay"></div>
    <div class="mobile">
        <div class="mobile-con">
            <div class="mobile-wr">
                <div class="mobile-nav">
                    <div class="mobile-close">
                        <div class="iwt">
                            <div class="icon"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                    </div>
                    <div class="mobile-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/header-logo.svg"
                                 alt="KIENA"
                                 loading="lazy">
                        </a>
                    </div>
                    <div class="menu-nav">
                        <?php
                        mona_cached_nav_menu([
                            'container'       => false,
                            'container_class' => '',
                            'menu_class'      => 'menu-list',
                            'theme_location'  => 'header-menu-mb',
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'fallback_cb'     => false,
                            'walker'          => new Mona_Walker_Nav_Menu_Mobile,
                        ]);
                        ?>
                    </div>
                    <div class="mobile-content"></div>
                </div>
            </div>
        </div>
    </div>
</header>
