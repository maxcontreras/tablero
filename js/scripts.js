//funcion para abrir los menus


function show_opc(pag,div,v1,v2)
{	
	switch (pag){

	case '7.3':
	if($F('login')!='' && $F('pass')!='' && $F('array_items')!=''){
		var url="admon/guarda_usuario.php";
		var params="usuario="+$F('usuario')+"&array_items="+$F('array_items')+"&login="+$F('login')+"&pass="+$F('pass');
		}else alert("Se debe registrar el usuario y contrasena y asignar los privilegios del usuario");
	break;
	case '7.4':
		var url="admon/buscar_user.php";
		var params="nombre="+$F('nombre');
	break;
	case '7.5':
		var url="admon/modificar_permisos.php";
		var params="usuario="+v1;
	break;
	case '7.6':
	if($F('login')!='' && $F('pass')!='' && $F('array_items')!=''){
		var url="admon/actualiza_usuario.php";
		var params="usuario="+$F('usuario')+"&array_items="+$F('array_items')+"&login="+$F('login')+"&pass="+$F('pass')+"&estatus="+$F('estatus');
		}else alert("Se debe registrar el usuario y contrasena y asignar los privilegios del usuario");
	break;

	case '7.7':	 //activo o desactivo los bancos
		if(confirm("Seguro que desea activar / desactivar el Documentp?")){
			var url= "catalogos/activa_documento.php";
			
			var params="activo="+v2+"&iddocumento="+v1;	
		}
	break;

	case '7.8':	 //activo o desactivo los bancos
			var url= "Subprogramas/carga_tipoIngreso.php";
			var params="id_rubro="+$F('rubro');	
	break;
	
	}
if(url){
		var ajx = new Ajax.Updater(div, url, {
			method: 'post',
			parameters:params,
			evalScripts: true,
			onLoading: loadingRespuesta($(div))}
			);
}						
}


function check_permiso(id_items)
{
	var chec="check"+id_items;
	
	if($(chec).checked==1){
	var array_items=id_items+"::"+$F('array_items');
	$('array_items').value=array_items;
	}
	else {
	var array_items=$F('array_items');
	var id_c = array_items.split('::');
	var id_tem="";
	for(var i=0; i<id_c.length; i++)
	{
		if(id_c[i]!=id_items && id_c[i]!="")
		{
			id_tem=id_c[i]+"::"+id_tem;
		}
	
	}
	$('array_items').value=id_tem;
 }

}


function show_div(div)
{
			if($(div).style.display=='none'){
				$(div).show();
			}else{
			    $(div).hide();
			}
}


function limpia_div(div){ $(div).innerHTML= '';	}

function enter_click(e,objeto) { 
    var evento= e || window.event;
	var tecla = evento.charCode || evento.keyCode;
   // tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla == 13) { 
	 $(objeto).click();
	}//Tecla de enter 
}


///*****************FUNCION GLOBAL******************////
function loadingRespuesta(div) { 
div.innerHTML= '<div align="center" style="font-size:12px"><img src="../images/loader.gif" width= "25">Trabajando...</div>';
}	


function calendarios(inputt,boton)
{
	
              Zapatec.Calendar.setup({                
				firstDay          : 1,
                showOthers        : true,
                showsTime         : false,
                timeFormat        : "12",
                range             : [1980.01, 2099.12],
                electric          : false,
                inputField        :  inputt,
                button            :  boton,
                ifFormat          : "%d/%m/%Y",
				showsTime	      :  false,
                daFormat          : "%d/%m/%Y"
              });
}


function contrasena(op,div){
var url; 
var band=0;
var parm;
var claseError="claseError";
var claseCorrecto="claseCorrecto";
	if(op==1){  // validar cambio de contraseña..
		var txt1=$F('actual');
		var txt2=$F('new1');
		var txt3=$F('new2');
		var obcion=0;
		txt1 = txt1.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/," ");
		txt2 = txt2.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/," ");
		txt3 = txt3.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/," ");
		 // valida campo 1
		 if(txt1==" "){  // valkidamos campo contra actual que sea igual.
			 $('actual').className=claseError;
			 $('err1').innerHTML= "Este campo no puede dejarse en blanco";
			 band=1;			 
		 }else{
			 $('actual').className=claseCorrecto;
			 $('err1').innerHTML= "";
			 obcion = obcion + 1; 
		 }
		 // valida campo 2
		 if(txt2==" "){
			 $('new1').className=claseError;
			 $('err2').innerHTML= "Este campo no puede dejarse en blanco";
			 band=1;
		 }else{
			 $('new1').className=claseCorrecto;
			 $('err2').innerHTML= "";
			 obcion = obcion + 1; 
		 }
		 // validar campo 3
		 if(txt3==" "){
			 $('new2').className=claseError;
			 $('err3').innerHTML= "Este campo no puede dejarse en blanco";
			 band=1;
		 }else{
			 $('new2').className=claseCorrecto;
			 $('err3').innerHTML= "";
			 obcion = obcion + 1; 
		 }
		 if(obcion==3){ // if que nos indica si los 3 v1es tienen datos.
			 if(txt2==txt3){
				 if( $F('contra_db') == $F('actual')){
				  url= "login/cambio_password.php?ob=1&contra="+$F('new1'); 
			      band=0;
				 }else{
				  $('actual').className=claseError;
				  $('actual').focus();
				  $('new1').value="";
				  $('new2').value="";
				  $('err1').innerHTML= "Password anterior no es correcto.";
				  band=1;
				 }
			 }else{
			  $('new1').className=claseError;
			  $('new2').className=claseError;
			  $('new1').focus();
			  $('new1').value="";
			  $('new2').value="";
			  $('err3').innerHTML= "Las contrase&ntilde;as no coinciden.";	
			  band=1;
			 }
		 }
	} // validar cambio de contraseña..
	if ( band==0 ){
	var ajx = new Ajax.Updater(div, url, {encoding:"UTF-8", method:"post", postBody:parm, onLoading:loadingRespuesta($(div)) } );
	}

}

function formatNumber(num,prefix,text1,text2){
//	alert(num);
	if (num.length==0)return;
	prefix = prefix || '';
	num += '';
	var splitStr = num.split('.');
	var splitLeft = splitStr[0];
	if (splitStr.length >1){
		var splitRight = (splitStr[1].length ==0)? '.00': '.'+ splitStr[1];
	} else var splitRight='.00';
	//var splitRight = splitStr.length > 1 ? '.' + (splitStr[1].length ==0)? : '.00';
	var regx = /(\d+)(\d{3})/;
	
	while (regx.test(splitLeft)) {
		splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
	};
	
	resp= prefix + splitLeft + splitRight;
	$(text1).value = resp;
	$(text2).value = unformatNumber(resp); 
};

function unformatNumber(num) {
	return num.replace(/([^0-9\.\-])/g,'')*1;
};
   
   function noLetras(e)
{
	var keynum;
	var keychar;
	var numcheck;
	var moneycheck;
	
	var evento = e || window.event;

	keynum = evento.charCode || evento.keyCode;
	keychar = String.fromCharCode(keynum);
	numcheck = /^\d*(\.)?$/;
	if (keynum==8 || keynum==9){
		return true;
	} else {
		return numcheck.test(keychar);
	}
};

function valmoneda(v1)
{
	moneycheck = /^\d+(\.\d{0,2})?$/;
	val = (v1.length==0) ? true : moneycheck.test(v1);		
	return val;		
};


function rellenar(quien,que,cuanto){
cadcero='';
for(i=0;i<(cuanto-que.length);i++){
cadcero+='0';
}
quien.value=cadcero+que;
}


function calendarios(inputt,boton)
{
	
              Zapatec.Calendar.setup({                
				firstDay          : 1,
                showOthers        : true,
                showsTime         : false,
                timeFormat        : "12",
                range             : [1980.01, 2099.12],
                electric          : false,
                inputField        :  inputt,
                button            :  boton,
                ifFormat          : "%d/%m/%Y",
				showsTime	      :  false,
                daFormat          : "%d/%m/%Y"
              });
}
