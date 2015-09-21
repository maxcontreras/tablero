<?php
require_once '../lib/parsecsv.php';

$estados = array(
	array(
	'Aguascalientes',
  	'Baja California Norte',
  	'Baja California Sur',
  	'Campeche',
  	'Chiapas',
  	'Chihuahua',
	'Coahuila',
	'Colima',
	'Distrito Federal',
	'Durango',
	'Guanajuato',
	'Guerrero',
	'Hidalgo',
	'Jalisco',
	'México - Estado de',
	'Michoacán',
	'Morelos',
	'Nayarit',
	'Nuevo León',
	'Oaxaca',
	'Puebla',
	'Querétaro',
	'Quintana Roo',
	'San Luis Potosí',
	'Sinaloa',
	'Sonora',
	'Tabasco',
	'Tamaulipas',
	'Tlaxcala',
	'Veracruz',
	'Yucatán',
	'Zacatecas',
	)
);

$fecha = Date('d-m-Y');


$csv = new parseCSV();
$csv->encoding('UTF-8');
$csv->delimiter = "\t";
$csv->output('entidades_'.$fecha.'.csv', $estados, ',');