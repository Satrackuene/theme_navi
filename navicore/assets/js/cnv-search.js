jQuery(function ($) {
	var $type = $("#navicore-search-type");
	var $plateInputs = $("#navicore-plate-inputs .navicore-char");
	var $vinInput = $("#navicore-vin-input");
	var $button = $("#navicore-search-form button[type='submit']");

	function updateButton() {
		if ($type.val() === "vin") {
			var v = $vinInput.val();
			var ok = /^[A-Z0-9]{15,22}$/.test(v);
			$button.prop("disabled", !ok);
			return;
		}
		var valid = true;
		$plateInputs.each(function (index, el) {
			if ($(el).val().length !== 1) {
				valid = false;
				return false;
			}
		});
		$button.prop("disabled", !valid);
	}

	$plateInputs.on("input", function () {
		var index = $plateInputs.index(this);
		var val = $(this).val().toUpperCase();
		if (index < 3) {
			val = val.replace(/[^A-Z]/g, "");
		} else {
			val = val.replace(/[^0-9]/g, "");
		}
		$(this).val(val);
		if (val && index < 5) {
			$plateInputs.eq(index + 1).focus();
		}
		updateButton();
	});

	$vinInput.on("input", function () {
		var val = $(this).val().toUpperCase();
		val = val.replace(/[^A-Z0-9]/g, "");
		$(this).val(val);
		updateButton();
	});

	$type.on("change", function () {
		$("#navicore-plate-inputs").toggleClass("active");
		$vinInput.toggleClass("active");

		updateButton();
	});

	$("#navicore-search-form").on("submit", function (e) {
		e.preventDefault();
		var code = "";
		if ($type.val() === "vin") {
			code = $vinInput.val();
			if (!/^[A-Z0-9]{15,22}$/.test(code)) {
				return;
			}
		} else {
			$plateInputs.each(function () {
				code += $(this).val();
			});
			if (code.length !== 6) {
				return;
			}
		}
		$("#navicore-search-result").html('<div class="navicore-loading"></div>');
		$.get(navicore.api, { code: code }, function (res) {
			if (!res.found) {
				$("#navicore-search-result").html("<p>Su número de placa no se encuentra registrado o no tiene ninguna campaña de seguridad pendiente.</p>");
				return;
			}

			var html = "<h3>Vehículo:</h3>";
			html += "<p><strong>VIN:</strong> " + res.vehicle.vin + "<br>";
			html += "<strong>Placa:</strong> " + res.vehicle.plate + "<br>";
			html += "<strong>Modelo:</strong> " + res.vehicle.model + "<br>";
			html += "<strong>Marca:</strong> " + res.vehicle.brand + "</p>";
			if (res.campaigns.length) {
				html += html = "<div class='intro'><h4><strong>Importante:</strong> Campañas de Seguridad para su Vehículo</h4>";
				"<p>En International y Navitrans, trabajamos constantemente para ofrecerle el máximo desempeño y seguridad en nuestros productos. Por este motivo, informamos que su vehículo con VIN " +
					res.vehicle.vin;
				if (res.campaigns.length > 1) {
					html += " ha sido identificado dentro de " + res.campaigns.length + " campañas de seguridad preventiva.</p>";
				} else {
					html += " ha sido identificado dentro de una o campaña de seguridad preventiva.</p>";
				}
				html += "</div>";
				html += "<h3>Campañas</h3>";
				res.campaigns.forEach(function (c) {
					html += '<div class="campaign">';
					html += "<h4>" + c.title + "</h4>";
					html += "<div class='fecha'>" + c.date + "</div>";
					html += c.content;
					html += "</div>";
				});
			} else {
				html += "<p>Sin campañas asociadas.</p>";
			}
			$("#navicore-search-result").html(html);
		});
	});
});
