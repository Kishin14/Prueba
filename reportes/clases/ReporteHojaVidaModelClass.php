<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteHojaVidaModel extends Db{

  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
 

   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'CONTRATO'),1=>array('value'=>'2','text'=>'TERCERO'));
	return $opciones;
   }

   public function GetIndicadores($Conex){
	$opciones=array(0=>array('value'=>'S','text'=>'SI'),1=>array('value'=>'N','text'=>'NO'));
	return $opciones;
   }


  public function getReporte($consulta_cliente,$Conex){ 
	   	
	  	$select="SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = ce.empresa_id) AS logo,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS empleado,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS empleado,s.numero_contrato,CONCAT(s.prefijo,' - ',s.numero_contrato)AS prefijo,(SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS cedula_empleado,s.fecha_inicio,(CASE WHEN s.fecha_terminacion != '' THEN s.fecha_terminacion WHEN s.fecha_terminacion = '' AND s.fecha_terminacion_real != '' THEN s.fecha_terminacion_real ELSE 'N/A' END)AS fecha_terminacion,s.contrato_id,(SELECT nombre FROM tipo_contrato WHERE s.tipo_contrato_id=tipo_contrato_id)AS tipo_contrato,(SELECT descripcion FROM tipo_contrato WHERE s.tipo_contrato_id=tipo_contrato_id)AS descripcion_contrato,(SELECT nombre_cargo FROM cargo WHERE s.cargo_id=cargo_id)AS cargo,s.lugar_expedicion_doc,s.lugar_trabajo,s.sueldo_base,s.subsidio_transporte,ce.nombre AS centro_costo,(SELECT CONCAT(clase_riesgo,' - %',porcentaje)FROM categoria_arl WHERE categoria_arl_id= s.categoria_arl_id)AS categoria_arl,(CASE WHEN periodicidad ='H' THEN 'HORAS' WHEN periodicidad ='D' THEN 'DIAS' WHEN periodicidad ='S' THEN 'SEMANAL' WHEN periodicidad ='Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END)AS periocidad,(CASE WHEN area_laboral ='O' THEN 'OPERATIVA' WHEN area_laboral ='A' THEN 'ADMINISTRATIVO' ELSE 'COMERCIAL' END)AS area,(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=s.motivo_terminacion_id)AS motivo_terminacion_id,(SELECT nombre FROM causal_despido WHERE causal_despido_id=s.causal_despido_id)AS causal_despido_id,s.fecha_terminacion_real,
		CASE s.estado WHEN 'A' THEN '<span style=\'color:#008000;\'>
		 ACTIVO</span>' WHEN 'R' THEN 'RETIRADO'  WHEN 'F' THEN 
		'<span style=\'color:#FF0000;\'>
		 FINALIZADO</span>' ELSE 'ANULADO' END AS estado,
		IF(s.escaner_eps!='',CONCAT('','<a href=\"javascript:popPup(\'',s.escaner_eps,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS escaner_eps,
		IF(s.escaner_pension!='',CONCAT('','<a href=\"javascript:popPup(\'',s.escaner_pension,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS escaner_pension,
		IF(s.escaner_arl!='',CONCAT('','<a href=\"javascript:popPup(\'',s.escaner_arl,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS escaner_arl,
		IF(s.escaner_caja!='',CONCAT('','<a href=\"javascript:popPup(\'',s.escaner_caja,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS escaner_caja,
		IF(s.escaner_cesan!='',CONCAT('','<a href=\"javascript:popPup(\'',s.escaner_cesan,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS escaner_cesan,
		IF(s.examen_medico!='',CONCAT('','<a href=\"javascript:popPup(\'',s.examen_medico,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS examen_medico,
		IF(s.salud_ocupacional!='',CONCAT('','<a href=\"javascript:popPup(\'',s.salud_ocupacional,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS salud_ocupacional,
		IF(s.examen_periodico!='',CONCAT('','<a href=\"javascript:popPup(\'',s.examen_periodico,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS examen_periodico,
		IF(s.examen_egreso!='',CONCAT('','<a href=\"javascript:popPup(\'',s.examen_egreso,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS examen_egreso,
		IF(s.cartas_cyc!='',CONCAT('','<a href=\"javascript:popPup(\'',s.cartas_cyc,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS cartas_cyc,
		IF(s.entrega_dotacion!='',CONCAT('','<a href=\"javascript:popPup(\'',s.entrega_dotacion,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS entrega_dotacion,
		IF(s.contrato_firmado!='',CONCAT('','<a href=\"javascript:popPup(\'',s.contrato_firmado,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS contrato_firmado,
		IF(s.foto!='',CONCAT('','<a href=\"javascript:popPup(\'',s.foto,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS foto,
		IF(s.incapacidades!='',CONCAT('','<a href=\"javascript:popPup(\'',s.incapacidades,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS incapacidades,
		IF(s.paz_salvo!='',CONCAT('','<a href=\"javascript:popPup(\'',s.paz_salvo,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS paz_salvo,
		IF(s.certi_procu!='',CONCAT('','<a href=\"javascript:popPup(\'',s.certi_procu,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS certi_procu,
		IF(s.certi_antece!='',CONCAT('','<a href=\"javascript:popPup(\'',s.certi_antece,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS certi_antece,
		IF(s.certi_contralo!='',CONCAT('','<a href=\"javascript:popPup(\'',s.certi_contralo,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS certi_contralo,
		IF(s.certi_liquidacion!='',CONCAT('','<a href=\"javascript:popPup(\'',s.certi_liquidacion,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS certi_liquidacion,
		IF(s.certi_laboral!='',CONCAT('','<a href=\"javascript:popPup(\'',s.certi_laboral,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS certi_laboral
        FROM contrato s, centro_de_costo ce WHERE $consulta_cliente AND ce.centro_de_costo_id=s.centro_de_costo_id";

	  
	  $results = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $results;
  }  

  public function getempresa_eps($contrato_id,$Conex){ 
	   	

		$select = "SELECT (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS usuario_actualizo FROM tercero t,empresa_prestaciones em WHERE t.tercero_id=em.tercero_id AND f.empresa_prestacion_nueva=em.empresa_id AND f.contrato_id=$contrato_id)AS empresa_prestacion_nueva,f.fecha_inicio FROM contrato_prestacion f WHERE f.contrato_id=$contrato_id AND f.tipo='EPS'";

	  $result_presta = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result_presta;
  }

  public function getempresa_pension($contrato_id,$Conex){ 
	   	

	   	$select = "SELECT (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS usuario_actualizo FROM tercero t,empresa_prestaciones em WHERE t.tercero_id=em.tercero_id AND f.empresa_prestacion_nueva=em.empresa_id AND f.contrato_id=$contrato_id)AS empresa_prestacion_nueva,f.fecha_inicio FROM contrato_prestacion f WHERE f.contrato_id=$contrato_id AND f.tipo='PENSION'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }

  public function getempresa_cesantias($contrato_id,$Conex){ 
	   	

	   	$select_rela_mora = "SELECT (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS usuario_actualizo FROM tercero t,empresa_prestaciones em WHERE t.tercero_id=em.tercero_id AND f.empresa_prestacion_nueva=em.empresa_id AND f.contrato_id=$contrato_id)AS empresa_prestacion_nueva,f.fecha_inicio FROM contrato_prestacion f WHERE f.contrato_id=$contrato_id AND f.tipo='CESANTIAS'";

	  $result_rela_mora = $this -> DbFetchAll($select_rela_mora,$Conex,true);		  
	  $i=0;
	  return $result_rela_mora;
  }

  public function getempresa_arl($contrato_id,$Conex){ 
	   	

	   	$select = "SELECT (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS usuario_actualizo FROM tercero t,empresa_prestaciones em WHERE t.tercero_id=em.tercero_id AND f.empresa_prestacion_nueva=em.empresa_id AND f.contrato_id=$contrato_id)AS empresa_prestacion_nueva,f.fecha_inicio FROM contrato_prestacion f WHERE f.contrato_id=$contrato_id AND f.tipo='ARL'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }

  public function getempresa_caja($contrato_id,$Conex){ 
	   	

	   	$select = "SELECT (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS usuario_actualizo FROM tercero t,empresa_prestaciones em WHERE t.tercero_id=em.tercero_id AND f.empresa_prestacion_nueva=em.empresa_id AND f.contrato_id=$contrato_id)AS empresa_prestacion_nueva,f.fecha_inicio FROM contrato_prestacion f WHERE f.contrato_id=$contrato_id AND f.tipo='CAJA$tercero_id,'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }

  public function get_licencia($contrato_id,$Conex){ 
	   	

	   	$select = "SELECT l.concepto, l.fecha_licencia,l.fecha_inicial,l.fecha_final,l.dias,IF(l.estado='A','<span style=\'color:#008000;\'>
		 ACTIVO</span>','<span style=\'color:#FF0000;\'>
		 INACTIVO</span>')AS estado,(SELECT t.nombre FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id)AS tipo_incapacidad,IF(l.remunerado=1,'SI','NO')AS remunerado,CONCAT('','<a href=\"\../../movimientos/clases/LicenciaClass.php?licencia_id=',l.licencia_id,'\" target=\"_blank\">','<input type=\"button\" class=\"btn btn-info\" value=\"VER LICENCIA\" style=\"padding: 0.055rem 0.55rem\">','</a>' )AS ver,l.diagnostico FROM licencia l WHERE l.contrato_id = $contrato_id ORDER BY l.fecha_inicial ASC";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }

  public function get_novedad($contrato_id,$Conex){ 
	   	

		   $select = "SELECT n.concepto,n.fecha_novedad,n.fecha_inicial,n.fecha_final,n.cuotas,n.valor,n.valor_cuota,(CASE WHEN n.periodicidad='H' THEN 'HORAS' WHEN n.periodicidad='D' THEN 'DIAS' WHEN n.periodicidad='S' THEN 'SEMANAL' WHEN n.periodicidad='Q' THEN 'QUINCENAL' WHEN n.periodicidad='M' THEN 'MENSUAL'END)AS periodicidad,IF(n.tipo_novedad='D','DEDUCIDO','DEVENGADO')AS tipo_novedad,IF(n.estado='A','<span style=\'color:#008000;\'>
		 ACTIVO</span>','<span style=\'color:#FF0000;\'>
		 INACTIVO</span>')AS estado,CONCAT('','<a href=\"\../../movimientos/clases/NovedadClass.php?novedad_fija_id=',n.novedad_fija_id,'\" target=\"_blank\">','<input type=\"button\" class=\"btn btn-info\" value=\"VER NOVEDAD\" style=\"padding: 0.055rem 0.55rem\">','</a>' )AS ver,(SELECT c.descripcion FROM concepto_area c WHERE c.concepto_area_id=n.concepto_area_id)AS concepto_area,IF(n.documento_anexo!='',CONCAT('','<a href=\"javascript:popPup(\'',n.documento_anexo,'\',\'1000\',\'1150\');\">','<img src=\"../../../framework/media/images/forms/visualizar.png\">','</a>' ),'N/A')AS soporte FROM novedad_fija n WHERE n.contrato_id = $contrato_id ORDER BY n.fecha_inicial ASC";
		   
	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }

  public function get_extras($contrato_id,$Conex){ 
	   	

	   	$select = "SELECT  s.*, (CASE WHEN s.estado='E' THEN 'EDICION' WHEN s.estado='A' THEN '<span style=\'color:#FF0000;\'>
		 ANULADO</span>' WHEN s.estado='P' THEN 'PROCESADO' ELSE '<span style=\'color:#008000;\'>
		 LIQUIDADO</span>' END)AS estado,(SUM(s.vr_horas_diurnas)+SUM(s.vr_horas_nocturnas)+SUM(s.vr_horas_diurnas_fes)+SUM(s.vr_horas_nocturnas_fes)+SUM(s.vr_horas_recargo_noc)+SUM(s.vr_horas_recargo_doc))AS total_valor,(SUM(s.horas_diurnas)+SUM(s.horas_nocturnas)+SUM(s.horas_diurnas_fes)+SUM(s.horas_nocturnas_fes)+SUM(s.horas_recargo_noc)+SUM(s.horas_recargo_doc))AS total_cant,CONCAT('','<a href=\"\../../movimientos/clases/ExtrasClass.php?hora_extra_id=',s.hora_extra_id,'\" target=\"_blank\">','<input type=\"button\" class=\"btn btn-info\" value=\"VER HORA EXTRA\" style=\"padding: 0.055rem 0.55rem\">','</a>' )AS ver
				FROM hora_extra s WHERE s.contrato_id = $contrato_id ORDER BY s.fecha_inicial ASC";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }


  public function getliquida_cesantias($contrato_id,$Conex){ 

	   	$select = "SELECT lc.*,IF(lc.tipo_liquidacion='T','TOTAL','PARCIAL')AS tipo_liquidacion,(CASE WHEN lc.estado='I' THEN '<span style=\'color:#FF0000;\'>
		 INACTIVO</span>' WHEN lc.estado='A' THEN 'ACTIVO' ELSE '<span style=\'color:#008000;\'>
		 CONTABILIZADO</span>' END)AS estado,CONCAT('','<a href=\"\../../movimientos/clases/CesantiasClass.php?liquidacion_cesantias_id=',lc.liquidacion_cesantias_id,'\" target=\"_blank\">','<input type=\"button\" class=\"btn btn-info\" value=\"IR A LIQUIDACION\" style=\"padding: 0.055rem 0.55rem\">','</a>' )AS ir,
		 (CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',lc.encabezado_registro_id,')\">','','<input type=\"button\" class=\"btn btn-info\" value=\"VER LIQUIDACION\" style=\"padding: 0.055rem 0.55rem\"> </a>' )) AS ver
	   	FROM liquidacion_cesantias lc 
	   	WHERE lc.contrato_id = $contrato_id ORDER BY lc.fecha_corte ASC";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }

  public function getliquida_primas($contrato_id,$Conex){ 
	   	

	 $select = "SELECT lc.*,IF(lc.periodo=1,'PRIMER SEMESTRE','SEGUNDO SEMESTRE')AS periodo,IF(lc.tipo_liquidacion='T','TOTAL','PARCIAL')AS tipo_liquidacion,(CASE WHEN lc.estado='I' THEN '<span style=\'color:#FF0000;\'>
		 INACTIVO</span>' WHEN lc.estado='A' THEN 'ACTIVO' ELSE '<span style=\'color:#008000;\'>
		 CONTABILIZADO</span>' END)AS estado,CONCAT('','<a href=\"\../../movimientos/clases/PrimaClass.php?liquidacion_prima_id=',lc.liquidacion_prima_id,'\" target=\"_blank\">','<input type=\"button\" class=\"btn btn-info\" value=\"IR A LIQUIDACION\" style=\"padding: 0.055rem 0.55rem\">','</a>' )AS ir,
		 (CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',lc.encabezado_registro_id,')\">','','<input type=\"button\" class=\"btn btn-info\" value=\"VER LIQUIDACION\" style=\"padding: 0.055rem 0.55rem\"> </a>' )) AS ver
	   	FROM liquidacion_prima lc 
	   	WHERE lc.contrato_id = $contrato_id ORDER BY lc.fecha_liquidacion ASC";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }
  public function getliquida_vacacion($contrato_id,$Conex){ 
	   	

	 $select = "SELECT lc.*,(SELECT sueldo_base FROM contrato WHERE contrato_id = lc.contrato_id)AS salario,(SELECT nombre_cargo FROM cargo WHERE cargo_id = (SELECT cargo_id FROM contrato WHERE contrato_id = lc.contrato_id))AS cargo,(CASE WHEN lc.estado='I' THEN '<span style=\'color:#FF0000;\'>
		 INACTIVO</span>' WHEN lc.estado='A' THEN 'ACTIVO' ELSE '<span style=\'color:#008000;\'>
		 CONTABILIZADO</span>' END)AS estado,CONCAT('','<a href=\"\../../movimientos/clases/VacacionClass.php?liquidacion_vacaciones_id=',lc.liquidacion_vacaciones_id,'\" target=\"_blank\">','<input type=\"button\" class=\"btn btn-info\" value=\"IR A LIQUIDACION\" style=\"padding: 0.055rem 0.55rem\">','</a>' )AS ir,
		 (CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',lc.encabezado_registro_id,')\">','','<input type=\"button\" class=\"btn btn-info\" value=\"VER LIQUIDACION\" style=\"padding: 0.055rem 0.55rem\"> </a>' )) AS ver
	   	FROM liquidacion_vacaciones lc 
	   	WHERE lc.contrato_id = $contrato_id ORDER BY lc.fecha_dis_inicio ASC";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $result;
  }
}

?>