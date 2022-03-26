<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_DocumentoModel extends Db{ 
  
  public function getdocumento($empresa_id,$Conex){
 
    $documento_laboral_id = $this -> requestDataForQuery('documento_laboral_id','integer');
	
	if(is_numeric($documento_laboral_id)){

  	    $select = "SELECT d.*,(SELECT nombre_documento FROM tipo_documento_laboral WHERE tipo_documento_laboral_id=d.tipo_documento_laboral_id)AS nombre_documento,
		(SELECT cuerpo_mensaje FROM  tipo_documento_laboral WHERE tipo_documento_laboral_id=d.tipo_documento_laboral_id ) cuerpo_mensaje,
		(SELECT numero_contrato FROM contrato WHERE contrato_id=d.contrato_id)AS numero_contrato,
		(SELECT prefijo FROM contrato WHERE contrato_id=d.contrato_id)AS prefijo,
		(SELECT fecha_inicio FROM contrato WHERE contrato_id=d.contrato_id)AS fecha_inicio,
		(SELECT fecha_terminacion FROM contrato WHERE contrato_id=d.contrato_id)AS fecha_terminacion,
		(SELECT fecha_terminacion_real FROM contrato WHERE contrato_id=d.contrato_id)AS fecha_terminacion_real,
		(SELECT CONCAT_WS (' ',t.primer_apellido, t.segundo_apellido,t.primer_nombre,t.segundo_nombre) FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS nombre_empleado,
		(SELECT t.numero_identificacion FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS numero_identificacion,
		(SELECT tp.nombre FROM tercero t, empleado e, contrato c, tipo_persona tp WHERE t.tipo_persona_id=tp.tipo_persona_id and t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id) as tipo_persona,
		(SELECT ti.nombre FROM tercero t, empleado e, contrato c, tipo_identificacion ti WHERE t.tipo_identificacion_id=ti.tipo_identificacion_id and t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id) as tipo_identificacion,
		(SELECT t.direccion FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS direccion,
		(SELECT t.email FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS email,
		(SELECT t.telefax FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS telefax,
		(SELECT t.telefono FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS telefono,
		(SELECT t.movil FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS movil,
		(SELECT t.retei_proveedor FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS retei_proveedor,
		(SELECT t.autoret_proveedor FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS autoret_proveedor,
		(SELECT t.renta_proveedor FROM tercero t, empleado e, contrato c WHERE t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS renta_proveedor,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, vehiculo v, empleado e, contrato c WHERE v.propietario_id=t.tercero_id AND t.tercero_id=e.tercero_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS propietario_vehiculo,
		(SELECT e.sexo FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS sexo_empleado,
		(SELECT e.fecha_nacimiento FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS fecha_nacimiento_empleado,
		(SELECT ec.estado_civil FROM estado_civil ec, empleado e, contrato c WHERE ec.estado_civil_id=e.estado_civil_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS estado_civil_empleado,
		(SELECT e.tipo_vivienda FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS tipo_vivienda_empleado,
		(SELECT p.nombre_dane FROM profesion p, empleado e, contrato c WHERE p.profesion_id=e.profesion_id and e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS profesion_empleado,
		(SELECT e.num_hijos FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS numero_hijos_empleado,
		(SELECT e.estado FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS estado,
		(SELECT e.foto FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id and c.contrato_id=d.contrato_id)AS foto,
		(SELECT tc.nombre FROM tipo_contrato tc, contrato c WHERE tc.tipo_contrato_id=c.tipo_contrato_id and c.contrato_id=d.contrato_id)AS tipo_contrato,
		(SELECT ca.nombre_cargo FROM cargo ca, tipo_contrato tc, contrato c WHERE ca.cargo_id=c.cargo_id and tc.tipo_contrato_id=c.tipo_contrato_id and c.contrato_id=d.contrato_id)AS cargo,
		(SELECT c.motivo_terminacion_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS motivo_termicion,
		(SELECT c.sueldo_base FROM contrato c WHERE c.contrato_id=d.contrato_id)AS sueldo_base,
		(SELECT c.subsidio_transporte FROM contrato c WHERE c.contrato_id=d.contrato_id)AS subsidio_transporte,
		(SELECT ce.nombre FROM centro_de_costo ce, contrato c WHERE ce.centro_de_costo_id= c.centro_de_costo_id and c.contrato_id=d.contrato_id)AS centro_de_costo,
		(SELECT c.periodicidad FROM contrato c WHERE c.contrato_id=d.contrato_id)AS periodicidad,
		(SELECT c.causal_despido_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS casual_despido,
		(SELECT c.area_laboral FROM contrato c WHERE c.contrato_id=d.contrato_id)AS area_laboral,
		(SELECT c.empresa_eps_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS empresa_eps_id,
		(SELECT c.empresa_pension_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS empresa_pension_id,
		(SELECT c.empresa_arl_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS empresa_arl_id,
		(SELECT c.empresa_caja_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS empresa_caja_id,
		(SELECT c.empresa_cesan_id FROM contrato c WHERE c.contrato_id=d.contrato_id)AS empresa_cesan_id,
		(SELECT c.escaner_eps FROM contrato c WHERE c.contrato_id=d.contrato_id)AS escaner_eps,
		(SELECT c.escaner_pension FROM contrato c WHERE c.contrato_id=d.contrato_id)AS escaner_pension,
		(SELECT c.escaner_arl FROM contrato c WHERE c.contrato_id=d.contrato_id)AS escaner_arl,
		(SELECT c.escaner_caja FROM contrato c WHERE c.contrato_id=d.contrato_id)AS escaner_caja,
		(SELECT c.escaner_cesan FROM contrato c WHERE c.contrato_id=d.contrato_id)AS escaner_cesan,
		(SELECT c.insti_medico FROM contrato c WHERE c.contrato_id=d.contrato_id)AS insti_medico,
		(SELECT c.escaner_medico FROM contrato c WHERE c.contrato_id=d.contrato_id)AS escaner_medico,
		(SELECT c.horario_ini FROM contrato c WHERE c.contrato_id=d.contrato_id)AS horario_ini,
		(SELECT c.horario_fin FROM contrato c WHERE c.contrato_id=d.contrato_id)AS horario_fin,
		(SELECT c.lugar_trabajo FROM contrato c WHERE c.contrato_id=d.contrato_id)AS lugar_trabajo,
		(SELECT c.lugar_expedicion_doc FROM contrato c WHERE c.contrato_id=d.contrato_id)AS lugar_expedicion_doc,
		(SELECT t.descripcion FROM tipo_contrato t, contrato c WHERE t.tipo_contrato_id= c.tipo_contrato_id AND c.contrato_id=d.contrato_id)AS descrip_contrato

		FROM documento_laboral d 
		WHERE documento_laboral_id=$documento_laboral_id";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
   
}


?>