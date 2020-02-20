<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_LiquidacionFinalModel extends Db{ 
  


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

  public function getDetallesLiquidaciondeven($liquidacion_definitiva_id, $Conex)
    {
		
        if ($liquidacion_definitiva_id > 0) {

            $select = "SELECT l.*,
			IF(l.fecha_inicio IS NOT NULL, CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ),'') AS periodo,
			(SELECT SUM(valor) FROM liq_def_devengado WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
			FROM 	liq_def_devengado l
			WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";
			
			$result = $this->DbFetchAll($select, $Conex, true);
			
            if (!count($result) > 0) {
                $result = array();
            }

        } else {
            $result = array();
        }
        return $result;
    }

  public function getLiquidacion2($liquidacion_definitiva_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_definitiva_id)){

  	     $select = "SELECT ln.*,
				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 
				
				(SELECT ca.nombre	FROM tipo_contrato ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.tipo_contrato_id=ca.tipo_contrato_id) AS tipo_contrato, 
				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base,
				(SELECT c.subsidio_transporte	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS subsidio_transporte,
				(SELECT (c.sueldo_base+c.subsidio_transporte)	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS salario_base,
				(SELECT c.nombre	FROM  motivo_terminacion c  WHERE c.motivo_terminacion_id=ln.motivo_terminacion_id ) AS motivo_terminacion

				FROM liquidacion_definitiva ln
				WHERE ln.liquidacion_definitiva_id=$liquidacion_definitiva_id  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getLiquidacion3($liquidacion_definitiva_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_definitiva_id)){

  	     $select = "SELECT ln.*		FROM liquidacion_definitiva ln
				WHERE ln.liquidacion_definitiva_id=$liquidacion_definitiva_id AND ln.estado!='A' ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


   
}


?>