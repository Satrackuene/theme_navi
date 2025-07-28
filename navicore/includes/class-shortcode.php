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
      wp_register_script('navicore-search', NAVICORE_URL . 'assets/js/cnv-search.js', array('jquery'), NAVICORE_VERSION, true);
      wp_register_style('navicore-style', NAVICORE_URL . 'assets/css/cnv-style.css', array(), NAVICORE_VERSION);

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
      <div id="navicore-search-inputs">
        <input type="text" maxlength="1" class="navicore-char" data-index="0" />
        <input type="text" maxlength="1" class="navicore-char" data-index="1" />
        <input type="text" maxlength="1" class="navicore-char" data-index="2" />
        <div class="guion">-</div>
        <input type="text" maxlength="1" class="navicore-char" data-index="3" />
        <input type="text" maxlength="1" class="navicore-char" data-index="4" />
        <input type="text" maxlength="1" class="navicore-char" data-index="5" />
      </div>
      <button type="submit" disabled>Buscar</button>
    </form>
    <div id="navicore-search-result"></div>
    <?php
    return ob_get_clean();
  }
}