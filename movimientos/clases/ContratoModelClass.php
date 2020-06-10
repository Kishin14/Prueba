<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class ContratoModel extends Db
{

    private $UserId;
    private $Permisos;

    public function SetUsuarioId($UserId, $CodCId)
    {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($UserId, $CodCId);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function selectDatosContratoId($contrato_id, $Conex)
    {
        $select = "SELECT
			c.*,
			(SELECT nombre_banco FROM banco WHERE banco_id = c.banco_id)as banco,
			(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
			(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id) AS cargo,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id ) AS empresa_eps,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id ) AS empresa_pension,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_arl_id AND t.tercero_id=e.tercero_id ) AS empresa_arl,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_caja_id AND t.tercero_id=e.tercero_id ) AS empresa_caja,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_cesan_id AND t.tercero_id=e.tercero_id ) AS empresa_cesan,

			(SELECT tipo FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id) AS tipo,
			(SELECT prestaciones_sociales FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id) AS prestaciones_sociales


		FROM contrato c	WHERE	c.contrato_id = $contrato_id
		";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;
    }

    public function selectTipoContratoId($tipo_contrato_id, $Conex)
    {
        $select = "SELECT *	FROM tipo_contrato	WHERE	tipo_contrato_id = $tipo_contrato_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result[0];
    }

    public function calculaFecha($tiempo_contrato, $fecha_inicio, $Conex)
    {

        $select = "SELECT DATE_ADD('$fecha_inicio', INTERVAL $tiempo_contrato MONTH) as fecha";
        $result = $this->DbFetchAll($select, $Conex, true);
        $fecha = $result[0]['fecha'];

        $select = "SELECT DATE_ADD('$fecha_inicio', INTERVAL $tiempo_contrato MONTH) as fecha";
        $result = $this->DbFetchAll($select, $Conex, true);

        $fecha = $result[0]['fecha'];

        $select = "SELECT DATE_ADD('$fecha', INTERVAL -1 DAY) as fechafin";
        $result1 = $this->DbFetchAll($select, $Conex, true);

        //$nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ));
        //$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        return $result1[0];
    }

    public function selectEstado($contrato_id, $Conex)
    {
        $select = "SELECT estado	FROM contrato	WHERE	contrato_id = $contrato_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result[0]['estado'];
    }

    public function GetARL($Conex)
    {
        return $this->DbFetchAll("SELECT categoria_arl_id  AS value,CONCAT_WS('',clase_riesgo,'-  % ',porcentaje) AS text FROM categoria_arl WHERE estado = 'A'", $Conex,
            $ErrDb = false);
    }

    public function GetTipoCuenta($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_cta_id AS value,nombre_tipo_cuenta AS text FROM tipo_cuenta", $Conex,
            $ErrDb = false);
    }

    public function Save($Campos, $Conex)
    {
        $this->Begin($Conex);
        $contrato_id = $this->DbgetMaxConsecutive("contrato", "contrato_id", $Conex, true, 1);

        $numero_contrato = $_REQUEST['numero_contrato'];
        $tipo_contrato_id = $this->requestDataForQuery('tipo_contrato_id', 'text');
        $empleado_id = $this->requestDataForQuery('empleado_id', 'integer');
        $sueldo_base = $this->requestDataForQuery('sueldo_base', 'numeric');
        $fecha_inicio = $this->requestDataForQuery('fecha_inicio', 'date');

        $select = "SELECT prefijo FROM tipo_contrato WHERE tipo_contrato_id=$tipo_contrato_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $prefijo = $result[0]['prefijo'];
        if (!strlen($numero_contrato) > 0 || $numero_contrato == 'NULL') {
            $tipo_contrato_id = $this->requestDataForQuery('tipo_contrato_id', 'text');
            $select_num = "SELECT MAX(numero_contrato+ 1) as num FROM contrato WHERE tipo_contrato_id = $tipo_contrato_id";
            $result_num = $this->DbFetchAll($select_num, $Conex, true);

            $numero_contrato = $result_num[0]['num'] > 0 ? $result_num[0]['num'] : 1;
            $this->assignValRequest('numero_contrato', $numero_contrato);
        }
        //exit($numero_contrato." -- ".$result_num[0]['num']);
        $this->assignValRequest('prefijo', $prefijo);

        $this->assignValRequest('contrato_id', $contrato_id);
        $this->DbInsertTable("contrato", $Campos, $Conex, true, false);

        $empresa_eps_id = $this->requestDataForQuery('empresa_eps_id', 'integer');
        $empresa_pension_id = $this->requestDataForQuery('empresa_pension_id', 'integer');
        $empresa_arl_id = $this->requestDataForQuery('empresa_arl_id', 'integer');
        $empresa_caja_id = $this->requestDataForQuery('empresa_caja_id', 'integer');
        $empresa_cesan_id = $this->requestDataForQuery('empresa_cesan_id', 'integer');
        $fecha_inicio = $this->requestDataForQuery('fecha_inicio', 'date');

        $fecha_ult_cesantias = $_REQUEST['fecha_ult_cesantias'];
        $fecha_ult_intcesan = $_REQUEST['fecha_ult_intcesan'];
        $fecha_ult_prima = $_REQUEST['fecha_ult_prima'];
        $fecha_ult_vaca = $_REQUEST['fecha_ult_vaca'];

        if ($empresa_eps_id > 0) {
            $contrato_afiliacion_id = $this->DbgetMaxConsecutive("contrato_afiliacion", "contrato_afiliacion_id", $Conex, true, 1);
            $insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,salud,fecha_inicio,contrato_id)
								VALUES ($contrato_afiliacion_id,$empresa_eps_id,1,$fecha_inicio,$contrato_id)";
            $this->query($insert, $Conex, true);
        }
        if ($empresa_pension_id > 0) {
            $contrato_afiliacion_id = $this->DbgetMaxConsecutive("contrato_afiliacion", "contrato_afiliacion_id", $Conex, true, 1);
            $insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,pension,fecha_inicio,contrato_id)
								VALUES ($contrato_afiliacion_id,$empresa_pension_id,1,$fecha_inicio,$contrato_id)";
            $this->query($insert, $Conex, true);
        }
        if ($empresa_arl_id > 0) {
            $contrato_afiliacion_id = $this->DbgetMaxConsecutive("contrato_afiliacion", "contrato_afiliacion_id", $Conex, true, 1);
            $insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,arl,fecha_inicio,contrato_id)
								VALUES ($contrato_afiliacion_id,$empresa_arl_id,1,$fecha_inicio,$contrato_id)";
            $this->query($insert, $Conex, true);
        }
        if ($empresa_caja_id > 0) {
            $contrato_afiliacion_id = $this->DbgetMaxConsecutive("contrato_afiliacion", "contrato_afiliacion_id", $Conex, true, 1);
            $insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,caja_compensacion,fecha_inicio,contrato_id)
								VALUES ($contrato_afiliacion_id,$empresa_caja_id,1,$fecha_inicio,$contrato_id)";
            $this->query($insert, $Conex, true);
        }

        if ($empresa_cesan_id > 0) {
            $contrato_afiliacion_id = $this->DbgetMaxConsecutive("contrato_afiliacion", "contrato_afiliacion_id", $Conex, true, 1);
            $insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,cesantias,fecha_inicio,contrato_id)
								VALUES ($contrato_afiliacion_id,$empresa_cesan_id,1,$fecha_inicio,$contrato_id)";
            $this->query($insert, $Conex, true);
        }
        if ($empresa_cesan_id > 0) {
            $contrato_afiliacion_id = $this->DbgetMaxConsecutive("contrato_afiliacion", "contrato_afiliacion_id", $Conex, true, 1);
            $insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,cesantias,fecha_inicio,contrato_id)
								VALUES ($contrato_afiliacion_id,$empresa_cesan_id,1,$fecha_inicio,$contrato_id)";
            $this->query($insert, $Conex, true);
        }
        //REGISTRO CESANTIAS HISTORIAL
        if ($fecha_ult_cesantias != '') {
            $liquidacion_cesantias_id = $this->DbgetMaxConsecutive("liquidacion_cesantias", "liquidacion_cesantias_id", $Conex, true, 1);
            $insert = "INSERT INTO liquidacion_cesantias (liquidacion_cesantias_id,fecha_liquidacion,fecha_corte,fecha_ultimo_corte,beneficiario, contrato_id, empleado_id,salario,fecha_inicio_contrato,estado,observaciones,inicial)
								VALUES ($liquidacion_cesantias_id,'$fecha_ult_cesantias','$fecha_ult_cesantias','$fecha_ult_cesantias','2',$contrato_id,$empleado_id,$sueldo_base,$fecha_inicio,'C' ,'REGISTRO INICIAL CONTRATO',1)";
            $this->query($insert, $Conex, true);
        }
        //REGISTRO INT CESANTIAS HISTORIAL
        if ($fecha_ult_intcesan != '') {
            $liquidacion_int_cesantias_id = $this->DbgetMaxConsecutive("liquidacion_int_cesantias", "liquidacion_int_cesantias_id", $Conex, true, 1);
            $insert = "INSERT INTO liquidacion_int_cesantias (liquidacion_int_cesantias_id,fecha_liquidacion,fecha_corte,fecha_ultimo_corte,beneficiario, contrato_id, empleado_id,salario,fecha_inicio_contrato,estado,observaciones,inicial)
								VALUES ($liquidacion_int_cesantias_id,'$fecha_ult_intcesan','$fecha_ult_intcesan','$fecha_ult_intcesan','2',$contrato_id,$empleado_id,$sueldo_base,$fecha_inicio,'C' ,'REGISTRO INICIAL CONTRATO',1)";
            $this->query($insert, $Conex, true);
        }
        //REGISTRO PRIMA HISTORIAL
        if ($fecha_ult_prima != '') {
            $periodo = intval(substr($fecha_ult_prima, 5, 2)) >= 7 ? 2 : 1;
            $liquidacion_prima_id = $this->DbgetMaxConsecutive("liquidacion_prima", "liquidacion_prima_id", $Conex, true, 1);
            $insert = "INSERT INTO liquidacion_prima (liquidacion_prima_id,fecha_liquidacion,estado,contrato_id,total,tipo_liquidacion,periodo,observaciones,inicial)
								VALUES ($liquidacion_prima_id,'$fecha_ult_prima','C',$contrato_id,0,'T',$periodo,'REGISTRO INICIAL CONTRATO',1)";
            $this->query($insert, $Conex, true);
        }

        //REGISTRO VACACIONES HISTORIAL
        if ($fecha_ult_vaca != '') {

            $liquidacion_vacaciones_id = $this->DbgetMaxConsecutive("liquidacion_vacaciones", "liquidacion_vacaciones_id", $Conex, true, 1);
            $insert = "INSERT INTO liquidacion_vacaciones (liquidacion_vacaciones_id,contrato_id,fecha_liquidacion,fecha_reintegro,dias,concepto,observaciones,estado,inicial)
								VALUES ($liquidacion_vacaciones_id,$contrato_id,'$fecha_ult_vaca','$fecha_ult_vaca',0,'REGISTRO INICIAL CONTRATO','REGISTRO INICIAL CONTRATO','C',1)";
            $this->query($insert, $Conex, true);
        }

        $this->Commit($Conex);
    }

    public function Update($Campos,$usuario_id,$Conex)
    {
		
        $this->Begin($Conex);

        ///////registro cambio prestaciones inicio ///////////////////

        $contrato_prestacion_id = $this->DbgetMaxConsecutive("contrato_prestacion", "contrato_prestacion_id", $Conex, true, 1);
        $fecha_inicio_eps = $this->requestDataForQuery('fecha_inicio_eps', 'date');
		$observacion_ren = $this->requestDataForQuery('desc_actualizacion', 'text');
        $fecha_inicio_pension = $this->requestDataForQuery('fecha_inicio_pension', 'date');
        $fecha_inicio_arl = $this->requestDataForQuery('fecha_inicio_arl', 'date');
        $fecha_inicio_compensacion = $this->requestDataForQuery('fecha_inicio_compensacion', 'date');
        $fecha_inicio_cesantias = $this->requestDataForQuery('fecha_inicio_cesantias', 'date');

        $empresa_eps_id = $this->requestDataForQuery('empresa_eps_id', 'integer');
        $empresa_pension_id = $this->requestDataForQuery('empresa_pension_id', 'integer');
        $empresa_arl_id = $this->requestDataForQuery('empresa_arl_id', 'integer');
        $empresa_caja_id = $this->requestDataForQuery('empresa_caja_id', 'integer');
        $empresa_cesan_id = $this->requestDataForQuery('empresa_cesan_id', 'integer');

        $contrato_id = $this->requestDataForQuery('contrato_id', 'integer');

        $select = "SELECT empresa_eps_id,empresa_pension_id,empresa_arl_id,empresa_caja_id,empresa_cesan_id FROM contrato WHERE contrato_id = $contrato_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $empresa_eps_vieja = $result[0]['empresa_eps_id'];
        $empresa_pension_vieja = $result[0]['empresa_pension_id'];
        $empresa_arl_vieja = $result[0]['empresa_arl_id'];
        $empresa_caja_vieja = $result[0]['empresa_caja_id'];
        $empresa_cesan_vieja = $result[0]['empresa_cesan_id'];

        if (($empresa_eps_id != $empresa_eps_vieja) && ($empresa_eps_vieja != '' && $empresa_eps_id != 'NULL')) {
            $insert = "INSERT INTO contrato_prestacion (contrato_prestacion_id,contrato_id,fecha_inicio,empresa_prestacion_antigua,empresa_prestacion_nueva,tipo)
									VALUES ($contrato_prestacion_id,$contrato_id,$fecha_inicio_eps,$empresa_eps_vieja,$empresa_eps_id,'EPS')";
            $this->query($insert, $Conex, true);

        }

        if (($empresa_arl_id != $empresa_arl_vieja) && ($empresa_arl_vieja != '' && $empresa_arl_id != 'NULL')) {
            $contrato_prestacion_id = $this->DbgetMaxConsecutive("contrato_prestacion", "contrato_prestacion_id", $Conex, true, 1);
            //  exit($fecha_inicio_arl.' fecha '.$empresa_arl_vieja.' vieja'.$empresa_arl_id.' nueva');
            $insert_arl = "INSERT INTO contrato_prestacion (contrato_prestacion_id,contrato_id,fecha_inicio,empresa_prestacion_antigua,empresa_prestacion_nueva,tipo)
										VALUES ($contrato_prestacion_id,$contrato_id,$fecha_inicio_arl,$empresa_arl_vieja,$empresa_arl_id,'ARL')";
            $this->query($insert_arl, $Conex, true);

        }
        if (($empresa_pension_id != $empresa_pension_vieja) && ($empresa_pension_vieja != '' && $empresa_pension_id != 'NULL')) {
            $contrato_prestacion_id = $this->DbgetMaxConsecutive("contrato_prestacion", "contrato_prestacion_id", $Conex, true, 1);
            $insert_pension = "INSERT INTO contrato_prestacion (contrato_prestacion_id,contrato_id,fecha_inicio,empresa_prestacion_antigua,empresa_prestacion_nueva,tipo)
									VALUES ($contrato_prestacion_id,$contrato_id,$fecha_inicio_pension,$empresa_pension_vieja,$empresa_pension_id,'PENSION')";
            $this->query($insert_pension, $Conex, true);
        }
        if (($empresa_caja_id != $empresa_caja_vieja) && ($empresa_caja_vieja != '' && $empresa_caja_id != 'NULL')) {
            $contrato_prestacion_id = $this->DbgetMaxConsecutive("contrato_prestacion", "contrato_prestacion_id", $Conex, true, 1);
            $insert_caja = "INSERT INTO contrato_prestacion (contrato_prestacion_id,contrato_id,fecha_inicio,empresa_prestacion_antigua,empresa_prestacion_nueva,tipo)
									VALUES ($contrato_prestacion_id,$contrato_id,$fecha_inicio_compensacion,$empresa_caja_vieja,$empresa_caja_id,'CAJA')";
            $this->query($insert_caja, $Conex, true);
        }
        if (($empresa_cesan_id != $empresa_cesan_vieja) && ($empresa_cesan_vieja != '' && $empresa_cesan_id != 'NULL')) {
            $contrato_prestacion_id = $this->DbgetMaxConsecutive("contrato_prestacion", "contrato_prestacion_id", $Conex, true, 1);
            $insert_cesan = "INSERT INTO contrato_prestacion (contrato_prestacion_id,contrato_id,fecha_inicio,empresa_prestacion_antigua,empresa_prestacion_nueva,tipo)
									VALUES ($contrato_prestacion_id,$contrato_id,$fecha_inicio_cesantias,$empresa_cesan_vieja,$empresa_cesan_id,'CESANTIAS')";
            $this->query($insert_cesan, $Conex, true);
        }

        ///////registro cambio prestaciones fin ///////////////////

        if ($_REQUEST['contrato_id'] == 'NULL') {
            $this->DbInsertTable("contrato", $Campos, $Conex, true, false);
        } else {
            $this->DbUpdateTable("contrato", $Campos, $Conex, true, false);
        }

        // $contrato_id = $this -> requestDataForQuery('contrato_id','integer');
        $empleado_id = $this->requestDataForQuery('empleado_id', 'integer');
        $sueldo_base = $this->requestDataForQuery('sueldo_base', 'numeric');
        $fecha_inicio = $this->requestDataForQuery('fecha_inicio', 'date');

        $fecha_ult_cesantias = $_REQUEST['fecha_ult_cesantias'];
        $fecha_ult_intcesan = $_REQUEST['fecha_ult_intcesan'];
        $fecha_ult_prima = $_REQUEST['fecha_ult_prima'];
        $fecha_ult_vaca = $_REQUEST['fecha_ult_vaca'];

        //REGISTRO CESANTIAS HISTORIAL
        if ($fecha_ult_cesantias != '') {

            $select = "SELECT liquidacion_cesantias_id	FROM liquidacion_cesantias	WHERE	contrato_id = $contrato_id AND inicial=1 AND estado='C'";
            $result = $this->DbFetchAll($select, $Conex, true);
            if (count($result) == 0) {
                $liquidacion_cesantias_id = $this->DbgetMaxConsecutive("liquidacion_cesantias", "liquidacion_cesantias_id", $Conex, true, 1);
                $insert = "INSERT INTO liquidacion_cesantias (liquidacion_cesantias_id,fecha_liquidacion,fecha_corte,fecha_ultimo_corte,beneficiario, contrato_id, empleado_id,salario,fecha_inicio_contrato,estado,observaciones,inicial)
									VALUES ($liquidacion_cesantias_id,'$fecha_ult_cesantias','$fecha_ult_cesantias','$fecha_ult_cesantias','2',$contrato_id,$empleado_id,$sueldo_base,$fecha_inicio,'C' ,'REGISTRO INICIAL CONTRATO',1)";
                $this->query($insert, $Conex, true);
            }
        }
        //REGISTRO INT CESANTIAS HISTORIAL
        if ($fecha_ult_intcesan != '') {
            $select = "SELECT liquidacion_int_cesantias_id	FROM liquidacion_int_cesantias	WHERE	contrato_id = $contrato_id AND inicial=1 AND estado='C'";
            $result = $this->DbFetchAll($select, $Conex, true);
            if (count($result) == 0) {

                $liquidacion_int_cesantias_id = $this->DbgetMaxConsecutive("liquidacion_int_cesantias", "liquidacion_int_cesantias_id", $Conex, true, 1);
                $insert = "INSERT INTO liquidacion_int_cesantias (liquidacion_int_cesantias_id,fecha_liquidacion,fecha_corte,fecha_ultimo_corte,beneficiario, contrato_id, empleado_id,salario,fecha_inicio_contrato,estado,observaciones,inicial)
									VALUES ($liquidacion_int_cesantias_id,'$fecha_ult_intcesan','$fecha_ult_intcesan','$fecha_ult_intcesan','2',$contrato_id,$empleado_id,$sueldo_base,$fecha_inicio,'C' ,'REGISTRO INICIAL CONTRATO',1)";
                $this->query($insert, $Conex, true);
            }
        }
        //REGISTRO PRIMA HISTORIAL
        if ($fecha_ult_prima != '') {
            $select = "SELECT liquidacion_prima_id	FROM liquidacion_prima	WHERE	contrato_id = $contrato_id AND inicial=1 AND estado='C'";
            $result = $this->DbFetchAll($select, $Conex, true);
            if (count($result) == 0) {

                $periodo = intval(substr($fecha_ult_prima, 5, 2)) >= 7 ? 2 : 1;
                $liquidacion_prima_id = $this->DbgetMaxConsecutive("liquidacion_prima", "liquidacion_prima_id", $Conex, true, 1);
                $insert = "INSERT INTO liquidacion_prima (liquidacion_prima_id,fecha_liquidacion,estado,contrato_id,total,tipo_liquidacion,periodo,observaciones,inicial)
									VALUES ($liquidacion_prima_id,'$fecha_ult_prima','C',$contrato_id,0,'T',$periodo,'REGISTRO INICIAL CONTRATO',1)";
                $this->query($insert, $Conex, true);
            }
        }

//REGISTRO VACACIONES HISTORIAL
if ($fecha_ult_vaca != '') {
    $select = "SELECT liquidacion_vacaciones_id	FROM liquidacion_vacaciones	WHERE	contrato_id = $contrato_id AND inicial=1 AND estado='C'";
    $result = $this->DbFetchAll($select, $Conex, true);
    if (count($result) == 0) {

        $liquidacion_vacaciones_id = $this->DbgetMaxConsecutive("liquidacion_vacaciones", "liquidacion_vacaciones_id", $Conex, true, 1);
        $insert = "INSERT INTO liquidacion_vacaciones (liquidacion_vacaciones_id,contrato_id,fecha_liquidacion,fecha_reintegro,dias,concepto,observaciones,estado,inicial)
								VALUES ($liquidacion_vacaciones_id,$contrato_id,'$fecha_ult_vaca','$fecha_ult_vaca',0,'REGISTRO INICIAL CONTRATO','REGISTRO INICIAL CONTRATO','C',1)";
        $this->query($insert, $Conex, true);

        $select_contrato = "SELECT DATEDIFF(CURDATE(),$fecha_inicio) as dias_trabajados
						FROM contrato WHERE contrato_id = $contrato_id AND estado='A'";
        $result_contrato = $this->DbFetchAll($select_contrato, $Conex);

        $dias_trabajados = $result_contrato[0]['dias_trabajados'];

        $anios = $anios = intval(intval($dias_trabajados) / 360);
        $fecha_aux = $_REQUEST['fecha_inicio'];

        $i = 0;
        for ($i = 0; $i < $anios; $i++) {

            $select_periodo = "SELECT DATE_ADD('$fecha_aux',INTERVAL 1 YEAR) as fecha_fin";
            $result_periodo = $this->DbFetchAll($select_periodo, $Conex);

            $periodo[$i]['fecha_inicial'] = $fecha_aux;
            $periodo[$i]['fecha_final'] = $result_periodo[0]['fecha_fin'];
            $periodo[$i]['dias_ganados'] = 15;
            $fecha_aux = $result_periodo[0]['fecha_fin'];

            if ($fecha_ult_vaca >= $periodo[$i]['fecha_inicial'] && $fecha_ult_vaca <= $periodo[$i]['fecha_final']) {
                $detalle_liquidacion_vacaciones_id = $this->DbgetMaxConsecutive("detalle_liquidacion_vacaciones", "detalle_liquidacion_vacaciones_id", $Conex, true, 1);
                $insert_detalle = "INSERT INTO detalle_liquidacion_vacaciones (detalle_liquidacion_vacaciones_id,liquidacion_vacaciones_id,periodo_inicio,periodo_fin,dias_ganados,dias_disfrutados,dias_pagados) VALUES ($detalle_liquidacion_vacaciones_id,$liquidacion_vacaciones_id," . "'" . $periodo[$i]['fecha_inicial'] . "'" . "," . "'" . $periodo[$i]['fecha_final'] . "'" . "," . $periodo[$i]['dias_ganados'] . "," . $periodo[$i]['dias_ganados'] . ",0)";
                $this->query($insert_detalle, $Conex, true);
                break;
            }
        }
    }
}


        $this->Commit($Conex);
		$fecha = date("Y-m-d H:i:s");
		
        $update1 = "UPDATE historial_contrato SET
					  observacion_ren=$observacion_ren,fecha_actualizacion='$fecha',usuario_actualiza_id=$usuario_id
				    WHERE contrato_id = $contrato_id";

        $this->query($update1, $Conex, true);

    }

    public function Delete($Campos, $Conex)
    {
        $this->DbDeleteTable("contrato", $Campos, $Conex, true, false);
    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "contrato", $Campos);
        return $Data->GetData();
    }

    public function GetCosto($Conex)
    {
        return $this->DbFetchAll("SELECT centro_de_costo_id  AS value, nombre AS text FROM centro_de_costo ORDER BY nombre ASC", $Conex,
            $ErrDb = false);
    }

    public function GetCausal($Conex)
    {
        return $this->DbFetchAll("SELECT causal_despido_id  AS value, nombre AS text FROM causal_despido WHERE estado='A' ORDER BY nombre ASC", $Conex,
            $ErrDb = false);
    }

    public function GetTip($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_contrato_id  AS value, nombre AS text FROM tipo_contrato ORDER BY nombre ASC", $Conex,
            $ErrDb = false);
    }

    public function GetMot($Conex)
    {
        return $this->DbFetchAll("SELECT motivo_terminacion_id  AS value, nombre AS text FROM motivo_terminacion ORDER BY nombre ASC", $Conex,
            $ErrDb = false);
    }

    public function GetQueryContratoGrid()
    {

        $Query = "SELECT
		    c.numero_contrato,
			c.fecha_inicio,
			c.fecha_terminacion,
			c.fecha_terminacion_real,
			(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado_id,
			 (SELECT t.numero_identificacion FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS cedula,
			(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato_id,
			(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo_id,
			(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion_id,
			c.sueldo_base,
			c.subsidio_transporte,
			(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo_id,
			CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
			(SELECT CONCAT_WS('',clase_riesgo,'-  % ',porcentaje) FROM categoria_arl WHERE categoria_arl_id =c.categoria_arl_id)as categoria_arl,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id ) AS empresa_eps,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id ) AS empresa_pension,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_arl_id AND t.tercero_id=e.tercero_id ) AS empresa_arl,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_caja_id AND t.tercero_id=e.tercero_id ) AS empresa_caja,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_cesan_id AND t.tercero_id=e.tercero_id ) AS empresa_cesan,
			(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido_id,
			CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO'  WHEN 'AN' THEN 'ANULADO' WHEN 'L' THEN 'LICENCIA' ELSE '' END AS estado

		FROM
			contrato c
		";
        return $Query;
    }
}
