jQuery(function ($) {
  //Quitar automaticamente banner alert sup
  if ($("#alerta_aviso .elementor-alert-dismiss")) {
    setTimeout(function () { $("#alerta_aviso .elementor-alert-dismiss").trigger("click"); }, 8000);
  }


  if ($("#boton_marco")) {
    setTimeout(function () {
      $("#boton_marco").addClass("activo");
      $("#boton_marco").attr("data-content", "¿Tienes alguna duda? Escríbeme para ayudarte");

      setTimeout(function () {
        $("#boton_marco").removeClass("activo");
        $("#boton_marco").attr("data-content", "¿Cómo puedo ayudarte?");
        $("#boton_marco:before").width(170);
      }, 3000);
    }, 4000);
  }



  $url = $('#boton_marco').find('a').prop('href');

  $('#boton_marco').on('click', function (e) {
    e.preventDefault();

    $(this).slideUp();
    $('#cont-mensaje-whp').slideDown();
    $('.texto-salida').focus();
  });

  $('#boton-cerrar').on('click', function (e) {
    e.preventDefault();

    $('#boton_marco').slideDown();
    $('#cont-mensaje-whp').slideUp();
  });

  $('.boton-enviar').on('click', function (e) {
    e.preventDefault();
    $mensaje = encodeURI($('.texto-salida').text());
    $url = $url + "?text=" + $mensaje;
    $('.texto-salida').text("");
    window.open($url, 'Chat con Marco');
    $url = $('#boton_marco').find('a').prop('href');

    $('#boton_marco').slideDown();
    $('#cont-mensaje-whp').slideUp();
  });


  settings = {
    maxLen: 100,
  }

  keys = {
    'backspace': 8,
    'shift': 16,
    'ctrl': 17,
    'alt': 18,
    'delete': 46,
    // 'cmd':
    'leftArrow': 37,
    'upArrow': 38,
    'rightArrow': 39,
    'downArrow': 40,
  }

  utils = {
    special: {},
    navigational: {},
    isSpecial(e) {
      return typeof this.special[e.keyCode] !== 'undefined';
    },
    isNavigational(e) {
      return typeof this.navigational[e.keyCode] !== 'undefined';
    }
  }

  utils.special[keys['backspace']] = true;
  utils.special[keys['shift']] = true;
  utils.special[keys['ctrl']] = true;
  utils.special[keys['alt']] = true;
  utils.special[keys['delete']] = true;

  utils.navigational[keys['upArrow']] = true;
  utils.navigational[keys['downArrow']] = true;
  utils.navigational[keys['leftArrow']] = true;
  utils.navigational[keys['rightArrow']] = true;

  $("div[contenteditable='true']").on('keydown', function (event) {
    let len = event.target.innerText.trim().length;
    console.log(len);
    hasSelection = false;
    selection = window.getSelection();
    isSpecial = utils.isSpecial(event);
    isNavigational = utils.isNavigational(event);

    if (selection) {
      hasSelection = !!selection.toString();
    }

    if (isSpecial || isNavigational) {
      return true;
    }

    if (len >= settings.maxLen && !hasSelection) {
      event.preventDefault();
      $(this).css('border', '1px sold yellow');
      return false;

    }

  });

  $('.btn-pais').on('click', function () {
    if ($('.caja-opciones').hasClass('oculto')) {
      $('.caja-opciones').removeClass('oculto');
    } else {
      $('.caja-opciones').addClass('oculto');
    }
  });
});