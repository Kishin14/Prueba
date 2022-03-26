<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleProvisionesModel extends Db{

  private $Permisos;
    

  public function Update($Campos,$Conex){
    
    $detalle_liquidacion_provision_id = $this -> requestDataForQuery('detalle_liquidacion_provision_id','integer'); 
    $observacion             = $this -> requestDataForQuery('observacion','text'); 

    $update = "UPDATE detalle_liquidacion_provision SET observacion=$observacion  WHERE detalle_liquidacion_provision_id=$detalle_liquidacion_provision_id";
    $this -> query($update,$Conex,true);

  }

  public function getDetallesRegistrar($Conex){
  
	$liquidacion_provision_id = $this -> requestDataForQuery('liquidacion_provision_id','integer');
	
	if(is_numeric($liquidacion_provision_id)){
	
		$select  = "SELECT d.*,
		(SELECT estado FROM liquidacion_provision WHERE liquidacion_provision_id= $liquidacion_provision_id) AS estado,
		(SELECT codigo_puc FROM puc WHERE puc_id=d.puc_id) AS puc
		FROM detalle_liquidacion_provision d WHERE d.liquidacion_provision_id = $liquidacion_provision_id ORDER BY detalle_liquidacion_provision_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


   
}

?>