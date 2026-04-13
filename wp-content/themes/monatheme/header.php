<?php

/**
 * The template for displaying header.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Body class
if (wp_is_mobile()) {
    $body = 'mobile-detect';
} else {
    $body = 'desktop-detect';
}

$menu_pc_items = wp_get_nav_menu_object(get_nav_menu_locations()['header-menu-pc']);
$menu_tree = [];
if (! empty($menu_pc_items)) {
    $menu_pc_items = wp_get_nav_menu_items($menu_pc_items->term_id, ['no_found_rows' => true,]);
    
    if ($menu_pc_items) {
        foreach ($menu_pc_items as $item) {
            if (!$item->menu_item_parent) {
                $menu_tree[$item->ID] = ['item' => $item, 'children' => []];
            } else {
                $parent_id = $item->menu_item_parent;
                if (isset($menu_tree[$parent_id])) {
                    $menu_tree[$parent_id]['children'][$item->ID] = ['item' => $item, 'children' => []];
                } else {
                    foreach ($menu_tree as &$top_item) {
                        if (isset($top_item['children'][$parent_id])) {
                            $top_item['children'][$parent_id]['children'][$item->ID] = ['item' => $item];
                        }
                    }
                }
            }
        }
    }
}

$header_top_settings = get_field('header_top', 'option');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
    <!-- Meta ================================================== -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <?php wp_site_icon(); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
</head>

<body <?php body_class($body); ?>>
    <!-- <header class="hd">
        <div class="hd-wr">
            <div class="container">
                <div class="hd-flex">
                    <div class="hd-left">
                        <div class="burger">
                            <div class="hamburger" id="hamburger">
                                <svg class="ham" viewbox="0 0 100 100" width="48">
                                    <path class="line top"
                                        d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40">
                                    </path>
                                    <path class="line middle" d="m 30,50 h 40"></path>
                                    <path class="line bottom"
                                        d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="burger">
                            <div class="burgerDesk" id="burgerDesk">
                                <svg class="ham" viewbox="0 0 100 100" width="48">
                                    <path class="line top"
                                        d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40">
                                    </path>
                                    <path class="line middle" d="m 30,50 h 40"></path>
                                    <path class="line bottom"
                                        d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40">
                                    </path>
                                </svg><span class="txt">Menu</span>
                            </div>
                        </div>
                    </div>
                    <div class="hd-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                    <div class="hd-act">
                        <div class="hd-srch">
                            <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-srch.svg" alt="image" loading="lazy" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="found foundJS">
            <div class="found-over foundOver"></div>
            <div class="found-x foundClose"> <i class="fa-solid fa-xmark-large"></i></div>
            <div class="found-wr">
                <div class="container">
                    <div class="found-f">
                        <p class="tt"><?php esc_html_e('TÌM KIẾM', 'monamedia'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mobile-overlay"></div>
        <div class="mobile">
            <div class="mobile-con">
                <div class="mobile-wr">
                    <div class="mobile-nav">
                        <div class="mobile-close">
                            <div class="iwt">
                                <div class="icon"> <i class="fa-solid fa-xmark"></i></div>
                            </div>
                        </div>
                        <div class="mobile-logo">
                            <?php the_custom_logo(); ?>
                        </div>

                        <?php if (has_nav_menu('header-menu-mb')) : ?>
                            <div class="menu-nav">
                                <?php
                                mona_cached_nav_menu(array(
                                    'container' => false,
                                    'container_class' => '',
                                    'menu_class' => 'menu-list',
                                    'theme_location' => 'header-menu-mb',
                                    'before' => '',
                                    'after' => '',
                                    'link_before' => '',
                                    'link_after' => '',
                                    'fallback_cb' => false,
                                    'walker' => new Mona_Walker_Nav_Menu_Mobile,
                                ));
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="mobile-content"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="desk-overlay"> </div>

        <div class="desk">
            <div class="desk-con">
                <div class="desk-wr">
                    <div class="desk-nav">
                        <div class="desk-close">
                            <div class="iwt">
                                <div class="icon"> <i class="fa-solid fa-xmark"></i></div>
                            </div>
                        </div>
                        <div class="desk-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                        <div class="hd-lg">
                            <div class="hd-lg__item active"> <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/flag-vn.svg" alt="image" loading="lazy" />
                            </div>
                            <div class="hd-lg__item"> <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/flag-uk.svg" alt="image" loading="lazy" />
                            </div>
                            <div class="hd-lg__item"> <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/flag-jp.svg" alt="image" loading="lazy" />
                            </div>
                        </div>

                        <?php if (! empty($menu_tree)) : ?>
                            <div class="desk-nav deskMenuJS">
                                <ul class="desk-list">
                                    <?php foreach ($menu_tree as $id => $node) : 
                                        $item = $node['item'];
                                        $has_children = !empty($node['children']);
                                        $data_id = sanitize_title($item->title); 
                                        ?>
                                        <li class="desk-item <?php echo $has_children ? 'dropdown' : ''; ?>" data-id="<?php echo $data_id; ?>">
                                            <a class="desk-link" href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="desk-content"></div>
                    </div>
                </div>
            </div>

            <?php if (! empty($menu_tree)) : ?>
                <div class="desk-panels deskPanelJS">
                    <?php foreach ($menu_tree as $id => $node) : 
                        $item = $node['item'];
                        $data_id = sanitize_title($item->title);

                        $title_panel = get_field('title_panel', $item);
                        if (empty($title_panel)) {
                            $title_panel = $item->title;
                        }
                        ?>
                        <div class="desk-panel" data-id-tab="<?php echo $data_id; ?>">
                            <?php if (!empty($node['children'])) : ?>
                                <div class="desk-top"><?php echo esc_html($title_panel); ?></div>
                                <div class="desk-bottom">
                                    <div class="desk-menu">
                                        <div class="desk-menu__box c2">
                                            <div class="desk-menu__c2 deskMenuC2JS">
                                                <ul class="menu-list">
                                                    <?php foreach ($node['children'] as $c2_id => $c2_node) : 
                                                        $c2_item = $c2_node['item'];

                                                        $gallery = get_field('images', $c2_item);
                                                        $has_gallery = ! empty($gallery);
                                                        $has_c3 = !empty($c2_node['children']);

                                                        $data_id = sanitize_title($c2_item->title);
                                                    ?>
                                                        <li class="menu-item <?php echo $has_c3 || $has_gallery ? 'dropdown' : ''; ?>" 
                                                            data-c2="<?php echo $data_id ?>" 
                                                            data-c3="<?php echo $data_id ?>">
                                                            <a class="menu-link" href="<?php echo $c2_item->url; ?>"><?php echo $c2_item->title; ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>

                                                
                                            </div>
                                        </div>

                                        <div class="desk-menu__box c3">
                                            <div class="desk-menu__c3 deskPanelC2JS deskMenuC3JS">
                                                <?php foreach ($node['children'] as $c2_id => $c2_node) :
                                                    $gallery = get_field('images', $c2_node['item']);

                                                    if (!empty($c2_node['children']) || ! empty($gallery)) :
                                                    ?>
                                                    <div class="desk-menu__c3-panel" 
                                                        data-c2-id="<?php echo sanitize_title($c2_node['item']->title); ?>">
                                                        <?php if (!empty($c2_node['children'])) : ?>
                                                            <ul class="menu-list">
                                                                <?php foreach ($c2_node['children'] as $c3_id => $c3_node) : 
                                                                    $c3_item = $c3_node['item'];
                                                                    $gallery2 = get_field('images', $c3_item);

                                                                    $has_gallery = ! empty($gallery2);
                                                                ?>
                                                                    <li class="menu-item <?php echo $has_gallery ? 'dropdown' : ''; ?>" data-c3="<?php echo sanitize_title($c3_item->title); ?>">
                                                                        <a class="menu-link" href="<?php echo $c3_item->url; ?>"><?php echo $c3_item->title; ?></a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>

                                                        <?php if (! empty($gallery)) : ?>
                                                            <ul class="img-list">
                                                                <?php foreach ($gallery as $image) : ?>
                                                                    <li class="img-item">
                                                                        <?php echo mona_get_image_by_id($image); ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; 
                                                endforeach; ?>

                                            </div>
                                        </div>

                                        <div class="desk-menu__box c4">
                                            <div class="desk-imgs__panels deskPanelC3JS">
                                                <?php foreach ($node['children'] as $c2_id => $c2_node) : 
                                                    if (!empty($c2_node['children'])) {
                                                        foreach ($c2_node['children'] as $c3_id => $c3_node) {
                                                            $gallery = get_field('images', $c3_node['item']);
    
                                                            if (! empty($gallery)) {
                                                                ?>
                                                                <div class="desk-imgs__panel" 
                                                                    data-c3-id="<?php echo sanitize_title($c3_node['item']->title); ?>">
                                                                    <div class="desk-imgs">
                                                                        <?php foreach ($gallery as $image) : ?>
                                                                            <div class="desk-img">
                                                                                <div class="img">
                                                                                    <?php echo mona_get_image_by_id($image); ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </header> -->

    <!-- <div class="fixedNav"> 
        <div class="container"> 
            <div class="fixedNav-list"> 
                <?php if (MONA_PAGE_HOME) : ?>
                    <a class="fixedNav-item <?php echo is_front_page() ? 'active' : ''; ?>"
                        href="<?php echo get_permalink(MONA_PAGE_HOME); ?>"> 
                        <div class="inner"> 
                            <div class="icon">
                                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-home.svg" alt="image" loading="lazy"/>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div> -->

    <?php get_template_part('partials/components/header-main'); ?>

    <main class="<?php echo join(' ', apply_filters('mona_main_classes', ['main'])); ?>">