<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleCargoModel extends Db{

  private $Permisos;
  public $cargo_id;
    
  public function Save($Campos,$Conex){
  
        $this -> DbInsertTable("categoria_cargo",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();

  }

  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("categoria_cargo",$Campos,$Conex,true,false);  		
		
  }

  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("categoria_cargo",$Campos,$Conex,true,false);  
  }
    
  public function getOficinas($Conex){
  
    // $select = "SELECT oficina_id AS value,CONCAT(codigo_centro,' - ',nombre) AS text FROM oficina ORDER BY codigo_centro ASC";
    $select = "SELECT categoria_id AS value,CONCAT(codigo,' - ',categoria) AS text FROM categoria_licencia ORDER BY codigo ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;	
  
  }

  public function updateCargoId($conex){
    if ($_REQUEST['cargo_id'] == "-1")
    {
      $this->cargo_id = $this -> DbgetMaxConsecutive("cargo","cargo_id",$Conex,true,5);
      $_REQUEST['cargo_id'] = $this->cargo_id;
    }
  }
  
  public function getDetallesCargo($Conex){
  
  if ($_REQUEST['cargo_id'] == "-1")
  {
	  $cargo_id = $this -> DbgetMaxConsecutive("cargo","cargo_id",$Conex,true);
    $_REQUEST['cargo_id'] = $cargo_id;
    echo '<script languaje="JavaScript">var varjs="'.$cargo_id.'"</script>';
  }
	
  $cargo_id = $_REQUEST['cargo_id'];
	if(is_numeric($cargo_id)){
	
		// $select  = "SELECT consecutivo_documento_oficina_id,tipo_documento_id,oficina_id,consecutivo FROM  consecutivo_documento_oficina d 
		// WHERE tipo_documento_id = $tipo_documento_id";	
    $select = "SELECT * FROM categoria_cargo WHERE cargo_id = $cargo_id";
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  


   
}



?>