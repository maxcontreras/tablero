function Ajaxh(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


function OrdenarPor(campo, orden){
	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");

//alert (Filtro);
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "ranking_gral.php?campo="+campo+"&orden="+orden);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function OrdenarPorRanking(campo, orden, filtro){
	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "muestra_ranking_subind.php?campo="+campo+"&orden="+orden+"&filtro="+filtro);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function OrdenarPorEntidad(campo, orden, filtro, filtroent){
	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "muestra_entidad.php?campo="+campo+"&orden="+orden+"&filtro="+filtro+"&filtroent="+filtroent);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function OrdenarPorMejora(campo, orden, filtro){
	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "muestra_mejora_factible.php?campo="+campo+"&orden="+orden+"&filtro="+filtro);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function OrdenarPorResultados(campo, orden, filtro){
	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "muestra_resultados.php?campo="+campo+"&orden="+orden+"&filtro="+filtro);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function OrdenarPorResultadosgral(campo, orden){
	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "muestra_resultadosgral.php?campo="+campo+"&orden="+orden);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function OrdenarPorRank(campo, orden, filtro, filtroent){

	//especificamos en div donde se mostrará el resultado
	divListado = document.getElementById("listado");
	ajax=Ajaxh();
	//especificamos el archivo que realizará el listado
	//y enviamos las dos variables: campo y orden
	ajax.open("GET", "muestra_ranking.php?campo="+campo+"&orden="+orden+"&filtro="+filtro+"&filtroent="+filtroent);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
