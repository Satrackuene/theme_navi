<?php
namespace Navicore;

use WP_Error;
use WP_Query;

class Rest
{

  public function __construct()
  {
    add_action('rest_api_init', array($this, 'register_routes'));
  }

  public function register_routes()
  {
    register_rest_route('navicore/v1', '/search', array(
      'methods' => 'GET',
      'callback' => array($this, 'search'),
      'permission_callback' => '__return_true',
    ));
  }

  public function search($request)
  {
    global $wpdb;
    $code = sanitize_text_field($request->get_param('code'));
    if (!$code) {
      return new WP_Error('invalid_code', 'Código no proporcionado', array('status' => 400));
    }
    $table = Vehicles::table_name();
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE vin=%s OR plate=%s", $code, $code), ARRAY_A);
    if (!$row) {
      return array('found' => false);
    }
    $args = array(
      'post_type' => 'recall_campaign',
      'meta_query' => array(
        array(
          'key' => '_navicore_codes',
          'value' => $code,
          'compare' => 'LIKE',
        ),
      ),
    );
    $query = new WP_Query($args);
    $campaigns = array();
    foreach ($query->posts as $post) {
      $campaigns[] = array(
        'title' => $post->post_title,
        'content' => apply_filters('the_content', $post->post_content),
        'link' => get_permalink($post->ID),
      );
    }
    return array(
      'found' => true,
      'vehicle' => $row,
      'campaigns' => $campaigns,
    );
  }
}