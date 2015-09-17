 /*DOCUMENT READY */
jQuery(document).ready(function() {
			
   
    $('#tabs .tabscontent>div').not('div:first').hide();
    $('#tabs ul li:first,#tabs .tabscontent>div:first').addClass('active');
 
    $('#tabs ul li a').click(function(){
 
        var currentTab = $(this).parent();
        if(!currentTab.hasClass('active')){
            $('#tabs ul li').removeClass('active');             
 
            $('#tabs .tabscontent>div').slideUp('fast').removeClass('active');


            var currentIdPestania = $(this).attr('id');
            
            if(currentIdPestania == '2'){ //edita

            	
            	$idindS = $('input:radio[name=rad_ind_secretaria]:checked').val(); //radio status información
				alert(currentIdPestania+" : "+$idindS);
				//$( "#contenedor" ).remove();
				$( "#content2" ).load( "menu_arbol.php?p=2&i="+$idindS, function( response, status, xhr ) {
						  if ( status == "error" ) {
						    var msg = "A ocurrido un error al cargar el menu  ";
						    $( "#divresultado" ).html( msg + xhr.status + " " + xhr.statusText );
						  }
				});
				

            }else if(currentIdPestania == '1'){ //captura

            	//alert(currentIdPestania);

				//$( "#contenedor" ).remove();
				$( "#content1" ).load( "menu_arbol.php?p=1", function( response, status, xhr ) {
						  if ( status == "error" ) {
						    var msg = "A ocurrido un error al cargar el menu  ";
						    $( "#divresultado" ).html( msg + xhr.status + " " + xhr.statusText );
						  }
				});
				//$("#pestania").val("captura");
		
            }else if(currentIdPestania == '3'){ //publica


            	//alert(currentIdPestania);

				$( "#contenedor" ).remove();
				$( "#content3" ).load( "edicion.php?p=3", function( response, status, xhr ) {
						  if ( status == "error" ) {
						    var msg = "A ocurrido un error al cargar el menu  ";
						    $( "#divresultado" ).html( msg + xhr.status + " " + xhr.statusText );
						  }
				});



            }else if(currentIdPestania == '4'){ //carrusel
            	
            	//alert(currentIdPestania);
				$( "#contenedor" ).remove();
				$( "#content4" ).load( "admon_carrusel.php?p=4", function( response, status, xhr ) {
						  if ( status == "error" ) {
						    var msg = "A ocurrido un error al cargar el menu  ";
						    $( "#divresultado" ).html( msg + xhr.status + " " + xhr.statusText );
						  }
				});



            }

 
            var currentcontent = $($(this).attr('href'));
            currentcontent.slideDown('fast', function() {
                currentTab.addClass('active');
                currentcontent.addClass('active');
            });



            
        }
        return false;                           
    });


            
	       	/*centra los divs y los espande*/
       		//$('#content').center();

       	function verTabladetalle(){


       	}



			/*Control los radios de liga y archivo*/
			$('input[name="rad_ind_secretaria"]:radio' ).change(
						function(){
						       
	

						    sendRdVal(); /*FUNCION ENVIA VALORES RADIOS DE LOS INDICADORES*/
						    /*   

								   var r = $(this).val();
							       alert('valor: '+r);


						       if (r == 'liga') {
									$("#divarchivo").hide();
									$("#divliga").show();
									
						       }else{
						       		
						       		$("#divliga").hide();
						       		$("#divarchivo").show();

						       };
						    */

						        
						});

			/*FUNCION VENTANA MODAL  * /
			
			dialog = $( "#dialog-confirm" ).dialog({	
							position: { my: "center", at: "center", of: $("body"),within: $("body") },							 
							autoOpen: false,
							height: 150,
							width: 450,
							modal: true,
							buttons: {
								"Si": function() {  // con esta accion acepta publicar o no publicar el contenido

									realizaProceso(dialog.data('IDinsertado'),dialog.data('accion'),dialog.data('seccion'));	
									$('#divresultado').empty(); //limpia la capa
									$( this ).dialog( "close" );
								},
								"Cancelar": function() {
									$('#divresultado').empty(); //limpia la capa
									$( this ).dialog( "close" );
								}
							},
							close: function() {
								$('#divresultado').empty(); //limpia la capa
								$( this ).dialog( "close" );
								/*
								form[ 0 ].reset();
								allFields.removeClass( "ui-state-error" );
								* /
								
							}

					});
			*/


						/*FUNCION VENTANA MODAL CON TABLA RESULTADOS  */

		dialog_tabla = $( "#dialog-table" ).dialog({	
							position: { my: "center", at: "center", of: $("body"),within: $("body") },							 
							autoOpen: false,
						    width: $(window).width() - 400,
						    height: $(window).height() - 300,
							modal: true,
							

					});

	/*

	dialog_tabla =	$("#dialog-table").dialog({ 
			autoOpen: false,
			width: 590,  
			height: 350,
			show: "scale", 
			hide: "scale", 
			resizable: "false", 
			position: "center",
			modal: "true" 
		});
*/
					/*FUNCION VENTANA MODAL PARA CONFIRMAR  Y PUBLICAR CONTENIDO*/



var form = $( "#formcaptura" );
//form.validate();  
/*************/

				 //al enviar el formulario en el click de "guardar"
				$('#guardar').on('click', function() {

					//validar por indicador compuesto 
					//validar calendario
					//validar lista

		     						//información del formulario
						        	var formData = new FormData($(".formcaptura")[0]);
							        //ENVIA EL FORMULARIO 	
							        enviaformulario(formData);

				});


				 //al enviar el formulario en el click de "editar"
				$('#editar').on('click', function() {
				    form.valid();
  					//alert( "Valid: " + form.valid() );
  					if(form.valid()){
						     	//información del formulario
					        	var formData = new FormData($(".formcaptura")[0]);
						        //ENVIA EL FORMULARIO 	
						        enviaformulario(formData);
  					}

				});


 $("#temas").treeview();
})

/*FIN DE DOCUMENT READY*/
