<?php

/**
 * Theme Navitrans functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package theme_navitrans
 */

if (!defined('_S_VERSION')) {
  define('_S_VERSION', '1.0.11');
}

if (!defined('_S_DOMAIN')) {
  define('_S_DOMAIN', 'theme_navitrans');
}

add_filter('rest_authentication_errors', function ($access) {
  return is_wp_error($access) ? $access : true;
});

function theme_navitrans_setup()
{
  load_theme_textdomain(_S_DOMAIN, get_template_directory() . '/languages');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');


  add_theme_support('title-tag');


  add_theme_support('post-thumbnails');

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus(
    array(
      'menu_principal' => esc_html__('Menu Principal', _S_DOMAIN),
    )
  );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );

  // Set up the WordPress core custom background feature.
  add_theme_support(
    'custom-background',
    apply_filters(
      'theme_navitrans_custom_background_args',
      array(
        'default-color' => 'ffffff',
        'default-image' => '',
      )
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');


  add_theme_support(
    'custom-logo',
    array(
      'height' => 200,
      'width' => 400,
      'flex-width' => true,
      'flex-height' => true,
      'header-text' => array('site-title', 'site-description'),
    )
  );

  // Add theme support for thumbnails.
  add_theme_support('post-thumbnails');
  add_image_size('post-thumb', 600, 320, true);
  add_image_size('category-thumb', 420, 250, array('center', 'top'));
  add_image_size('cuadrado', 320, 320, array('center', 'center'));
}

add_action('after_setup_theme', 'theme_navitrans_setup');

function cc_mime_types($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function theme_navitrans_widgets_init()
{
  register_sidebar(
    array(
      'name' => esc_html__('Sidebar', _S_DOMAIN),
      'id' => 'sidebar-1',
      'description' => esc_html__('Add widgets here.', _S_DOMAIN),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>',
    )
  );
}
add_action('widgets_init', 'theme_navitrans_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function theme_navitrans_scripts()
{
  wp_enqueue_style('googlefont', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap', false);

  wp_register_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css', array(), "5.9.1");
  wp_enqueue_style('font-awesome');

  add_action('wp_head', function () {
    echo '<link rel="preload" href="' . get_stylesheet_uri() . '?ver=' . _S_VERSION . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="' . get_stylesheet_uri() . '?ver=' . _S_VERSION . '" integrity="crossorigin"></noscript>';

    echo '<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="crossorigin"></noscript>';
  });



  //wp_enqueue_style('theme-gallo-style', get_stylesheet_uri(), array(), _S_VERSION);
  //wp_style_add_data('theme-gallo-style', 'rtl', 'replace');

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_register_script('Bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.2.4', array('in_footer' => true, 'strategy' => 'async'));
  wp_enqueue_script('Bootstrap');
  wp_script_add_data('Bootstrap', array('integrity', 'crossorigin'), array('sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4', 'anonymous'));
}
add_action('wp_enqueue_scripts', 'theme_navitrans_scripts');


//* Cambia el logotipo de la página inicio de sesión de WordPress (usar imagen de 80x80px)
function login_personalizado()
{
  wp_enqueue_style('custom-login-styles', get_template_directory_uri() . '/assets/css/custom-login-styles.css', null, _S_VERSION . ".1");
}

add_action('login_enqueue_scripts', 'login_personalizado');


function modificar_enlace_logo()
{
  return home_url();
}
add_filter('login_headerurl', 'modificar_enlace_logo');



function admin_style()
{
  wp_register_style('cutom-admin-styles', get_template_directory_uri() . '/assets/css/admin.css', false, _S_VERSION);
  wp_enqueue_style('cutom-admin-styles');

  if (!current_user_can('administrator')) {
    wp_register_style('cutom-editor-styles', get_template_directory_uri() . '/assets/css/editor.css', false, _S_VERSION);
    wp_enqueue_style('cutom-editor-styles');
  }
}
add_action('admin_enqueue_scripts', 'admin_style');

// 1. Agregar el meta box para el subtítulo en el editor de entradas.
function prefijo_subtitulo_meta_box()
{
  add_meta_box(
    'subtitulo_meta_box_id', // ID único del meta box.
    'Subtítulo de la Entrada', // Título del meta box que se muestra en el editor.
    'prefijo_subtitulo_meta_box_callback', // Función que renderiza el contenido del meta box.
    'post', // Tipo de contenido donde se mostrará (en este caso, 'post' para entradas).
    'normal', // Contexto donde se mostrará ('normal', 'side', 'advanced').
    'high' // Prioridad ('high', 'core', 'default', 'low').
  );
}
add_action('add_meta_boxes', 'prefijo_subtitulo_meta_box');

// 2. Callback para renderizar el campo del subtítulo dentro del meta box.
function prefijo_subtitulo_meta_box_callback($post)
{
  // Agregar un nonce para verificación.
  wp_nonce_field('prefijo_guardar_subtitulo_meta', 'prefijo_subtitulo_nonce');

  // Obtener el valor actual del subtítulo si existe.
  $subtitulo = get_post_meta($post->ID, '_subtitulo_meta_key', true);

  // Mostrar el campo de texto.
  echo '<label for="subtitulo_campo_id">Subtítulo:</label> ';
  echo '<input type="text" id="subtitulo_campo_id" name="subtitulo_campo_name" value="' . esc_attr($subtitulo) . '" size="50" />';
  echo '<p><em>Ingresa aquí el subtítulo para tu entrada.</em></p>';
}

// 3. Guardar el valor del subtítulo cuando se guarda la entrada.
function prefijo_guardar_subtitulo_meta_data($post_id)
{
  // Verificar si nuestro nonce está seteado.
  if (!isset($_POST['prefijo_subtitulo_nonce'])) {
    return;
  }

  // Verificar que el nonce es válido.
  if (!wp_verify_nonce($_POST['prefijo_subtitulo_nonce'], 'prefijo_guardar_subtitulo_meta')) {
    return;
  }

  // Si es un autoguardado, no hacer nada.
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Verificar los permisos del usuario.
  if (isset($_POST['post_type']) && 'post' == $_POST['post_type']) {
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }
  }

  // Asegurarse de que el campo del subtítulo está seteado.
  if (!isset($_POST['subtitulo_campo_name'])) {
    return;
  }

  // Sanitizar la entrada del usuario.
  $mi_subtitulo = sanitize_text_field($_POST['subtitulo_campo_name']);

  // Actualizar el meta campo en la base de datos.
  update_post_meta($post_id, '_subtitulo_meta_key', $mi_subtitulo);
}
add_action('save_post', 'prefijo_guardar_subtitulo_meta_data');

// 4. Mostrar el subtítulo pegado al título en la página de la entrada.
function prefijo_mostrar_titulo_con_subtitulo($title, $id = null)
{
  if (is_single() && 'post' == get_post_type($id) && in_the_loop() && is_main_query()) { // Asegurarse que es una entrada individual y el loop principal.
    $subtitulo = get_post_meta($id, '_subtitulo_meta_key', true);
    if (!empty($subtitulo)) {
      $title .= ' <span class="subtitulo-entrada">' . esc_html($subtitulo) . '</span>'; // Agrega el subtítulo. Puedes estilizar la clase .subtitulo-entrada en tu CSS.
    }
  }
  return $title;
}
add_filter('the_title', 'prefijo_mostrar_titulo_con_subtitulo', 10, 2);

include_once WP_CONTENT_DIR . '/themes/theme_navitrans/inc/catalogo.php';
include_once WP_CONTENT_DIR . '/themes/theme_navitrans/inc/shortcodes.php';