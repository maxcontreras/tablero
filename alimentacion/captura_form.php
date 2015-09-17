<!-- CALENDARIO -->
<script type="text/javascript" src="../lib/calendario_dw/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../lib/calendario_dw/calendario_dw.js"></script>
<link href="../lib/calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET">
<script type="text/javascript">
</script>
<?php
  require_once('../lib/class.database.php');  
  require_once('../php/funciones.php');  
  require_once('../lib/config.php');

  $id = $_POST['idindS'];
  //echo "id: ".$id;
	

	global  $BD;
  $BD = new database(_BD_SERVIDOR.':'._BD_PUERTO, _BD_USUARIO, _BD_PASSWORD );  

   //OBTENER INFORMACIÓN GENERAL 
  $query_ind_gral = "
      SELECT ins.idesindicador, ins.idindicador, ins.idind_secretaria, ins.descripcion, ins.metodologia, ins.fuente, s.secretaria,f.idfrecuencia, f.frecuencia,t.tema_elemental, u.unidad_medida, palabra
      FROM "._TBL_INDSEC." ins
      LEFT JOIN "._TBL_TEMA." t
      ON ins.idtema_elemental = t.idtema_elemental
      LEFT JOIN "._TBL_SECRETARIA." s
      ON ins.idsecretaria = s.idsecretaria
      LEFT JOIN "._TBL_U_MEDIDA." u
      ON ins.idunidad_medida = u.idunidad_medida
      LEFT JOIN "._TBL_FRECUENCIA." f
      ON ins.idfrecuencia = f.idfrecuencia
      LEFT JOIN "._TBL_INDCOMP." ic ON ins.idindicador = ic.idindicador
      WHERE idind_secretaria = ".$id."
  ";
  //echo "consul".$query_ind_gral;
  $BD->setQuery($query_ind_gral);  
  $ind_gral = $BD->loadObjectList();
  //print_r($ind_gral);

?>
<div id="dialog-table" title="Tabla Resultados de contenido en el Subtema">
</div>

<form id="formcaptura" name = "formcaptura" class = "formcaptura">
<!--form id="formcaptura" class = "formcaptura" enctype="application/x-www-form-urlencoded"-->	

  	   
    <div id='DatosInd'>
        <div id="contenedor_tabla">
            <div id="contenidos">
                <div id="columna1">Secretaria:</div>
                <div id="columna2"><?php echo $ind_gral[0]->secretaria ?></div>
            </div>
            <div id="contenidos">
                <div id="columna1">Tema Elemental:</div>
                <div id="columna2"><?php echo $ind_gral[0]->tema_elemental ?></div>
            </div>
            <div id="contenidos">
                <div id="columna1">Unidad de Medida:</div>
                <div id="columna2"><?php echo $ind_gral[0]->unidad_medida ?></div>
            </div>
            <div id="contenidos">
                <div id="columna1">Descripción:</div>
                <div id="descripcion" name="descripcion"><?php echo $ind_gral[0]->descripcion ?></div>
            </div>  
            <div id="contenidos">
                <div id="columna1"></div> 
                <div id="columna2"> <img src="../images/captura/mas.png" alt="ver mas" height="25" width="25"id="myLink">&nbsp;&nbsp;Ver más...</div>
            </div>
            <div id="contenidos">
                <div id="columna1"></div> 
                <div id="columna2" ><img src="../images/editar.png" title="Editar Indicador" id="editar">&nbsp;&nbsp;&nbsp;<img src="../images/meta.png" height="20" width="24" title="Meta" id="meta"></div>
            </div>
        </div>
    </div>

    <!--div id='DescInd'>Próxima Actualización:  Enero 2015</div-->
  	<div id='form_captura' name='form_captura'>
    <?php
              //OBTENER  FRECUENCIA Y PERIODO 

              $frecuencia = $ind_gral[0]->frecuencia;
              //echo "fre".$frecuencia;

              switch ($frecuencia) {
                case "Semanal":
                    //echo "Semanal";
                
                echo '
                      <table width = "100%" >
                          <tr><td>
                              '.crea_calendario($ind_gral[0]->frecuencia,$BD,$ind_gral[0]->idfrecuencia).'
                          </td></tr>
                      </table>
                    ' ;
                
                    break;
                case "Mensual":
                case "Bimestral":
                case "Trimestral":
                case "Cuatrimestral":    
                case "Semestral":        
                    //echo "de Meses";

                 
                echo '
                      <table width = "100%">
                          <tr>
                              '.crea_listaPeriodo($ind_gral[0]->idind_secretaria,$ind_gral[0]->frecuencia,$BD,$ind_gral[0]->idfrecuencia).'
                          </tr>
                      </table>
                    ' ;
                


                    break;
                case "Anual":
                case "Bienal":
                case "Trianual":    
                    //echo "anual";
                
                echo '
                      <table width = "100%" border = 0>
                          <tr>'.creaListaAnual($ind_gral[0]->idind_secretaria,$ind_gral[0]->frecuencia,$BD,$ind_gral[0]->idfrecuencia,'').'                         
                              '.crea_camposValor($ind_gral[0]->idindicador, $ind_gral[0]->idesindicador, $BD).'
                          </tr>
                      </table>
                    ' ;
                

                    break;
                default:
                    echo "No tiene frecuencia";
            }

    ?>  

  	</div>
    <div id ='guardar'><input id="btn_guardar" type="button" value="Guardar"></div>
    <div id='InformacionH'><?php
        mostrar_historico($ind_gral[0]->idind_secretaria, $BD);
     
    ?>
    </div>    

    <div id='divresultado' class='divresultado'>resultado</div>

</form>



  <script type="text/javascript">

   $(".campofecha").calendarioDW();


   $('#myLink').click(function(){ 
      verDetalles();
      return false;
    });
    $('#editar').click(function(){ 
      verEditar();
      return false;
    });
    $('#meta').click(function(){ 
      verMeta();
      return false;
    });


       //al enviar el formulario en el click de "guardar"


   $('#guardar').click(function(){ 
    
                      
                      $idindS = $('input:radio[name=rad_ind_secretaria]:checked').val(); //radio status información                      

                      guardavalores($(".campofecha").val(),$("#valorIndicador").val(),$idindS,$(".frecuencia").val());


    });   

 

 </script>


  

