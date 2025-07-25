<?php
namespace Navicore;

class Shortcode
{

  public function __construct()
  {
    add_shortcode('navicore_recall_search', array($this, 'render'));
    add_action('wp_enqueue_scripts', array($this, 'enqueue'));
  }

  public function enqueue()
  {
    if (!is_admin()) {
      wp_register_script('navicore-search', NAVICORE_URL . 'assets/cnv-search.js', array('jquery'), NAVICORE_VERSION, true);
      wp_register_style('navicore-style', NAVICORE_URL . 'assets/cnv-style.css', array(), NAVICORE_VERSION);

    }
  }

  public function render()
  {
    wp_enqueue_style('navicore-style');
    wp_enqueue_script('navicore-search');
    wp_localize_script('navicore-search', 'navicore', array(
      'api' => rest_url('navicore/v1/search'),
    ));

    ob_start();
    ?>
    <form id="navicore-search-form">
      <input type="text" id="navicore-search-input" placeholder="Placa o VIN" required />
      <button type="submit">Buscar</button>
    </form>
    <div id="navicore-search-result"></div>
    <?php
    return ob_get_clean();
  }
}