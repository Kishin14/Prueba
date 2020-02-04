<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesPruebaModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($desde,$hasta,$Conex){ 

	    $select = "SELECT p.*,(SELECT CONCAT_WS(' ',c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido) FROM convocado c WHERE p.postulacion_id=po.postulacion_id AND c.convocado_id= po.convocado_id )  AS postulacion_id, (SELECT nombre_cargo FROM cargo 
		WHERE cargo_id=co.cargo_id) AS nombre_cargo  
		
		 FROM  prueba p, postulacion po, convocatoria co WHERE  p.postulacion_id = po.postulacion_id AND po.convocatoria_id =co.convocatoria_id AND p.fecha BETWEEN '$desde' AND '$hasta' ORDER BY p.prueba_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(prueba_id=>$items[prueba_id], nombre=>$items[nombre], observacion=>$items[observacion], resultado=>$items[resultado]
		, base=>$items[base], postulacion_id=>$items[postulacion_id], fecha=>$items[fecha], nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 
  
  public function getReporteMC2($convocado_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT p.*,(SELECT CONCAT_WS(' ',c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido) FROM convocado c WHERE p.postulacion_id=po.postulacion_id AND c.convocado_id= po.convocado_id )  AS postulacion_id, (SELECT nombre_cargo FROM cargo 
		WHERE cargo_id=co.cargo_id) AS nombre_cargo  
		
		 FROM  prueba p, postulacion po, convocatoria co WHERE p.postulacion_id = po.postulacion_id AND po.convocatoria_id =co.convocatoria_id AND  po.convocado_id IN ($convocado_id) AND p.fecha BETWEEN '$desde' AND '$hasta' ORDER BY p.prueba_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(prueba_id=>$items[prueba_id], nombre=>$items[nombre], observacion=>$items[observacion], resultado=>$items[resultado]
		, base=>$items[base], postulacion_id=>$items[postulacion_id], fecha=>$items[fecha], nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 

  public function getReporteMC3($cargo_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT p.*,(SELECT CONCAT_WS(' ',c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido) FROM convocado c WHERE p.postulacion_id=po.postulacion_id AND c.convocado_id= po.convocado_id AND po.convocatoria_id=co.convocatoria_id) AS postulacion_id, (SELECT nombre_cargo FROM cargo 
		WHERE cargo_id=co.cargo_id) AS nombre_cargo  
		
		 FROM  prueba p, postulacion po, convocatoria co WHERE  p.postulacion_id = po.postulacion_id AND po.convocatoria_id=co.convocatoria_id AND co.cargo_id IN ($cargo_id) AND p.fecha BETWEEN '$desde' AND '$hasta' ORDER BY p.prueba_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(prueba_id=>$items[prueba_id], nombre=>$items[nombre], observacion=>$items[observacion], resultado=>$items[resultado]
		, base=>$items[base], postulacion_id=>$items[postulacion_id], fecha=>$items[fecha], nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 

  public function getReporteMC4($convocado_id,$cargo_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT p.*,(SELECT CONCAT_WS(' ',c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido) FROM convocado c WHERE p.postulacion_id=po.postulacion_id AND c.convocado_id= po.convocado_id AND po.convocatoria_id=co.convocatoria_id) AS postulacion_id, (SELECT nombre_cargo FROM cargo 
		WHERE cargo_id=co.cargo_id) AS nombre_cargo  
		
		 FROM  prueba p, postulacion po, convocatoria co WHERE  p.postulacion_id = po.postulacion_id AND po.convocatoria_id=co.convocatoria_id AND co.cargo_id IN ($cargo_id) AND po.convocado_id IN ($convocado_id) AND p.fecha BETWEEN '$desde' AND '$hasta' ORDER BY p.prueba_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(prueba_id=>$items[prueba_id], nombre=>$items[nombre], observacion=>$items[observacion], resultado=>$items[resultado]
		, base=>$items[base], postulacion_id=>$items[postulacion_id], fecha=>$items[fecha], nombre_cargo=>$items[nombre_cargo]);
		$i++;
		}
		
		return $result;
  } 
  
}

?>