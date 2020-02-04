<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ExtrasModel extends Db{ 
  
  public function getextras($empresa_id,$Conex){
 
    $hora_extra_id = $this -> requestDataForQuery('hora_extra_id','integer');
	
	if(is_numeric($hora_extra_id)){

  	     $select = "SELECT ex.*,
		 		(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id)) AS razon_social_emp,
				(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id)) AS sigla_emp, 
				(SELECT CONCAT_WS(' - ',numero_identificacion, digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id)) AS  numero_identificacion_emp,
				(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id)) AS direccion_emp,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id))) AS ciudad_emp,				
		 		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=ex.contrato_id)AS empleado,
				(SELECT CONCAT_WS(' ',t.numero_identificacion)AS contra FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=ex.contrato_id)AS identificacion
				FROM hora_extra ex
				WHERE ex.hora_extra_id=$hora_extra_id";
				
				
		/*		(SELECT ex.horas_nocturnas FROM hora_extra WHERE hora_extra_id=ex.hora_extra_id) AS extrasn,
				(SELECT ex.horas_diurnas_fes FROM hora_extra WHERE hora_extra_id=ex.hora_extra_id) AS extrasdf,
				(SELECT ex.horas_nocturnas_fes FROM hora_extra WHERE hora_extra_id=ex.hora_extra_id) AS extrasnf,
				(SELECT ex.horas_recargo_noc FROM hora_extra WHERE hora_extra_id=ex.hora_extra_id) AS horarecargo,
				FROM hora_extra ex 
				WHERE ex.hora_extra_id=$hora_extra_id";*/
				
		
					
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  public function getTotal($hora_extra_id,$Conex){
  
    $hora_extra_id = $this -> requestDataForQuery('hora_extra_id','integer');
	
	if(is_numeric($hora_extra_id)){
				
        $select = "SELECT SUM(vr_horas_diurnas+vr_horas_nocturnas+vr_horas_diurnas_fes+vr_horas_nocturnas_fes+vr_horas_recargo_noc+vr_horas_recargo_doc) AS total		
         FROM  hora_extra  WHERE hora_extra_id = $hora_extra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

}


?>