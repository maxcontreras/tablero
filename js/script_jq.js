// JavaScript Document
function enviarlas (var1, var2){
	        //recogemos el contenido de las cajas de texto
          var num1=var1;
          var num2=var2;
         
          var parametros={
            'valor':num1,
            'idproyecto':num2
          };
          /*var parametros={
            'valor':num1,
            'valor1:num2'
          };*/
          $.ajax({ //inicia la funcion ajax
            type: 'POST', //tipo de envio: post o get como en un formulario web
            data: parametros, //ajuntamos los parametros con los datos
            url: "muestra_detalle_ficha.php", //url del archivo a llamar y que hace el procedimiento
            dataType: 'html' //tipo de data que retorna
          })
          //done se ejecuta al terminar la ejecucion del archivo getSuma.php
          .done(function(data){ 
            //llenamos el div "resultado" con lo obtenido de getSuma.php
            $('#listado').html(data);
          });    
}
function enviarescena (var1){
          //recogemos el contenido de las cajas de texto
          var num1=var1;
         
          var parametros={
            'valor':num1
          };
          /*var parametros={
            'valor':num1,
            'valor1:num2'
          };*/
          $.ajax({ //inicia la funcion ajax
            type: 'POST', //tipo de envio: post o get como en un formulario web
            data: parametros, //ajuntamos los parametros con los datos
            url: "muestra_detalle_fichaescenarios.php", //url del archivo a llamar y que hace el procedimiento
            dataType: 'html' //tipo de data que retorna
          })
          //done se ejecuta al terminar la ejecucion del archivo getSuma.php
          .done(function(data){ 
            //llenamos el div "resultado" con lo obtenido de getSuma.php
            $('#listado').html(data);
          });    
}
function opc_result (var1){
	        //recogemos el contenido de las cajas de texto
          var filtro=$("#filtro").val();
          var parametros={
            'filtro':filtro
          };
          $.ajax({ //inicia la funcion ajax
            type: 'POST', //tipo de envio: post o get como en un formulario web
            data: parametros, //ajuntamos los parametros con los datos
            url: "muestra_proyectos.php", //url del archivo a llamar y que hace el procedimiento
            dataType: 'html' //tipo de data que retorna
          })
          //done se ejecuta al terminar la ejecucion del archivo getSuma.php
          .done(function(data){ 
            //llenamos el div "resultado" con lo obtenido de getSuma.php
            $('#listado').html(data);
          });    
}
function opc_resultver (var1){
          //recogemos el contenido de las cajas de texto
          var filtro=$("#filtro").val();
          var parametros={
            'filtro':filtro
          };
          $.ajax({ //inicia la funcion ajax
            type: 'POST', //tipo de envio: post o get como en un formulario web
            data: parametros, //ajuntamos los parametros con los datos
            url: "muestra_verproyectos.php", //url del archivo a llamar y que hace el procedimiento
            dataType: 'html' //tipo de data que retorna
          })
          //done se ejecuta al terminar la ejecucion del archivo getSuma.php
          .done(function(data){ 
            //llenamos el div "resultado" con lo obtenido de getSuma.php
            $('#listado').html(data);
          });    
}
function opc_resultagrupar (var1){
          //recogemos el contenido de las cajas de texto
          var filtro=$("#filtro").val();
          var parametros={
            'filtro':filtro
          };
          $.ajax({ //inicia la funcion ajax
            type: 'POST', //tipo de envio: post o get como en un formulario web
            data: parametros, //ajuntamos los parametros con los datos
            url: "muestra_proyectos_agr.php", //url del archivo a llamar y que hace el procedimiento
            dataType: 'html' //tipo de data que retorna
          })
          //done se ejecuta al terminar la ejecucion del archivo getSuma.php
          .done(function(data){ 
            //llenamos el div "resultado" con lo obtenido de getSuma.php
            $('#listado').html(data);
          });    
}

function sendsecretaria(idsecretaria){
    document.getElementById("idsecretariaHi").value = idsecretaria;
    document.oculto.submit();
}
