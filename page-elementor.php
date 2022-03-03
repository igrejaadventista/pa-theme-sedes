<?php

/* 
  Template name: Page - Elementor 
  Template Post Type: projects, post, page
*/

get_header();
?>
<?php
require(get_template_directory() . '/components/parent/header.php');
?>

<div>
  <?php the_content(); ?>
</div>


<?php get_footer(); ?>
