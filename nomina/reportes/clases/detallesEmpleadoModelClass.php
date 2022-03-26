<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class detallesEmpleadoModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($desde,$hasta,$Conex){ 

	    $select = "SELECT e.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS empleado_id,
		t.numero_identificacion,t.direccion,t.telefono,t.movil,
		(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=t.ubicacion_id) AS ubicacion_id,
		(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
		
				FROM contrato co, empleado e, tercero t
				WHERE co.empleado_id=e.empleado_id AND  co.fecha_inicio BETWEEN '$desde' AND '$hasta'  AND t.tercero_id=e.tercero_id ORDER BY e.empleado_id
		";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(empleado_id=>$items[empleado_id],sexo=>$items[sexo],numero_identificacion=>$items[numero_identificacion],direccion=>$items[direccion],telefono=>$items[telefono],movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],nombre_cargo=>$items[nombre_cargo]
						 );
		$i++;
		}
		
		return $result;
  } 
  
      public function getReporteMC2($empleado_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT e.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido))  AS empleado_id,
		t.numero_identificacion,t.direccion,t.telefono,t.movil,
		(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=t.ubicacion_id) AS ubicacion_id,
		(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
		
				FROM contrato co, empleado e, tercero t
				WHERE co.empleado_id=e.empleado_id AND  co.fecha_inicio BETWEEN '$desde' AND '$hasta'  AND t.tercero_id=e.tercero_id AND e.empleado_id=$empleado_id ORDER BY e.empleado_id
		";
		
	
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(empleado_id=>$items[empleado_id],sexo=>$items[sexo],numero_identificacion=>$items[numero_identificacion],direccion=>$items[direccion],telefono=>$items[telefono],movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],nombre_cargo=>$items[nombre_cargo]
						 );
		$i++;
		}
		
		return $result;
  } 
  
        public function getReporteMC3($empleado_id,$cargo_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT e.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido))  AS empleado_id,
		t.numero_identificacion,t.direccion,t.telefono,t.movil,
		(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=t.ubicacion_id) AS ubicacion_id,
		(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo 
		
				FROM contrato co, empleado e, tercero t
				WHERE co.empleado_id=e.empleado_id AND  co.fecha_inicio BETWEEN '$desde' AND '$hasta'  AND t.tercero_id=e.tercero_id AND e.empleado_id=$empleado_id AND co.cargo_id=$cargo_id ORDER BY e.empleado_id
		";
		
		/*$select = "SELECT c.*,(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS empleado_id,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ubicacion_id,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM empleado c, cargo co, postulacion p  		
					WHERE c.empleado_id=p.empleado_id AND c.empleado_id IN ($empleado_id) AND p.cargo_id=co.cargo_id AND co.cargo_id IN ($cargo_id) AND p.fecha BETWEEN '$desde' AND '$hasta'";*/
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_identificacion=>$items[numero_identificacion],empleado_id=>$items[empleado_id],sexo=>$items[sexo],direccion=>$items[direccion],telefono=>$items[telefono],
						  movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],fecha=>$items[fecha],nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 
  
          public function getReporteMC4($cargo_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT c.*,(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS empleado_id,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ubicacion_id,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM empleado c, cargo co, postulacion p  		
					WHERE c.empleado_id=p.empleado_id AND p.cargo_id=co.convocatoria_id AND co.cargo_id IN ($cargo_id) AND p.fecha BETWEEN '$desde' AND '$hasta'";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_identificacion=>$items[numero_identificacion],empleado_id=>$items[empleado_id],sexo=>$items[sexo],direccion=>$items[direccion],telefono=>$items[telefono],
						  movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],fecha=>$items[fecha],nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  }


}

?>