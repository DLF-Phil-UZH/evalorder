/*
If the survey (Umfrage) shall be done online, the user has to
upload a file with all e-mail adresses of the participants, so
the file upload field must be shown. If it shall be done paper-based,
the user has to enter the number of participants, so the participant
number field must to be shown. Only of those options can be chosen at
a time.
 */
function showHideUmfrageart(){
	// Online selected: show file upload field
	if(document.getElementById("onlineumfrage").checked){
		$("#teilnehmerdatei_tr").show();
		$("#teilnehmeranzahl_tr").hide();
	}
	// Paper-based selected: show participant number field
	else if(document.getElementById("papierumfrage").checked){
		$("#teilnehmerdatei_tr").hide();
		$("#teilnehmeranzahl_tr").show();
	}
	// Hide both (nothing selected)
	else{
		$("#teilnehmerdatei_tr").hide();
		$("#teilnehmeranzahl_tr").hide();
	}
}

// Shows button for removing last lecturer if more than one lecturer is in form,
// hides button if only one lecturer is in form
function showHideRemoveLecturerButton(){
	var currentNumber = parseInt($('#anzahlDozenten').val());
	if(currentNumber > 1){
		$("#removeDozent").show();
	}
	else{
		$("#removeDozent").hide();
	}
}

function clearDozent(number){
  $("#nachname_dozent_".concat(number.toString())).value = "";
  $("#vorname_dozent_".concat(number.toString())).value = "";
  $("#dozent_".concat(number.toString()).concat("maennlich")).checked = false;
  $("#dozent_".concat(number.toString()).concat("weiblich")).checked = false;
  $("#titel_dozent_".concat(number.toString())).value = "";
  $("#email_dozent_".concat(number.toString())).value = "";
}

function addDozenten(number){
	if(typeof number === 'number'){
		for(var i = 0; i < number; i++){
			
			var currentNumber = parseInt($('#anzahlDozenten').val());
			var newNumber = currentNumber + 1;
			var newNumberString = newNumber.toString();
			
			// Get element to insert new lecturer after
			if(currentNumber === 0){
				var elementBefore = $('#dozent_');
			}
			else{
				var elementBefore = $('#dozent_' + currentNumber.toString());
			}
			
			// Insert new lecturer elements
			$("#dozent_").clone().attr('id', 'dozent_' + newNumberString).insertAfter(elementBefore);
			
			// Append number to attributes
			$("#dozent_" + newNumberString).removeAttr("class");
			$("#dozent_" + newNumberString).find("h3").text("DozentIn " + newNumberString);
			$("#dozent_" + newNumberString).find("label").each(function(){
				var oldFor = $(this).attr("for");
				$(this).attr("for", oldFor + newNumberString);
			});
			$("#dozent_" + newNumberString).find("input").each(function(){
				var oldId = $(this).attr("id");
				$(this).attr("id", oldId + newNumberString);
			});
			$("#dozent_" + newNumberString).find("input").each(function(){
				var oldName = $(this).attr("name");
				$(this).attr("name", oldName + newNumberString);
			});
			/*$("#dozent_" + newNumberString).find("input[type=radio]").each(function(){
				var oldValue = $(this).attr("value");
				$(this).attr("value", oldValue + newNumberString);
			});*/
			
			// Update number of lecturers
			$("#anzahlDozenten").val(newNumber);
		}
		
		showHideRemoveLecturerButton();
		
    }
}

function removeLastDozent(){
	
	var currentNumber = parseInt($('#anzahlDozenten').val());
	
	// First lecturer cannot be removed, at least one must be present
	if(currentNumber > 1){
	
		var currentNumberString = currentNumber.toString();
		var newNumber = currentNumber - 1;
		
		// Remove all elements of last lecturer (dozent) completely with all data potentially inserted
		$("#dozent_" + currentNumberString).remove();
		
		// Update number of lecturers
		$("#anzahlDozenten").val(newNumber);
	
	}
	
	showHideRemoveLecturerButton();
	
}

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
	
});