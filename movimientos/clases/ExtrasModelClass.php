<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ExtrasModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectExtrasId($hora_extra_id,$Conex){
			$select ="SELECT
				h.*,
				(SELECT sueldo_base FROM contrato WHERE contrato_id=h.contrato_id)as sueldo_base,
				(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,'-',t.numero_identificacion) 
				AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=h.contrato_id)AS contrato
			FROM hora_extra h WHERE	h.hora_extra_id = $hora_extra_id"; 
			
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
		
		public function getExtras($fecha_inicial,$Conex){
			
			$anio = substr($fecha_inicial,0,4);
			
			$select_per = "SELECT * FROM datos_periodo WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio)";
			$result_per = $this -> DbFetchAll($select_per,$Conex,true);
			return $result_per;			
			
		}		
		
		public function getExtrasAuto($fecha_inicial,$Conex){
			
			$anio = substr($fecha_inicial,0,4);
			
			$select_per = "SELECT * FROM datos_periodo WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio)";
			$result_per = $this -> DbFetchAll($select_per,$Conex,true);
			return $result_per;			
			
		}		

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$hora_extra_id    = $this -> DbgetMaxConsecutive("hora_extra","hora_extra_id",$Conex,true,1);
				$this -> assignValRequest('hora_extra_id',$id_uvt);
				$this -> DbInsertTable("hora_extra",$Campos,$Conex,true,false);

			$this -> Commit($Conex);
		}
		
		public function SaveExcel($fecha_inicial,$fecha_final,$camposArchivo,$Conex){
			$this -> Begin($Conex);
			$estado ='E';

			for($i=1; $i<count($camposArchivo); $i++){

				$select_valid = "SELECT c.contrato_id FROM tercero t,empleado e,contrato c,hora_extra ex WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=ex.contrato_id AND ex.estado ='E' AND t.numero_identificacion='".$camposArchivo[$i][0]."'";
				$result_valid = $this -> DbFetchAll($select_valid,$Conex,true);	
				
				if($result_valid>0){

						exit('Este empleado '.$camposArchivo[$i][0].', Ya cuenta con una hora extra creada, por favor revise.');

				}else{

							$select = "SELECT c.contrato_id,c.sueldo_base FROM tercero t,empleado e,contrato c,hora_extra ex WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.estado='A' AND t.numero_identificacion='".$camposArchivo[$i][0]."'";
						$result = $this -> DbFetchAll($select,$Conex,true);		 
						$contrato_id = $result[0]['contrato_id'];	
						$sueldo_base = $result[0]['sueldo_base'];	


					 if ($result > 0) {
							
									

						$data = $this->getExtrasAuto($fecha_inicial,$Conex);

						$valor_festivo = 0;
						$valor_recargo_noct = 0;
						$valor_noct_fest = 0;
						$valor_diur_fest = 0;
						$valor_nocturnas = 0;
						$valor_diurnas = 0;
						
						$horas_dia=$data[0]['horas_dia'];
						$val_recargo_dominical=$data[0]['val_recargo_dominical'];
						$val_recargo_nocturna=$data[0]['val_recargo_nocturna'];
						$val_hr_ext_festiva_nocturna=$data[0]['val_hr_ext_festiva_nocturna'];
						$val_hr_ext_festiva_diurna=$data[0]['val_hr_ext_festiva_diurna'];
						$val_hr_ext_nocturna=$data[0]['val_hr_ext_nocturna'];
						$val_hr_ext_diurna=$data[0]['val_hr_ext_diurna'];
						$dias_lab_mes=$data[0]['dias_lab_mes'];
						$val_hr_corriente=$data[0]['val_hr_corriente'];
						$salario = ($sueldo_base/240);

						$vr_horas_festivo = (($salario*$val_recargo_dominical)/100);
						$vr_horas_nocturno = (($salario*$val_recargo_nocturna)/100);
						$vr_horas_recargo_festivo = (($salario*$val_hr_ext_festiva_nocturna)/100);
						$vr_horas_diurna_fest = (($salario*$val_hr_ext_festiva_diurna)/100);
						$vr_horas_extra_nocturna = (($salario*$val_hr_ext_nocturna)/100);
						$vr_horas_extra_diurna = (($salario*$val_hr_ext_diurna)/100);

						$vr_horas_diurnas = $camposArchivo[$i][1]*$vr_horas_extra_diurna;
						$vr_horas_nocturnas = $camposArchivo[$i][2]*$vr_horas_extra_nocturna;
						$vr_horas_diurnas_fes = $camposArchivo[$i][3]*$vr_horas_diurna_fest;
						$vr_horas_nocturnas_fes = $camposArchivo[$i][4]*$vr_horas_recargo_festivo;
						$vr_horas_recargo_noc = $camposArchivo[$i][5]*$vr_horas_nocturno;
						$vr_horas_recargo_doc = $camposArchivo[$i][6]*$vr_horas_festivo;


						$hora_extra_id    = $this -> DbgetMaxConsecutive("hora_extra","hora_extra_id",$Conex,true,1);
						$insert = "INSERT INTO hora_extra (
											hora_extra_id,
											fecha_inicial,
											fecha_final,
											horas_diurnas,
											vr_horas_diurnas,
											horas_nocturnas,
											vr_horas_nocturnas,
											horas_diurnas_fes,
											vr_horas_diurnas_fes,
											horas_nocturnas_fes,
											vr_horas_nocturnas_fes,
											horas_recargo_noc,
											vr_horas_recargo_noc,
											horas_recargo_doc,
											vr_horas_recargo_doc,
											contrato_id,
											estado
										) 
								VALUES ($hora_extra_id,
										'$fecha_inicial',
										'$fecha_final',
										'".trim($camposArchivo[$i][1])."',
										$vr_horas_diurnas,
										'".trim($camposArchivo[$i][2])."' ,
										$vr_horas_nocturnas,
										'".trim($camposArchivo[$i][3])."' ,
										$vr_horas_diurnas_fes,						 
										'".trim($camposArchivo[$i][4])."' ,
										$vr_horas_nocturnas_fes,						 
										'".trim($camposArchivo[$i][5])."' ,
										$vr_horas_recargo_noc,						 
										'".trim($camposArchivo[$i][6])."' ,
										$vr_horas_recargo_doc,
										$contrato_id,
										'$estado'						 
										)";
										
						$this -> query($insert,$Conex,true);
					}else{
						echo('El Empleado con No. de Identificacion: '.$camposArchivo[$i][0].' no tiene un contrato activo. --- ');
					}

				}
				
				if($this -> GetNumError() > 0){
				 $this -> Rollback($Conex);	
				 return false;
				}
			}

			$this -> Commit($Conex);

			
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['hora_extra_id'] == 'NULL'){
					$this -> DbInsertTable("hora_extra",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("hora_extra",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}
		
		public function Procesar($Campos,$contrato_id,$fecha_inicial,$fecha_final,$Conex){

			if ($contrato_id > 0) {
				$update = "UPDATE hora_extra SET estado = 'P' WHERE estado = 'E' AND contrato_id=$contrato_id AND fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final' AND fecha_final BETWEEN '$fecha_inicial' AND '$fecha_final'";
			}else {
				$update = "UPDATE hora_extra SET estado = 'P' WHERE estado = 'E' AND fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final' AND fecha_final BETWEEN '$fecha_inicial' AND '$fecha_final'";
			}
										
			$this -> query($update,$Conex,true);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("hora_extra",$Campos,$Conex,true,false);
		}

		public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
    }  

		 public function cancellation($contrato_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
			$this -> Begin($Conex);

				$update = "UPDATE hora_extra SET estado = 'A' WHERE contrato_id= $contrato_id";
				$this -> query($update,$Conex,true);	 	  	 
				
			$this -> Commit($Conex);
			
			} 

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"hora_extra",$Campos);
			return $Data -> GetData();
		}
		
	  public function getDataContrato($contrato_id,$Conex){

 		 $select_valida = "SELECT * FROM hora_extra WHERE estado ='E' AND contrato_id = $contrato_id";
		 $result_valida = $this -> DbFetchAll($select_valida,$Conex,true);

		if ($result_valida > 0) {
			return 'false';
		}else{
			
			$select = "SELECT * FROM contrato WHERE contrato_id = $contrato_id";
			$result = $this -> DbFetchAll($select,$Conex,true);
			return $result;
		}


	  } 
		

		public function GetQueryExtrasGrid(){

			$Query = "SELECT
				h.hora_extra_id,
				(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,'-',t.numero_identificacion) 
				AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=h.contrato_id)AS contrato,
				h.fecha_inicial, h.fecha_final,CONCAT(h.horas_diurnas,'h')AS horas_diurnas,h.vr_horas_diurnas,CONCAT(h.horas_nocturnas,'h')AS horas_nocturnas,h.vr_horas_nocturnas, CONCAT(h.horas_diurnas_fes,'h')AS horas_diurnas_fes,h.vr_horas_diurnas_fes,CONCAT(h.horas_nocturnas_fes,'h')AS horas_nocturnas_fes,
				h.vr_horas_nocturnas_fes,CONCAT(h.horas_recargo_noc,'h')AS horas_recargo_noc,h.vr_horas_recargo_noc,
				(CASE h.estado WHEN 'P' THEN 'PROCESADO' WHEN 'E' THEN 'EDICION' WHEN 'L' THEN 'LIQUIDADO' ELSE 'ANULADO' END)as estado
				FROM hora_extra h";
			return $Query;
		}
	}
?>