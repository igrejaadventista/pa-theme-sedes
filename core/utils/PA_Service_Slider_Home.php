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
    'name' => _x('Sliders Home', 'Nome do post genérico'),
    'singular_name' => _x('Slider Home', 'Nome do post no singular'),
  );

  $args = array(
    'labels' => $labels,
    'description' => 'Sliders da Página Inicial',
    'public' => true
  );

  register_post_type('slider_home', $args);
}
