document.getElementById("stats").addEventListener("click", function() {
    if(document.getElementById("stats").checked) {
        document.getElementById("Names").disabled = true;
        document.getElementById("Levels").disabled = true;        
        var x = document.getElementsByName("stat[]");
		var i;
		for(i = 0; i < x.length; i++)
			x[i].disabled = false;
    }
    else {
        document.getElementById("Names").disabled = false;
        document.getElementById("Levels").disabled = false;  
        var x = document.getElementsByName("stat[]");
		var i;
		for(i = 0; i < x.length; i++)
			x[i].disabled = true;
    }
});

//Form
function submitForm(name, level) {
	document.getElementById("Names").value = name;
    document.getElementById("Levels").value = level;
	document.forms["artifact"].submit();
}