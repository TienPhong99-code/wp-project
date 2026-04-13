<?php

/**
 * The template for front page
 *
 * @author MONA.Media / Website
 */

if (! defined('ABSPATH')) {
   die();
}

$page_id = MONA_PAGE_HOME;
$section_feedback = get_field('section_feedback', $page_id) ?? null;
$show_section_commit = get_field('show_section_commit', $page_id) ?? null;
$section_about = get_field('section_about', $page_id) ?? null;
$section_news = get_field('section_news', $page_id) ?? null;

get_header();

the_title('<h1 class="hide-sitename">', '</h1>');
?>
<div class="custom-cursor"></div>

<?php ?>
<h1 class="text-red-500 text-4xl">Test Tailwind</h1>
<?php ?>

<?php get_template_part('partials/sections/section', 'support'); ?>
<?php
get_footer();
