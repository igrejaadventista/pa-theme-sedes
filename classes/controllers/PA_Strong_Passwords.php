<?php

/**
 * Enforce strong passwords (ESP) for all website users.
 *
 * To disable enforcing strong passwords:
 *   define('ESP_IS_ENABLED', false);
 */

if (!defined('WPINC')) {
  exit('Do NOT access this file directly.');
}

/**
 * Initialise constants and handlers.
 */
function esp_init()
{
  if (defined('ESP_IS_ENABLED') && (ESP_IS_ENABLED === false)) {
    // Disabled by configuration.
  } else {
    add_action('user_profile_update_errors', 'esp_user_profile_update_errors', 0, 3);
    add_action('resetpass_form', 'esp_resetpass_form', 10);
    add_action('validate_password_reset', 'esp_validate_password_reset', 10, 2);
  }
}
add_action('init', 'esp_init');

function esp_user_profile_update_errors($errors, $update, $user_data)
{
  return esp_validate_password_reset($errors, $user_data);
}

function esp_resetpass_form($user_data)
{
  return esp_validate_password_reset(false, $user_data);
}

/**
 * Sanitise the input parameters and then check the password strength.
 */
function esp_validate_password_reset($errors, $user_data)
{
  $is_password_ok = false;

  $user_name = null;
  if (isset($_POST['user_login'])) {
    $user_name = sanitize_text_field($_POST['user_login']);
  } elseif (isset($user_data->user_login)) {
    $user_name = $user_data->user_login;
  } else {
    // No user specified.
  }

  $password = null;
  if (isset($_POST['pass1']) && !empty(trim($_POST['pass1']))) {
    $password = sanitize_text_field(trim($_POST['pass1']));
  }

  $error_message = null;
  if (is_null($password)) {
    // Don't do anything if there isn't a password to check.
  } elseif (is_wp_error($errors) && $errors->get_error_data('pass')) {
    // We've already got a password-related error.
  } elseif (empty($user_name)) {
    $error_message = __('User name cannot be empty.', 'iasd');
  } elseif (!($is_password_ok = esp_is_password_ok($password, $user_name))) {
    $error_message = __('Password is not strong enough.', 'iasd');
  } else {
    // Password is strong enough. All OK.
  }

  if (!empty($error_message)) {
    $error_message = '<strong>ERROR</strong>: ' . $error_message;
    if (!is_a($errors, 'WP_Error')) {
      $errors = new WP_Error('pass', $error_message);
    } else {
      $errors->add('pass', $error_message);
    }
  }

  return $errors;
}

/**
 * Given a password, return true if it's OK, otherwise return false.
 */
function esp_is_password_ok($password, $user_name)
{
  // Default to the password not being valid - fail safe.
  $is_ok = false;

  $password = sanitize_text_field($password);
  $user_name = sanitize_text_field($user_name);

  $is_number_found = preg_match('/[0-9]/', $password);
  $is_lowercase_found = preg_match('/[a-z]/', $password);
  $is_uppercase_found = preg_match('/[A-Z]/', $password);
  $is_symbol_found = preg_match('/[^a-zA-Z0-9]/', $password);

  if (strlen($password) < 8) {
    // Too short
  } elseif (strtolower($user_name) == strtolower($password)) {
    // User name and password can't be the same.
  } elseif (!$is_number_found) {
    // ...
  } elseif (!$is_lowercase_found) {
    // ...
  } elseif (!$is_uppercase_found) {
    // ...
  } elseif (!$is_symbol_found) {
    // ...
  } else {
    // Password is OK.
    $is_ok = true;
  }

  return $is_ok;
}

// Isso não é a ,elhor maneira de ocultar o campo que libera criar senha fraca, precisamso pensar numa forma melhor, pois desse jeito esta dando erro no site QS e BS
//add_action('login_init', 'no_weak_password_header');
//add_action('admin_head', 'no_weak_password_header');
function no_weak_password_header()
{
  echo "<style>.pw-weak{display:none!important}</style>";
  echo '<script>const pwCheckbox = document.getElementById("pw-checkbox"); if(pwCheckbox){ pwCheckbox.disabled = true;}</script>';
}
