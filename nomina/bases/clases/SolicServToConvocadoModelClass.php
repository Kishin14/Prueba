<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicServToConvocadoModel extends Db{

  private $Permisos;
  private $convocado_id;
  private $datalle_remesa_id;
  
  
  public function SelectConvocado($detalles_ss_id,$convocado_id,$Conex){

    $arraySolicitud = array();
    $detalle_ss_id  = explode(",",$detalles_ss_id); 
    $detalle_ss_id  = $detalle_ss_id[0];
       
    $select = "SELECT s.solicitud_id,d.orden_despacho,s.cliente_id,s.contacto_id,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  propietario_mercancia,	
	(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id =  (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id))) AS  tipo_identificacion_propietario_mercancia,	
	(SELECT numero_identificacion FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  numero_identificacion_propietario_mercancia,		
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  propietario_mercancia_txt,
	( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id) AS  propietario_mercancia_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.origen_id) AS origen,d.origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.destino_id) AS destino,
	d.destino_id,d.remitente_id,d.remitente,d.doc_remitente,d.tipo_identificacion_remitente_id,d.direccion_remitente,d.telefono_remitente,d.destinatario_id,d.destinatario,
	IF(d.doc_destinatario IS NULL,(SELECT numero_identificacion FROM remitente_destinatario WHERE cliente_id = s.cliente_id AND TRIM(nombre) LIKE TRIM(d.destinatario) LIMIT 1), d.doc_destinatario) AS doc_destinatario,
	IF(d.tipo_identificacion_destinatario_id IS NULL, (SELECT tipo_identificacion_id FROM remitente_destinatario WHERE cliente_id = s.cliente_id AND TRIM(nombre) LIKE TRIM(d.destinatario) LIMIT 1),d.tipo_identificacion_destinatario_id) AS tipo_identificacion_destinatario_id,
	d.direccion_destinatario,
	d.telefono_destinatario,s.fecha_recogida_ss,s.hora_recogida_ss, d.fecha_entrega, d.hora_entrega
	FROM solicitud_servicio s,detalle_solicitud_servicio d 
	WHERE s.solicitud_id = $solicitud_id AND s.solicitud_id = d.solicitud_id AND detalle_ss_id = $detalle_ss_id";

    $result = $this -> DbFetchAll($select,$Conex,false);

    $arraySolicitud[0]['solicitud'] = $result;

    $select = "SELECT detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto_detalle,cantidad AS cantidad_detalle,peso AS peso_detalle,valor_unidad AS valor_detalle,peso_volumen AS peso_volumen_detalle,orden_despacho AS guia_cliente FROM detalle_solicitud_servicio WHERE solicitud_id = $solicitud_id AND detalle_ss_id IN ($detalles_ss_id) ORDER BY detalle_ss_id ASC";

    $result = $this -> DbFetchAll($select,$Conex,false);

    $arraySolicitud[0]['detalle_solicitud'] = $result;

    return $arraySolicitud;  
  
  }

//// GRID ////
		public function GetQuerySolicServToConvocadosGrid(){

			$Query = "SELECT
			    CONCAT('<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',cv.convocado_id,'\" />') 
				AS link,
				convocado_id,
				(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id=cv.tipo_identificacion_id) AS tipo_identificacion_id,
				numero_identificacion,
				primer_nombre,
				segundo_nombre,
				primer_apellido,
				segundo_apellido,
				direccion,
				telefono,
				movil,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=cv.ubicacion_id) AS ubicacion_id,
				IF(estado='A','ACTIVO','INACTIVO') AS estado 

			FROM
				convocado cv
			";
			return $Query;
		}
   
}



?>