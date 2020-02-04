<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleVacacionesModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($liquidacion_vacaciones_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($liquidacion_vacaciones_id)){

	 $select  = "SELECT i.*,(SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,(SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo FROM detalle_vacaciones_puc i WHERE liquidacion_vacaciones_id = $liquidacion_vacaciones_id";


	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
   
}



?>