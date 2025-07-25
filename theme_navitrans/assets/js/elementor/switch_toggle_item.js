function switch_satrack(id_sw, items1, items2) {
  let input = jQuery(".elementor-element-" + id_sw).find(
    'input[type="checkbox"]'
  );
  let label = jQuery(".elementor-element-" + id_sw).find(".labels-switch");
  console.log(input);
  jQuery.each(items1, function (index, value) {
    jQuery(value).addClass("item_switch_str_" + id_sw);
    if (!input.is(":checked")) {
      jQuery(value).addClass("item_switch_str_active");
    } else {
      jQuery(value).addClass("item_switch_str_desactive");
    }
  });

  jQuery.each(items2, function (index, value) {
    jQuery(value).addClass("item_switch_str_" + id_sw);

    if (input.is(":checked")) {
      jQuery(value).addClass("item_switch_str_active");
    } else {
      jQuery(value).addClass("item_switch_str_desactive");
    }
  });

  input.off("change").on("change", function () {
    console.log("deberia aplicar el toggle", ".item_switch_str_" + id_sw);

    label.toggleClass("label_switch_str_active");
    jQuery(".item_switch_str_" + id_sw).toggleClass("item_switch_str_active");
    jQuery(".item_switch_str_" + id_sw).toggleClass(
      "item_switch_str_desactive"
    );
  });
}
