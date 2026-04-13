<?php
/**
 * Custom nav menu
 * 
 * @author MONA.Media / Website
 */
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

if ( ! class_exists( 'Mona_Walker_Nav_Menu_Desktop' ) ) {
    class Mona_Walker_Nav_Menu_Desktop extends Walker_Nav_Menu {
        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class='child js-child{$depth}'>\n";
        }

        function end_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        function start_el( &$output, $item, $depth=0, $args=array(), $id = 0 ) {
            $title = $item->title;
            $permalink = $item->url;

            // Check has children
            $has_children = in_array('menu-item-has-children', $item->classes);

            $images = get_field('images', $item);
            if ($has_children) {
                $item->classes[] = 'dropdown';
            }

            $output .= "<li class='" .  implode(" ", $item->classes) . "'>";

            //Add SPAN if no Permalink
            if ( $permalink && $permalink != '#' ) {
                $output .= '<a class="menu-link" href="' . $permalink . '" title="' . $title . '">';
            } else {
                $output .= '<a class="menu-link" href="javascript:;" title="' . $title . '">';
            }

            $output .= '<span>' . $title . '</span>';

            $output .= '</a>';

            // If image
            $output .= '<div class="images" style="display:none;">';
            if ($images) {
                $output .= '<div class="desk-imgs">';
                foreach ($images as $image) {
                    $output .= '<div class="desk-img">';
                        $output .= mona_get_image_by_id($image);
                    $output .= '</div>';
                }
                $output .= '</div>';
            }
            $output .= '</div>';
        }
    }
}
