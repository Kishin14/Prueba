<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class LiquidacionFinalModel extends Db
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

    public function Save($usuario_id, $Campos, $datos, $datos_con, $Conex)
    {
        $this->Begin($Conex);

        $liquidacion_definitiva_id = $this->DbgetMaxConsecutive("liquidacion_definitiva", "liquidacion_definitiva_id", $Conex, true, 1);

        $this->assignValRequest('liquidacion_definitiva_id', $liquidacion_definitiva_id);
        $this->assignValRequest('usuario_id', $usuario_id);
        $this->assignValRequest('fecha_registro', date('Y-m-d H:i'));

        $this->DbInsertTable("liquidacion_definitiva", $Campos, $Conex, true, false);
        $contrato_id = $_REQUEST['contrato_id'];

        for ($i = 0; $i < count($datos); $i++) {
            $fecha_inicio = $datos[$i]['fecha_inicio'];
            $fecha_fin = $datos[$i]['fecha_fin'];
            $dias = $datos[$i]['dias'];
            $valor = $datos[$i]['valor'];
            $concepto = $datos[$i]['concepto'];
            $empresa_id = $datos[$i]['empresa_id'];
            $concepto_area_id = $datos[$i]['concepto_area_id'];

            if ($datos[$i]['tipo'] == 'P') {
                //prestaciones sociales
                $liq_def_prestacion_id = $this->DbgetMaxConsecutive("liq_def_prestacion", "liq_def_prestacion_id", $Conex, true, 1);
                $insert = "INSERT INTO liq_def_prestacion (liq_def_prestacion_id,liquidacion_definitiva_id,fecha_inicio,fecha_fin,dias,valor,concepto,empresa_id)
			VALUES ($liq_def_prestacion_id,$liquidacion_definitiva_id,'$fecha_inicio','$fecha_fin',$dias,$valor,'$concepto',$empresa_id)";
                $this->query($insert, $Conex, true);

            } elseif ($datos[$i]['tipo'] == 'I') {
                //indemnizaciones
                $liq_def_indemnizacion_id = $this->DbgetMaxConsecutive("liq_def_indemnizacion", "liq_def_indemnizacion_id", $Conex, true, 1);
                $insert = "INSERT INTO liq_def_indemnizacion (liq_def_indemnizacion_id,liquidacion_definitiva_id,fecha_inicio,fecha_fin,dias,valor,concepto)
			VALUES ($liq_def_indemnizacion_id,$liquidacion_definitiva_id,'$fecha_inicio','$fecha_fin',$dias,$valor,'$concepto')";
                $this->query($insert, $Conex, true);

            } elseif ($datos[$i]['tipo'] == 'S') {
                //salarios pendientes
                $liq_def_salario_id = $this->DbgetMaxConsecutive("liq_def_salario", "liq_def_salario_id", $Conex, true, 1);
                $insert = "INSERT INTO liq_def_salario (liq_def_salario_id,liquidacion_definitiva_id,fecha_inicio,fecha_fin,dias,valor,concepto)
			VALUES ($liq_def_salario_id,$liquidacion_definitiva_id,'$fecha_inicio','$fecha_fin',$dias,$valor,'$concepto')";
                $this->query($insert, $Conex, true);

            } elseif ($datos[$i]['tipo'] == 'D') {
                //deducciones
                $liq_def_deduccion_id = $this->DbgetMaxConsecutive("liq_def_deduccion", "liq_def_deduccion_id", $Conex, true, 1);
                $insert = "INSERT INTO liq_def_deduccion (liq_def_deduccion_id,liquidacion_definitiva_id,concepto,fecha_inicio,fecha_fin,dias,valor,concepto_area_id,empresa_id)
			VALUES ($liq_def_deduccion_id,$liquidacion_definitiva_id,'$concepto',$fecha_inicio,$fecha_fin,$dias,$valor,$concepto_area_id,$empresa_id)";
                $this->query($insert, $Conex, true);

            } elseif ($datos[$i]['tipo'] == 'V') {
                //devengados
                $liq_def_devengado_id = $this->DbgetMaxConsecutive("liq_def_devengado", "liq_def_devengado_id", $Conex, true, 1);
                $insert = "INSERT INTO liq_def_devengado (liq_def_devengado_id,liquidacion_definitiva_id,concepto,fecha_inicio,fecha_fin,dias,valor,concepto_area_id,empresa_id)
			VALUES ($liq_def_devengado_id,$liquidacion_definitiva_id,'$concepto',$fecha_inicio,$fecha_fin,$dias,$valor,$concepto_area_id,$empresa_id)";
                $this->query($insert, $Conex, true);

            }

        }

        for ($i = 0; $i < count($datos_con); $i++) {
            $valor = $datos_con[$i]['valor'];
            $concepto = $datos_con[$i]['concepto'];
            $puc_id = $datos_con[$i]['puc_id'];
            $debito = $datos_con[$i]['debito'];
            $credito = $datos_con[$i]['credito'];
            $tercero_id = $datos_con[$i]['tercero_id'];

            $liq_def_puc_id = $this->DbgetMaxConsecutive("liq_def_puc", "liq_def_puc_id", $Conex, true, 1);
            $insert = "INSERT INTO liq_def_puc (liq_def_puc_id,liquidacion_definitiva_id,concepto,puc_id,valor,debito,credito,tercero_id)
			VALUES ($liq_def_puc_id,$liquidacion_definitiva_id,'$concepto',$puc_id,$valor,$debito,$credito,$tercero_id)";
            $this->query($insert, $Conex, true);

        }

        $this->Commit($Conex);
        return $liquidacion_definitiva_id;

    }

    public function Update($Campos, $Conex)
    {
        $this->Begin($Conex);
        $this->DbUpdateTable("liquidacion_definitiva", $Campos, $Conex, true, false);
        $this->Commit($Conex);
    }

    public function GetMotivoTer($Conex)
    {
        return $this->DbFetchAll("SELECT motivo_terminacion_id AS value,nombre AS text FROM motivo_terminacion ORDER BY nombre ASC", $Conex, $ErrDb = false);
    }

    public function GetCausalDes($Conex)
    {
        return $this->DbFetchAll("SELECT causal_despido_id AS value,nombre AS text FROM causal_despido ORDER BY nombre ASC", $Conex, $ErrDb = false);
    }

    public function getCausalesAnulacion($Conex)
    {

        $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion WHERE documento!='RM' ORDER BY nombre";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;
    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "liquidacion_definitiva", $Campos);
        return $Data->GetData();
    }

    public function selectDatosLiquidacionFinalId($liquidacion_definitiva_id, $Conex)
    {

        $select = "SELECT l.*,
	(SELECT CONCAT_WS(' ',c.numero_contrato, '-', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido ) FROM contrato c, empleado e, tercero t
	WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS contrato
	FROM liquidacion_definitiva l  WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";
        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);
        return $result;

    }

    public function selectContrato($contrato_id, $Conex)
    {

        $select = "SELECT * FROM contrato  WHERE contrato_id = $contrato_id";
        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);
        return $result;

    }

    public function GetQueryLiquidacionFinalGrid()
    {
        $Query = "SELECT l.liquidacion_definitiva_id ,l.fecha_inicio, l.fecha_final,
	(SELECT CONCAT_WS(' ',c.numero_contrato, '-', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido ) FROM contrato c, empleado e, tercero t
	WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS contrato,
	(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=l.encabezado_registro_id) AS documento,
	CASE l.estado WHEN 'E' THEN 'EDICION' WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CONTABILIZADO' ELSE 'N/C' END AS estado
    FROM liquidacion_definitiva l ORDER BY l.liquidacion_definitiva_id DESC";
        return $Query;
    }

    public function getDias($fecha_inicio, $fecha_final, $Conex)
    {
        $select = "SELECT (DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),ADDDATE('$fecha_inicio', INTERVAL 1 DAY))) AS dias";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result[0]['dias'];
    }

    public function getDetallesLiquidacion($liquidacion_definitiva_id, $Conex)
    {

        if (is_numeric($liquidacion_definitiva_id)) {

            $select = "SELECT d.*,
		(SELECT codigo_puc FROM puc WHERE puc_id=d.puc_id) AS puc
		FROM detalle_liquidacion_novedad d WHERE d.liquidacion_novedad_id = $liquidacion_novedad_id ORDER BY detalle_liquidacion_novedad_id ASC";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesContrato($contrato_id, $dias, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT c.*,
		(SELECT t.prestaciones_sociales FROM tipo_contrato t WHERE t.tipo_contrato_id=c.tipo_contrato_id) as prestaciones,
		(((sueldo_base+subsidio_transporte)*$dias)/360) AS cesantias,
		((((sueldo_base+subsidio_transporte)*0.12)*$dias)/360) AS int_cesantias,
		(((sueldo_base+subsidio_transporte)*$dias)/360) AS prima_servicios,
		(((sueldo_base+subsidio_transporte)*$dias)/720) AS prima_vacaciones,
		(SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id) AS tercero_id,
		(SELECT ep.tercero_id FROM empresa_prestaciones ep WHERE ep.empresa_id=c.empresa_eps_id) AS tercero_eps_id,
		(SELECT ep.tercero_id FROM empresa_prestaciones ep WHERE ep.empresa_id=c.empresa_pension_id) AS tercero_pension_id

		FROM contrato c
		WHERE c.contrato_id = $contrato_id";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesCesantias($contrato_id, $fecha_final, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'), ADDDATE(l.fecha_corte, INTERVAL 1 DAY)) AS dias_dif,  ADDDATE(l.fecha_corte, INTERVAL 1 DAY) AS fecha_corte
		FROM liquidacion_cesantias l
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' ORDER BY l.fecha_ultimo_corte DESC LIMIT 1";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesIntCesantias($contrato_id, $fecha_final, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),ADDDATE(l.fecha_corte, INTERVAL 1 DAY)) AS dias_dif, ADDDATE(l.fecha_corte, INTERVAL 1 DAY) AS fecha_corte
		FROM liquidacion_int_cesantias l
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' ORDER BY l.fecha_ultimo_corte DESC LIMIT 1";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesVacaciones($contrato_id, $fecha_final, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT SUM(dl.dias_disfrutados) AS dias_va,
		(SELECT dlv.periodo_fin FROM liquidacion_vacaciones lv, detalle_liquidacion_vacaciones dlv
		 WHERE lv.contrato_id = $contrato_id AND lv.estado!='I' AND dlv.liquidacion_vacaciones_id=lv.liquidacion_vacaciones_id ORDER BY dlv.periodo_fin DESC LIMIT 1 ) AS fecha_ultima
		FROM liquidacion_vacaciones l, detalle_liquidacion_vacaciones dl
		WHERE l.contrato_id = $contrato_id AND l.estado!='I' AND dl.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id ";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesPrima($contrato_id, $fecha_final, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT l.fecha_liquidacion, l.periodo, l.inicial
		FROM liquidacion_prima l
        WHERE l.contrato_id = $contrato_id AND l.estado!='I' ORDER BY l.fecha_liquidacion DESC LIMIT 1";
            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesDeducciones($contrato_id, $dias, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT c.*
		FROM novedad_fija c
		WHERE c.contrato_id = $contrato_id AND c.estado='A' AND tipo_novedad='D'";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesDevengado($contrato_id, $dias, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT c.*
		FROM novedad_fija c
		WHERE c.contrato_id = $contrato_id AND c.estado='A' AND tipo_novedad='V'";
//echo $select;
            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesDeduccionesDetalle($contrato_id, $concepto_area_id, $fecha_final, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT SUM(dl.credito) AS valor
		FROM liquidacion_novedad l, detalle_liquidacion_novedad dl
		WHERE l.contrato_id = $contrato_id AND l.estado!='A' AND dl.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.fecha_final='$fecha_final'  AND dl.concepto_area_id IS NOT NULL";
//echo $select;
            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesDevengadoDetalle($contrato_id, $concepto_area_id, $fecha_final, $Conex)
    {
        if ($contrato_id > 0) {

            $select = "SELECT dl.debito AS valor
		FROM liquidacion_novedad l, detalle_liquidacion_novedad dl
		WHERE l.contrato_id = $contrato_id AND l.estado!='A' AND dl.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.fecha_final='$fecha_final'  AND dl.concepto_area_id IS NOT NULL";
//echo $select;
            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesSalario($contrato_id, $fecha_final, $Conex)
    {

        if ($contrato_id > 0) {

            $select = "SELECT DATEDIFF(CONCAT_WS(' ','$fecha_final','23:59:59'),l.fecha_final) AS dias_dif, l.fecha_final
		FROM liquidacion_novedad l
		WHERE l.contrato_id = $contrato_id AND l.estado!='A' ORDER BY l.fecha_final DESC LIMIT 1";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDatosperiodo($periodo, $Conex)
    {

        if ($periodo > 0) {

            $select = "SELECT *
		FROM datos_periodo
		WHERE 	periodo_contable_id = (SELECT 	periodo_contable_id FROM periodo_contable WHERE anio=$periodo)";

            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getParametroCesan($oficina_id, $Conex)
    {
        if ($oficina_id > 0) {
            $select_parametros = "SELECT
			puc_cesantias_prov_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_prov_id) as natu_puc_cesantias_prov,
			puc_cesantias_cons_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_cons_id) as natu_puc_cesantias_cons,
			puc_cesantias_contra_id,
			puc_admon_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_admon_cesantias_id) as natu_puc_admon_cesantias,
			puc_ventas_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_prov_id) as natu_puc_ventas_cesantias,
			puc_produ_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_prov_id) as natu_puc_produ_cesantias,

			puc_int_cesantias_prov_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_prov_id) as natu_puc_int_cesantias_prov,
			puc_int_cesantias_cons_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_cons_id) as natu_puc_int_cesantias_cons,
			puc_int_cesantias_contra_id,
			puc_admon_int_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_admon_int_cesantias_id) as natu_puc_admon_int_cesantias,
			puc_ventas_int_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_prov_id) as natu_puc_ventas_int_cesantias,
			puc_produ_int_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_prov_id) as natu_puc_produ_int_cesantias,
			puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,
			puc_vac_prov_id,puc_vac_cons_id,puc_vac_contra_id,puc_admon_vac_id,puc_ventas_vac_id,puc_produ_vac_id,puc_salud_vac_id,puc_pension_vac_id,

			tipo_documento_id
		FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
            $result = $this->DbFetchAll($select_parametros, $Conex, true);
        } else {
            $result = array();
        }
        return $result;
    }

    public function getSaldosConsProv($puc_id, $tercero_id, $hasta, $Conex)
    {
        if ($tercero_id > 0) {
            $select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable
			WHERE puc_id=$puc_id AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE fecha<='$hasta')";
            $result = $this->DbFetchAll($select_consolidado, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getPucConcepto($concepto_area_id, $Conex)
    {
        if ($concepto_area_id > 0) {
            $select_consolidado = "SELECT * FROM concepto_area
			WHERE concepto_area_id=$concepto_area_id";
            $result = $this->DbFetchAll($select_consolidado, $Conex, true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function comprobar_estado($liquidacion_definitiva_id, $Conex)
    {

        $select = "SELECT l.estado,l.encabezado_registro_id, l.encabezado_registro_id,l.fecha_inicio,l.fecha_final,
   			(SELECT p.estado  FROM encabezado_de_registro e,	periodo_contable p
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.periodo_contable_id=e.periodo_contable_id) AS estado_periodo,
			(SELECT p.estado  FROM encabezado_de_registro e,	mes_contable p
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.mes_contable_id=e.mes_contable_id) AS estado_mes
   			FROM liquidacion_definitiva l
			WHERE l.liquidacion_definitiva_id=$liquidacion_definitiva_id";
        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

        return $result;
    }

    public function cancellation($liquidacion_definitiva_id, $encabezado_registro_id, $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $Conex)
    {
        $this->Begin($Conex);

        $update = "UPDATE liquidacion_definitiva SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	        fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id";
        $this->query($update, $Conex, true);

        if ($encabezado_registro_id > 0) {

            $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS
                encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
                forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
                fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
                $observacion_anulacion AS observaciones,$usuario_anulo_id AS usuario_anula,fecha_anulacion,usuario_actualiza,fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";

            $this->query($insert, $Conex, true);

            $insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS
                imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS
                encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,
			    area_id,departamento_id,unidad_negocio_id,sucursal_id FROM
                imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";

            $this->query($insert, $Conex, true);

            $update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";

            $this->query($update, $Conex, true);

            $update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";

            $this->query($update, $Conex, true);

        }

        $this->Commit($Conex);

    }

    public function getTotalDebitoCredito($liquidacion_definitiva_id, $Conex)
    {

        $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito
	  FROM liq_def_puc  WHERE liquidacion_definitiva_id=$liquidacion_definitiva_id";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function getContabilizarReg($liquidacion_definitiva_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $Conex)
    { //contabilizar uno

        include_once "UtilidadesContablesModelClass.php";
        $utilidadesContables = new UtilidadesContablesModel();

        $this->Begin($Conex);

        $select = "SELECT f.*,
					(SELECT tipo_documento_id FROM datos_periodo WHERE periodo_contable_id =(SELECT periodo_contable_id FROM periodo_contable WHERE anio=YEAR(DATE(f.fecha_final )) ) ) AS tipo_documento_id,
					(SELECT SUM(debito+credito) FROM liq_def_puc WHERE liquidacion_definitiva_id=f.liquidacion_definitiva_id AND concepto LIKE '%A PAGAR%') AS valor,
					(SELECT t.numero_identificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
					(SELECT t.digito_verificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
					(SELECT e.tercero_id FROM contrato c, empleado e WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id ) AS tercero_id,

					(SELECT c.centro_de_costo_id FROM contrato c WHERE c.contrato_id=f.contrato_id  ) AS centro_de_costo_id,
					(SELECT cc.codigo FROM contrato c, centro_de_costo cc WHERE c.contrato_id=f.contrato_id AND cc.centro_de_costo_id=c.centro_de_costo_id ) AS codigo_centro

					FROM liquidacion_definitiva f WHERE f.liquidacion_definitiva_id=$liquidacion_definitiva_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        $select_emp = "SELECT tercero_id FROM empresa	WHERE empresa_id=$empresa_id";
        $result_emp = $this->DbFetchAll($select_emp, $Conex);

        $select_cc = "SELECT 	centro_de_costo_id, codigo FROM centro_de_costo	WHERE oficina_id=$oficina_id";
        $result_cc = $this->DbFetchAll($select_cc, $Conex);

        $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
        $result_usu = $this->DbFetchAll($select_usu, $Conex);

        $contrato_id = $result[0]['contrato_id'];
        $tipo_documento_id = $result[0]['tipo_documento_id'];
        $valor = $result[0]['valor'];
        $numero_soporte = $result[0]['consecutivo'];
        $tercero_id = $result_emp[0]['tercero_id'];
        $terceroid = $result[0]['tercero_id'];
        $numero_identificacion = $result[0]['numero_identificacion'];
        $digito_verificacion = $result[0]['digito_verificacion'] != '' ? $result[0]['digito_verificacion'] : 'NULL';

        $centro_de_costo_id1 = $result[0]['centro_de_costo_id'];
        $codigo_centro1 = $result[0]['codigo_centro'];

        if ($result_cc[0]['centro_de_costo_id'] > 0) {
            $centro_de_costo_id = $result_cc[0]['centro_de_costo_id'];
            $codigo = $result_cc[0]['codigo'];
        } else {
            exit('No existe Centro de Costo para la oficina Actual');
        }

        $fechaMes = substr($result[0]['fecha_final'], 0, 10);
        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);
        $consecutivo = $utilidadesContables->getConsecutivo($oficina_id, $tipo_documento_id, $periodo_contable_id, $Conex);

        $fecha = $result[0]['fecha_final'];
        $concepto = 'LIQUIDACION FINAL PERIODO ' . $result[0]['fecha_inicio'] . ' AL ' . $result[0]['fecha_final'];
        $puc_id = 'NULL';
        $fecha_registro = date("Y-m-d H:m");
        $modifica = $result_usu[0]['usuario'];
        $fuente_servicio_cod = 'NO';
        $numero_documento_fuente = $consecutivo;
        $id_documento_fuente = $result[0]['liquidacion_definitiva_id'];
        $motivo_terminacion_id = $result[0]['motivo_terminacion_id'];
        $causal_despido_id = $result[0]['causal_despido_id'] > 0 ? $result[0]['causal_despido_id'] : 'NULL';
        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);

        $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$terceroid,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)";
        $this->query($insert, $Conex, true);

        $select_item = "SELECT *
		FROM  liq_def_puc WHERE liquidacion_definitiva_id=$liquidacion_definitiva_id";
        $result_item = $this->DbFetchAll($select_item, $Conex);
        foreach ($result_item as $result_items) {
            $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
            $tercero_imp = $result_items['tercero_id'];
            $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,(SELECT numero_identificacion FROM tercero  WHERE tercero_id=$tercero_imp),(SELECT digito_verificacion FROM tercero  WHERE tercero_id=$tercero_imp),puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id1,'$codigo_centro1',valor,debito,credito
							FROM liq_def_puc WHERE liquidacion_definitiva_id=$liquidacion_definitiva_id AND liq_def_puc_id=$result_items[liq_def_puc_id]";

            $this->query($insert_item, $Conex, true);
        }

        $update = "UPDATE liquidacion_definitiva SET encabezado_registro_id=$encabezado_registro_id,
					estado= 'C',
					usuario_con_id = $usuario_id,
					fecha_conta='$fecha_registro'
				WHERE liquidacion_definitiva_id=$liquidacion_definitiva_id";
        $this->query($update, $Conex, true);

        //actualizar estado contrato
        $update = "UPDATE contrato SET estado='F', fecha_terminacion_real='$fecha', motivo_terminacion_id='$motivo_terminacion_id', causal_despido_id=$causal_despido_id WHERE contrato_id=$contrato_id";
        $this->query($update, $Conex, true);

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);

        } else {
            $this->Commit($Conex);
            return true;
        }
    }
    public function getDetallesLiquidacionPres($liquidacion_definitiva_id, $Conex)
    {
        if ($liquidacion_definitiva_id > 0) {
            $select = "SELECT l.*,
			CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ) AS periodo,
			(SELECT SUM(valor) FROM liq_def_prestacion WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
			FROM 	liq_def_prestacion l
			WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";

            $result = $this->DbFetchAll($select, $Conex, true);

            if (!count($result) > 0) {
                $result = array();
            }

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesLiquidacionIndem($liquidacion_definitiva_id, $Conex)
    {

        if ($liquidacion_definitiva_id > 0) {

            $select = "SELECT l.*,
			CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ) AS periodo,
			(SELECT SUM(valor) FROM liq_def_indemnizacion WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
			FROM 	liq_def_indemnizacion l
			WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";

            $result = $this->DbFetchAll($select, $Conex, true);

            if (!count($result) > 0) {
                $result = array();
            }

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesLiquidacionSala($liquidacion_definitiva_id, $Conex)
    {

        if ($liquidacion_definitiva_id > 0) {

            $select = "SELECT l.*,
			CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ) AS periodo,
			(SELECT SUM(valor) FROM liq_def_salario WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
			FROM 	liq_def_salario l
			WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";

            $result = $this->DbFetchAll($select, $Conex, true);
            if (!count($result) > 0) {
                $result = array();
            }

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesLiquidaciondeduc($liquidacion_definitiva_id, $Conex)
    {

        if ($liquidacion_definitiva_id > 0) {

            $select = "SELECT l.*,
			IF(l.fecha_inicio IS NOT NULL, CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ),'') AS periodo,
			(SELECT SUM(valor) FROM liq_def_deduccion WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
			FROM 	liq_def_deduccion l
			WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";
//echo $select;
            $result = $this->DbFetchAll($select, $Conex, true);
            if (!count($result) > 0) {
                $result = array();
            }

        } else {
            $result = array();
        }
        return $result;
    }

    public function getDetallesLiquidaciondeven($liquidacion_definitiva_id, $Conex)
    {

        if ($liquidacion_definitiva_id > 0) {

            $select = "SELECT l.*,
			IF(l.fecha_inicio IS NOT NULL, CONCAT_WS(' ','De:', l.fecha_inicio, 'Hasta:',l.fecha_fin ),'') AS periodo,
			(SELECT SUM(valor) FROM liq_def_devengado WHERE liquidacion_definitiva_id = $liquidacion_definitiva_id) AS total
			FROM 	liq_def_devengado l
			WHERE l.liquidacion_definitiva_id = $liquidacion_definitiva_id";

            $result = $this->DbFetchAll($select, $Conex, true);
            if (!count($result) > 0) {
                $result = array();
            }

        } else {
            $result = array();
        }
        return $result;
    }

}
