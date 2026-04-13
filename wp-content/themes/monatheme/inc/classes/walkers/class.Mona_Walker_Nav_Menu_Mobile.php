<?php
/**
 * Custom nav menu
 * 
 * @author MONA.Media / Website
 */
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

if ( ! class_exists( 'Mona_Walker_Nav_Menu_Mobile' ) ) {
    class Mona_Walker_Nav_Menu_Mobile extends Walker_Nav_Menu {
        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class='menu-list'>\n";
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

            // If has children
            if ($has_children) {
                $output .= '<i class="bx bxs-chevron-down"></i>';
            }

            $output .= '</a>';
        }
    }
}
