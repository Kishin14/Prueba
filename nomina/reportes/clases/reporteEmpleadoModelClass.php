<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteEmpleadoModel extends Db{

  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  


   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
    public function GetSi_Pro2($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
  public function getReporteMC1($desde,$hasta,$Conex){ 	   	
 
	    $select = "SELECT 
		t.numero_identificacion,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS nombre_empleado,e.sexo,t.direccion,t.telefono,t.movil,
		(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=t.ubicacion_id) AS ciudad,
		(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
		
				FROM contrato co, empleado e, tercero t
				WHERE co.empleado_id=e.empleado_id AND  co.fecha_inicio BETWEEN '$desde' AND '$hasta'  AND t.tercero_id=e.tercero_id ORDER BY e.empleado_id";		  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex,true);
		  return $results;
  } 
  
    public function getReporteMC2($convocado_id,$desde,$hasta,$Conex){ 	   	
 
	    $select = "SELECT (SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS nombre_convocado,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ciudad,
					c.numero_identificacion,		
					c.direccion,
					c.telefono,
					c.movil,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p 		
					WHERE c.convocado_id=p.convocado_id AND c.convocado_id IN ($convocado_id)  AND p.convocatoria_id=co.convocatoria_id AND p.fecha BETWEEN '$desde' AND '$hasta'";		  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  }
  
    public function getReporteMC3($convocado_id,$convocatoria_id,$desde,$hasta,$Conex){ 	   	
 
	    $select = "SELECT (SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS nombre_convocado,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ciudad,
					c.numero_identificacion,		
					c.direccion,
					c.telefono,
					c.movil,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p  		
					WHERE c.convocado_id=p.convocado_id AND c.convocado_id IN ($convocado_id) AND p.convocatoria_id=co.convocatoria_id AND co.convocatoria_id IN ($convocatoria_id) AND p.fecha BETWEEN '$desde' AND '$hasta'";		  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  }
  
    public function getReporteMC4($convocatoria_id,$desde,$hasta,$Conex){ 	   	
 
	    $select = "SELECT (SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido)) AS  nombre_convocado,
		 			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id) AS ciudad,
					c.numero_identificacion,		
					c.direccion,
					c.telefono,
					c.movil,
					p.fecha,
					(SELECT ca.nombre_cargo FROM cargo ca WHERE ca.cargo_id=co.cargo_id) AS nombre_cargo
					FROM convocado c, convocatoria co, postulacion p  		
					WHERE c.convocado_id=p.convocado_id AND p.convocatoria_id=co.convocatoria_id AND co.convocatoria_id IN ($convocatoria_id) AND p.fecha BETWEEN '$desde' AND '$hasta'";		  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  }
  
 

}

?>