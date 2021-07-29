<?php
	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");
	final class EmpleadoModel extends Db{
		private $UserId;
		private $Permisos;
		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}
		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}
		
		public function selectDatosEmpleadoId($empleado_id,$Conex){
	  		 $select    = "SELECT 
	 						e.*,
							(SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id=e.tercero_id) AS numero_identificacion,
							(SELECT t.primer_nombre FROM tercero t WHERE t.tercero_id=e.tercero_id) AS primer_nombre,
							(SELECT t.segundo_nombre FROM tercero t WHERE t.tercero_id=e.tercero_id) AS segundo_nombre,
							(SELECT t.primer_apellido FROM tercero t WHERE t.tercero_id=e.tercero_id) AS primer_apellido,
							(SELECT t.segundo_apellido FROM tercero t WHERE t.tercero_id=e.tercero_id) AS segundo_apellido,
							(SELECT t.direccion FROM tercero t WHERE t.tercero_id=e.tercero_id) AS direccion,
							(SELECT t.telefono FROM tercero t WHERE t.tercero_id=e.tercero_id) AS telefono,							
							(SELECT t.movil FROM tercero t WHERE t.tercero_id=e.tercero_id) AS movil,							
    						(SELECT p.nombre FROM profesion p  WHERE p.profesion_id=e.profesion_id) AS profesion,
							(SELECT tipo_identificacion_id FROM tercero WHERE  tercero_id=e.tercero_id) AS tipo_identificacion_id,
							(SELECT tipo_persona_id FROM tercero WHERE  tercero_id=e.tercero_id) AS tipo_persona_id
							
							FROM empleado e 
	                		WHERE e.empleado_id = $empleado_id "; 
     			$result    = $this -> DbFetchAll($select,$Conex);
     			return $result;					  			
	  		}

  
  public function selectDatosNumId($numero_identificacion,$Conex){
	  	 $select    = "SELECT 
	 						e.*,
							t.*, 
				   			(SELECT nombre 
							FROM ubicacion 
							WHERE ubicacion_id=t.ubicacion_id) 
							AS ubicacion
				   			FROM tercero t 
							LEFT JOIN empleado e ON t.tercero_id = e.tercero_id 
	                		WHERE t.numero_identificacion = $numero_identificacion"; 
	  
		     $result    = $this -> DbFetchAll($select,$Conex);
     		return $result;					  			
	  		 }  
  
  							/*(SELECT nombre_banco 
							 FROM banco 
							 WHERE 	banco_id=e.banco_id) 
							AS banco */
							
		  public function ValidateRow($Conex,$Campos){
		 require_once("../../../framework/clases/ValidateRowClass.php");
	 	$Data = new ValidateRow($Conex,"tercero",$Campos);
	 	return $Data -> GetData();
   }
		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$empleado_id    = $this -> DbgetMaxConsecutive("empleado","empleado_id",$Conex,true,1);
				$this -> assignValRequest('empleado_id',$empleado_id);
     			$this -> DbInsertTable("tercero",$Campos,$Conex,true,false);
				$this -> DbInsertTable("empleado",$Campos,$Conex,true,false);
				
			$this -> Commit($Conex);
		}
		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['empleado_id'] == 'NULL'){
					$this -> DbInsertTable("empleado",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("empleado",$Campos,$Conex,true,false);
					$this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}
		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("empleado",$Campos,$Conex,true,false);
		}
		
		public function GetTipoId($Conex){
	return $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion WHERE tipo_identificacion_id NOT IN (2,3) ORDER BY nombre
	ASC",$Conex,$ErrDb = false);
  }
  
   public function GetTipoPersona($Conex){
	return $this -> DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona",$Conex,
	$ErrDb = false);
   }	
  


		public function GetEstadoCiv($Conex){
			return $this -> DbFetchAll("SELECT estado_civil_id  AS value, estado_civil AS text FROM estado_civil",$Conex,
			$ErrDb = false);
		}
		
		/*public function GetProfesion($Conex){
			return $this -> DbFetchAll("SELECT profesion_id  AS value, nombre AS text FROM profesion",$Conex,
			$ErrDb = false);
		}*/
		

		// public function GetCivil($Conex){
		// 	return $this -> DbFetchAll("SELECT estado_civil_id  AS value,estado_civil AS text FROM estado_civil",$Conex,
		// 	$ErrDb = false);
		// }
		public function GetConvocados($Conex){
			return $this -> DbFetchAll("SELECT * FROM convocado WHERE convocado_id NOT IN (SELECT convocado_id FROM empleado)",$Conex,
			$ErrDb = false);
		}
		
		  public function getcargaDatos($convocado_id,$Conex){

			$select = "SELECT
				convocado_id,
				(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id=cv.tipo_identificacion_id) AS tipo_identificacion_id,
				numero_identificacion,
				primer_nombre,
				segundo_nombre,
				primer_apellido,
				segundo_apellido,
				direccion,
				telefono,
				movil,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=cv.ubicacion_id) AS ubicacion_id,
				IF(estado='A','ACTIVO','INACTIVO') AS estado 

			FROM
				convocado cv
				
				WHERE convocado_id=$convocado_id
			";
     			$result    = $this -> DbFetchAll($select,$Conex);
     			return $result;					  			
		}
  
		public function GetQueryEmpleadoGrid(){
			$Query = "SELECT
				empleado_id,
				(SELECT razon_social FROM tercero WHERE tercero_id = e.tercero_id) AS tercero_id,
				IF(sexo='F','FEMENINO','MASCULINO') AS sexo,
				fecha_nacimiento,
				(SELECT estado_civil FROM estado_civil WHERE estado_civil_id = e.estado_civil_id) AS estado_civil_id,
				tipo_vivienda,
				(SELECT nombre FROM profesion WHERE profesion_id = e.profesion_id) AS profesion_id,
				num_hijos,
				IF(e.estado='A','ACTIVO','INACTIVO') AS estado,
				(SELECT CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido) FROM convocado WHERE convocado_id = e.convocado_id) AS convocado_id,
				t.tipo_identificacion_id, t.numero_identificacion,t.digito_verificacion,t.tipo_persona_id,t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre
			FROM
				empleado e, tercero t WHERE t.tercero_id=e.tercero_id
			";
			// $Query = "SELECT * FROM perfil";
			return $Query;
		}
	}
?>