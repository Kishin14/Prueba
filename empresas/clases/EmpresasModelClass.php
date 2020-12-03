<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EmpresaModel extends Db{
		
  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosEmpresaTerceroId($tercero_id,$Conex){
	  
  
     $select    = "SELECT 
	 					t.*,
						e.*,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion 
				   	FROM tercero t 
				   		LEFT JOIN empresa e ON t.tercero_id = e.tercero_id 
	                WHERE t.tercero_id = $tercero_id";
					  
     $result    = $this -> DbFetchAll($select,$Conex);
	  
	
     return $result;					  			
	  
  }
  
  public function selectDatosEmpresaNumeroId($numero_identificacion,$Conex){
	  
  
     $select    = "SELECT 
	 					t.*,
						e.*, 
				   		(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion 
				   	FROM tercero t 
						LEFT JOIN empresa e ON t.tercero_id = e.tercero_id 
	                WHERE t.numero_identificacion = $numero_identificacion";
					  
     $result    = $this -> DbFetchAll($select,$Conex);
	  
	
     return $result;					  			
	  
  }  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tercero_id             = $this -> DbgetMaxConsecutive("tercero","tercero_id",$Conex,true,1);
	  $ubicacion_id           = $this -> requestDataForQuery('ubicacion_id','integer');
	  $tipo_persona_id        = $this -> requestDataForQuery('tipo_persona_id','integer');
	  $tipo_identificacion_id = $this -> requestDataForQuery('tipo_identificacion_id','integer');
	  $numero_identificacion  = $this -> requestDataForQuery('numero_identificacion','bigint');
	  $digito_verificacion    = $this -> requestDataForQuery('digito_verificacion','integer');
	  $primer_apellido        = $this -> requestDataForQuery('primer_apellido','text');
	  $segundo_apellido       = $this -> requestDataForQuery('segundo_apellido','text');
	  $primer_nombre 	      = $this -> requestDataForQuery('primer_nombre','text');
	  $segundo_nombre 	      = $this -> requestDataForQuery('segundo_nombre','text');
	  $razon_social 	      = $this -> requestDataForQuery('razon_social','alphanum');
	  $sigla                  = $this -> requestDataForQuery('sigla','alphanum');
	  $telefono               = $this -> requestDataForQuery('telefono','integer');
	  $movil 	              = $this -> requestDataForQuery('movil','integer');
	  $direccion 	          = $this -> requestDataForQuery('direccion','alphanum');
	
	  $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,
									  primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion) 
	  				VALUES 
									($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,
									 $primer_apellido,$segundo_apellido,$primer_nombre,$segundo_nombre,$razon_social,$sigla,$telefono,$movil,$direccion)"; 
	  
	  $this -> query($insert,$Conex);
	  	
      $this -> assignValRequest('tercero_id',$tercero_id);
	 	  
      $this -> DbInsertTable("empresa",$Campos,$Conex,true,false);  
	  
	$this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	

    $this -> Begin($Conex);

      $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
	  	
	  if($_REQUEST['empresa_id'] == 'NULL'){
		  		
	    $this -> DbInsertTable("empresa",$Campos,$Conex,true,false);			
	  
      }else{
			
          $this -> DbUpdateTable("empresa",$Campos,$Conex,true,false);
	  
	    }
				
	$this -> Commit($Conex);

  }
  
  public function Delete($Campos,$Conex){

  	$this -> DbDeleteTable("empresa",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"tercero",$Campos);
	 
	 return $Data -> GetData();
   }
	 	
  public function GetTipoId($Conex){
	return $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion ORDER BY nombre
	ASC",$Conex,$ErrDb = false);
  }
	
   public function GetTipoPersona($Conex){
	return $this -> DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona",$Conex,
	$ErrDb = false);
   }
   
   public function GetQueryEmpresasGrid(){
	   	   
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
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
			direccion,
			telefono,
			movil,
			telefax,
			apartado,
			t.email,
			registro_mercantil,
			escritura_constitucion,
			notaria,
			resolucion,
			fecha_resolucion,
			inicio_resolucion,
			fin_resolucion,
			inicio_disponible_res,
			saldo_res,
			IF(e.estado='A','ACTIVO','INACTIVO') AS estado
		FROM tercero t,empresa e 
		WHERE t.tercero_id = e.tercero_id";
   
   return $Query;
   }
   
   

}





?>