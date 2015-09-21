<?php


// CONEXION LOCALHOST PRUEBAS
/*

define("_BD_SERVIDOR","localhost");

define("_BD_USUARIO","iieggob_pruebas");

define("_BD_PASSWORD","pru3b4S");

define("_BD_NOMBREBD","iieggob_iiegpruebas");

define("_BD_PUERTO","3306");

*/

//CONEXION REAL 

define("_BD_SERVIDOR","localhost");

define("_BD_USUARIO","root");

define("_BD_PASSWORD","");

define("_BD_NOMBREBD","localhost_tablero");

define("_BD_PUERTO","3306");






$BD = _BD_NOMBREBD;

/*FORMATO FECHA*/
define("_FORMATO_FECHA","Y-m-d H:i:s"); 



/*TABLAS*/

define("_TBL_IND","$BD.indicadores");
define("_TBL_USUARIO","$BD.adm_usuario");
define("_TBL_INDSEC","$BD.indicadores_secretarias");
define("_TBL_TPOIND","$BD.tpo_indicador");
define("_TBL_SEC", "$BD.secretarias");
define("_TBL_TEMA","$BD.tema_elementales");
define("_TBL_SECRETARIA","$BD.secretarias");
define("_TBL_U_MEDIDA","$BD.unidad_medidas");
define("_TBL_FRECUENCIA","$BD.frecuencia_act");
define("_TBL_MES","$BD.meses");
define("_TBL_INDCOMP","$BD.indicador_compuesto");
define("_TBL_VALORES","$BD.valores");
define("_TBL_PERIODO", "$BD.periodo");
define("_TBL_ANIO", "$BD.anios");




/*RUTAS DE DIRECTORIOS*/   
// RUTAS PRUEBAS
/*
define("_IMG_CARRUSEL", "../pruebasweb/carrusel2/imagenes/"); //cambiar cuando se suba el sitio 
define("_IMG_CARRUSEL_BORRAR", "../pruebasweb/carrusel2/imagenes/imagenesborrar/"); //cambiar cuando se suba el sitio 
define("_DCTOS_CONTENIDO", "../pruebasweb/"); //ruta para ingresar el contenido de los temas principales
*/

// RUTAS REAL

define("_IMG_CARRUSEL", "img/");
define("_IMG_CD","img/principal/consultadinamica/");
define("_IMG_P","img/principal/publicaciones/");
define("_IMG_B","img/principal/banners/");
define("_IMG_E","img/principal/estudios/");
define("_IMG_D","img/principal/doctosinteres/");
define("_DCTOS_E","contenido/Estudios/");



?>

