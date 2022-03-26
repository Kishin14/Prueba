<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PrestacionFinalModel extends Db{

  private $Permisos;
    

  public function Update($Campos,$Conex){
    
    $detalle_liquidacion_novedad_id = $this -> requestDataForQuery('detalle_liquidacion_novedad_id','integer'); 
    $observacion             = $this -> requestDataForQuery('observacion','text'); 

    $update = "UPDATE detalle_liquidacion_novedad SET observacion=$observacion  WHERE detalle_liquidacion_novedad_id=$detalle_liquidacion_novedad_id";
    $this -> query($update,$Conex,true);

  }
  public function getDias($fecha_inicio,$fecha_final,$Conex){
		$select  = "SELECT (DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),'$fecha_inicio')+1) AS dias";
	  	$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result[0]['dias'];
  }
  
  public function getDetallesLiquidacion($liquidacion_definitiva_id,$Conex){
  
	if(is_numeric($liquidacion_definitiva_id)){
	
		$select  = "SELECT d.*,
		(SELECT codigo_puc FROM puc WHERE puc_id=d.puc_id) AS puc
		FROM detalle_liquidacion_novedad d WHERE d.liquidacion_novedad_id = $liquidacion_novedad_id ORDER BY detalle_liquidacion_novedad_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

 public function getDetallesContrato($contrato_id,$dias,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT c.*,
		(((sueldo_base+subsidio_transporte)*$dias)/360) AS cesantias,
		((((sueldo_base+subsidio_transporte)*0.12)*$dias)/360) AS int_cesantias,
		(((sueldo_base+subsidio_transporte)*$dias)/360) AS prima_servicios,
		(((sueldo_base+subsidio_transporte)*$dias)/720) AS prima_vacaciones
		
		FROM contrato c
		WHERE c.contrato_id = $contrato_id";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	return $result;
  }

   public function getDetallesCesantias($contrato_id,$fecha_final,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),l.fecha_ultimo_corte) AS dias_dif, l.fecha_ultimo_corte
		FROM liquidacion_cesantias l
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' ORDER BY l.fecha_ultimo_corte DESC LIMIT 1";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);

	}else{
   	    $result = array();
	}
	return $result;
  }

   public function getDetallesIntCesantias($contrato_id,$fecha_final,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),l.fecha_ultimo_corte) AS dias_dif, l.fecha_ultimo_corte
		FROM liquidacion_int_cesantias l
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' ORDER BY l.fecha_ultimo_corte DESC LIMIT 1";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);

	}else{
   	    $result = array();
	}
	return $result;
  }

   public function getDetallesVacaciones($contrato_id,$fecha_final,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT SUM(dl.dias_disfrutados) AS dias_va, 
		(SELECT dlv.periodo_fin FROM liquidacion_vacaciones lv, detalle_liquidacion_vacaciones dlv 
		 WHERE lv.contrato_id = $contrato_id AND lv.estado!='I' AND dlv.liquidacion_vacaciones_id=lv.liquidacion_vacaciones_id ORDER BY dlv.periodo_fin DESC LIMIT 1 ) AS fecha_ultima
		FROM liquidacion_vacaciones l, detalle_liquidacion_vacaciones dl
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' AND dl.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id ";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);

	}else{
   	    $result = array();
	}
	return $result;
  }

   public function getDetallesPrima($contrato_id,$fecha_final,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT l.fecha_liquidacion, l.periodo
		FROM liquidacion_prima l
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' ORDER BY l.fecha_liquidacion, l.periodo DESC LIMIT 1";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);

	}else{
   	    $result = array();
	}
	return $result;
  }


  public function getDetallesDeducciones($contrato_id,$dias,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT c.*
		FROM novedad_fija c
		WHERE c.contrato_id = $contrato_id AND c.estado='A' AND tipo_novedad='D'";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	return $result;
  }

  public function getDetallesDeduccionesDetalle($contrato_id,$concepto_area_id,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT SUM(dl.credito) AS valor
		FROM liquidacion_novedad l, detalle_liquidacion_novedad dl
		WHERE l.contrato_id = $contrato_id AND l.estado!='A' AND dl.liquidacion_novedad_id=l.liquidacion_novedad_id 
		AND dl.concepto_area_id=$concepto_area_id";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	return $result;
  }



 public function getDetallesSalario($contrato_id,$fecha_final,$Conex){
  
	
	if($contrato_id>0){
	
		$select  = "SELECT DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),l.fecha_final) AS dias_dif, l.fecha_final 
		FROM liquidacion_novedad l
		WHERE l.contrato_id = $contrato_id AND l.estado!='A' ORDER BY l.fecha_final DESC LIMIT 1";
	  	$result = $this -> DbFetchAll($select,$Conex,true);

		if(!count($result)>0){
			$result = array();	
		}

	}else{
   	    $result = array();
	}
	return $result;
  }

  public function getDetallesLiquidacionPres($liquidacion_definitiva_id,$Conex){
  
	
	if($liquidacion_definitiva_id>0){
	
		$select  = "SELECT l.*,
		CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ) AS periodo,
		(SELECT SUM(valor) FROM liq_def_prestacion WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
		FROM 	liq_def_prestacion l
		WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";

	  	$result = $this -> DbFetchAll($select,$Conex,true);

		if(!count($result)>0){
			$result = array();	
		}

	}else{
   	    $result = array();
	}
	return $result;
  }

  public function getDetallesLiquidacionIndem($liquidacion_definitiva_id,$Conex){
  
	
	if($liquidacion_definitiva_id>0){
	
		$select  = "SELECT l.*,
		CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ) AS periodo,
		(SELECT SUM(valor) FROM liq_def_indemnizacion WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total		
		FROM 	liq_def_indemnizacion l
		WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
		
		if(!count($result)>0){
			$result = array();	
		}
	  
	}else{
   	    $result = array();
	}
	return $result;
  }

  public function getDetallesLiquidacionSala($liquidacion_definitiva_id,$Conex){
  
	
	if($liquidacion_definitiva_id>0){
	
		$select  = "SELECT l.*,
		CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ) AS periodo,
		(SELECT SUM(valor) FROM liq_def_salario WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total		
		FROM 	liq_def_salario l
		WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
		if(!count($result)>0){
			$result = array();	
		}
	  
	}else{
   	    $result = array();
	}
	return $result;
  }

  public function getDetallesLiquidaciondeduc($liquidacion_definitiva_id,$Conex){
  
	
	if($liquidacion_definitiva_id>0){
	
		$select  = "SELECT l.*,
		IF(l.fecha_inicio IS NOT NULL, CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ),'') AS periodo,
		(SELECT SUM(valor) FROM liq_def_deduccion WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total		
		FROM 	liq_def_deduccion l
		WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
		if(!count($result)>0){
			$result = array();	
		}
	  
	}else{
   	    $result = array();
	}
	return $result;
  }


 public function getDatosperiodo($periodo,$Conex){
  
	
	if($periodo>0){
	
		$select  = "SELECT *
		FROM datos_periodo
		WHERE 	periodo_contable_id = (SELECT 	periodo_contable_id FROM periodo_contable WHERE anio=$periodo)";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	return $result;
  }


}

?>