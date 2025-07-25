<?php
namespace Navicore;

class Recall_CPT
{

  public $meta_key = '_navicore_codes';

  public function __construct()
  {
    add_action('init', array($this, 'register'));
    add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    add_action('save_post', array($this, 'save_meta_box'), 10, 2);
  }

  public function register()
  {
    $labels = array(
      'name' => 'Campañas Recall',
      'singular_name' => 'Campaña Recall',
    );
    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'revisions'),
      'taxonomies' => array('category'),
      'show_in_menu' => 'navicore',
    );
    register_post_type('recall_campaign', $args);
  }

  public function add_meta_boxes()
  {
    add_meta_box('navicore_codes', 'Placas y VIN', array($this, 'render_meta_box'), 'recall_campaign');
  }

  public function render_meta_box($post)
  {
    $codes = get_post_meta($post->ID, $this->meta_key, true);
    if (is_array($codes)) {
      $codes = implode("\n", $codes);
    }
    echo '<textarea style="width:100%;height:100px;" name="navicore_codes">' . esc_textarea($codes) . '</textarea>';
    echo '<p>Ingrese una placa o VIN por línea.</p>';
  }

  public function save_meta_box($post_id, $post)
  {
    if ($post->post_type !== 'recall_campaign') {
      return;
    }
    if (isset($_POST['navicore_codes'])) {
      $lines = preg_split("/[\r\n]+/", sanitize_textarea_field($_POST['navicore_codes']));
      $lines = array_filter(array_map('trim', $lines));
      update_post_meta($post_id, $this->meta_key, $lines);
    }
  }
}