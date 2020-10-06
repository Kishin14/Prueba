<?php

require_once "../../../framework/clases/ControlerClass.php";

final class Patronales extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    //DEFINICION CAMPOS DE FORMULARIO
    protected function setCampos()
    {

        $this->Campos[liquidacion_patronal_id] = array(
            name => 'liquidacion_patronal_id',
            id => 'liquidacion_patronal_id',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_patronal'),
                type => array('primary_key')),
        );

        $this->Campos[consecutivo] = array(
            name => 'consecutivo',
            id => 'consecutivo',
            Boostrap => 'si',
            type => 'text',
            required => 'no',
            readonly => 'readonly',
            size => '10',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_patronal'),
                type => array('column')),
        );

        $this->Campos[encabezado_registro_id] = array(
            name => 'encabezado_registro_id',
            id => 'encabezado_registro_id',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
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
                table => array('liquidacion_patronal'),
                type => array('column')),
        );

        $this->Campos[fecha_final] = array(
            name => 'fecha_final',
            id => 'fecha_final',
            type => 'text',
            required => 'yes',
            value => '',
            //tabindex=>'3',
            datatype => array(
                type => 'date'),
            transaction => array(
                table => array('liquidacion_patronal'),
                type => array('column')),
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
                table => array('liquidacion_patronal'),
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
                table => array('liquidacion_patronal'),
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
                table => array('liquidacion_patronal'),
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
                onsuccess => 'PatronalesOnSave'),
        );

        /*$this -> Campos[actualizar] = array(
        name    =>'actualizar',
        id        =>'actualizar',
        type    =>'button',
        value    =>'Actualizar',
        disabled=>'disabled',
        property=>array(
        name    =>'update_ajax',
        onsuccess=>'PatronalesOnUpdate')
        );*/

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
            onclick => 'PatronalesOnReset()',
        );

        //BUSQUEDA
        $this->Campos[busqueda] = array(
            name => 'busqueda',
            id => 'busqueda',
            type => 'text',
            Boostrap => 'si',
            size => '85',
            value => '',
            placeholder => 'Por favor digite el consecutivo o la fecha',
            //tabindex=> '1',
            suggest => array(
                name => 'busca_patronal',
                setId => 'liquidacion_patronal_id',
                onclick => 'setDataFormWithResponse'),
        );

        $this->SetVarsValidate($this->Campos);
    }

    public function Main()
    {

        $this->noCache();

        require_once "PatronalesLayoutClass.php";
        require_once "PatronalesModelClass.php";

        $Layout = new PatronalesLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new PatronalesModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));
        $Layout->setActualizar($Model->getPermiso($this->getActividadId(), 'UPDATE', $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));
        $Layout->setAnular($Model->getPermiso($this->getActividadId(), 'ANULAR', $this->getConex()));
        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));

        $Layout->setCampos($this->Campos);

        //LISTA MENU
        $Layout->setCausalesAnulacion($Model->getCausalesAnulacion($this->getConex()));

        //// GRID ////
        $Attributes = array(
            id => 'Patronales',
            title => 'Liquidacion Patronales',
            sortname => 'fecha_inicial',
            sortorder => 'desc',
            rowId => 'liquidacion_patronal_id',
            width => 'auto',
            height => '250',
        );

        $Cols = array(
            array(name => 'consecutivo', index => 'consecutivo', sorttype => 'text', width => '90', align => 'center'),
            array(name => 'fecha_inicial', index => 'fecha_inicial', sorttype => 'date', width => '140', align => 'center'),
            array(name => 'fecha_final', index => 'fecha_final', sorttype => 'text', width => '140', align => 'left'),
            array(name => 'doc_contable', index => 'doc_contable', sorttype => 'date', width => '100', align => 'left'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '100', align => 'center'),
        );

        $Titles = array('CONSECUTIVO',
            'FECHA INICIAL',
            'FECHA FINAL',
            'DOCUMENTO',
            'ESTADO',
        );

        $Layout->SetGridPatronales($Attributes, $Titles, $Cols, $Model->getQueryPatronalesGrid());
        $Layout->RenderMain();
    }

    protected function onclickValidateRow()
    {

        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), "liquidacion_patronal", $this->Campos);
        $this->getArrayJSON($Data->GetData());
    }

    protected function onclickSave()
    {

        require_once "PatronalesModelClass.php";
        $Model = new PatronalesModel();

        $fecha_inicial = $_REQUEST['fecha_inicial'];
        $fecha_final = $_REQUEST['fecha_final'];
        $dias = $this->restaFechasCont($fecha_inicial, $fecha_final);
        //$dias = $dias==31 ? 30 : $dias;

        if (substr($fecha_inicial, 0, 4) != substr($fecha_final, 0, 4)) {
            exit("Las fechas Inicial y final no pueden ser en diferente A&ntilde;o");
        }

        $comprobar = $Model->ComprobarLiquidacionT($fecha_inicial, $fecha_final, $this->getConex());
        if ($comprobar[0]['consecutivo'] > 0) {
            exit("Existe una liquidaci&oacute;n Previa  para las fechas seleccionadas. <br>Por favor verifique Liquidaci&oacute;n No " . $comprobar[0]['consecutivo']);
        }

        $comprobar1 = $Model->ComprobarLiquidacionNovedadIni($fecha_inicial, $this->getConex());
        if (count($comprobar1) == 0) {
            exit("No existen Liquidaciones de Nomina con la  fecha Inicial seleccionadas. <br>Por favor verifique.");
        }

        $comprobar1 = $Model->ComprobarLiquidacionNovedadFin($fecha_final, $this->getConex());
        if (count($comprobar1) == 0) {
            exit("No existen Liquidaciones de Nomina con la  fecha Final seleccionadas. <br>Por favor verifique.");
        }

		$fechas = $Model->getDataContrato($fecha_inicial, $fecha_final, $this->getConex());
		$diasRealesArray = $this -> groupArrayDias($fechas,'contrato_id');

        $result = $Model->SaveTodos($this->getOficinaId(), $this->getUsuarioId(), $this->Campos, $dias, $diasRealesArray, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit("false");
        } else {
            $this->getArrayJSON($result);
        }

    }

    protected function onclickCancellation()
    {

        require_once "PatronalesModelClass.php";

        $Model = new PatronalesModel();
        $liquidacion_patronal_id = $this->requestDataForQuery('liquidacion_patronal_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $observacion_anulacion = $this->requestDataForQuery('observacion_anulacion', 'text');
        $usuario_anulo_id = $this->getUsuarioId();

        $estado = $Model->comprobar_estado($liquidacion_patronal_id, $this->getConex());

        if ($estado[0]['estado'] == 'A') {
            exit('No se puede Anular, La Liquidaci&oacute;n previamente estaba Anulada');

        } else if ($estado[0]['estado'] == 'C' && $estado[0]['estado_mes'] == 0) {

            //exit('No se puede Anular, El mes contable de la Liquidaci&oacute;n esta Cerrado');

        } else if ($estado[0]['estado'] == 'C' && $estado[0]['estado_periodo'] == 0) {

            //exit('No se puede Anular, El periodo contable de la Liquidaci&oacute;n esta Cerrado');

        }
        $Model->cancellation($liquidacion_patronal_id, $estado[0]['encabezado_registro_id'], $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $this->getConex());

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function onclickPrint()
    {

        require_once "Imp_Documento1Class.php";
        $print = new Imp_Documento($this->getConex());
        $print->printOut();

    }

    protected function getTotalDebitoCredito()
    {

        require_once "PatronalesModelClass.php";
        $Model = new PatronalesModel();
        $liquidacion_patronal_id = $_REQUEST['liquidacion_patronal_id'];
        $estado = $Model->comprobar_estado($liquidacion_patronal_id, $this->getConex());
        $data = $Model->getTotalDebitoCredito($liquidacion_patronal_id, $this->getConex());
        print json_encode($data);

    }
    protected function getContabilizar()
    {

        require_once "PatronalesModelClass.php";
        $Model = new PatronalesModel();
        $liquidacion_patronal_id = $_REQUEST['liquidacion_patronal_id'];
        $fecha_inicial = $_REQUEST['fecha_inicial'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();
        $usuario_id = $this->getUsuarioId();

        $mesContable = $Model->mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha_inicial, $this->getConex());
        $periodoContable = $Model->PeriodoContableEstaHabilitado($this->getConex());
        $estado = $Model->comprobar_estado($liquidacion_patronal_id, $this->getConex());

        if ($estado[0]['estado'] == 'C') {
            exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Contabilizada.');
        } else if (is_numeric($estado[0]['encabezado_registro_id'])) {
            exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Relacionada con un Registro contable.');

        }

        if ($mesContable && $periodoContable) {
            $return = $Model->getContabilizarReg($liquidacion_patronal_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $this->getConex()); //aca
            if (is_numeric($return)) {
                exit("$return");
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

    protected function groupArrayDias($array, $groupkey)
    {

        $contador = 0; //se inicializa un contador
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

                $countDias = 0; //se inicializa dias

                for ($j = 0; $j < count($return[$i]['groupeddata']); $j++) {

                    $countDias += $this->restaFechasCont($return[$i]['groupeddata'][$j]['fecha_inicial'], $return[$i]['groupeddata'][$j]['fecha_final']); //Se acumulan la cantidad dias restados de los respectivas licencias por separado

                    $contrato_id_array = $return[$i]['contrato_id']; //Se le agrega el contrato ID en el Array para diferenciar los dias

                }

                if ($return[$i]['contrato_id'] == 230) {
                    $countDias = $countDias + 1;
                }

                $arrayDias[$contador]['dias'] = $countDias; //Aqui se Alimentan los Dias
                $arrayDias[$contador]['contrato_id'] = $contrato_id_array; //Aqui se Alimentan los Contratos
                $contador++;
            }

            return $arrayDias;

        } else {
            return array();
        }

    }

    //BUSQUEDA
    protected function onclickFind()
    {

        require_once "PatronalesModelClass.php";

        $Model = new PatronalesModel();
        $Liquidacion = $_REQUEST['liquidacion_patronal_id'];

        $Data = $Model->selectLiquidacion($Liquidacion, $this->getConex());

        $this->getArrayJSON($Data);

    }

}

$Patronales = new Patronales();
