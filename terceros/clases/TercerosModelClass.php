<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TerceroModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
  
    $this -> DbInsertTable("tercero",$Campos,$Conex,true,false);
	
  }
	
  public function Update($Campos,$Conex){	
	
    $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);

  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("tercero",$Campos,$Conex,true,false);
	
  }	
			 	
  public function GetTipoId($Conex){

	$result =  $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion ORDER BY nombre ASC",$Conex,false);

        return $result;


  }
	
   public function GetTipoPersona($Conex){

	$result = $this -> DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona",$Conex,false);

        return $result;

   }
   
   public function getRegimen($Conex){
	   
	   $select = "SELECT regimen_id AS value,nombre AS text FROM regimen";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }     
   
   public function selectTercero($Conex){
	 $tercero_id = $this -> requestDataForQuery('tercero_id','integer');
	 $numero_identificacion = $this -> requestDataForQuery('numero_identificacion','integer');
	 
	 if ($tercero_id!='NULL'){
       $Query = "SELECT 
	 			t.*,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion
				
			FROM tercero t
			WHERE t.tercero_id=$tercero_id";
	 }
	 elseif($numero_identificacion!='NULL'){
       $Query = "SELECT 
	 			t.*,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion
				
			FROM tercero t
			WHERE t.numero_identificacion=$numero_identificacion";
	 }
     $result =  $this -> DbFetchAll($Query,$Conex,$ErrDb = false);
   
     return $result;
   }
   
   
   
   
   
   public function getQueryTercerosGrid(){
	   	   
     $Query = "SELECT 
	 			(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_id,
				numero_identificacion,
				digito_verificacion,
				(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = t.tipo_persona_id) AS tipo_persona_id, 
				primer_apellido,
     			segundo_apellido,
				primer_nombre,
				segundo_nombre,
				razon_social,
				sigla,
				telefono,
				movil,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
				direccion,
				email,
				(SELECT nombre FROM regimen WHERE regimen_id=t.regimen_id) AS regimen,
				IF (t.estado='D','DISPONIBLE','BLOQUEADO') AS estado
			FROM tercero t";
   
     return $Query;
   }
   

}


?>