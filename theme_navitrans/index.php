<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theme_navitrans
 */

get_header();
?>

<main id="primary" class="site-main">

  <?php
  while (have_posts()):
    the_post();
    ?>

    <?php
    the_content(
      sprintf(
        wp_kses(
          /* translators: %s: Name of current post. Only visible to screen readers */
          __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'theme-satrack'),
          array(
            'span' => array(
              'class' => array(),
            ),
          )
        ),
        wp_kses_post(get_the_title())
      )
    );

    wp_link_pages(
      array(
        'before' => '<div class="page-links">' . esc_html__('Pages:', 'theme-satrack'),
        'after' => '</div>',
      )
    );
    ?>


    <?php
  endwhile; // End of the loop.
  ?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
