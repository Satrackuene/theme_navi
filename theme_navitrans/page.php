<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
get_footer();
