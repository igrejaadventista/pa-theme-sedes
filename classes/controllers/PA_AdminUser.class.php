<?php

class IASD_SupportUser
{

  public function __construct()
  {
    add_action('init', array($this, 'AddUser'), 1);
    add_action('init', array($this, 'CheckUser'), 2);
    // add_action('init', array($this, 'RemoveUser'), 3);
  }

  static function AddUser()
  {
    $username = 'suporte.internetdsa';
    $email = 'suporte@internetdsa.com';
    $password = wp_generate_password($length = 12, $include_standard_special_chars = false);

    $user_id = username_exists($username);
    if (!$user_id && email_exists($email) == false) {
      $user_id = wp_create_user($username, $password, $email);
      if (!is_wp_error($user_id)) {
        $u = new WP_User($user_id);
        $u->set_role('administrator');
      }
    }
  }

  static function CheckUser()
  {
    $email = 'suporte@internetdsa.com';
    $user = get_user_by('email', $email);

    if(!empty($user)){
      require_once(ABSPATH . 'wp-admin/includes/ms.php');
      grant_super_admin($user->ID);
    }
  }

  static function RemoveUser()
  {
    $username = 'admindsa';
    $email = 'internetdsa@gmail.com';

    $current_admin = "suporte.internetdsa";
    $current_admin = get_user_by('login', $current_admin);

    $user_email = get_user_by('email', $email);
    $user_name = get_user_by('login', $username);

    if ($user_email || $user_name) {
      require_once(ABSPATH . 'wp-admin/includes/ms.php');
      revoke_super_admin($user_email->ID);
      revoke_super_admin($user_name->ID);

      require_once(ABSPATH . 'wp-admin/includes/user.php');
      wp_delete_user($user_email->ID, $current_admin->ID);
      wp_delete_user($user_name->ID, $current_admin->ID);
    }
  }
}

$IASD_SupportUser = new IASD_SupportUser();
