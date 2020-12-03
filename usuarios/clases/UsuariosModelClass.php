<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class UsuarioModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
  
	$tercero_id             = $this -> DbgetMaxConsecutive("tercero","tercero_id",$Conex,true,1);
    $tipo_identificacion_id = $this -> requestDataForQuery('tipo_identificacion_id','integer');
	$tipo_persona_id        = $this -> requestDataForQuery('tipo_persona_id','integer');
    $numero_identificacion  = $this -> requestDataForQuery('numero_identificacion','bigint');
    $primer_apellido        = $this -> requestDataForQuery('primer_apellido','alphanum');
    $segundo_apellido       = $this -> requestDataForQuery('segundo_apellido','alphanum');
    $primer_nombre          = $this -> requestDataForQuery('primer_nombre','alphanum');
    $segundo_nombre         = $this -> requestDataForQuery('segundo_nombre','alphanum');
    $usuario                = $this -> requestDataForQuery('usuario','alphanum');
    $cargo                  = $this -> requestDataForQuery('cargo','alphanum');	
    $email                  = $this -> requestDataForQuery('email','alphanum');
    $estado                 = $this -> requestDataForQuery('estado','alphanum');
	$empresas               = explode(",",$_REQUEST['empresa_id']);
	$password               = md5($_REQUEST['usuario']);
			
	$this -> Begin($Conex);
	
	$insert = "INSERT INTO tercero(tercero_id,tipo_identificacion_id,tipo_persona_id,numero_identificacion,
			   primer_apellido,segundo_apellido,primer_nombre,segundo_nombre) VALUES 
	           ($tercero_id,$tipo_identificacion_id,$tipo_persona_id,$numero_identificacion,$primer_apellido,
				$segundo_apellido,$primer_nombre,$segundo_nombre)";
			      
    $this -> query($insert,$Conex);
	
	if($this -> GetNumError() > 0){
      exit('Error : '.$this -> GetError());
    }else{
		
   	    $usuario_id = $this -> DbgetMaxConsecutive("usuario","usuario_id",$Conex,true,1);
		
		$insert = "INSERT INTO usuario (usuario_id,tercero_id,cargo,usuario,email,estado,password) VALUES 
		                               ($usuario_id,$tercero_id,$cargo,$usuario,$email,$estado,'$password')";
									   
        $this -> query($insert,$Conex);	
		
	    if($this -> GetNumError() > 0){
          exit('Error : '.$this -> GetError());
        }else{
		
		        for($i = 0; $i < count($empresas); $i++){
		
          		  $empresa_id         = $empresas[$i];
		   	      $empresa_usuario_id = $this -> DbgetMaxConsecutive("empresa_usuario","empresa_usuario_id",$Conex);
		
 				  $insert = "INSERT INTO empresa_usuario (empresa_usuario_id,usuario_id,empresa_id) VALUES 
		                               ($empresa_usuario_id + 1,$usuario_id,$empresa_id)";
									   
                  $this -> query($insert,$Conex);	
				  
				}
		
		
	        }		
		
		
		
	  }
	  
   $this -> Commit($Conex);
	
  }
	
  public function Update($Campos,$Conex){	
  
    $usuario_id = $this -> requestDataForQuery('usuario_id','integer');
	$empresas   = $this -> requestDataForQuery('empresa_id','alphanum'); 
	
	$this -> Begin($Conex);	
  
      $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);  

      if($usuario_id == 'NULL'){

       $tercero_id = $this -> requestDataForQuery('tercero_id','integer');	
       $usuario    = $this -> requestDataForQuery('usuario','alphanum');
       $email      = $this -> requestDataForQuery('email','alphanum');
	   $cargo      = $this -> requestDataForQuery('cargo','alphanum');
       $estado     = $this -> requestDataForQuery('estado','alphanum');
       $password   = md5($_REQUEST['usuario']);	
	
 	   $usuario_id = $this -> DbgetMaxConsecutive("usuario","usuario_id",$Conex,true,1);
		
	   $insert = "INSERT INTO usuario (usuario_id,tercero_id,cargo,usuario,email,estado,password) VALUES ($usuario_id,$tercero_id,$cargo,$usuario,$email,$estado,'$password')";
									   
       $this -> query($insert,$Conex);		
	
	 }else{
        $this -> DbUpdateTable("usuario",$Campos,$Conex,true,false);	
		
        $delete = "DELETE FROM empresa_usuario WHERE usuario_id = $usuario_id AND empresa_id NOT IN ($empresas)";
	  
        $this -> query($delete,$Conex,true);					
	   }
	
		
	  $empresas   = explode(",",$_REQUEST['empresa_id']);	

      for($i = 0; $i < count($empresas); $i++){
		
    	$empresa_id = $empresas[$i];		
		
		$select = "SELECT * FROM empresa_usuario WHERE usuario_id = $usuario_id AND empresa_id = $empresa_id"; 
		$result = $this -> DbFetchAll($select,$Conex);
		
		if(count($result) == 0){
		
		  $empresa_usuario_id = $this -> DbgetMaxConsecutive("empresa_usuario","empresa_usuario_id",$Conex);
		
 		  $insert = "INSERT INTO empresa_usuario (empresa_usuario_id,usuario_id,empresa_id) VALUES ($empresa_usuario_id + 1,$usuario_id,$empresa_id)";
									   
          $this -> query($insert,$Conex,true);	
		  
		 }
				  
	  }	
	  
	$this -> Commit($Conex);

  }
	
  public function Delete($Campos,$Conex){
  
     $usuario_id = $this -> requestDataForQuery('usuario_id','integer');
	 
     $this -> Begin($Conex);
	 
       $delete = "DELETE FROM empresa_usuario WHERE usuario_id = $usuario_id";
	   
       $this -> query($delete,$Conex,true);	
		
  	   $this -> DbDeleteTable("usuario",$Campos,$Conex,true,false);
	 
	 $this -> Commit($Conex);
	
  }	
			 	
  public function GetTipoId($Conex){
	return $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion WHERE 
								tipo_identificacion_id != 2 ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  
  public function getEmpresas($Conex){
  
    $select = "SELECT empresa_id AS value,CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS text FROM 
	empresa	e, tercero t WHERE e.tercero_id = t.tercero_id";
	
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;
  
  }	
  
  public function selectEmpresasUsuario($usuario_id,$Conex){
  
     $select = "SELECT * FROM empresa_usuario WHERE usuario_id = $usuario_id";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
  
  }
  
   public function getQueryTercerosGrid(){
	   	   
     $Query = "SELECT IF(u.estado = 'A','ACTIVO','INACTIVO') AS estado,numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,
     segundo_apellido,cargo,u.usuario,u.email FROM tercero t, usuario u WHERE u.tercero_id = t.tercero_id";
   
     return $Query;
   }
   

}





?>