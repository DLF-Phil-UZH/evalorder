/*
If the survey (Umfrage) shall be done online, the user has to
upload a file with all e-mail adresses of the participants, so
the file upload field must be shown. If it shall be done paper-based,
the user has to enter the number of participants, so the participant
number field must to be shown. Only one of those options can be chosen at
a time.
 */
function showHideUmfrageart(){
	// Online selected: show file upload field
	if(document.getElementById("onlineumfrage").checked){
		$("#teilnehmerdatei_tr").show();
		$("#teilnehmeranzahl_tr").hide();
		
		// Enable file inputs in order to allow upload and ensure validation
		$("#nofiles").prop('disabled', false);
		$("#file1").prop('disabled', false);
		$("#file2").prop('disabled', false);
		
		// Disable participant number input to prevent validation
		$("#teilnehmeranzahl").prop('disabled', true);
	}
	// Paper-based selected: show participant number field
	else if(document.getElementById("papierumfrage").checked){
		$("#teilnehmerdatei_tr").hide();
		$("#teilnehmeranzahl_tr").show();
		
		// Disable file inputs in order to prevent validation
		$("#nofiles").prop('disabled', true);
		$("#file1").prop('disabled', true);
		$("#file2").prop('disabled', true);
		
		// Enable participant number input to ensure validation
		$("#teilnehmeranzahl").prop('disabled', false);
	}
	// Hide both (nothing selected)
	else{
		$("#teilnehmerdatei_tr").hide();
		$("#teilnehmeranzahl_tr").hide();
		
		// Disable all inputs
		$("#nofiles").prop('disabled', true);
		$("#file1").prop('disabled', true);
		$("#file2").prop('disabled', true);
		
		$("#teilnehmeranzahl").prop('disabled', true);
	}
}

// Shows button for removing last lecturer if more than one lecturer is in form,
// hides button if only one lecturer is in form
function showHideRemoveLecturerButton(){
	var currentNumber = parseInt($('#anzahlDozenten').val());
	if(currentNumber > 1){
		$("#removeDozent").show();
		$('#removeDozent').css('display', 'inline-block');
	}
	else{
		$("#removeDozent").hide();
	}
}

// Adds validation rules for a given lecturer
function addRulesDozenten(dozentNumber){
	
	$("#nachname_dozent_" + dozentNumber).rules("add", {
		required: true
	});
	$("#vorname_dozent_" + dozentNumber).rules("add", {
		required: true
	});
	$('input[name="geschlecht_dozent_' + dozentNumber + '"]').rules("add", {
		required: true
	});
	$("#email_dozent_" + dozentNumber).rules("add", {
		required: true,
		email: true
	});
	
}

// Removes all validation rules for a given lecturer
function removeRulesDozenten(dozentNumber){
	$("#nachname_dozent_" + dozentNumber).rules("remove");
	$("#vorname_dozent_" + dozentNumber).rules("remove");
	$('input[name="geschlecht_dozent_' + dozentNumber + '"]').rules("remove");
	$("#email_dozent_" + dozentNumber).rules("remove");
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
			// Only add number to title from second lecturer ascending
			if(newNumber > 1){
				$("#dozent_" + newNumberString).find("h3").text("Dozierende Person " + newNumberString);
			}
			else{
				$("#dozent_" + newNumberString).find("h3").text("Dozierende Person");
			}
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
			
			// Add validation rules to new lecturer
			addRulesDozenten(newNumberString);
			
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
		
		// Remove validation rules from last lecturer
		removeRulesDozenten(currentNumberString);
		
		// Remove all elements of last lecturer (dozent) completely with all data potentially inserted
		$("#dozent_" + currentNumberString).remove();
		
		// Update number of lecturers
		$("#anzahlDozenten").val(newNumber);
	
	}
	
	showHideRemoveLecturerButton();
	
}

// Enables/disables the file upload related inputs according to passed number
function setNumberOfLists(number){
	if(typeof number === 'number'){
		if(number == 0){
			document.getElementById('fileselect1').disabled = true;
			document.getElementById('uploadbutton1').disabled = true;
			document.getElementById('filecheck1').disabled = true;
			
			document.getElementById('fileselect2').disabled = true;
			document.getElementById('uploadbutton2').disabled = true;
			document.getElementById('filecheck2').disabled = true;
		}
		else if(number == 1){
			document.getElementById('fileselect1').disabled = false;
			document.getElementById('uploadbutton1').disabled = false;
			document.getElementById('filecheck1').disabled = false;
			
			document.getElementById('fileselect2').disabled = true;
			document.getElementById('uploadbutton2').disabled = true;
			document.getElementById('filecheck2').disabled = true;
		}
		else if(number == 2){
			document.getElementById('fileselect1').disabled = false;
			document.getElementById('uploadbutton1').disabled = false;
			document.getElementById('filecheck1').disabled = false;
			
			document.getElementById('fileselect2').disabled = false;
			document.getElementById('uploadbutton2').disabled = false;
			document.getElementById('filecheck2').disabled = false;
		}
	}
}

function uploadList(number, course) {
	
	// Optional parameter, will only be set if called from backend
	course = course || "";
	
	var uriAddition = "";
	var idAddition = "";
	
	// If course is set, prepare URI and ID addition
	if((course.toString()).length > 0){
		uriAddition = "/" + course.toString() + "/" + number.toString();
		idAddition = "_" + course.toString();
	}
	
	if(typeof number === 'number'){
		
		var form = document.getElementById('evalorderform');
		var fileSelect = document.getElementById('fileselect' + number.toString() + idAddition);
		var feedback = document.getElementById('filefeedback' + number.toString() + idAddition);
		var filecheck = document.getElementById('filecheck' + number.toString() + idAddition);

		if(fileSelect.files.length === 1){

			feedback.style = "";
			feedback.innerHTML = 'Liste wird hochgeladen...';

			// Get the selected files from the input
			var files = fileSelect.files;
			// Create a new FormData object
			var formData = new FormData();
			// Loop through each of the selected files
			for(var i = 0; i < files.length; i++){
				var file = files[i];
				// Add the file to the request.
				formData.append('list' + number.toString(), file, file.name);
			}
			
			// Set up the request.
			var xhr = new XMLHttpRequest();
			
			// Open the connection.
			xhr.open('POST', 'https://www.uzh.ch/phil/static/dev/evalorder/evalorderform/uploadfile' + uriAddition, true);
			// Set up a handler for when the request finishes.
			xhr.onload = function(){
				if(xhr.status === 200) {
					// File(s) uploaded.
					var responseArray = JSON.parse(xhr.responseText);
					if(responseArray.status === "error"){
						feedback.style = "color: red;";
						feedback.innerHTML = responseArray.feedback;
					}
					else if(responseArray.status === "success"){
						feedback.style = "color: green;";
						feedback.innerHTML = "Datei <b>" + responseArray.feedback + "</b> erfolgreich hochgeladen.";
					}
					filecheck.value = responseArray.feedback;
				}
				else{
					feedback.style = "color: red;";
					feedback.innerHTML = "Fehler bei der Server-Anfrage.";
				}
			};
			// Send the Data.
			xhr.send(formData);
		}
		else{
			feedback.style = "color: red;";
			feedback.innerHTML = 'Keine Datei ausgew&auml;hlt';
		}
	}
}