// On document load
$(document).ready(function(){
	
	// Tablesorter plugin
	$("#bestellungen_table").tablesorter({
		// Sort according to fourth column ascending first, to second column ascending second
		sortList: [[3,0], [1,0]],
		// For zebra pattern on table rows
		widgets: ['zebra']
	});
	
});