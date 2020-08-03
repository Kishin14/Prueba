<?php

require_once "../../../framework/clases/ControlerClass.php";

final class Registrar extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    //DEFINICION CAMPOS DE FORMULARIO
    protected function setCampos()
    {

        $this->Campos[liquidacion_novedad_id] = array(
            name => 'liquidacion_novedad_id',
            id => 'liquidacion_novedad_id',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('primary_key')),
        );

        $this->Campos[consecutivo] = array(
            name => 'consecutivo',
            id => 'consecutivo',
            type => 'text',
            Boostrap => 'si',
            required => 'no',
            readonly => 'readonly',
            size => '10',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[fecha_inicial] = array(
            name => 'fecha_inicial',
            id => 'fecha_inicial',
            type => 'text',
            required => 'yes',
            value => '',
            //tabindex=>'3',
            datatype => array(
                type => 'date'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[fecha_final] = array(
            name => 'fecha_final',
            id => 'fecha_final',
            type => 'text',
            disabled => 'yes',
            required => 'yes',
            value => '',
            datatype => array(
                type => 'date'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[empleados] = array(
            name => 'empleados',
            id => 'empleados',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'U', text => 'UNO', selected => 'U'), array(value => 'T', text => 'TODOS')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),

        );

        $this->Campos[periodo] = array(
            name => 'periodo',
            id => 'periodo',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => '1', text => 'SEMANAL'), array(value => '2', text => 'PRIMERA QUINCENA'), array(value => '3', text => 'SEGUNDA QUINCENA'), array(value => '4', text => 'MES COMPLETO'), array(value => '5', text => 'RANGO FECHAS')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
        );

        $this->Campos[periodicidad] = array(
            name => 'periodicidad',
            id => 'periodicidad',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'S', text => 'SEMANAL'), array(value => 'Q', text => 'QUINCENAL'), array(value => 'M', text => 'MENSUAL'), array(value => 'T', text => 'TODOS', selected => 'T')),
            //required=>'yes',
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),

        );

        $this->Campos[area_laboral] = array(
            name => 'area_laboral',
            id => 'area_laboral',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'T', text => 'TODOS', selected => 'T'), array(value => 'A', text => 'ADMINISTRATIVO'), array(value => 'O', text => 'OPERATIVO'), array(value => 'C', text => 'COMERCIAL')),
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[centro_de_costo_id] = array(
            name => 'centro_de_costo_id',
            id => 'centro_de_costo_id',
            type => 'select',
            Boostrap => 'si',
            options => array(),
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[contrato_id] = array(
            name => 'contrato_id',
            id => 'contrato_id',
            type => 'hidden',
            required => 'yes',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[contrato] = array(
            name => 'contrato',
            id => 'contrato',
            Boostrap => 'si',
            type => 'text',
            size => '20',
            suggest => array(
                name => 'contrato',
                setId => 'contrato_id'),

        );

        $this->Campos[estado] = array(
            name => 'estado',
            id => 'estado',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            options => array(array(value => 'A', text => 'ANULADO', selected => 'E'), array(value => 'E', text => 'EDICION', selected => 'E'), array(value => 'C', text => 'CONTABILIZADO', selected => 'E')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[usuario_id] = array(
            name => 'usuario_id',
            id => 'usuario_id',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[fecha_registro] = array(
            name => 'fecha_registro',
            id => 'fecha_registro',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        //ANULACION
        $this->Campos[usuario_anulo_id] = array(
            name => 'usuario_anulo_id',
            id => 'usuario_anulo_id',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'integer'),
        );

        $this->Campos[fecha_anulacion] = array(
            name => 'fecha_anulacion',
            id => 'fecha_anulacion',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'text'),
        );

        $this->Campos[observacion_anulacion] = array(
            name => 'observacion_anulacion',
            id => 'observacion_anulacion',
            type => 'textarea',
            required => 'yes',
            datatype => array(
                type => 'tex'),
        );

        $this->Campos[causal_anulacion_id] = array(
            name => 'causal_anulacion_id',
            id => 'causal_anulacion_id',
            type => 'select',
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
        );

        //BOTONES
        $this->Campos[guardar] = array(
            name => 'guardar',
            id => 'guardar',
            type => 'button',
            value => 'Guardar',
            property => array(
                name => 'save_ajax',
                onsuccess => 'RegistrarOnSave'),
        );

        $this->Campos[anular] = array(
            name => 'anular',
            id => 'anular',
            type => 'button',
            value => 'Anular',
            disabled => 'disabled',
            onclick => 'onclickCancellation(this.form)',
        );

        $this->Campos[contabilizar] = array(
            name => 'contabilizar',
            id => 'contabilizar',
            type => 'button',
            value => 'Contabilizar',
            tabindex => '16',
            onclick => 'OnclickContabilizar()',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'print',
            value => 'Imprimir',
            displayoptions => array(
                form => 0,
                beforeprint => 'beforePrint',
                title => 'Impresion Liquidacion',
                width => '700',
                height => '600',
            ),

        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            onclick => 'RegistrarOnReset()',
        );

        $this->Campos[previsual] = array(
            name => 'previsual',
            id => 'previsual',
            Clase => 'btn btn-success',
            type => 'button',
            value => 'Previsual',
            onclick => 'Previsual(this.form)',
        );

        $this->Campos[print_out] = array(
            name => 'print_out',
            id => 'print_out',
            type => 'button',
            value => 'OK',

        );

        $this->Campos[tipo_impresion] = array(
            name => 'tipo_impresion',
            id => 'tipo_impresion',
            type => 'select',
            options => array(array(value => 'C', text => 'PLANILLA LIQUIDACION'), array(value => 'CL', text => 'DESPRENDIBLES LIQUIDACION'), array(value => 'DP', text => 'DESPRENDIBLE DE PAGO'), array(value => 'DC', text => 'DOCUMENTO CONTABLE'), array(value => 'PE', text => 'PLANILLA EXCEL')),
            selected => 'C',
            required => 'yes',
            datatype => array(type => 'text'),
        );

        $this->Campos[desprendibles] = array(
            name => 'desprendibles',
            id => 'desprendibles',
            type => 'select',
            options => array(array(value => '1', text => '1'), array(value => '2', text => '2'), array(value => '3', text => '3'), array(value => '4', text => '4'), array(value => '5', text => '5')),
            selected => '1',
            required => 'yes',
            datatype => array(type => 'text'),
        );

        $this->Campos[print_cancel] = array(
            name => 'print_cancel',
            id => 'print_cancel',
            type => 'button',
            value => 'CANCEL',

        );

        //BUSQUEDA
        $this->Campos[busqueda] = array(
            name => 'busqueda',
            id => 'busqueda',
            type => 'text',
            Boostrap => 'si',
            size => '85',
            value => '',
            placeholder => 'Por favor digite el numero de la liquidacion o el nombre del empleado',
            //tabindex=> '1',
            suggest => array(
                name => 'busca_registrar_nov_nomina',
                setId => 'liquidacion_novedad_id',
                onclick => 'setDataFormWithResponse'),
        );
        //busqueda por rango de fechas
        $this->Campos[busqueda1] = array(
            name => 'busqueda1',
            id => 'busqueda1',
            type => 'text',
            Boostrap => 'si',
            size => '85',
            value => '',
            placeholder => 'Por favor digite el numero de la liquidacion o la fecha',
            //tabindex=> '1',
            suggest => array(
                name => 'busca_registrar_nov_fecha',
                setId => 'liquidacion_novedad_id',
                onclick => 'setDataFormWithResponse1'),
        );

        $this->SetVarsValidate($this->Campos);
    }

    public function Main()
    {

        $this->noCache();

        require_once "RegistrarLayoutClass.php";
        require_once "RegistrarModelClass.php";

        $Layout = new RegistrarLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new RegistrarModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));
        $Layout->setActualizar($Model->getPermiso($this->getActividadId(), 'UPDATE', $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));
        $Layout->setAnular($Model->getPermiso($this->getActividadId(), 'ANULAR', $this->getConex()));
        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));

        $Layout->setCampos($this->Campos);

        //LISTA MENU
        $Layout->setCausalesAnulacion($Model->getCausalesAnulacion($this->getConex()));
        $Layout->SetCosto($Model->GetCosto($this->getConex()));

        //// GRID ////
        $Attributes = array(
            id => 'Registrar',
            title => 'Registrar Novedades Nomima',
            sortname => 'fecha_inicial',
            sortorder => 'desc',
            rowId => 'liquidacion_novedad_id',
            width => 'auto',
            height => '250',
        );

        $Cols = array(
            array(name => 'consecutivo', index => 'consecutivo', sorttype => 'text', width => '90', align => 'center'),
            array(name => 'fecha_inicial', index => 'fecha_inicial', sorttype => 'date', width => '140', align => 'center'),
            array(name => 'fecha_final', index => 'fecha_final', sorttype => 'text', width => '140', align => 'left'),
            array(name => 'empleado', index => 'empleado', sorttype => 'text', width => '300', align => 'left'),
            array(name => 'contrato', index => 'contrato', sorttype => 'date', width => '100', align => 'left'),
            array(name => 'doc_contable', index => 'doc_contable', sorttype => 'date', width => '100', align => 'left'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '100', align => 'center'),
        );

        $Titles = array('CONSECUTIVO',
            'FECHA INICIAL',
            'FECHA FINAL',
            'EMPLEADO',
            'CONTRATO',
            'DOCUMENTO',
            'ESTADO',
        );

        $Layout->SetGridRegistrar($Attributes, $Titles, $Cols, $Model->getQueryRegistrarGrid());

        $Layout->RenderMain();

    }

    protected function onclickValidateRow()
    {

        require_once "../../../framework/clases/ValidateRowClass.php";

        $Data = new ValidateRow($this->getConex(), "liquidacion_novedad", $this->Campos);

        $this->getArrayJSON($Data->GetData());
    }

    protected function validaPeriodo()
    {

        require_once "RegistrarModelClass.php";
        require_once "RegistrarLayoutClass.php";

        $Model = new RegistrarModel();
        $Layout = new RegistrarLayout($this->getTitleTab(), $this->getTitleForm());

        $empleados = $_REQUEST['empleados'];
        $periodicidad = $_REQUEST['periodicidad'];

        if ($empleados == 'U') {

            $contrato_id = $_REQUEST['contrato_id'];

            $data = $Model->validarPeriodicidad($periodicidad, $this->getConex());

            if ($Model->GetNumError() > 0) {
                exit("Error al validar la periodicidad");
            } else {
                $this->getArrayJSON($data);
            }

        } else {

            $data = $Model->validarPeriodicidad($periodicidad, $this->getConex());

            if ($Model->GetNumError() > 0) {
                exit("Error al validar la periodicidad");
            } else {
                $this->getArrayJSON($data);
            }

        }

    }

    protected function onclickSave()
    {

        require_once "RegistrarModelClass.php";
        require_once "RegistrarLayoutClass.php";

        $Model = new RegistrarModel();
        $Layout = new RegistrarLayout($this->getTitleTab(), $this->getTitleForm());

        $empleados = $_REQUEST['empleados'];
        $fecha_inicial = $_REQUEST['fecha_inicial'];
        $fecha_final = $_REQUEST['fecha_final'];
        $periodicidad = $_REQUEST['periodicidad'];
        $periodo = $_REQUEST['periodo'];
        $area_laboral = $_REQUEST['area_laboral'];
        $centro_de_costo_id = $_REQUEST['centro_de_costo_id'];

        if ($periodo == 1) {
            $dias = 7;
        } else if ($periodo == 2 || $periodo == 3) {
            $dias = 15;
        } else if ($periodo == 4) {
            $dias = 30;
        } else {
            $dias = $this->restaFechasCont($fecha_inicial, $fecha_final);
           
        }

        $previsual = $_REQUEST['previsual'];

        $dias_real = $dias;

        if (substr($fecha_inicial, 0, 4) != substr($fecha_final, 0, 4)) {
            exit("Las fechas Inicial y final no pueden ser en diferente A&ntilde;o");
        }

        if ($empleados == 'U') {

            $contrato_id = $_REQUEST['contrato_id'];
            $result = $Model->validarContratos($fecha_inicial, $fecha_final, $this->getConex());

            if ($result > 0) {

                $numero_contrato = $result[0]['numero_contrato'];
                $empleado = $result[0]['empleado'];

                $resultado = '<br><br> N° Contrato: ' . $numero_contrato . ' ' . $empleado;

                exit("No puede liquidar la nomina hasta que actualice la fecha de terminación o realice la liquidación final del siguiente contrato: " . $resultado);
            }

/*         $result = $Model -> validarPeriodicidad($periodicidad,$this -> getConex());

if($result > 0){

$numero_contrato = $result[0]['numero_contrato'];
$empleado = $result[0]['empleado'];
$periodicidad = $result[0]['periodicidad'];

$resultado = '<br><br> N° Contrato: '. $numero_contrato.' '.$empleado;

exit("No puede liquidar la nomina hasta que actualice la periodicidad del siguiente contrato: ".$resultado."<br><br>El empleado en este momento cuenta con una periodicidad: <b style='color:#ed121a'>".$periodicidad."<b>");
}  */

            $comprobar = $Model->ComprobarLiquidacion($_REQUEST['contrato_id'], $fecha_inicial, $fecha_final, $periodicidad, $area_laboral, $this->getConex());
            if ($comprobar[0]['consecutivo'] > 0) {
                exit($comprobar[0]['consecutivo']);
            }
//Se valida si ese contrato no esta Finalizado

            $result = $Model->Save($this->getUsuarioId(), $this->Campos, $dias, $dias_real, $previsual, $this->getConex());

            if ($Model->GetNumError() > 0) {
                exit("false");
            } else {

                if (!is_numeric($result)) { #ingresa si es previsual (Array)

                    require_once "Imp_LiquidacionLayoutClass.php";
                    require_once "Imp_LiquidacionModelClass.php";

                    $Layout = new Imp_LiquidacionLayout();
                    $Model = new Imp_LiquidacionModel();

                    $liquidacion_novedad_id = $result[0]['liquidacion_novedad_id'];

                    $Layout->setConceptoDebito($Model->getConceptoDebito($this->getConex()));
                    $Layout->setConceptoCredito($Model->getConceptoCredito($this->getConex()));

                    $Layout->setConceptoDebitoExt($Model->getConceptoDebitoExt($this->getConex()));
                    $Layout->setConceptoCreditoExt($Model->getConceptoCreditoExt($this->getConex()));

                    $Layout->setConceptoSaldo($Model->getConceptoSaldo($this->getConex()));

                    $con_deb = $Model->getConceptoDebito($this->getConex());
                    $con_cre = $Model->getConceptoCredito($this->getConex());

                    $con_debExt = $Model->getConceptoDebitoExt($this->getConex());
                    $con_creExt = $Model->getConceptoCreditoExt($this->getConex());

                    $con_sal = $Model->getConceptoSaldo($this->getConex());
                    $select_deb = "";
                    $select_cre = "";
                    $select_sal = "";

                    $select_deb_total = "";
                    $select_cre_total = "";

                    $con_deb1 = array();
                    $con_cre1 = array();

                    $con_debExt1 = array();
                    $con_creExt1 = array();

                    $con_sal1 = array();

                    $select_deb_total = " (SELECT SUM(d.debito)
				FROM liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.contrato_id =ln.contrato_id AND l.liquidacion_novedad_id=ln.liquidacion_novedad_id
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.debito>0 AND d.sueldo_pagar=0 AND l.estado!='A' ) AS total_debito,";

                    $select_cre_total = " (SELECT SUM(d.credito)
				FROM liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.contrato_id =ln.contrato_id AND l.liquidacion_novedad_id=ln.liquidacion_novedad_id
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.credito>0 AND d.sueldo_pagar=0 AND l.estado!='A') AS total_credito,";

                    for ($i = 0; $i < count($con_deb); $i++) {
                        $select_deb .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('" . $con_deb[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_deb[$i]['concepto']) . ", ";
                        $con_deb1[$i]['concepto'] = str_replace(" ", "_", $con_deb[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_deb); $i++) {
                        $select_tot_deb .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.concepto LIKE ('" . $con_deb[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_deb[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_debExt); $i++) {
                        $select_debExt .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto_area_id =" . $con_debExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_debExt[$i]['concepto']) . ", ";
                        $con_debExt1[$i]['concepto'] = str_replace(" ", "_", $con_debExt[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_debExt); $i++) {
                        $select_tot_debExt .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto_area_id =" . $con_debExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_debExt[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_cre); $i++) {
                        $select_cre .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('" . $con_cre[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_cre[$i]['concepto']) . ", ";
                        $con_cre1[$i]['concepto'] = str_replace(" ", "_", $con_cre[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_cre); $i++) {
                        $select_tot_cre .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto LIKE ('" . $con_cre[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_cre[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_creExt); $i++) {
                        $select_creExt .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto_area_id = " . $con_creExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_creExt[$i]['concepto']) . ", ";
                        $con_creExt1[$i]['concepto'] = str_replace(" ", "_", $con_creExt[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_creExt); $i++) {
                        $select_tot_creExt .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto_area_id = " . $con_creExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_creExt[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_sal); $i++) {
                        $select_sal .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('" . $con_sal[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_sal[$i]['concepto']) . ", ";
                        $con_sal1[$i]['concepto'] = str_replace(" ", "_", $con_sal[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_sal); $i++) {
                        $select_tot_sal .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.concepto LIKE ('" . $con_sal[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_sal[$i]['concepto']) . ", ";

                    }
                    
                    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
                    
                    $diasIncapacidad = $Model -> getDiasIncapacidad($liquidacion_novedad_id,$fecha_inicial,$fecha_final,$this->getConex());
					
					$diasIncapacidad = $this->groupArrayDias($diasIncapacidad, 'contrato_id');
                    
                    $Layout->setLiquidacion($con_deb1, $con_cre1, $con_debExt1, $con_creExt1, $con_sal1, $Model->getLiquidacion($select_deb_total, $select_cre_total, $select_deb, $select_cre, $select_debExt, $select_creExt, $select_sal,$diasIncapacidad,$this->getOficinaId(), $this->getEmpresaId(), $this->getConex()), $Model->getTotales($select_tot_deb, $select_tot_cre, $select_tot_debExt, $select_tot_creExt, $select_tot_sal, $this->getEmpresaId(), $this->getConex()));

                    $Layout->exportToExcel('Imp_LiquidacionExcel.tpl');

                    //echo 'true'; #Este echo valida que la previsual se cumpla

                } else {

                    echo $result;
                }

            }
        } elseif ($empleados == 'T') {

            $result = $Model->validarContratos($fecha_inicial, $fecha_final, $this->getConex());

            if ($result > 0) {

                $array = array();

                for ($i = 0; $i < count($result); $i++) {

                    $numero_contrato = $result[$i]['numero_contrato'];
                    $empleado = $result[$i]['empleado'];

                    $resultado = $resultado . '<br><br>' . 'N° Contrato: ' . $numero_contrato . ' ' . $empleado;
                }

                exit("No puede liquidar la nomina hasta que actualice la fecha de terminación o realice la liquidación final de los siguientes contratos: " . $resultado);
            }

            $comprobar = $Model->ComprobarLiquidacionT($fecha_inicial, $fecha_final, $periodicidad, $area_laboral, $centro_de_costo_id, $this->getConex());
            if ($comprobar[0]['consecutivo'] > 0) {
                exit($comprobar[0]['consecutivo']);
            }

			$fechas = $Model->FechasLicenRe($fecha_inicial, $fecha_final, $this->getConex());
			
			$diasArrayRe = $this -> groupArrayDias($fechas,'contrato_id');

			$fechas = $Model->FechasLicenNoRe($fecha_inicial, $fecha_final, $this->getConex());
			
			$diasArrayNoRe = $this -> groupArrayDias($fechas,'contrato_id');
			
            $result = $Model->SaveTodos($this->getUsuarioId(), $this->Campos, $dias, $dias_real, $periodicidad, $area_laboral, $centro_de_costo_id, $previsual,$diasArrayNoRe,$diasArrayRe,$this->getConex());

            if ($Model->GetNumError() > 0) {

                exit("false");

            } else {

                if (!is_numeric($result)) { #ingresa si es previsual (Array)

                    require_once "Imp_LiquidacionLayoutClass.php";
                    require_once "Imp_LiquidacionModelClass.php";

                    $Layout = new Imp_LiquidacionLayout();
                    $Model = new Imp_LiquidacionModel();

                    $liquidacion_novedad_id = $result[0]['liquidacion_novedad_id'];

                    $Layout->setConceptoDebito($Model->getConceptoDebito($this->getConex()));
                    $Layout->setConceptoCredito($Model->getConceptoCredito($this->getConex()));

                    $Layout->setConceptoDebitoExt($Model->getConceptoDebitoExt($this->getConex()));
                    $Layout->setConceptoCreditoExt($Model->getConceptoCreditoExt($this->getConex()));

                    $Layout->setConceptoSaldo($Model->getConceptoSaldo($this->getConex()));

                    $con_deb = $Model->getConceptoDebito($this->getConex());
                    $con_cre = $Model->getConceptoCredito($this->getConex());

                    $con_debExt = $Model->getConceptoDebitoExt($this->getConex());
                    $con_creExt = $Model->getConceptoCreditoExt($this->getConex());

                    $con_sal = $Model->getConceptoSaldo($this->getConex());
                    $select_deb = "";
                    $select_cre = "";
                    $select_sal = "";

                    $select_deb_total = "";
                    $select_cre_total = "";

                    $con_deb1 = array();
                    $con_cre1 = array();

                    $con_debExt1 = array();
                    $con_creExt1 = array();

                    $con_sal1 = array();

                    $select_deb_total = " (SELECT SUM(d.debito)
				FROM liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.contrato_id =ln.contrato_id AND l.liquidacion_novedad_id=ln.liquidacion_novedad_id
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.debito>0 AND d.sueldo_pagar=0 AND l.estado!='A' ) AS total_debito,";

                    $select_cre_total = " (SELECT SUM(d.credito)
				FROM liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.contrato_id =ln.contrato_id AND l.liquidacion_novedad_id=ln.liquidacion_novedad_id
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.credito>0 AND d.sueldo_pagar=0 AND l.estado!='A') AS total_credito,";

                    for ($i = 0; $i < count($con_deb); $i++) {

                        $select_deb .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('" . $con_deb[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_deb[$i]['concepto']) . ", ";
                        $con_deb1[$i]['concepto'] = str_replace(" ", "_", $con_deb[$i]['concepto']);

                    }

                    for ($i = 0; $i < count($con_deb); $i++) {
                        $select_tot_deb .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.concepto LIKE ('" . $con_deb[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_deb[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_debExt); $i++) {
                        $select_debExt .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto_area_id =" . $con_debExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_debExt[$i]['concepto']) . ", ";
                        $con_debExt1[$i]['concepto'] = str_replace(" ", "_", $con_debExt[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_debExt); $i++) {
                        $select_tot_debExt .= " (SELECT SUM(d.debito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto_area_id =" . $con_debExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_debExt[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_cre); $i++) {
                        $select_cre .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('" . $con_cre[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_cre[$i]['concepto']) . ", ";
                        $con_cre1[$i]['concepto'] = str_replace(" ", "_", $con_cre[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_cre); $i++) {
                        $select_tot_cre .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto LIKE ('" . $con_cre[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_cre[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_creExt); $i++) {
                        $select_creExt .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto_area_id = " . $con_creExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_creExt[$i]['concepto']) . ", ";
                        $con_creExt1[$i]['concepto'] = str_replace(" ", "_", $con_creExt[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_creExt); $i++) {
                        $select_tot_creExt .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id  AND d.concepto_area_id = " . $con_creExt[$i]['concepto_area_id'] . " ) AS " . str_replace(" ", "_", $con_creExt[$i]['concepto']) . ", ";

                    }

                    for ($i = 0; $i < count($con_sal); $i++) {
                        $select_sal .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND l.contrato_id=ln.contrato_id AND d.concepto LIKE ('" . $con_sal[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_sal[$i]['concepto']) . ", ";
                        $con_sal1[$i]['concepto'] = str_replace(" ", "_", $con_sal[$i]['concepto']);
                    }

                    for ($i = 0; $i < count($con_sal); $i++) {
                        $select_tot_sal .= " (SELECT SUM(d.credito) FROM   liquidacion_novedad l, detalle_liquidacion_novedad d
				WHERE l.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND l.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND l.estado!='A'
				AND d.liquidacion_novedad_id=l.liquidacion_novedad_id AND d.concepto LIKE ('" . $con_sal[$i]['concepto'] . "') ) AS " . str_replace(" ", "_", $con_sal[$i]['concepto']) . ", ";

                    }

					$liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
                    
					$diasIncapacidad = $Model -> getDiasIncapacidad($liquidacion_novedad_id,$fecha_inicial,$fecha_final,$this->getConex());
					
					$diasIncapacidad = $this->groupArrayDias($diasIncapacidad, 'contrato_id');
                    $Layout->setLiquidacion($con_deb1, $con_cre1, $con_debExt1, $con_creExt1, $con_sal1, $Model->getLiquidacion($select_deb_total, $select_cre_total, $select_deb, $select_cre, $select_debExt, $select_creExt, $select_sal,$diasIncapacidad, $this->getOficinaId(), $this->getEmpresaId(), $this->getConex()), $Model->getTotales($select_tot_deb, $select_tot_cre, $select_tot_debExt, $select_tot_creExt, $select_tot_sal, $this->getEmpresaId(), $this->getConex()));

                    $Layout->exportToExcel('Imp_LiquidacionExcel.tpl');

                } else {

                    echo $result;
                }

            }

        }
    }

    protected function onclickCancellation()
    {

        require_once "RegistrarModelClass.php";

        $Model = new RegistrarModel();
        $liquidacion_novedad_id = $this->requestDataForQuery('liquidacion_novedad_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $observacion_anulacion = $this->requestDataForQuery('observacion_anulacion', 'text');
        $usuario_anulo_id = $this->getUsuarioId();

        $estado = $Model->comprobar_estado($liquidacion_novedad_id, $this->getConex());

        if ($estado[0]['estado'] == 'A') {
            exit('No se puede Anular, La Liquidaci&oacute;n previamente estaba Anulada');

        } else if ($estado[0]['estado'] == 'C' && $estado[0]['estado_mes'] == 0) {

            exit('No se puede Anular, El mes contable de la Liquidaci&oacute;n esta Cerrado');

        } else if ($estado[0]['estado'] == 'C' && $estado[0]['estado_periodo'] == 0) {

            exit('No se puede Anular, El periodo contable de la Liquidaci&oacute;n esta Cerrado');

        }
        if ($estado[0]['empleados'] == 'U') {
            $Model->cancellation($liquidacion_novedad_id, $estado[0]['encabezado_registro_id'], $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $this->getConex());
        } elseif ($estado[0]['empleados'] == 'T') {
            $Model->cancellation1($liquidacion_novedad_id, $estado[0]['encabezado_registro_id'], $estado[0]['fecha_inicial'], $estado[0]['fecha_final'], $estado[0]['consecutivo'], $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $this->getConex());
        }

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function onclickPrint()
    {

        require_once "Imp_LiquidacionClass.php";
        $print = new Imp_Liquidacion($this->getEmpresaId(), $this->getConex());
        $oficina_id = $this->getOficinaId();
        $print->printOut($oficina_id);

    }

    protected function getTotalDebitoCredito()
    {

        require_once "RegistrarModelClass.php";
        $Model = new RegistrarModel();
        $liquidacion_novedad_id = $_REQUEST['liquidacion_novedad_id'];
        $estado = $Model->comprobar_estado($liquidacion_novedad_id, $this->getConex());
        if ($estado[0]['empleados'] == 'U') {
            $data = $Model->getTotalDebitoCredito($liquidacion_novedad_id, $this->getConex());
        } elseif ($estado[0]['empleados'] == 'T') {
            $data = $Model->getTotalDebitoCredito1($liquidacion_novedad_id, $estado[0]['fecha_inicial'], $estado[0]['fecha_final'], $estado[0]['consecutivo'], $this->getConex());
        }
        print json_encode($data);

    }
    protected function getContabilizar()
    {

        require_once "RegistrarModelClass.php";
        $Model = new RegistrarModel();
        $liquidacion_novedad_id = $_REQUEST['liquidacion_novedad_id'];
        $fecha_inicial = $_REQUEST['fecha_inicial'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();
        $usuario_id = $this->getUsuarioId();

        $mesContable = $Model->mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha_inicial, $this->getConex());
        $periodoContable = $Model->PeriodoContableEstaHabilitado($this->getConex());
        $estado = $Model->comprobar_estado($liquidacion_novedad_id, $this->getConex());

        if ($estado[0]['estado'] == 'C') {
            exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Contabilizada.');
        } else if (is_numeric($estado[0]['encabezado_registro_id'])) {
            exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Relacionada con un Registro contable.');

        }

        if ($mesContable && $periodoContable) {
            if ($estado[0]['empleados'] == 'U') {
                $return = $Model->getContabilizarReg($liquidacion_novedad_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $this->getConex()); //aca
            } elseif ($estado[0]['empleados'] == 'T') {
                $return = $Model->getContabilizarRegT($liquidacion_novedad_id, $estado[0]['fecha_inicial'], $estado[0]['fecha_final'], $estado[0]['consecutivo'], $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $this->getConex());
            }
            if ($return == true) {
                exit("true");
            } else {
                exit("Error : " . $Model->GetError());
            }

        } else {

            if (!$mesContable && !$periodoContable) {
                exit("No se permite Contabilizar en el periodo y mes seleccionado");
            } elseif (!$mesContable) {
                exit("No se permite Contabilizar en el mes seleccionado");
            } else if (!$periodoContable) {
                exit("No se permite Contabilizar en el periodo seleccionado");
            }
        }

    }

    protected function groupArrayDias($array, $groupkey){
	   
		$contador = 0;//se inicializa un contador	
		if (count($array) > 0) {
            $keys = array_keys($array[0]);
            $removekey = array_search($groupkey, $keys);if ($removekey === false) {
                return array("Clave \"$groupkey\" no existe");
            } else {
                unset($keys[$removekey]);
            }

            $groupcriteria = array();
            $return = array();
            foreach ($array as $value) {
                $item = null;
                foreach ($keys as $key) {
                    $item[$key] = $value[$key];
                }
                $busca = array_search($value[$groupkey], $groupcriteria);
                if ($busca === false) {
                    $groupcriteria[] = $value[$groupkey];
                    $return[] = array($groupkey => $value[$groupkey], 'groupeddata' => array());
                    $busca = count($return) - 1;
                }
                $return[$busca]['groupeddata'][] = $item;
            }
			
			//LA VARIABLE RETURN NOS MUESTRA EL ARRAY AGRUPADO POR CONTRATO ID

			//NOTA: EL ARRAY DE FECHAS DEBE CONTENER 2 ITEMS LLAMADOS 'fecha_inicial' y 'fecha_final' OBLIGATORIAMENTE

			for ($i = 0; $i < count($return); $i++) {

				$countDias = 0;//se inicializa dias

				for ($j = 0; $j < count($return[$i]['groupeddata']); $j++) {
				
					$countDias += $this->restaFechasCont($return[$i]['groupeddata'][$j]['fecha_inicial'],$return[$i]['groupeddata'][$j]['fecha_final']);//Se acumulan la cantidad dias restados de los respectivas licencias por separado

					$contrato_id_array = $return[$i]['contrato_id'];//Se le agrega el contrato ID en el Array para diferenciar los dias
					
				}
				$arrayDias[$contador]['dias']       =$countDias;//Aqui se Alimentan los Dias
				$arrayDias[$contador]['contrato_id']=$contrato_id_array;//Aqui se Alimentan los Contratos
				$contador ++;
            }

			return $arrayDias;


        } else {
            return array();
        }

    }

    //BUSQUEDA
    protected function onclickFind()
    {
        require_once "RegistrarModelClass.php";
        
        $Model = new RegistrarModel();
        $Liquidacion  = $_REQUEST['liquidacion_novedad_id'];
        $Liquidacion1 = $_REQUEST['liquidacion_novedad_id1'];
        
        if ($Liquidacion > 0) {
            $Data = $Model->selectLiquidacion($Liquidacion, $this->getConex());
        } else {
            $Data = $Model->selectLiquidacion1($Liquidacion1, $this->getConex());
        }
        
       
        $this->getArrayJSON($Data);

    }

}

$Registrar = new Registrar();
