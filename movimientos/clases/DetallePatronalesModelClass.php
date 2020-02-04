<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallePatronalesModel extends Db{

  private $Permisos;
    

  public function Update($Campos,$Conex){
    
    $detalle_liquidacion_patronal_id = $this -> requestDataForQuery('detalle_liquidacion_patronal_id','integer'); 
    $observacion             = $this -> requestDataForQuery('observacion','text'); 

    $update = "UPDATE detalle_liquidacion_patronal SET observacion=$observacion  WHERE detalle_liquidacion_patronal_id=$detalle_liquidacion_patronal_id";
    $this -> query($update,$Conex,true);

  }

  public function getDetallesRegistrar($Conex){
  
	$liquidacion_patronal_id = $this -> requestDataForQuery('liquidacion_patronal_id','integer');
	
	if(is_numeric($liquidacion_patronal_id)){
	
		$select  = "SELECT d.*,
		(SELECT estado FROM liquidacion_patronal WHERE liquidacion_patronal_id= $liquidacion_patronal_id) AS estado,
		(SELECT codigo_puc FROM puc WHERE puc_id=d.puc_id) AS puc
		FROM detalle_liquidacion_patronal d WHERE d.liquidacion_patronal_id = $liquidacion_patronal_id ORDER BY detalle_liquidacion_patronal_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


   
}

?>