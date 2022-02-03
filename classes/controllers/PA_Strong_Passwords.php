<?php

// Esse bloco de código é responsável por ocultar e impedir que o campo "Confirmar o uso de uma senha fraca" seja ativado levando assim o usuário a criar uma senha forte.

add_action('login_init', 'no_weak_password_header');
add_action('admin_head', 'no_weak_password_header');
function no_weak_password_header()
{
  echo "<style>.pw-weak{display:none!important}</style>";
  echo '<script>document.getElementById("pw-checkbox").disabled = true;</script>';
}
