<?php

require_once "../../../framework/clases/ControlerClass.php";

final class Imp_Liquidacion extends Controler{

  private $Conex;
  private $empresa_id;

  public function __construct($empresa_id,$Conex){
    $this -> Conex = $Conex; 
	$this -> getEmpresaId = $empresa_id; 
  }

     public function printOut($oficina_id){
  	
      require_once("Imp_LiquidacionLayoutClass.php");
      require_once("Imp_LiquidacionModelClass.php");
		
      $Layout = new Imp_LiquidacionLayout();
      $Model  = new Imp_LiquidacionModel();		
	
      $Layout -> setIncludes();
	   $liquidacion_novedad_id = $_REQUEST['liquidacion_novedad_id'];
	   $fecha_inicial = $_REQUEST['fecha_inicial'];
	   $fecha_final = $_REQUEST['fecha_final'];
	  if($_REQUEST['tipo_impresion']=='C' || $_REQUEST['tipo_impresion']=='PE'){
		  
		  $download = $_REQUEST['download'];
		  $Layout -> setConceptoDebito    ($Model -> getConceptoDebito    ($this -> Conex));
		  $Layout -> setConceptoCredito   ($Model -> getConceptoCredito   ($this -> Conex));	

		  $Layout -> setConceptoDebitoExt ($Model -> getConceptoDebitoExt ($this -> Conex));
		  $Layout -> setConceptoCreditoExt($Model -> getConceptoCreditoExt($this -> Conex));	

		  $Layout -> setConceptoSaldo($Model -> getConceptoSaldo($this -> Conex));	

		  $con_deb = $Model -> getConceptoDebito($this -> Conex);
		  $con_cre = $Model -> getConceptoCredito($this -> Conex);

		  $con_debExt = $Model -> getConceptoDebitoExt($this -> Conex);
		  $con_creExt = $Model -> getConceptoCreditoExt($this -> Conex);

		  $con_sal = $Model -> getConceptoSaldo($this -> Conex);
		  $select_deb="";
		  $select_cre="";
		  $select_sal="";

		  $select_deb_total="";
		  $select_cre_total="";

		  $con_deb1 = array();
		  $con_cre1 = array();

		  $con_debExt1 = array();
		  $con_creExt1 = array();

	   	  $con_sal1 = array();
		  
		  

		  $select_deb_total=" (SELECT SUM(d.debito)
				FROM liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.contrato_id =ln.contrato_id AND l.liquidacion_novedad_id=ln.liquidacion_novedad_id
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.debito>0 AND d.sueldo_pagar=0 AND l.estado!='A' ) AS total_debito,";

		  $select_cre_total=" (SELECT SUM(d.credito)
				FROM liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.contrato_id =ln.contrato_id AND l.liquidacion_novedad_id=ln.liquidacion_novedad_id
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.credito>0 AND d.sueldo_pagar=0 AND l.estado!='A') AS total_credito,";

		  for($i=0;$i<count($con_deb);$i++){
			  $select_deb.=" (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('".$con_deb[$i]['concepto']."') ) AS ".str_replace(" ","_",$con_deb[$i]['concepto']).", ";


				  $con_deb1[$i]['concepto']=str_replace(" ","_",$con_deb[$i]['concepto']);

		  }
		  
		   for($i=0;$i<count($con_deb);$i++){
			  $select_tot_deb.=" (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.concepto LIKE ('".$con_deb[$i]['concepto']."') ) AS ".str_replace(" ","_",$con_deb[$i]['concepto']).", ";
			  	
		  }


		  for($i=0;$i<count($con_debExt);$i++){
			  $select_debExt.=" (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto_area_id =".$con_debExt[$i]['concepto_area_id']." ) AS ".str_replace(" ","_",$con_debExt[$i]['concepto']).", ";
			  	$con_debExt1[$i]['concepto']=str_replace(" ","_",$con_debExt[$i]['concepto']);
		  }
		  
		   for($i=0;$i<count($con_debExt);$i++){
			  $select_tot_debExt.=" (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto_area_id =".$con_debExt[$i]['concepto_area_id']." ) AS ".str_replace(" ","_",$con_debExt[$i]['concepto']).", ";
			  	
		  }

		  for($i=0;$i<count($con_cre);$i++){
			  $select_cre.=" (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('".$con_cre[$i]['concepto']."') ) AS ".str_replace(" ","_",$con_cre[$i]['concepto']).", ";
			  	$con_cre1[$i]['concepto']=str_replace(" ","_",$con_cre[$i]['concepto']);			  
		  }
		  
		  for($i=0;$i<count($con_cre);$i++){
			  $select_tot_cre.=" (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto LIKE ('".$con_cre[$i]['concepto']."') ) AS ".str_replace(" ","_",$con_cre[$i]['concepto']).", ";
			  		  
		  }

		  for($i=0;$i<count($con_creExt);$i++){
			  $select_creExt.=" (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto_area_id = ".$con_creExt[$i]['concepto_area_id']." ) AS ".str_replace(" ","_",$con_creExt[$i]['concepto']).", ";
			  	$con_creExt1[$i]['concepto']=str_replace(" ","_",$con_creExt[$i]['concepto']);			  
		  }
		  
		  for($i=0;$i<count($con_creExt);$i++){
			  $select_tot_creExt.=" (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto_area_id = ".$con_creExt[$i]['concepto_area_id']." ) AS ".str_replace(" ","_",$con_creExt[$i]['concepto']).", ";
			  	  
		  }


		  for($i=0;$i<count($con_sal);$i++){
			  $select_sal.=" (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('".$con_sal[$i]['concepto']."') ) AS ".str_replace(" ","_",$con_sal[$i]['concepto']).", ";
			  	$con_sal1[$i]['concepto']=str_replace(" ","_",$con_sal[$i]['concepto']);			  
		  }
		  
		   for($i=0;$i<count($con_sal);$i++){
			  $select_tot_sal.=" (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.concepto LIKE ('".$con_sal[$i]['concepto']."') ) AS ".str_replace(" ","_",$con_sal[$i]['concepto']).", ";
			   
		  }
		  
		  $diasIncapacidad = $Model -> getDiasIncapacidad($liquidacion_novedad_id,$fecha_inicial,$fecha_final,$this -> Conex);
		  $diasIncapacidad = $this->groupArrayDias($diasIncapacidad, 'contrato_id');

		  $diasLicencia = $Model -> getDiasLicencia($liquidacion_novedad_id,$fecha_inicial,$fecha_final,$this->Conex);
          $diasLicencia = $this->groupArrayDias($diasLicencia, 'contrato_id');

	      $Layout -> setLiquidacion($con_deb1,$con_cre1,$con_debExt1,$con_creExt1,$con_sal1,
									
									$Model -> getLiquidacion($select_deb_total,$select_cre_total,$select_deb,
									$select_cre,
									$select_debExt,$select_creExt,$select_sal,$diasIncapacidad,$diasLicencia,$oficina_id,$this -> getEmpresaId,$this -> Conex),$Model -> getTotales($select_tot_deb,$select_tot_cre,$select_tot_debExt,$select_tot_creExt,$select_tot_sal,$this -> getEmpresaId,$this -> Conex));

		  
	  }elseif($_REQUEST['tipo_impresion']=='DP'){
		  $desprendibles=$_REQUEST['desprendibles'];
		  $liquidacion = $Model -> getLiquidacion1($desprendibles,$this -> getEmpresaId,$this -> Conex);
		  
		  for($i=0;$i<count($liquidacion);$i++){
			  $liquidacion[$i]['detalles']= $Model -> getDetalles($liquidacion[$i]['liquidacion_novedad_id'],$this -> getEmpresaId,$this -> Conex);
		  }

		  $Layout -> setLiquidacion1($liquidacion);


	  }elseif($_REQUEST['tipo_impresion']=='CL'){
		  $desprendibles=$_REQUEST['desprendibles'];
		  $liquidacion = $Model -> getLiquidacion2($liquidacion_novedad_id,$this -> getEmpresaId,$this -> Conex);
		  
		  for($i=0;$i<count($liquidacion);$i++){
			  $liquidacion[$i]['detalles']= $Model -> getDetalles($liquidacion[$i]['liquidacion_novedad_id'],$this -> getEmpresaId,$this -> Conex);
		  }

		  $Layout -> setLiquidacion1($liquidacion);

	  }elseif($_REQUEST['tipo_impresion']=='DC'){
		  $desprendibles=$_REQUEST['desprendibles'];
		  $liquidacion = $Model -> getLiquidacion3($liquidacion_novedad_id,$this -> getEmpresaId,$this -> Conex);
		  $_REQUEST['encabezado_registro_id'] = $liquidacion[0]['encabezado_registro_id'];
		  if( $liquidacion[0]['encabezado_registro_id']>0){ 
			  require_once("Imp_Documento1Class.php"); 
			  $print = new Imp_Documento($this -> Conex); 
			  $print -> printOut();
		  }else{
				exit('Registro No Contabilizado');  
		  }

	  }
	  if($download=='true'){
      	$Layout -> exportToExcel('Imp_LiquidacionExcel.tpl'); 		
	  }else{
	  	$Layout -> RenderMain();	  
	  }
    
  }
	 
  public function groupArrayDias($array, $groupkey){
	   
	$contador = 0;//se inicializa un contador	
	if (count($array) > 0) {
		$keys = array_keys($array[0]);
		$removekey = array_search($groupkey, $keys);if ($removekey === false) {
			return array("Clave \"$groupkey\" no existe");
		} else {
			unset($keys[$removekey]);
		}

		$groupcriteria = array();
		$return = array();
		foreach ($array as $value) {
			$item = null;
			foreach ($keys as $key) {
				$item[$key] = $value[$key];
			}
			$busca = array_search($value[$groupkey], $groupcriteria);
			if ($busca === false) {
				$groupcriteria[] = $value[$groupkey];
				$return[] = array($groupkey => $value[$groupkey], 'groupeddata' => array());
				$busca = count($return) - 1;
			}
			$return[$busca]['groupeddata'][] = $item;
		}
		
		//LA VARIABLE RETURN NOS MUESTRA EL ARRAY AGRUPADO POR CONTRATO ID

		//NOTA: EL ARRAY DE FECHAS DEBE CONTENER 2 ITEMS LLAMADOS 'fecha_inicial' y 'fecha_final' OBLIGATORIAMENTE

		for ($i = 0; $i < count($return); $i++) {

			$countDias = 0;//se inicializa dias

			for ($j = 0; $j < count($return[$i]['groupeddata']); $j++) {
			
				$countDias += $this->restaFechasCont($return[$i]['groupeddata'][$j]['fecha_inicial'],$return[$i]['groupeddata'][$j]['fecha_final']);//Se acumulan la cantidad dias restados de los respectivas licencias por separado

				$contrato_id_array = $return[$i]['contrato_id'];//Se le agrega el contrato ID en el Array para diferenciar los dias
				
			}
			$arrayDias[$contador]['dias']       =$countDias;//Aqui se Alimentan los Dias
			$arrayDias[$contador]['contrato_id']=$contrato_id_array;//Aqui se Alimentan los Contratos
			$contador ++;
		}

		return $arrayDias;


	} else {
		return array();
	}

}   
  
	
}

new Imp_Liquidacion();

?>