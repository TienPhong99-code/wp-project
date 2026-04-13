<?php
/**
 * The template for all template
 * 
 * @author MONA.Media / Website
 */

if ( ! defined( 'ABSPATH' ) ) {
    die();
}
?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>