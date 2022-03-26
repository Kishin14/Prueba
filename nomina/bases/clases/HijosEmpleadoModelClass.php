<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class HijosEmpleadoModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){
  
        $this -> DbInsertTable("hijos",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();

  }

  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("hijos",$Campos,$Conex,true,false); 
		
  }

  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("hijos",$Campos,$Conex,true,false);  
  }

  public function getHijos($Conex){
    // $select = "SELECT oficina_id AS value,CONCAT(codigo_centro,' - ',nombre) AS text FROM oficina ORDER BY codigo_centro ASC";
    $select = "SELECT hijos_id AS value,primer_nombre AS text FROM hijos ORDER BY primer_nombre ASC, segundo_nombre ASC, primer_apellido ASC, segundo_apellido ASC";
    $result = $this -> DbFetchAll($select,$Conex);
//echo $select;
    return $result; 
  
  }

  
  public function getHijosEmpleado($Conex){
  
    $empleado_id = $this -> requestDataForQuery('empleado_id','integer');
    
    if(is_numeric($empleado_id)){
    
      $select = "SELECT h.*,TIMESTAMPDIFF(YEAR, h.fecha_nacimiento, CURDATE())as edad,(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id = h.ubicacion_id) AS ubicacion FROM hijos h WHERE empleado_id ='".$empleado_id."'";
      $result  = $this -> DbFetchAll($select,$Conex,true);
      
    }else{
        $result = array();
    }
    return $result;
  }

  public function getTip($Conex){
  
    $select = "SELECT tipo_identificacion_id  AS value, nombre AS text FROM tipo_identificacion";
    $result = $this -> DbFetchAll($select,$Conex);
    
    return $result; 
  
  }
   
}



?>