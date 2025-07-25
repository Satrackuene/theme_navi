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
				$("#navicore-search-result").html("<p>No encontrado.</p>");
				return;
			}
			var html = "<h3>Vehículo</h3>";
			html += "<p><strong>VIN:</strong> " + res.vehicle.vin + "<br>";
			html += "<strong>Placa:</strong> " + res.vehicle.plate + "<br>";
			html += "<strong>Modelo:</strong> " + res.vehicle.model + "<br>";
			html += "<strong>Marca:</strong> " + res.vehicle.brand + "</p>";
			if (res.campaigns.length) {
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
