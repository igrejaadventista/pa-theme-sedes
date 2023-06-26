<?php

use IASD\Core\Settings\Modules;

class PaRestCleanup
{
  public function __construct()
  {
    add_filter('wp_headless_rest__enable_rest_cleanup', array($this, 'wp_headless_rest_enable_rest_cleanup'));
    add_filter('wp_headless_rest__rest_endpoints_to_remove', array($this, 'wp_rest_headless_disable_endpoints'));
    add_filter('wp_headless_rest__post_types_to_clean', array($this, 'wp_rest_headless_clean_post_types'));
    add_filter('wp_headless_rest__rest_object_remove_nodes', array($this, 'wp_rest_headless_clean_response_nodes'));
  }

  function wp_headless_rest_enable_rest_cleanup() 
  {
    return Modules::isActiveModule('restcleanup');
  }

  function wp_rest_headless_disable_endpoints()
  {
    if(!Modules::isActiveModule('restcleanup'))
        return [];

    $to_remove = array(
      // '/wp/v2/post',
      '/wp/v2/media',
      '/wp/v2/types',
      '/wp/v2/statuses',
      '/wp/v2/taxonomies',
      '/wp/v2/tags',
      '/wp/v2/users',
      '/wp/v2/comments',
      '/wp/v2/themes',
      '/wp/v2/blocks',
      '/wp/v2/block-renderer',
      '/oembed/',
      '/wp/v2/pages',

      // CUSTOM
      '/wp/v2/pa_video_gallery',
      '/wp/v2/categories',
      '/wp/v2/search',
      '/wp/v2/block-types',
      '/wp/v2/plugins',
      '/wp/v2/block-directory',
      '/wp/v2/settings',
      '/wp/v2/templates',
      '/wp/v2/pattern-directory/patterns',
      '/wp/v2/widgets',
      '/wp/v2/widget-types',
      '/wp/v2/sidebars',
      '/wp/v2/yoast_head_json',
      '/wp/v2/yoast_head'
    );

    return $to_remove;
  }

  function wp_rest_headless_clean_response_nodes()
  {
    if(!Modules::isActiveModule('restcleanup'))
        return [];

    $to_remove = array(
      'guid',
      '_links',
      'ping_status'
    );
    return $to_remove;
  }
  function wp_rest_headless_clean_post_types()
  {
    if(!Modules::isActiveModule('restcleanup'))
        return [];

    $to_clean = array(
      'post',
      'press',
      'columnists'
    );
    return $to_clean;
  }
}

$PaRestCleanup = new PaRestCleanup();
