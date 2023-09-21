function showData(str){
	if(str == ""){
		document.getElementById("dynamicdata").innerHTML = "";
		return;
	}
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("dynamicdata").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","get_data.php?year=" + str, true);
	xmlhttp.send();
}

function showYearly(str){
	if(str == ""){
		document.getElementById("dynamicYearly").innerHTML = "";
		return;
	}
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("dynamicYearly").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","get_yearly_data.php?year=" + str, true);
	xmlhttp.send();
}
