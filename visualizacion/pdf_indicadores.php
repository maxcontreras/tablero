<?php
@require ("main_valida.php");
require('../pdf/fpdf.php');//agrego la libreria
require('../pdf/mc_table.php');

if(isset($_GET['idsecretaria']))$idsecretaria=$_GET['idsecretaria'];




 class PDF extends PDF_TABLE
{	//Cabecera de p?gina
//     	$pdf->ezImage("../images/encabezado.jpg", 0, 750, 'none', 'left');
        function Header(){	
        	@require ("main_valida.php");
        	if(isset($_GET['idsecretaria']))$idsecretaria=$_GET['idsecretaria'];

        	  $sql ="SELECT
			secretarias.idsecretaria,
			secretarias.secretaria,
			secretarias.nom_titular,
			secretarias.periodo
			FROM
			secretarias
			where idsecretaria = $idsecretaria";

	      	$result = $con->prepare($sql);
	      	$result->execute();
	    	$rowS = $result->fetch();
			$nom_titular =  $rowS['nom_titular'];
			$secretaria  =  $rowS['secretaria'];
			$periodo 	 =  $rowS['periodo'];


        		$this->SetTextColor(0,0,0);
                $this->Image("../images/imgsecretarios/".$idsecretaria.".jpg",10,5,20); //hoja membretada
               // $this->Cell(196,4,"Gobierno del Estado de Jalisco",1,'C');
                $this->SetXY(0,1);
               	$this->SetFillColor(176,35,32); // rojo
				$this->Cell(300, 3, '', 0, 0, 'C', True);
				
				$this->SetFont('Arial','B',12);
				$this->SetXY(60,8);
				$this->SetTextColor(64,64,65);
				$this->Cell(100,4,utf8_decode("Nombre: ".$nom_titular),0,'L');

				$this->SetFont('Arial','B',12);
				$this->SetXY(60,14);
				$this->SetTextColor(64,64,65);
				$this->Cell(100,4,utf8_decode("Secretaría: ".$secretaria),0,'L');

				$this->SetFont('Arial','B',12);
				$this->SetXY(60,20);
				$this->SetTextColor(64,64,65);
				$this->Cell(100,4,utf8_decode("Periodo: ".$periodo),0,'L');

				$this->SetXY(0,28);
               	$this->SetFillColor(64,64,65); // gris
				$this->Cell(300, 3, '', 0, 0, 'C', True);

                $this->SetFont('Arial','',10); 	//Fuente para titulos
                $this->Ln(25);	//salto de l?nea
        }
        function Footer()
        {
            //Posición: a 1,5 cm del final
          
            global $username, $fechaC;
            $this->SetTextColor(128);
            $this->SetY(-15);
            $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
			$this->SetY(-14);
     
			
		}
			
}

 $pdf=new PDF('P','mm','Letter');	//carta vertical
 $pdf->AliasNbPages();
 $pdf->AddPage('L');
 $pdf->SetMargins(4,2,1,1);


$idPaquete = 1;


 $saltoy=4;

///////////////////////////////								//////////////////////////////////////
 /////////////////////////////		IMPACTO						/////////////////////////////////////	
 /////////////////////////////								/////////////////////////////////////


	$sql1 ="SELECT v.idind_secretaria, FORMAT(CASE idformula WHEN 1 THEN v.valor  WHEN 2 THEN avg(v.valor) WHEN 3 THEN sum(v.valor) WHEN 4 THEN vmax.valor  ELSE sum(v.valor) END,2) AS valor, 
	FORMAT(prom,2) AS prom, idformula, m.anio_periodo, indicador, unidad_medida,
idtpo_indicador, ind.idsecretaria FROM (
SELECT * FROM vw_max_anio_val) as m
INNER JOIN 
(SELECT * FROM 
valores) as v 
INNER JOIN 
(SELECT avg(valor) AS prom, idind_secretaria FROM valores 
GROUP BY idind_secretaria) AS p
INNER JOIN (SELECT idind_secretaria, idformula FROM indicadores_secretarias) AS i
INNER JOIN (SELECT valores.valor, valores.idind_secretaria, valores.anio_periodo, valores.fre_periodo
FROM
vw_max_fre_periodo
INNER join valores ON vw_max_fre_periodo.idind_secretaria = valores.idind_secretaria AND vw_max_fre_periodo.anio_periodo = valores.anio_periodo AND vw_max_fre_periodo.fre_periodo = valores.fre_periodo) AS vmax
INNER JOIN (SELECT
indicadores_secretarias.idind_secretaria,
indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida) AS ind
ON p.idind_secretaria = v.idind_secretaria AND i.idind_secretaria = p.idind_secretaria
AND  m.idind_secretaria = v.idind_secretaria AND m.anio_periodo = v.anio_periodo
AND v.idind_secretaria = vmax.idind_secretaria AND v.anio_periodo = vmax.anio_periodo
AND v.idind_secretaria = ind.idind_secretaria
GROUP BY v.idind_secretaria
HAVING  ind.idsecretaria = $idsecretaria AND ind.idtpo_indicador = 1
UNION ALL
SELECT
indicadores_secretarias.idind_secretaria,
' ' as valor,
' ' as prom, 
indicadores_secretarias.idformula,
' ' as anio_periodo,
 indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores_secretarias
Inner Join indicadores ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
WHERE idind_secretaria NOT IN (SELECT idind_secretaria FROM valores) AND idsecretaria = $idsecretaria AND indicadores_secretarias.idtpo_indicador = 1";
//echo $sql1;
	$result1 = $con->prepare($sql1);
    $result1->execute(); 

 $pdf->SetXY(4,33);
 $pdf->SetFillColor(64,64,65);
 $pdf->SetTextColor(255,255,255);
 $pdf->Cell(110, 4, 'IMPACTO', 0, 0, 'C', True);


$x=$pdf->GetX();		
$y=$pdf->GetY();
$pdf->SetXY($x,$y);
$pdf->SetXY(4,37);
$pdf->SetWidths(array(46,22,18,15,9));
$pdf->SetAligns(array('C','C','C','C','C'));
$pdf->SetFillColor(164,64,65);
$pdf->SetTextColor(255,255,255);

$pdf->SetFont('Arial','B',7);
$headers=array("Indicador", "Unidad Medida", "Valor", "Promedio","Fecha");

$pdf->Row2(array(utf8_decode("Indicador"), "Unidad Medida", "Valor", "Promedio","fecha"),0,4,'FD');

$rellenar=false;
	while ($row1 = $result1->fetch()){



	    $img1 = "../images/rojo.jpg";
		if ($row1['valor'] > 0){
			$semaforo = (($row1['valor'] * 100) / $row1['prom']);
					 	
			if ($semaforo <= 85) $img1 = "../images/rojo.jpg";
			if ($semaforo >= 86 && $semaforo <=99) $img1 = "amarillo.jpg";
			if ($semaforo >99) $img1 = "../images/verde.jpg";
		}




		$ind = ""; $uni = ""; $val = ""; $prom=""; $fec=""; 

		$ind .= $row1['indicador'];
	    $uni .= $row1['unidad_medida'].'
	    ';
	    $val .= $row1['valor'].'
	    ';
	    	   // $val .= $row1['valor'].'<img src="../images/$img1" width="12" height="12">.';
	    $prom .= $row1['prom'].'
	    ';
	    $fec .= $row1['anio_periodo'].'
	    ';

		 if($rellenar)
		        $pdf->SetFillColor (230,230,230);
		    else
		        $pdf->SetFillColor(255);
		    $rellenar = !$rellenar;
		    $x=$pdf->GetX();		
		    $y=$pdf->GetY();
		    $pdf->SetXY($x,$y);
		    $pdf->SetTextColor(0,0,0);
		    $pdf->SetFont('Arial','',7);
		    $pdf->SetAligns(array('L','L','L','C','R'));
		    $pdf->Row2(array(utf8_decode($row1['indicador']),$row1['unidad_medida'],$row1['valor'],$row1['prom'],$row1['anio_periodo']),0,8,'FD');

	
	}

///////////////////////////////								//////////////////////////////////////
 /////////////////////////////		PROCESO						/////////////////////////////////////	
 /////////////////////////////								/////////////////////////////////////

  $sql2 ="SELECT v.idind_secretaria, FORMAT(CASE idformula WHEN 1 THEN v.valor  WHEN 2 THEN avg(v.valor) WHEN 3 THEN sum(v.valor) WHEN 4 THEN vmax.valor  ELSE sum(v.valor) END,2) AS valor, 
    FORMAT(prom,2) AS prom, idformula, m.anio_periodo, indicador, unidad_medida,
idtpo_indicador, ind.idsecretaria FROM (
SELECT * FROM vw_max_anio_val) as m
INNER JOIN 
(SELECT * FROM 
valores) as v 
INNER JOIN 
(SELECT avg(valor) AS prom, idind_secretaria FROM valores 
GROUP BY idind_secretaria) AS p
INNER JOIN (SELECT idind_secretaria, idformula FROM indicadores_secretarias) AS i
INNER JOIN (SELECT valores.valor, valores.idind_secretaria, valores.anio_periodo, valores.fre_periodo
FROM
vw_max_fre_periodo
INNER join valores ON vw_max_fre_periodo.idind_secretaria = valores.idind_secretaria AND vw_max_fre_periodo.anio_periodo = valores.anio_periodo AND vw_max_fre_periodo.fre_periodo = valores.fre_periodo) AS vmax
INNER JOIN (SELECT
indicadores_secretarias.idind_secretaria,
indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida) AS ind
ON p.idind_secretaria = v.idind_secretaria AND i.idind_secretaria = p.idind_secretaria
AND  m.idind_secretaria = v.idind_secretaria AND m.anio_periodo = v.anio_periodo
AND v.idind_secretaria = vmax.idind_secretaria AND v.anio_periodo = vmax.anio_periodo
AND v.idind_secretaria = ind.idind_secretaria
GROUP BY v.idind_secretaria
HAVING  ind.idsecretaria = $idsecretaria AND ind.idtpo_indicador = 2
UNION ALL
SELECT
indicadores_secretarias.idind_secretaria,
' ' as valor,
' ' as prom, 
indicadores_secretarias.idformula,
' ' as anio_periodo,
 indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores_secretarias
Inner Join indicadores ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
WHERE idind_secretaria NOT IN (SELECT idind_secretaria FROM valores) AND idsecretaria = $idsecretaria AND indicadores_secretarias.idtpo_indicador = 2";
	$result2 = $con->prepare($sql2);
    $result2->execute(); 

 $pdf->SetXY(150,33);
 $pdf->SetFillColor(64,64,65);
 $pdf->SetTextColor(255,255,255);
 $pdf->Cell(110, 4, 'PROCESO', 0, 0, 'C', True);





    $pdf->Ln($saltoy);


    /*
$pdf->SetTextColor(190, 190, 190);
$pdf->Cell(80,$saltoy,  utf8_decode("ELABORÓ"),0,0,'C',0);
$pdf->Cell(100,$saltoy,  utf8_decode("REVISÓ"),0,0,'C',0);
$pdf->Cell(80,$saltoy,  utf8_decode("AUTORIZÓ"),0,0,'C',0);
$pdf->Ln($saltoy);
*/

$pdf->Output();

?>



