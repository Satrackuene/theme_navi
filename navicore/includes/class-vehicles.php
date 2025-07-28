<?php
namespace Navicore;

class Vehicles
{

  public static function table_name()
  {
    global $wpdb;
    return $wpdb->prefix . 'navicore_vehicles';
  }

  public static function install()
  {
    global $wpdb;
    $table = self::table_name();
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
            vin varchar(50) NOT NULL,
            plate varchar(10) NOT NULL,
            model varchar(100) NOT NULL,
            brand varchar(100) NOT NULL,
            PRIMARY KEY  (vin),
            KEY plate (plate)
        ) $charset_collate;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
  }

  public function __construct()
  {
    add_action('admin_menu', array($this, 'admin_menu'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
  }

  public function enqueue($hook)
  {
    if ($hook !== 'navicore_page_navicore_vehicles') {
      return;
    }
    wp_enqueue_script('navicore-admin', NAVICORE_URL . 'assets/js/cnv-admin.js', array('jquery'), NAVICORE_VERSION, true);
    wp_enqueue_style('navicore-admin', NAVICORE_URL . 'assets/css/cnv-admin.css', array(), NAVICORE_VERSION);
  }

  public function admin_menu()
  {
    add_submenu_page('navicore', 'Datos de Vehículos', 'Vehículos', 'manage_options', 'navicore_vehicles', array($this, 'render_page'));
  }

  public function render_page()
  {
    if (!current_user_can('manage_options')) {
      return;
    }
    echo '<div class="wrap"><h1>Cargar Datos de Vehículos</h1>';

    if (!empty($_POST['delete_vehicle']) && !empty($_POST['vin'])) {
      $this->handle_delete($_POST['vin']);
      echo '<div class="updated notice"><p>Vehículo eliminado.</p></div>';
    }

    if (!empty($_POST['submit']) && !empty($_FILES['vehicles_csv']['tmp_name'])) {
      $invalid = $this->handle_csv_upload($_FILES['vehicles_csv']['tmp_name']);
      echo '<div class="updated notice"><p>Datos cargados.</p></div>';
      if (!empty($invalid)) {
        printf('<div class="error notice"><p>Placas inválidas no guardadas: %s</p></div>', esc_html(implode(', ', $invalid)));
      }
    }
    echo '<form method="post" enctype="multipart/form-data">';
    echo '<input type="file" name="vehicles_csv" accept=".csv" required />';
    submit_button('Cargar CSV');
    echo '</form>';

    if (!empty($_POST['add_vehicle'])) {
      if ($this->handle_manual_add()) {
        echo '<div class="updated notice"><p>Vehículo agregado.</p></div>';
      }
    }

    echo '<h2>Agregar manualmente</h2>';
    echo '<form method="post">';
    echo '<input type="text" name="vin" placeholder="VIN" required /> ';
    echo '<input type="text" name="plate" placeholder="Placa" required /> ';
    echo '<input type="text" name="model" placeholder="Modelo" /> ';
    echo '<input type="text" name="brand" placeholder="Marca" /> ';
    echo '<input type="submit" name="add_vehicle" class="button button-primary" value="Agregar" />';
    echo '</form>';

    $this->render_table();
    echo '</div>';
  }

  private function handle_csv_upload($file)
  {
    global $wpdb;
    $table = self::table_name();
    $handle = fopen($file, 'r');
    if (!$handle) {
      return array();
    }

    // skip header row
    fgetcsv($handle, 0, ',');

    $invalid = array();
    while (($data = fgetcsv($handle, 0, ',')) !== false) {
      $vin = sanitize_text_field($data[0] ?? '');
      $plate = sanitize_text_field($data[1] ?? '');
      $model = sanitize_text_field($data[2] ?? '');
      $brand = sanitize_text_field($data[3] ?? '');
      if (!$vin && !$plate) {
        continue;
      }
      if ($plate && !$this->validate_plate($plate)) {
        $invalid[] = $plate;
        continue;
      }
      $wpdb->replace(
        $table,
        array(
          'vin' => $vin,
          'plate' => $plate,
          'model' => $model,
          'brand' => $brand,
        ),
        array('%s', '%s', '%s', '%s')
      );
    }
    fclose($handle);
    return $invalid;
  }

  private function handle_manual_add()
  {
    global $wpdb;
    $table = self::table_name();
    $vin = strtoupper(sanitize_text_field($_POST['vin'] ?? ''));
    $plate = strtoupper(sanitize_text_field($_POST['plate'] ?? ''));
    $model = sanitize_text_field($_POST['model'] ?? '');
    $brand = sanitize_text_field($_POST['brand'] ?? '');
    if (!$vin && !$plate) {
      return false;
    }
    if ($plate && !$this->validate_plate($plate)) {
      echo '<div class="error notice"><p>Placa ' . $plate . ' no guardada por formato inválido.</p></div>';
      return false;
    }
    $wpdb->replace(
      $table,
      array(
        'vin' => $vin,
        'plate' => $plate,
        'model' => $model,
        'brand' => $brand,
      ),
      array('%s', '%s', '%s', '%s')
    );
    return true;
  }

  private function handle_delete($vin)
  {
    global $wpdb;
    $table = self::table_name();
    $vin = sanitize_text_field($vin);
    if (!$vin) {
      return;
    }
    $wpdb->delete($table, array('vin' => $vin), array('%s'));
  }

  private function validate_plate($plate)
  {
    return (bool) preg_match('/^[A-Z]{3}[0-9]{3}$/', $plate);
  }

  private function render_table()
  {
    global $wpdb;
    $table = self::table_name();
    $rows = $wpdb->get_results("SELECT * FROM {$table} ORDER BY vin DESC", ARRAY_A);
    if (!$rows) {
      return;
    }
    echo '<h2>Vehículos registrados</h2>';
    echo '<input type="text" id="navicore-vehicles-filter" placeholder="Filtrar" />';
    echo '<table id="navicore-vehicles-table" class="widefat fixed striped">';
    echo '<thead><tr>';
    $headers = array('VIN', 'Placa', 'Modelo', 'Marca');
    foreach ($headers as $i => $h) {
      echo '<th>' . $h .
        ' <button type="button" class="sort-asc" data-index="' . $i . '">&#9650;</button>' .
        ' <button type="button" class="sort-desc" data-index="' . $i . '">&#9660;</button>' .
        '</th>';
    }
    echo '<th>Acciones</th></tr></thead><tbody>';
    foreach ($rows as $r) {
      echo '<tr>';
      echo '<td>' . esc_html($r['vin']) . '</td>';
      echo '<td>' . esc_html($r['plate']) . '</td>';
      echo '<td>' . esc_html($r['model']) . '</td>';
      echo '<td>' . esc_html($r['brand']) . '</td>';
      echo '<td><form method="post" style="display:inline">' .
        '<input type="hidden" name="vin" value="' . esc_attr($r['vin']) . '" />' .
        '<button type="submit" name="delete_vehicle" class="button-link-delete">Eliminar</button>' .
        '</form></td>';
      echo '</tr>';
    }
    echo '</tbody></table>';
  }
}