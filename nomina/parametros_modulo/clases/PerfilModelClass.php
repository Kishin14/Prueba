<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PerfilModel extends Db{

	private $UserId;
	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function selectDatosPerfilId($perfil_id,$Conex){
		$select ="SELECT
			t.perfil_id,
			t.cargo_id,
			t.nivel_escolaridad_id,
			t.experiencia,
			t.escala_salarial_id,
			t.sexo,
			t.minimo_edad,
			t.maximo_edad,
			t.rango_sal_minimo,
			t.rango_sal_maximo,
			t.estado_civil_id,
			t.area_laboral,
			c.*,
			(SELECT CONCAT_WS(' ',	id_dane_ocupacion,'-',nombre) FROM ocupacion WHERE ocupacion_id=c.ocupacion_id) AS ocupacion
		FROM perfil t,cargo c	WHERE	t.perfil_id = $perfil_id AND c.cargo_id=t.cargo_id	";
		// echo "$select";
		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function Save($Campos,$Conex){
		$this -> Begin($Conex);
			$cargo_id    = $this -> DbgetMaxConsecutive("perfil","perfil_id",$Conex,true,1);
			$this -> assignValRequest('perfil_id',$perfil_id);
			$this -> DbInsertTable("cargo",$Campos,$Conex,true,false);
			$this -> DbInsertTable("perfil",$Campos,$Conex,true,false);
		$this -> Commit($Conex);
	}

	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			if($_REQUEST['perfil_id'] == 'NULL'){
				$this -> DbInsertTable("perfil",$Campos,$Conex,true,false);
			}else{
				$this -> DbUpdateTable("perfil",$Campos,$Conex,true,false);
				$this -> DbUpdateTable("cargo",$Campos,$Conex,true,false);
			}
		$this -> Commit($Conex);
	}

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("perfil",$Campos,$Conex,true,false);
	}

	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"perfil",$Campos);
		return $Data -> GetData();
	}

	public function GetARL($Conex){
		return $this -> DbFetchAll("SELECT categoria_arl_id  AS value,CONCAT_WS('',clase_riesgo,'-  % ',porcentaje) AS text FROM categoria_arl WHERE estado = 'A'",$Conex,
		$ErrDb = false);
	}

	public function GetEscolaridad($Conex){
		return $this -> DbFetchAll("SELECT nivel_escolaridad_id  AS value,nombre AS text FROM nivel_escolaridad WHERE estado = '1'",$Conex,
		$ErrDb = false);
	}

	public function GetEscala($Conex){
		return $this -> DbFetchAll("SELECT escala_salarial_id  AS value,
		                            CONCAT((minimo*(SELECT utv_minimo FROM uvt ORDER BY id_uvt DESC LIMIT 1)),' - ',
									        maximo*(SELECT utv_minimo FROM uvt ORDER BY id_uvt DESC LIMIT 1)) AS text 
									FROM escala_salarial",$Conex,
		$ErrDb = false);
	}

	public function GetCivil($Conex){
		return $this -> DbFetchAll("SELECT estado_civil_id  AS value,estado_civil AS text FROM estado_civil",$Conex,
		$ErrDb = false);
	}

	public function GetQueryPerfilGrid(){

		$Query = "SELECT
			perfil_id,
			(SELECT nombre_cargo FROM cargo WHERE cargo_id = t.cargo_id) AS cargo_id,
			(SELECT CONCAT_WS('',ca.clase_riesgo,' - %',ca.porcentaje) FROM cargo c, categoria_arl ca WHERE c.cargo_id = t.cargo_id AND ca.categoria_arl_id=c.categoria_arl_id) AS arl,
			(SELECT nombre FROM nivel_escolaridad WHERE nivel_escolaridad_id = t.nivel_escolaridad_id) AS nivel_escolaridad_id,
			experiencia,
			(SELECT CONCAT(minimo,' - ',maximo) FROM escala_salarial WHERE escala_salarial_id = t.escala_salarial_id) AS escala_salarial_id,
			sexo,
			minimo_edad,
			maximo_edad,
			rango_sal_minimo,
			rango_sal_maximo,
			(SELECT estado_civil FROM estado_civil WHERE estado_civil_id = t.estado_civil_id) AS estado_civil_id,
			(SELECT CONCAT_WS(' ',o.id_dane_ocupacion,' - ',o.nombre) FROM cargo c, ocupacion o WHERE c.cargo_id=t.cargo_id AND o.ocupacion_id=c.ocupacion_id) AS ocupacion_dane
		FROM perfil t
		";
		// $Query = "SELECT * FROM perfil";
		return $Query;
	}
}
?>