<?php

/**
 * 
 * REGISTER TYPE POST SLIDERS HOME
 * 
 */

add_action('init', 'PA_Register_Sliders_Home_Post_Type');

function PA_Register_Sliders_Home_Post_Type()
{

  $labels = array(
    'name' => __('Sliders Home', 'iasd'),
    'singular_name' => __('Slider Home', 'iasd'),
  );

  $args = array(
    'labels' => $labels,
    'description' => __('Front Page Slider Home', 'iasd'),
    'public' => true
  );

  register_post_type('slider_home', $args);
}
