// On document load
$(document).ready(function(){
	
	// Set empty default for course type (Lehrveranstaltungstyp) if data is not repopulated
	if($("#typ_lehrveranstaltung option[selected=selected]").length < 1){
		$('#typ_lehrveranstaltung').prop('selectedIndex', -1);
	}
	
	// Paste first lecturer (Dozent) if form is delivered the first time, 
	// but not if a previously submitted form must be revised
	var numberDozenten = parseInt($('#anzahlDozenten').val());
	if(numberDozenten === 0){
		addDozenten(1);
	}
	
	// Update remove last lecturer (Dozent) button
	showHideRemoveLecturerButton();
	
	// Update survey (Umfrageart) fields
	showHideUmfrageart();
	
	// Update language visibility
	showHideLanguage();
	
	// Update form preview
	displayFormPreview();
	
	// Add onclick events to all form inputs in step 3 for form preview handling
	$('input:radio[name="umfrageart"], input:radio[name="lvtyp"], input:radio[name="sprache"]').change(displayFormPreview);
	
	$('input:radio[name="umfrageart"]').change(showHideLanguage);
	
	// Add validation method for string equality (used in hidden input for filecheck status)
	$.validator.addMethod("equals", function(value, element, string){
		return value === string;
	}, $.validator.format("Please enter '{0}'"));
	
	// Default: Propose upload of one participant list (only applies if online survey is selected)
	setNumberOfLists(1);
	document.getElementById('file1').checked = true;
	
});