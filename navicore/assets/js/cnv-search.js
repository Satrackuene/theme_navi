jQuery(function ($) {
	$("#navicore-search-form").on("submit", function (e) {
		e.preventDefault();
		var code = $("#navicore-search-input").val();
		if (!code) {
			return;
		}
		$("#navicore-search-result").text("Buscando...");
		$.get(navicore.api, { code: code }, function (res) {
			if (!res.found) {
				$("#navicore-search-result").html("<p>Su número de placa no se encuentra registrado o no tiene ninguna campaña de seguridad pendiente.</p>");
				return;
			}

			var html = "<h4>Vehículo:</h4>";
			html += "<p><strong>VIN:</strong> " + res.vehicle.vin + "<br>";
			html += "<strong>Placa:</strong> " + res.vehicle.plate + "<br>";
			html += "<strong>Modelo:</strong> " + res.vehicle.model + "<br>";
			html += "<strong>Marca:</strong> " + res.vehicle.brand + "</p>";
			if (res.campaigns.length) {
				html += html = "<div><h3><strong>Importante:</strong> Campañas de Seguridad para su Vehículo</h3>";
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
