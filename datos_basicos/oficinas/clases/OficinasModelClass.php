<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class OficinaModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	

	  $this -> DbInsertTable("oficina",$Campos,$Conex,true,false);	
	  
	  $select="SELECT oficina_id,empresa_id,'O' AS tipo,nombre FROM oficina ORDER BY oficina_id DESC";

	  $result = $this -> DbFetchAll($select,$Conex,true);

	  $oficina_id 		  = $result[0]['oficina_id'];
	  $empresa_id 		  = $result[0]['empresa_id'];
	  $tipo       		  = $result[0]['tipo'];
	  $nombre             = $result[0]['nombre'];
	  $centro_de_costo_id = $this -> DbgetMaxConsecutive("centro_de_costo","centro_de_costo_id",$Conex,true,1);
	  $codigo             = $this -> DbgetMaxConsecutive("centro_de_costo","codigo",$Conex,true,1);

	  if($codigo < 9){
		$codigo  = str_pad($codigo, 3, '0', STR_PAD_LEFT);
	  }else{
		$codigo  = str_pad($codigo, 2, '0', STR_PAD_LEFT);
	  }

	 $insert = "INSERT INTO centro_de_costo(centro_de_costo_id, codigo, nombre, empresa_id, tipo, oficina_id) 
	 VALUES ($centro_de_costo_id,'$codigo','$nombre',$empresa_id,'$tipo',$oficina_id)";

	 $this -> query($insert,$Conex,true);
	
  }
	
  public function Update($Campos,$Conex){	

    $this -> DbUpdateTable("oficina",$Campos,$Conex,true,false);

  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("oficina",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"oficina",$Campos);
	 
	 return $Data -> GetData();
   }
   
   public function selectOficina($OficinaId,$Conex){
	   
	   $select = "SELECT o.*,(SELECT CONCAT_WS('-',u1.nombre, u2.nombre) FROM ubicacion u1 LEFT JOIN ubicacion u2     
	   ON u1.ubi_ubicacion_id=u2.ubicacion_id	WHERE u1.ubicacion_id = o.ubicacion_id) AS ubicacion,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = o.responsable_id) AS responsable FROM oficina o WHERE 
	   oficina_id = $OficinaId";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
	 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM oficina WHERE oficina_id IN (SELECT oficina_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
   
   public function selectOficinas($EmpresaId,$Conex){
	   
	   $select = "SELECT oficina_id AS value,nombre AS text FROM oficina WHERE empresa_id = $EmpresaId ORDER BY nombre";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
   
   public function selectOficinasSelected($EmpresaId,$OficinaId,$Conex){
	   
	   $select = "SELECT oficina_id AS value,nombre AS text,(SELECT cen_oficina_id FROM oficina WHERE oficina_id = $OficinaId) AS 
	   selected FROM oficina  WHERE empresa_id = $EmpresaId ORDER BY nombre";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;	   
	   
   }
   
   public function getEmpresasTree($Conex){
   
     $select = "SELECT empresa_id,CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
	 AS empresa_nombre FROM empresa e,tercero t WHERE e.tercero_id = t.tercero_id";
	 
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }
   
   public function getChildrenTop($EmpresaId,$Conex){
   
     $select = "SELECT *,(SELECT nombre FROM ubicacion WHERE ubicacion_id = o.ubicacion_id) AS ubicacion FROM oficina o WHERE 
	 cen_oficina_id IS NULL AND empresa_id = $EmpresaId";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }
   
   public function getChildren($IdParent,$Conex){
   
     $select = "SELECT *,(SELECT nombre FROM ubicacion WHERE ubicacion_id = o.ubicacion_id) AS ubicacion FROM oficina o WHERE 
	 cen_oficina_id = $IdParent";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }   
   
   
 
}





?>