<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleRegistrarModel extends Db{

  private $Permisos;
    

  public function Update($Campos,$Conex){
    
    $detalle_liquidacion_novedad_id = $this -> requestDataForQuery('detalle_liquidacion_novedad_id','integer'); 
    $observacion             = $this -> requestDataForQuery('observacion','text'); 

    $update = "UPDATE detalle_liquidacion_novedad SET observacion=$observacion  WHERE detalle_liquidacion_novedad_id=$detalle_liquidacion_novedad_id";
    $this -> query($update,$Conex,true);

  }

  public function getDetallesRegistrar($Conex){
  
	$liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){
	
		$select  = "SELECT d.*,
		(SELECT codigo_puc FROM puc WHERE puc_id=d.puc_id) AS puc
		FROM detalle_liquidacion_novedad d WHERE d.liquidacion_novedad_id = $liquidacion_novedad_id ORDER BY detalle_liquidacion_novedad_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

 public function getDetallesRegistrar1($Conex){
  
	$fecha_inicial = $this -> requestDataForQuery('fecha_inicial','text');
	$fecha_final = $this -> requestDataForQuery('fecha_final','text');
	
	if($fecha_inicial!='' && $fecha_final!=''){
	
		$select  = "SELECT d.*,
		(SELECT codigo_puc FROM puc WHERE puc_id=d.puc_id) AS puc,
		
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
			FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado 
		
		FROM detalle_liquidacion_novedad d, liquidacion_novedad l 
		WHERE d.liquidacion_novedad_id=l.liquidacion_novedad_id AND  l.fecha_inicial=$fecha_inicial AND l.fecha_final=$fecha_final AND l.estado!='A'   
		ORDER BY detalle_liquidacion_novedad_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
   
}

?>