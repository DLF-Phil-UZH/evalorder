// On document load
$(document).ready(function(){
	
	// Tablesorter plugin
	$("#bestellungen_table").tablesorter({
		sortList: [[3,0], [1,0]],
		widgets: ['zebra']//,
		// widgetOptions: {
			// zebra: ["normal-row", "alt-row"]
		// }
	});
	
});