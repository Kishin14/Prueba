<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ContratosModel extends Db{ 
  
  public function getcontrato($empresa_id,$Conex){
 
    $contrato_id = $this -> requestDataForQuery('contrato_id','integer');
	//	$documento_laboral_id = $this -> requestDataForQuery('documento_laboral_id','integer');
	
	if(is_numeric($contrato_id)){

  	    $select = "SELECT c.*,
		td.cuerpo_mensaje,
		(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id) AS cargo,
		(SELECT CONCAT_WS(' ',t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id ) AS eps,
		(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
		(SELECT CONCAT_WS(' ', t.numero_identificacion) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS identificacion,
		(SELECT e.logo FROM empresa e, centro_de_costo ce WHERE e.empresa_id=ce.empresa_id AND c.centro_de_costo_id=ce.centro_de_costo_id)AS logo,
		(SELECT CONCAT_WS (' ',t.primer_apellido, t.segundo_apellido,t.primer_nombre,t.segundo_nombre) FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS nombre_empleado,
		(SELECT t.numero_identificacion FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS numero_identificacion,
		(SELECT tp.nombre FROM tercero t, empleado e, contrato c, tipo_persona tp WHERE t.tipo_persona_id=tp.tipo_persona_id and t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id) as tipo_persona,
		(SELECT ti.nombre FROM tercero t, empleado e, contrato c, tipo_identificacion ti WHERE t.tipo_identificacion_id=ti.tipo_identificacion_id and t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id) as tipo_identificacion,
		(SELECT t.direccion FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS direccion,
		(SELECT t.email FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS email,
		(SELECT t.telefax FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS telefax,
		(SELECT t.telefono FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS telefono,
		(SELECT t.movil FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS movil,
		(SELECT t.retei_proveedor FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS retei_proveedor,
		(SELECT t.autoret_proveedor FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS autoret_proveedor,
		(SELECT t.renta_proveedor FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS renta_proveedor,
		(SELECT t.propietario_vehiculo FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS propietario_vehiculo,
		(SELECT e.sexo FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS sexo_empleado,
		(SELECT e.fecha_nacimiento FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS fecha_nacimiento_empleado,
		(SELECT ec.estado_civil FROM estado_civil ec, empleado e, contrato c WHERE ec.estado_civil_id=e.estado_civil_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS estado_civil_empleado,
		(SELECT e.tipo_vivienda FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS tipo_vivienda_empleado,
		(SELECT p.nombre_dane FROM profesion p, empleado e, contrato c WHERE p.profesion_id=e.profesion_id and e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS profesion_empleado,
		(SELECT e.num_hijos FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS numero_hijos_empleado,
		(SELECT e.estado FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS estado,
		(SELECT e.foto FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=$contrato_id)AS foto,
		(SELECT tc.nombre FROM tipo_contrato tc, contrato c WHERE tc.tipo_contrato_id=c.tipo_contrato_id and c.contrato_id=$contrato_id)AS tipo_contrato,
		(SELECT ca.nombre_cargo FROM cargo ca, tipo_contrato tc, contrato c WHERE ca.cargo_id=c.cargo_id and tc.tipo_contrato_id=c.tipo_contrato_id and c.contrato_id=$contrato_id)AS cargo
		
		FROM  contrato c, tipo_documento_laboral td
		WHERE c.contrato_id=$contrato_id AND c.tipo_contrato_id=td.tipo_contrato_id";
	  //echo $select;
	  $result = $this -> DbFetchAll($select,$Conex,true);
	
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
   
}


?>