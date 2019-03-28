function disable(name) { 
	if(document.getElementById("Names").options[document.getElementById("Names").selectedIndex].text == "") {
		document.getElementById("Bolster").disabled = false;
		document.getElementById("Type").disabled = false;
        document.getElementById("Enhancement").disabled = false;
	}
	else {
		document.getElementById("Bolster").disabled = true;
		document.getElementById("Type").disabled = true;
        document.getElementById("Enhancement").disabled = true;

	}	
	if(document.getElementById("Bolster").options[document.getElementById("Bolster").selectedIndex].text != "" ||
		document.getElementById("Type").options[document.getElementById("Type").selectedIndex].text != "" || 
        document.getElementById("Enhancement").options[document.getElementById("Enhancement").selectedIndex].text != "") {
			document.getElementById("Names").disabled = true;
            document.getElementById("powers").disabled =  (document.getElementById("Enhancement").options[document.getElementById("Enhancement").selectedIndex].text != "") ? true : false;
	}
	else {
		document.getElementById("Names").disabled = false;
	}
	if(document.getElementById("powers").checked) {
		document.getElementById("Names").disabled = true;
        document.getElementById("Enhancement").disabled = true;
		var x = document.getElementsByName("bonus[]");
		var i;
		for(i = 0; i < x.length; i++)
			x[i].disabled = false;
	}
}

function submitForm(name) {
	document.getElementById("Names").value = name;
	document.forms["companion"].submit();
}