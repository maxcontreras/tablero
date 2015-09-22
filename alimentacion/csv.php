<?php
require_once('../lib/PHPExcel.php');

$estados = array(
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
);

$objPHPExcel = new PHPExcel();
$fecha = date('d-m-Y');
$nombre = "entidades_".$fecha.".xls";


foreach ($estados as $key => $estado) {
	$key = $key+1;
	$cell = "A$key";
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell, $estado);
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombre.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');