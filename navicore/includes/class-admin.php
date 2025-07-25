<?php
namespace Navicore;

class Admin
{
  public function __construct()
  {
    add_action('admin_menu', array($this, 'admin_menu'));
  }

  public function admin_menu()
  {
    add_menu_page(
      'naviCore',
      'naviCore',
      'manage_options',
      'navicore',
      array($this, 'dashboard'),
      'dashicons-admin-generic'
    );
  }

  public function dashboard()
  {
    echo '<div class="wrap"><h1>naviCore</h1><p>Configuraci&oacute;n del plugin.</p></div>';
  }
}