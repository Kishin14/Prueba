<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleCesantiasModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($liquidacion_cesantias_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($liquidacion_cesantias_id)){

	 $select  = "SELECT i.*,(SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,(SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo FROM detalle_cesantias_puc i WHERE liquidacion_cesantias_id = $liquidacion_cesantias_id";


	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
   
}



?>