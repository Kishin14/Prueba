<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class asignarPermisosModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
      $this -> DbInsertTable("oficina",$Campos,$Conex,true,false);
	
  }
   
	 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM oficina WHERE oficina_id IN (SELECT oficina_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
   
   public function setOficinas($empresa_usuario_id,$oficina_id,$Conex){
	   
	   $this -> Begin($Conex);
	   
	     $delete = "DELETE FROM permiso_opcion_actividad WHERE opciones_actividad_id IN (SELECT opciones_actividad_id FROM 
																						 opciones_actividad WHERE usuario_id =
																						 (SELECT usuario_id FROM empresa_usuario WHERE 
																						  empresa_usuario_id = $empresa_usuario_id) AND 
																						 oficina_id NOT IN ($oficina_id))"; 
		 $this -> query($delete,$Conex,true);
		 
		 $delete = "DELETE FROM opciones_actividad WHERE usuario_id = (SELECT usuario_id FROM empresa_usuario WHERE 
		                                                               empresa_usuario_id = $empresa_usuario_id) AND oficina_id NOT IN  
																	   ($oficina_id)";
		 
		 $this -> query($delete,$Conex,true);	
		 
         $oficinas  = explode(",",$oficina_id);
		 
		 for($i = 0; $i < count($oficinas); $i++){

  		     $oficinaId = $oficinas[$i];		 
			 $select    = "SELECT * FROM opciones_actividad WHERE opciones_actividad_id IN (SELECT opciones_actividad_id FROM 
																						 opciones_actividad WHERE usuario_id =
																						 (SELECT usuario_id FROM empresa_usuario WHERE 
																						  empresa_usuario_id = $empresa_usuario_id) AND 
																						 oficina_id = $oficinaId)";
			 $result    = $this -> DbFetchAll($select,$Conex);
			 
			 if(!count($result) > 0 && $oficinaId != 0){
				 
				 $insert = "INSERT INTO opciones_actividad (consecutivo,usuario_id,oficina_id) VALUES (1,(SELECT usuario_id FROM 
				 empresa_usuario WHERE empresa_usuario_id = $empresa_usuario_id),$oficinaId)";
				 $this -> query($insert,$Conex);
				 
             }
			 
         }      
	   
	   	   
	   $this -> Commit($Conex);
	   
   }
   
   public function getOficinas($empresa_usuario_id,$Conex){
	   
	  $select = "SELECT oficina_id AS value,nombre AS text FROM oficina WHERE empresa_id = (SELECT empresa_id FROM empresa_usuario 
                 WHERE  empresa_usuario_id = $empresa_usuario_id)";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;
	   
   } 
   
   public function getOficinasSelected($empresa_usuario_id,$Conex){
	   
	  $select = "SELECT * FROM oficina WHERE oficina_id IN (SELECT DISTINCT oficina_id FROM opciones_actividad WHERE usuario_id = 
															(SELECT usuario_id FROM empresa_usuario WHERE 
															 empresa_usuario_id = $empresa_usuario_id))";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;
	   
   } 
   
   public function selectOpcionesAplicacion($empresa_usuario_id,$oficinas_asignadas_id,$Conex){
	   
	   $select = "SELECT consecutivo FROM actividad WHERE display = 1 AND estado = 1 AND consecutivo IN (SELECT consecutivo FROM opciones_actividad WHERE 
																		  usuario_id = (SELECT usuario_id FROM empresa_usuario WHERE 
																						empresa_usuario_id = $empresa_usuario_id) AND
																		  oficina_id = $oficinas_asignadas_id)";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
   
   public function selectPermisosOpcion($consecutivo,$empresa_usuario_id,$oficinas_asignadas_id,$Conex){
	   
	   $select = "SELECT permiso_id FROM permiso_opcion_actividad WHERE opciones_actividad_id = (SELECT opciones_actividad_id FROM 
																						opciones_actividad WHERE usuario_id = 
																						(SELECT usuario_id FROM empresa_usuario 
																						 WHERE empresa_usuario_id = $empresa_usuario_id) 
																						AND oficina_id = $oficinas_asignadas_id AND 
																						consecutivo = $consecutivo)";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
   }
   
   public function getEmpresasTree($Conex){
   
     $select = "SELECT consecutivo,descripcion,path_imagen,color FROM actividad WHERE modulo = 1 AND consecutivo != 1 AND display = 1 ORDER BY orden";
	 
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }
   
   public function getChildrenTop($EmpresaId,$Conex){
   
     $select = "SELECT consecutivo,descripcion,path_imagen,color FROM actividad WHERE display = 1 AND estado  = 1 AND nivel_superior = $EmpresaId ORDER BY orden";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }
   
   public function setPermisosAplicacion($empresa_usuario_id,$oficina_id,$permisosAplicacion,$Conex){
	   
	  $this -> Begin($Conex);
	  
	  $delete = "DELETE FROM permiso_opcion_actividad WHERE opciones_actividad_id IN (SELECT opciones_actividad_id FROM 
                 opciones_actividad WHERE oficina_id = $oficina_id AND usuario_id = (SELECT usuario_id FROM empresa_usuario
                 WHERE empresa_usuario_id = $empresa_usuario_id) AND consecutivo != 1)"; 
	  
	  $result = $this -> query($delete,$Conex);
	  	  
      if($this -> GetNumError() > 0){
		$this -> RollBack($Conex);
        return false;
      }else{
		  
         $delete = "DELETE FROM opciones_actividad WHERE consecutivo != 1 AND oficina_id = $oficina_id AND usuario_id = 
		           (SELECT usuario_id FROM empresa_usuario WHERE empresa_usuario_id = $empresa_usuario_id)";
				   
         $this -> query($delete,$Conex);
		 
         if($this -> GetNumError() > 0){
	  	   $this -> RollBack($Conex);
           return false;
         }else{		 
		  		  
		    for($i = 0; $i < count($permisosAplicacion); $i++){
				
				$consecutivo           = $permisosAplicacion[$i] -> consecutivo;
				$opciones_actividad_id = $this -> DbgetMaxConsecutive('opciones_actividad','opciones_actividad_id',$Conex,false,1);
				
				$insert = "INSERT INTO opciones_actividad (opciones_actividad_id,consecutivo,usuario_id,oficina_id) VALUES 
				           ($opciones_actividad_id,$consecutivo,(SELECT usuario_id FROM empresa_usuario WHERE empresa_usuario_id 
																 = $empresa_usuario_id),$oficina_id)";
						   
                $this -> query($insert,$Conex);	
				
				if($this -> GetNumError() > 0){
					
	  	          $this -> RollBack($Conex);
                  return false;
				  
                }else{	
				
				    for($j = 0; $j < count($permisosAplicacion[$i] -> permisos); $j++){
						
    				  $permiso_opcion_actividad_id = $this -> DbgetMaxConsecutive('permiso_opcion_actividad','permiso_opcion_actividad_id',$Conex,false,1);
					  $permiso_id                  = $permisosAplicacion[$i] -> permisos[$j] -> permiso_id;

                      $insert = "INSERT INTO permiso_opcion_actividad (permiso_opcion_actividad_id,opciones_actividad_id,permiso_id) 
					             VALUES ($permiso_opcion_actividad_id,$opciones_actividad_id,$permiso_id)";
					  
					  $this -> query($insert,$Conex);
					  
					  if($this -> GetNumError() > 0){
	  	                $this -> RollBack($Conex);
                        return false;
                      }
					  
					}
					
				  }
				  
				
 			}
			
            $this -> Commit($Conex);
			return true; 
			
		  }
		  
	   }		  
	   
   }
   
   public function getPermisos($Conex){
   
     $select = "SELECT * FROM permiso ORDER BY orden";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;	 
   
   }
   
   
 
}





?>