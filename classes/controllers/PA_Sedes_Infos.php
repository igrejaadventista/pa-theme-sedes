<?php
function getNetworkInfo()
{
  switch_to_blog(1);
  $fields = get_fields('pa_network_settings');
  restore_current_blog();
  return $fields;
}

function getSiteInfo()
{
  if (!empty(get_field('overwrite_global_settings', 'pa_settings')) || !is_multisite()) {
    return get_fields('pa_settings');
  }
  return getNetworkInfo();
}
