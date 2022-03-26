<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetLiqFinPreModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){

	$origen_id                  = $this -> requestDataForQuery('origen_id','integer'); 
	$unidad_peso_id             = $this -> requestDataForQuery('unidad_peso_id','integer'); 
	$unidad_volumen_id          = $this -> requestDataForQuery('unidad_volumen_id','integer'); 
	$solicitud_id               = $this -> requestDataForQuery('solicitud_id','integer'); 
	$destino_id                 = $this -> requestDataForQuery('destino_id','integer'); 
	$shipment                   = $this -> requestDataForQuery('shipment','text'); 	
	$orden_despacho             = $this -> requestDataForQuery('orden_despacho','text'); 
	$remitente                  = $this -> requestDataForQuery('remitente','text'); 
    $remitente_id               = $this -> requestDataForQuery('remitente_id','integer'); 	
    $tipo_identificacion_remitente_id = $this -> requestDataForQuery('tipo_identificacion_remitente_id','integer'); 			
	$doc_remitente              = $this -> requestDataForQuery('doc_remitente','text'); 
	$direccion_remitente        = $this -> requestDataForQuery('direccion_remitente','text'); 
	$telefono_remitente         = $this -> requestDataForQuery('telefono_remitente','text'); 
	$destinatario               = $this -> requestDataForQuery('destinatario','text'); 
	$destinatario_id            = $this -> requestDataForQuery('destinatario_id','integer'); 
    $tipo_identificacion_destinatario_id = $this -> requestDataForQuery('tipo_identificacion_destinatario_id','integer'); 				
	$doc_destinatario           = $this -> requestDataForQuery('doc_destinatario','text'); 
	$direccion_destinatario     = $this -> requestDataForQuery('direccion_destinatario','text'); 
	$telefono_destinatario      = $this -> requestDataForQuery('telefono_destinatario','text'); 
	$referencia_producto        = $this -> requestDataForQuery('referencia_producto','text'); 
	$descripcion_producto       = $this -> requestDataForQuery('descripcion_producto','text'); 
	$cantidad                   = $this -> requestDataForQuery('cantidad','numeric'); 
	$peso                       = $this -> requestDataForQuery('peso','numeric'); 
	$peso_volumen               = $this -> requestDataForQuery('peso_volumen','numeric'); 
	$valor_unidad               = $this -> requestDataForQuery('valor_unidad','numeric');                     
   
	$detalle_ss_id = $this -> DbgetMaxConsecutive("detalle_solicitud_servicio","detalle_ss_id",$Conex,true,true);	

     $insert = "INSERT INTO detalle_solicitud_servicio 				(detalle_ss_id,origen_id,unidad_peso_id,unidad_volumen_id,solicitud_id,destino_id,orden_despacho,shipment,remitente,remitente_id,tipo_identificacion_remitente_id,doc_remitente,direccion_remitente,telefono_remitente,destinatario,destinatario_id,tipo_identificacion_destinatario_id,doc_destinatario,direccion_destinatario,telefono_destinatario,referencia_producto,descripcion_producto,cantidad,peso,peso_volumen,valor_unidad)

        VALUES 

        ($detalle_ss_id,$origen_id,$unidad_peso_id,$unidad_volumen_id,$solicitud_id,$destino_id,$orden_despacho,$shipment,$remitente,$remitente_id,$tipo_identificacion_remitente_id,$doc_remitente,$direccion_remitente,$telefono_remitente,$destinatario,$destinatario_id,$tipo_identificacion_destinatario_id,$doc_destinatario,$direccion_destinatario,$telefono_destinatario,$referencia_producto,$descripcion_producto,$cantidad,$peso,$peso_volumen,$valor_unidad)";
	
        $this -> query($insert,$Conex);

	return $detalle_ss_id;

  }

  public function Update($Campos,$Conex){
    
    $detalle_ss_id              = $this -> requestDataForQuery('detalle_ss_id','integer'); 
    $origen_id                  = $this -> requestDataForQuery('origen_id','integer'); 
    $unidad_peso_id             = $this -> requestDataForQuery('unidad_peso_id','integer'); 
    $unidad_volumen_id          = $this -> requestDataForQuery('unidad_volumen_id','integer'); 
    $solicitud_id               = $this -> requestDataForQuery('solicitud_id','integer'); 
    $destino_id                 = $this -> requestDataForQuery('destino_id','integer'); 
    $orden_despacho             = $this -> requestDataForQuery('orden_despacho','text'); 
	$shipment                   = $this -> requestDataForQuery('shipment','text'); 
    $remitente                  = $this -> requestDataForQuery('remitente','text'); 
    $remitente_id               = $this -> requestDataForQuery('remitente_id','integer'); 	
    $tipo_identificacion_remitente_id = $this -> requestDataForQuery('tipo_identificacion_remitente_id','integer'); 		
    $doc_remitente              = $this -> requestDataForQuery('doc_remitente','text'); 
    $direccion_remitente        = $this -> requestDataForQuery('direccion_remitente','text'); 
    $telefono_remitente         = $this -> requestDataForQuery('telefono_remitente','text'); 
    $destinatario               = $this -> requestDataForQuery('destinatario','text'); 
	$destinatario_id            = $this -> requestDataForQuery('destinatario_id','integer'); 
    $tipo_identificacion_destinatario_id = $this -> requestDataForQuery('tipo_identificacion_destinatario_id','integer'); 			
    $doc_destinatario           = $this -> requestDataForQuery('doc_destinatario','text'); 
    $direccion_destinatario     = $this -> requestDataForQuery('direccion_destinatario','text'); 
    $telefono_destinatario      = $this -> requestDataForQuery('telefono_destinatario','text'); 
    $referencia_producto        = $this -> requestDataForQuery('referencia_producto','text'); 
    $descripcion_producto       = $this -> requestDataForQuery('descripcion_producto','text'); 
    $cantidad                   = $this -> requestDataForQuery('cantidad','numeric'); 
    $peso                       = $this -> requestDataForQuery('peso','numeric'); 
    $peso_volumen               = $this -> requestDataForQuery('peso_volumen','numeric'); 
    $valor_unidad               = $this -> requestDataForQuery('valor_unidad','numeric'); 

    $update = "UPDATE detalle_solicitud_servicio SET origen_id=$origen_id,unidad_peso_id=$unidad_peso_id,unidad_volumen_id=$unidad_volumen_id,destino_id=$destino_id,orden_despacho=$orden_despacho,shipment=$shipment,remitente=$remitente,remitente_id=$remitente_id,tipo_identificacion_remitente_id=$tipo_identificacion_remitente_id,doc_remitente=$doc_remitente,direccion_remitente=$direccion_remitente,telefono_remitente=$telefono_remitente,destinatario=$destinatario,destinatario_id=$destinatario_id,tipo_identificacion_destinatario_id=$tipo_identificacion_destinatario_id,doc_destinatario=$doc_destinatario,direccion_destinatario=$direccion_destinatario,telefono_destinatario=$telefono_destinatario,referencia_producto=$referencia_producto,descripcion_producto=$descripcion_producto,cantidad=$cantidad,peso=$peso,peso_volumen=$peso_volumen,valor_unidad=$valor_unidad  WHERE detalle_ss_id=$detalle_ss_id";
	
    $this -> query($update,$Conex);

  }

  public function Delete($Campos,$Conex){
	 $detalle_ss_id              = $this -> requestDataForQuery('detalle_ss_id','integer'); 
    $select = "SELECT detalle_ss_id FROM detalle_remesa WHERE detalle_ss_id = $detalle_ss_id ";
    $result = $this -> DbFetchAll($select,$Conex);
	if($result[0]['detalle_ss_id']>0){
		$update = "UPDATE detalle_solicitud_servicio SET estado='A'  WHERE detalle_ss_id=$detalle_ss_id AND estado='D'";
		$this -> query($update,$Conex,true);
		
	}else{

	  	$this -> DbDeleteTable("detalle_solicitud_servicio",$Campos,$Conex,true,false);
	}
  
  }
  
  public function getUnidades($Conex){

    $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE ministerio = 1 ORDER BY medida ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }
  
  public function getTipoIdentificacion($Conex){
  
    $select = "SELECT tipo_identificacion_id AS value,descripcion AS text FROM tipo_identificacion WHERE ministerio = 1";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;	
  
  }

  public function getUnidadesVolumen($Conex){

    $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE tipo_unidad_medida_id = 11 ORDER BY medida ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }
  
  public function getDetallesSolicitudServicios($Conex){
  
	$solicitud_id = $this -> requestDataForQuery('solicitud_id','integer');
	
	if(is_numeric($solicitud_id)){
	
		$select  = "SELECT d.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.destino_id) AS destino FROM detalle_solicitud_servicio d WHERE solicitud_id = $solicitud_id ORDER BY detalle_ss_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  public function selectDataRemitenteDestinatario($remitente_destinatario_id,$Conex){
  
    $select = "SELECT r.*,nombre AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS ubicacion 
	FROM remitente_destinatario r WHERE remitente_destinatario_id 	= $remitente_destinatario_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }
 

   
}



?>