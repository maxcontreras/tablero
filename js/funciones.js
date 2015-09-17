// JavaScript Document
function carga(){ 
var url = './obra/DetConsulta.php'; var parametro = '_accion=cargaContenidoMesa'; 
// AJAX UPDATER 
 var myAjax = new Ajax.Updater( "basic-accordian", url, { method: 'get', parameters: parametro, evalScripts: true } ); } 

function funSendVrs(coche)
	{
	 arrysnd = coche.split (","); // el separador es el espacio
	 vars = "idoficio="+arrysnd;
	 
	 /*
	window.opener.document.formulario.tipo.value = arrysnd[2];
	window.opener.document.formulario.placas.value = arrysnd[3];
	window.opener.document.formulario.marca.value = arrysnd[4];
	window.opener.document.formulario.modelo.value = arrysnd[5];
	window.opener.document.formulario.cili.value = arrysnd[6];
	window.opener.document.formulario.id_vehiculo.value = arrysnd[7];
	window.opener.document.formulario.idoficio.value = arrysnd[0];

    window.opener.validarGasUnidad(arrysnd[0]);
	*/
	//window.close();
	//window.open("detalle.php?"+vars,"detalle","location=1,status=1,scrollbars=1,width=800,height=600") 
	
//	 document.FrmEnvia.submit(); 
  //   window.top.frames["contenido"].location.href="detalle.php"; 
    // document.form1.detalle.style.visibility = "visible"; 
	 window.open("detalle.php?"+vars,"detalle","location=1,status=1,scrollbars=1,width=800,height=600") 
}
function vwdetalle(idind_secretaria)
	{
     document.getElementById("idind_secretatiaHi").value = idind_secretaria;
	 document.oculto.submit();
}


