<?php


//Hide Post Page Options from all except Administrator
if (!current_user_can('administrator')) {
  function hide_post_page_options()
  {
    global $post;
    $hide_post_options = "
    <style type=\"text/css\"> 
      .editor-post-taxonomies__hierarchical-terms-add,
      .wp-hidden-children,
      #menu-pages, #menu-appearance, 
      #toplevel_page_pa-adventistas, 
      #toplevel_page_wpseo_workouts, 
      #menu-tools, 
      #wp-admin-bar-new-page 
      { 
        display: none; 
      }
    </style>";
    print($hide_post_options);
  }
  add_action('admin_head', 'hide_post_page_options');
}
