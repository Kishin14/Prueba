<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ConyugeEmpleadoModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){
  
        $this -> DbInsertTable("conyuge",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();

  }

  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("conyuge",$Campos,$Conex,true,false);  		
		
  }

  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("conyuge",$Campos,$Conex,true,false);  
  }

  public function getConyuge($Conex){
  
    // $select = "SELECT oficina_id AS value,CONCAT(codigo_centro,' - ',nombre) AS text FROM oficina ORDER BY codigo_centro ASC";
    $select = "SELECT conyuge_id AS value,primer_nombre AS text FROM conyuge ORDER BY primer_nombre ASC, segundo_nombre ASC, primer_apellido ASC, segundo_apellido ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result; 
  
  }

  
  public function getConyugeEmpleado($Conex){
  
    $empleado_id = $this -> requestDataForQuery('empleado_id','integer');
    
    if(is_numeric($empleado_id)){
    
      $select = "SELECT * FROM conyuge WHERE empleado_id ='".$empleado_id."'";
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