<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EstudiosEmpleadoModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){
  
        $this -> DbInsertTable("estudio",$Campos,$Conex,true,false); 
		return $this -> getConsecutiveInsert();

  }

  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("estudio",$Campos,$Conex,true,false);  		
		
  }

  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("estudio",$Campos,$Conex,true,false);  
  }

  public function getEstudios($Conex){
  
    $select = "SELECT estudio_id AS value,titulo AS text FROM estudio ORDER BY titulo ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result; 
  
  }

  
  public function getEstudiosEmpleado($Conex){
  
    $empleado_id = $this -> requestDataForQuery('empleado_id','integer');
    
    if(is_numeric($empleado_id)){
    
      $select = "SELECT * FROM estudio WHERE empleado_id ='".$empleado_id."' ";
      $result  = $this -> DbFetchAll($select,$Conex,true);
      
    }else{
        $result = array();
    }
    return $result;
  }

  public function getNiv($Conex){
  
    $select = "SELECT nivel_escolaridad_id AS value,nombre AS text FROM nivel_escolaridad ORDER BY nombre ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result; 
  
  }
   
}



?>