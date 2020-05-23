<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallePrimasModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($consecutivo,$liquidacion_prima_id,$rango,$empresa_id,$oficina_id,$Conex){
	   
	if(is_numeric($liquidacion_prima_id) || is_numeric($consecutivo)){
		
		if($rango=='T'){
			
			$select  = "SELECT i.*,
			           (SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,
					   (SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS puc,
					   (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,
					   (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,
					   (SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,
					   (SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo
					   
					   FROM detalle_prima_puc i WHERE liquidacion_prima_id IN(SELECT liquidacion_prima_id FROM liquidacion_prima WHERE consecutivo = $consecutivo)";
	 			
		}
		else{
			$select  = "SELECT i.*,(SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,(SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo FROM detalle_prima_puc i WHERE liquidacion_prima_id = $liquidacion_prima_id";
		}

	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else if($liquidacion_prima_id != ''){
       if($rango=='T'){
			
			$select  = "SELECT i.*,
			                  (SELECT concat(codigo_puc) FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,
							  (SELECT codigo_puc FROM puc WHERE puc_id = i.puc_id) AS puc,
							  (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,
							  (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,
							  (SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,
							  (SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo 

					   FROM detalle_prima_puc i WHERE liquidacion_prima_id IN(SELECT liquidacion_prima_id FROM liquidacion_prima WHERE consecutivo IN (SELECT consecutivo FROM liquidacion_prima WHERE liquidacion_prima_id IN($liquidacion_prima_id)))";	
		}else{
			$select  = "SELECT i.*,(SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,(SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo FROM detalle_prima_puc i WHERE liquidacion_prima_id = $liquidacion_prima_id";
		}

		$result = $this -> DbFetchAll($select,$Conex);
		
	}else{
   	    $result = array();
	 }


	
	return $result;
  
  }
  
   
}



?>