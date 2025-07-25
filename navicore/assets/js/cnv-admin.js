jQuery(function ($) {
	function sortTable($table, col, reverse) {
		var $tbody = $table.find("tbody");
		var rows = $tbody
			.find("tr")
			.toArray()
			.sort(function (a, b) {
				var A = $(a).children("td").eq(col).text().toLowerCase();
				var B = $(b).children("td").eq(col).text().toLowerCase();
				if ($.isNumeric(A) && $.isNumeric(B)) {
					A = parseFloat(A);
					B = parseFloat(B);
				}
				if (A < B) return reverse ? 1 : -1;
				if (A > B) return reverse ? -1 : 1;
				return 0;
			});
		$.each(rows, function (index, row) {
			$tbody.append(row);
		});
	}

	var $table = $("#navicore-vehicles-table");
	$table.find("thead th").each(function (index) {
		var $th = $(this);
		$th.data("index", index).data("reverse", false).css("cursor", "pointer");
		$th.on("click", function () {
			var reverse = !$th.data("reverse");
			$th.data("reverse", reverse);
			sortTable($table, index, reverse);
		});
	});

	$("#navicore-vehicles-filter").on("input", function () {
		var val = $(this).val().toLowerCase();
		$table.find("tbody tr").each(function () {
			var text = $(this).text().toLowerCase();
			$(this).toggle(text.indexOf(val) !== -1);
		});
	});
});
