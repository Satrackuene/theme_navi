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
      'NaviCore',
      'NaviCore',
      'manage_options',
      'navicore',
      array($this, 'dashboard'),
      'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0nMS4wJyBlbmNvZGluZz0nVVRGLTgnPz48c3ZnIGlkPSdDYXBhXzEnIHhtbG5zPSdodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZycgdmVyc2lvbj0nMS4xJyB2aWV3Qm94PScwIDAgNTEyIDUxMic+PCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI5LjYuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDIuMS4xIEJ1aWxkIDkpIC0tPjxwYXRoIGQ9J000MTMuNTk3LDM3MS43MjRjMTcuMDMxLDE0LjQ1NiwzOS4wMTIsMjIuNTc1LDYzLjE3MiwyMy43NjQtNDQuMTYxLDYzLjc2Ni0xMTcuODI4LDEwNS41NS0yMDEuMzk4LDEwNS41NS0xMzUuMjU1LDAtMjQ0Ljk2NC0xMDkuNzA5LTI0NC45NjQtMjQ0Ljk2NFMxNDAuMTE2LDExLjExLDI3NS4zNzEsMTEuMTFjODYuNTQsMCwxNjIuNzgyLDQ0Ljk1MywyMDYuMzQ4LDExMi42NzktNi45MzEuOTktMTMuMjY4LDEuOTgtMTkuNjA1LDMuMzY3LTE1LjA1LDIuOTctMjguMzE4LDcuNTI1LTQxLjE5LDEyLjY3NC0xLjk4Ljc5Mi0zLjc2MywxLjc4Mi01LjM0NywyLjc3Mi0zMy4wNzEtNDAuNzk0LTgzLjU2OS02Ni43MzYtMTQwLjIwNi02Ni43MzYtOTkuNjEsMC0xODAuMjA4LDgwLjU5OS0xODAuMjA4LDE4MC4yMDhzODAuNTk4LDE4MC4yMDgsMTgwLjIwOCwxODAuMjA4YzU1LjQ0OSwwLDEwNS4xNTQtMjQuOTUyLDEzOC4yMjYtNjQuNTU4Wk0zMjIuNTAyLDExMy44ODh2MTUxLjg5bC05OS4wMTUtMTQ4LjkxOWMtMjYuMTQsOS45MDEtNDguNzE2LDI3LjEzLTY1LjU0OCw0OC45MTR2MTgyLjU4NHMyMy45NzYsMzMuOTcxLDY3LjMzMSw0OS41MDh2LTE1NC4yNjZsMTAyLjc3OCwxNTQuNjYyczM1LjQ4NS0xMS41OTcsNjEuNTg4LTQyLjE4MXYtMTk4LjIyOWMtMTcuODIzLTIwLjE5OS00MC45OTMtMzUuNjQ2LTY3LjEzMy00My45NjNaJyBmaWxsLXJ1bGU9J2V2ZW5vZGQnIGZpbGw9JyNmZmZmZmY5OScvPjwvc3ZnPg==',
      5,
    );
  }

  public function dashboard()
  {
    echo '<div class="wrap"><h1>naviCore</h1><p>Configuraci&oacute;n del plugin.</p></div>';
  }
}