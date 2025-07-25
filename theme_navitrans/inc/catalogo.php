<?php
/**
 * Registra el tipo de publicación personalizado 'producto'.
 */



function crear_tipo_equipo()
{
  define('MI_ICONO_NUEVO_SVG', '<svg clip-rule="evenodd" fill-rule="evenodd" fill="#F0F6FC99" height="512" stroke-linejoin="round" viewBox="0 0 48 48" width="512" xmlns="http://www.w3.org/2000/svg"><g transform="translate(0 -106)"><g transform="translate(0 -30.001)"><path d="m9.112 170.584c.455 2.004 2.248 3.5 4.388 3.5s3.933-1.496 4.388-3.5h10.557c.455 2.004 2.248 3.5 4.388 3.5s3.933-1.496 4.389-3.5h4.34c1.347 0 2.438-1.091 2.438-2.437v-7.896c0-.334-.167-.646-.445-.832l-1.742-1.161s-2.104-5.261-2.104-5.261c-.422-1.054-1.443-1.746-2.579-1.746h-5.797v-2.334c0-.796-.316-1.559-.878-2.121-.563-.563-1.326-.879-2.122-.879-4.736 0-16.596 0-21.333 0-.796 0-1.559.316-2.121.879-.563.562-.879 1.325-.879 2.121v18.967c0 1.492 1.209 2.7 2.7 2.7zm23.721-3.5c1.38 0 2.5 1.121 2.5 2.5 0 1.38-1.12 2.5-2.5 2.5-1.379 0-2.5-1.12-2.5-2.5 0-1.379 1.121-2.5 2.5-2.5zm-19.333 0c1.38 0 2.5 1.121 2.5 2.5 0 1.38-1.12 2.5-2.5 2.5s-2.5-1.12-2.5-2.5c0-1.379 1.12-2.5 2.5-2.5zm15.833-.327v-17.84c0-.265-.105-.52-.293-.707-.187-.188-.441-.293-.707-.293h-21.333c-.265 0-.52.105-.707.293-.188.187-.293.442-.293.707v18.967c0 .387.313.7.7.7h2.412c.455-2.003 2.248-3.5 4.388-3.5s3.933 1.497 4.388 3.5h10.557c.155-.68.464-1.302.888-1.827zm2-13.506v12.09c.47-.166.975-.257 1.5-.257 2.14 0 3.933 1.497 4.389 3.5h4.34c.242 0 .438-.196.438-.437v-4.229h-2.333c-.552 0-1-.448-1-1s.448-1 1-1h2.333v-1.132l-1.346-.897-6.654.029c-.514 0-.944-.39-.995-.901l-.577-5.766zm3.105 0 .467 4.667h4.618l-1.671-4.178c-.118-.295-.404-.489-.722-.489z"/></g></g></svg>');
  $svg_data_uri = 'data:image/svg+xml;base64,' . base64_encode(MI_ICONO_NUEVO_SVG);

  $labels = array(
    'name' => _x('Equipos', 'Nombre general de los productos', _S_DOMAIN),
    'singular_name' => _x('Equipo', 'Nombre singular de producto', _S_DOMAIN),
    'menu_name' => __('Equipos', _S_DOMAIN),
    'name_admin_bar' => __('Equipos', _S_DOMAIN),
    'parent_item_colon' => __('Equipo padre:', _S_DOMAIN),
    'all_items' => __('Todos los equipos', _S_DOMAIN),
    'add_new_item' => __('Añadir nuevo equipo', _S_DOMAIN),
    'add_new' => __('Añadir nuevo', _S_DOMAIN),
    'new_item' => __('Nuevo equipo', _S_DOMAIN),
    'edit_item' => __('Editar equipo', _S_DOMAIN),
    'update_item' => __('Actualizar equipo', _S_DOMAIN),
    'view_item' => __('Ver equipo', _S_DOMAIN),
    'view_items' => __('Ver equipos', _S_DOMAIN),
    'search_items' => __('Buscar equipos', _S_DOMAIN),
    'not_found' => __('No se encontraron equipos.', _S_DOMAIN),
    'not_found_in_trash' => __('No se encontraron equipos en la papelera.', _S_DOMAIN),
    'featured_image' => __('Imagen del equipo', _S_DOMAIN),
    'set_featured_image' => __('Establecer imagen del equipo', _S_DOMAIN),
    'remove_featured_image' => __('Eliminar imagen del equipo', _S_DOMAIN),
    'use_featured_image' => __('Usar como imagen del equipo', _S_DOMAIN),
    'archives' => __('Archivo de equipos', _S_DOMAIN),
    'insert_into_item' => __('Insertar en el equipo', _S_DOMAIN),
    'uploaded_to_this_item' => __('Subido a este equipo', _S_DOMAIN),
    'filter_items_list' => __('Filtrar lista de equipos', _S_DOMAIN),
    'items_list_navigation' => __('Navegación de la lista de equipos', _S_DOMAIN),
    'items_list' => __('Lista de equipos', _S_DOMAIN),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => false, // Como las entradas normales
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true, // Aparecerá en el menú principal del admin
    'menu_position' => 5,   // Posición en el menú (ajusta según necesites)
    'menu_icon' => $svg_data_uri, // Icono del menú (puedes buscar otros dashicons)
    'show_admin_column' => true,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'query_var' => true,
    'has_archive' => true, // <-- ¡ESTE ES CRUCIAL!
    'show_in_nav_menus' => true,
    'can_export' => true,
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'supports' => array('title', 'editor', 'thumbnail'), // Soporte para título, descripción (editor WYSIWYG) e imagen destacada
    'rewrite' => array('slug' => 'equipos'), // URL amigable para los productos
  );
  register_post_type('equipos', $args);
}
add_action('init', 'crear_tipo_equipo');


/**
 * Registra la taxonomía 'marca'.
 */
function crear_taxonomia_marca()
{
  $labels = array(
    'name' => _x('Marca', 'Nombre general de los Marca', _S_DOMAIN),
    'singular_name' => _x('Marca', 'Nombre singular de marca', _S_DOMAIN),
    'menu_name' => __('Marcas', _S_DOMAIN),
    'all_items' => __('Todos las Marcas', _S_DOMAIN),
    'parent_item' => null, // No jerárquico como las etiquetas
    'parent_item_colon' => null,
    'new_item_name' => __('Nueva Marca', _S_DOMAIN),
    'add_new_item' => __('Añadir nueva marca', _S_DOMAIN),
    'edit_item' => __('Editar marca', _S_DOMAIN),
    'update_item' => __('Actualizar marca', _S_DOMAIN),
    'view_item' => __('Ver marca', _S_DOMAIN),
    'separate_items_with_commas' => __('Separar marcas con comas', _S_DOMAIN),
    'add_or_remove_items' => __('Añadir o eliminar marcas', _S_DOMAIN),
    'choose_from_most_used' => __('Elegir entre las marcas más usados', _S_DOMAIN),
    'popular_items' => __('Marcas populares', _S_DOMAIN),
    'search_items' => __('Buscar Marca', _S_DOMAIN),
    'not_found' => __('No se encontraron Marcas.', _S_DOMAIN),
    'no_terms' => __('No hay Marcas.', _S_DOMAIN),
    'items_list' => __('Lista de Marcas', _S_DOMAIN),
    'items_list_navigation' => __('Navegación de Marca', _S_DOMAIN),
  );
  $args = array(
    'hierarchical' => false, // Como las etiquetas normales
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud' => true,
    'show_in_rest' => true, // <-- ¡ESTA ES LA LÍNEA CLAVE!
    'query_var' => true,
    'rewrite' => array('slug' => 'marca'),
  );
  register_taxonomy('marca', ['equipos'], $args);
}
add_action('init', 'crear_taxonomia_marca', 0);

/**
 * Registra la taxonomía 'marca'.
 */
/**
 * Función para crear la taxonomía personalizada 'Tipo de Maquinaria'.
 */
function crear_taxonomia_tipo_equipo()
{
  $labels = array(
    'name' => _x('Tipos de Maquinaria', 'Nombre general de la taxonomía', _S_DOMAIN),
    'singular_name' => _x('Tipo de Maquinaria', 'Nombre singular de la taxonomía', _S_DOMAIN),
    'menu_name' => __('Tipos de Maquinaria', _S_DOMAIN),
    'all_items' => __('Todos los Tipos', _S_DOMAIN),
    'parent_item' => null,
    'parent_item_colon' => null,
    'new_item_name' => __('Nuevo Tipo de Maquinaria', _S_DOMAIN),
    'add_new_item' => __('Añadir Nuevo Tipo', _S_DOMAIN),
    'edit_item' => __('Editar Tipo de Maquinaria', _S_DOMAIN),
    'update_item' => __('Actualizar Tipo de Maquinaria', _S_DOMAIN),
    'view_item' => __('Ver Tipo de Maquinaria', _S_DOMAIN),
    'separate_items_with_commas' => __('Separar tipos con comas', _S_DOMAIN),
    'add_or_remove_items' => __('Añadir o eliminar tipos', _S_DOMAIN),
    'choose_from_most_used' => __('Elegir de los más usados', _S_DOMAIN),
    'popular_items' => __('Tipos Populares', _S_DOMAIN),
    'search_items' => __('Buscar Tipos de Maquinaria', _S_DOMAIN),
    'not_found' => __('No se encontraron tipos.', _S_DOMAIN),
    'no_terms' => __('No hay tipos', _S_DOMAIN),
    'items_list' => __('Lista de tipos de maquinaria', _S_DOMAIN),
    'items_list_navigation' => __('Navegación de la lista de tipos', _S_DOMAIN),
  );

  $args = array(
    'labels' => $labels,
    'hierarchical' => true, // Para que funcione como etiquetas (no jerárquica). Cambia a `true` si quieres que funcione como categorías.
    'public' => true,  // Esencial para que sea visible en el front-end y para Elementor.
    'show_ui' => true,  // Muestra la interfaz de usuario en el panel de administración.
    'show_admin_column' => true,  // Muestra la taxonomía en la tabla de listado de los post types asociados.
    'show_in_nav_menus' => true,  // Permite añadir términos de la taxonomía a los menús de navegación.
    'show_tagcloud' => true,  // Permite usar los términos en nubes de etiquetas.
    'query_var' => true,  // Permite consultas como /?tipo-maquina=nombre-del-termino
    'rewrite' => array(
      'slug' => 'tipo_equipo', // El slug base para la URL de la taxonomía
      'hierarchical' => true,
    ), // URL amigable para los archivos de esta taxonomía.
    'show_in_rest' => true,  // ¡CLAVE! Permite que la taxonomía esté disponible en la API REST de WordPress, algo que Elementor utiliza intensivamente.
  );

  // Registra la taxonomía y la asocia a tus Custom Post Types.
  register_taxonomy('tipo_equipo', ['equipos'], $args);
}

// Engancha la función al hook 'init' con una prioridad estándar.
add_action('init', 'crear_taxonomia_tipo_equipo', 0);


/**
 * Añade un campo de imagen a la pantalla de "Añadir nuevo término" para la taxonomía 'segmentos'.
 */
function mi_tema_anadir_campo_imagen_taxonomia($taxonomy_slug)
{
  ?>
  <div class="form-field term-group">
    <label for="imagen_tax_id"><?php _e('Imagen del Segmento', _S_DOMAIN); ?></label>
    <input type="hidden" id="imagen_tax_id" name="imagen_tax_id" class="custom_media_url" value="">
    <div id="imagen_tax_wrapper"></div>
    <p>
      <button type="button"
        class="button button-secondary mi_tema_subir_media_button"><?php _e('Subir/Seleccionar Imagen', _S_DOMAIN); ?></button>
      <button type="button"
        class="button button-secondary mi_tema_remover_media_button"><?php _e('Eliminar Imagen', _S_DOMAIN); ?></button>
    </p>
  </div>
  <?php
}
add_action('tipo_equipo_add_form_fields', 'mi_tema_anadir_campo_imagen_taxonomia', 10, 2);

/**
 * Añade el campo de imagen a la pantalla de "Editar término" para la taxonomía 'segmentos'.
 */
function mi_tema_editar_campo_imagen_taxonomia($term, $taxonomy_slug)
{
  $image_id = get_term_meta($term->term_id, 'imagen_tax_id', true);
  ?>
  <tr class="form-field term-group-wrap">
    <th scope="row">
      <label for="imagen_tax_id"><?php _e('Imagen del too de marca', _S_DOMAIN); ?></label>
    </th>
    <td>
      <input type="hidden" id="imagen_tax_id" name="imagen_tax_id" value="<?php echo esc_attr($image_id); ?>">
      <div id="imagen_tax_wrapper">
        <?php if ($image_id): ?>
          <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
        <?php endif; ?>
      </div>
      <p>
        <button type="button"
          class="button button-secondary mi_tema_subir_media_button"><?php _e('Subir/Seleccionar Imagen', _S_DOMAIN); ?></button>
        <button type="button"
          class="button button-secondary mi_tema_remover_media_button"><?php _e('Eliminar Imagen', _S_DOMAIN); ?></button>
      </p>
    </td>
  </tr>
  <?php
}
add_action('tipo_equipo_edit_form_fields', 'mi_tema_editar_campo_imagen_taxonomia', 10, 2);


//**
/* Guarda el valor del campo de imagen para la taxonomía 'tipo_equipo'.
*/
function mi_tema_guardar_meta_imagen_taxonomia($term_id)
{
  if (isset($_POST['imagen_tax_id']) && '' !== $_POST['imagen_tax_id']) {
    $image_id = absint($_POST['imagen_tax_id']);
    update_term_meta($term_id, 'imagen_tax_id', $image_id);
  } else {
    delete_term_meta($term_id, 'imagen_tax_id');
  }
}
add_action('created_tipo_equipo', 'mi_tema_guardar_meta_imagen_taxonomia', 10, 2);
add_action('edited_tipo_equipo', 'mi_tema_guardar_meta_imagen_taxonomia', 10, 2);

/**
 * Carga los scripts necesarios en las páginas de administración de la taxonomía.
 */
function mi_tema_cargar_scripts_admin($hook)
{
  if ('term.php' !== $hook && 'edit-tags.php' !== $hook) {
    return;
  }
  wp_enqueue_media();
  add_action('admin_footer', 'mi_tema_script_media_taxonomia');
}
add_action('admin_enqueue_scripts', 'mi_tema_cargar_scripts_admin');

function mi_tema_script_media_taxonomia()
{
  ?>
  <script>
    jQuery(document).ready(function ($) {
      var mediaUploader;
      $(document).on('click', '.mi_tema_subir_media_button', function (e) {
        e.preventDefault();
        if (mediaUploader) { mediaUploader.open(); return; }
        mediaUploader = wp.media.frames.file_frame = wp.media({
          title: '<?php _e("Seleccionar una Imagen", _S_DOMAIN); ?>',
          button: { text: '<?php _e("Usar esta Imagen", _S_DOMAIN); ?>' },
          multiple: false
        });
        mediaUploader.on('select', function () {
          var attachment = mediaUploader.state().get('selection').first().toJSON();
          $('#imagen_tax_id').val(attachment.id);
          $('#imagen_tax_wrapper').html('<img src="' + attachment.url + '" style="max-width:150px;height:auto;">');
        });
        mediaUploader.open();
      });
      $(document).on('click', '.mi_tema_remover_media_button', function (e) {
        e.preventDefault();
        $('#imagen_tax_id').val('');
        $('#imagen_tax_wrapper').html('');
      });
    });
  </script>
  <?php
}


/**
 * Shortcode para generar una miga de pan personalizada para maquinaria.
 * Uso: [miga_de_pan_maquinaria]
 * * Muestra:
 * - En la página de archivo de una taxonomía: Inicio / Nombre del Tipo de Maquinaria
 * - En la página de un equipo (post): Inicio / Nombre del Tipo de Maquinaria / Nombre del Equipo
 */
