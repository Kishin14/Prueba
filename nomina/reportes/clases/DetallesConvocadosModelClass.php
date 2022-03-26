<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesConvocadosModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($desde,$hasta,$Conex){ 

	    $select = "SELECT c.*,(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS convocado_id,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ubicacion_id,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p 		
					WHERE c.convocado_id=p.convocado_id AND p.convocatoria_id=co.convocatoria_id AND p.fecha BETWEEN '$desde' AND '$hasta' ORDER BY c.convocado_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_identificacion=>$items[numero_identificacion],convocado_id=>$items[convocado_id],direccion=>$items[direccion],telefono=>$items[telefono],
						  movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],fecha=>$items[fecha],nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 
  
      public function getReporteMC2($convocado_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT c.*,(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS convocado_id,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ubicacion_id,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p 		
					WHERE c.convocado_id=p.convocado_id AND c.convocado_id IN ($convocado_id)  AND p.convocatoria_id=co.convocatoria_id AND p.fecha BETWEEN '$desde' AND '$hasta'";
	
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_identificacion=>$items[numero_identificacion],convocado_id=>$items[convocado_id],direccion=>$items[direccion],telefono=>$items[telefono],
						  movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],fecha=>$items[fecha],nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 
  
        public function getReporteMC3($convocado_id,$convocatoria_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT c.*,(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS convocado_id,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ubicacion_id,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p  		
					WHERE c.convocado_id=p.convocado_id AND c.convocado_id IN ($convocado_id) AND p.convocatoria_id=co.convocatoria_id AND co.convocatoria_id IN ($convocatoria_id) AND p.fecha BETWEEN '$desde' AND '$hasta'";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_identificacion=>$items[numero_identificacion],convocado_id=>$items[convocado_id],direccion=>$items[direccion],telefono=>$items[telefono],
						  movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],fecha=>$items[fecha],nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 
  
          public function getReporteMC4($convocatoria_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT c.*,(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS convocado_id,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ubicacion_id,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p  		
					WHERE c.convocado_id=p.convocado_id AND p.convocatoria_id=co.convocatoria_id AND co.convocatoria_id IN ($convocatoria_id) AND p.fecha BETWEEN '$desde' AND '$hasta'";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_identificacion=>$items[numero_identificacion],convocado_id=>$items[convocado_id],direccion=>$items[direccion],telefono=>$items[telefono],
						  movil=>$items[movil],ubicacion_id=>$items[ubicacion_id],fecha=>$items[fecha],nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  }


}

?>