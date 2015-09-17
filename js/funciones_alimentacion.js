/* Controla el cambio de los radios del status de los temas : P / NP */
$('input[name="rad_ind_secretaria"]:radio').change(
		function(){
					sendRdVal(); /*FUNCION ENVIA VALORES RADIOS TEMAS PRINCIPALES /  STATUS DE TEMAS*/
				}
	);	

$('#myLink').click(function(){ 
  alert("entra");
  sendRdVal();
  return false;
});


/*FUNCION PARA VER DETALLES DEL INDICADOR*/
function verDetalles(){

        $idindS = $('input:radio[name=rad_ind_secretaria]:checked').val(); //radio status información

	    seccion = "";

        dialog_tabla.load("tabla_detalles.php", {"idIndicador": $idindS}) //envio por post para formar la tabla de resultados
		dialog_tabla.dialog( "open" );
	

}

function verEditar(){

        $idindS = $('input:radio[name=rad_ind_secretaria]:checked').val(); //radio status información

	    seccion = "	";

        dialog_tabla.load("edicion.php", {"idIndicador": $idindS}) //envio por post para formar la tabla de resultados
		dialog_tabla.dialog( "open" );
}
function verMeta(){

        $idindS = $('input:radio[name=rad_ind_secretaria]:checked').val(); //radio status información

	    seccion = "	";

        dialog_tabla.load("meta.php", {"idIndicador": $idindS}) //envio por post para formar la tabla de resultados
		dialog_tabla.dialog( "open" );
	

}

function sendRdVal(){


        $idindS = $('input:radio[name=rad_ind_secretaria]:checked').val(); //radio status información

        //alert($idindS);

		/*		
		$( "#contenido_alimentacion" ).remove();
		
		var midiv = document.createElement("div");
		midiv.setAttribute("id","contenido_alimentacion");
		midiv.className = 'contenido_alimentacion';
	    var s = document.getElementById('contenedor');
	    s.appendChild(midiv);
		
		*/


		$( "#contenido_alimentacion" ).load( "captura_form.php",{idindS:$idindS}, function( response, status, xhr ) {
				  /*
				  if ( status == "error" ) {
				    var msg = "A ocurrido un error al cargar el menu  ";
				    $( "#divresultado" ).html( msg + xhr.status + " " + xhr.statusText );
				  }
				  */
		});





}



function guardavalores(periodo, valor, idIndicador, frecuencia){

	alert("valores: "+periodo+" : "+valor);
        var parametros = {
        		"idIndicador": idIndicador,
                "periodo" : periodo,
                "valor" : valor,
                "frecuencia": frecuencia
        };

        $.ajax({
                data:  parametros,
                url:   'guardar.php',
                type:  'post',
                beforeSend: function () {
	                message = $("<span class='before'>Procesando, espere por favor...</span>");
	                $("#divresultado").html(message);     
                },
                success:  function (response) {
	                message = $("<span class='before'>El registro se actualizo correctamente</span>");
	                $("#divresultado").html(message);     
                },
	            //si ha ocurrido un error
	            error: function(){
	                message = $("<span class='error'>Ha ocurrido un error....</span>");
	                showMessage(message);
	            }                
        });
}



/* FUNCION QUE ENVIA EL FORMULARIO PARA INSERTAR UN REGISTRO */

	function enviaformulario(formData){

					 alert("va a guardar");
	        var message = ""; 
	        //hacemos la petición ajax  
	        $.ajax({
	            url: 'guardar.php',  
	            type: 'POST',
	            // Form data
	            //datos del formulario
	            data: formData,
	            //necesario para subir archivos via ajax
	            cache: false,
	            contentType: false,
	            processData: false,
	            //mientras enviamos el archivo
	            beforeSend: function(){
	                message = $("<span class='before'>Procesando, espere por favor...</span>");
	                $("#divresultado").html(message);       
	            },
	            //una vez finalizado correctamente
	            success: function(response){
	            	var a = new String("actualizado");
	            	//alert(a+"="+response);

	            	//Si el estatus es "actualizado"	
	            	if(a == response.trim()){

		                message = $("<span class='success'>El registro se actualizo correctamente</span>");
		                $("#divresultado").html(message);  	  


	            	}else{ //si no fue inserción 

	            		
	            		message = $("<span class='success'>El registro se inserto correctamente</span>");
	                	$("#divresultado").html(message);  


		              	$( "#divresultado" ).empty();
		              	

	            	}


	            },
	            //si ha ocurrido un error
	            error: function(){
	                message = $("<span class='error'>Ha ocurrido un error....</span>");
	                showMessage(message);
	            }
	        });

	}

