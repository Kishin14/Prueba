<?php
require_once "../../../framework/clases/ControlerClass.php";

final class Contrato extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main()
    {
        $this->noCache();
        require_once "ContratoLayoutClass.php";
        require_once "ContratoModelClass.php";

        $Layout = new ContratoLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new ContratoModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->SetGuardar($Model->getPermiso($this->getActividadId(), INSERT, $this->getConex()));
        $Layout->SetActualizar($Model->getPermiso($this->getActividadId(), UPDATE, $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));
        $Layout->SetAnular($Model->getPermiso($this->getActividadId(), 'ANULAR', $this->getConex()));
        $Layout->SetLimpiar($Model->getPermiso($this->getActividadId(), CLEAR, $this->getConex()));

        $Layout->SetCampos($this->Campos);

        //LISTA MENU
        $Layout->SetCosto($Model->GetCosto($this->getConex()));
        $Layout->SetCausal($Model->GetCausal($this->getConex()));
        $Layout->SetTip($Model->GetTip($this->getConex()));
        $Layout->SetMot($Model->GetMot($this->getConex()));
        $Layout->SetARL($Model->GetARL($this->getConex()));

        $Layout->SetTiposCuenta($Model->GetTipoCuenta($this->getConex()));

        //// GRID ////
        $Attributes = array(
            id => 'contrato',
            title => 'Lista de Contratos',
            sortname => 'numero_contrato',
            width => 'auto',
            height => '250',
        );

        $Cols = array(
            array(name => 'numero_contrato', index => 'numero_contrato', sorttype => 'text', width => '100', align => 'center'),
            array(name => 'fecha_inicio', index => 'fecha_inicio', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'fecha_terminacion', index => 'fecha_terminacion', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'fecha_terminacion_real', index => 'fecha_terminacion_real', sorttype => 'text', width => '160', align => 'center'),
            array(name => 'empleado_id', index => 'empleado_id', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'cedula', index => 'cedula', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'tipo_contrato_id', index => 'tipo_contrato_id', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'cargo_id', index => 'cargo_id', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'motivo_terminacion_id', index => 'motivo_terminacion_id', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'sueldo_base', index => 'sueldo_base', sorttype => 'numeric', width => '150', align => 'right', format => 'currency'),
            array(name => 'subsidio_transporte', index => 'subsidio_transporte', sorttype => 'numeric', width => '150', align => 'right', format => 'currency'),
            array(name => 'centro_de_costo_id', index => 'centro_de_costo_id', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'periodicidad', index => 'periodicidad', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'categoria_arl', index => 'categoria_arl', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'empresa_eps', index => 'empresa_eps', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'empresa_pension', index => 'empresa_pension', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'empresa_arl', index => 'empresa_arl', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'empresa_caja', index => 'empresa_caja', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'empresa_cesan', index => 'empresa_cesan', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'causal_despido_id', index => 'causal_despido_id', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '150', align => 'center'),
            array(name => 'prefijo', index => 'prefijo', sorttype => 'text', width => '40', align => 'center'),
            array(name => 'carne', index => 'carne', sorttype => 'int', width => '40', align => 'center'),
        );

        $Titles = array('NO. CONTRATO',
            'FECHA INICIO',
            'FECHA TERMINACION',
            'FECHA TERMINACION REAL',
            'EMPLEADO',
            'CEDULA',
            'TIPO CONTRATO',
            'CARGO',
            'MOTIVO TERMINACION',
            'SUELDO BASE',
            'SUBSIDIO TRANSPORTE',
            'CENTRO DE COSTO',
            'PERIOCIDAD',
            'CATEGORIA ARL',
            'EPS',
            'PENSION',
            'ARL',
            'CAJA COMPENSACION',
            'CESANTIAS',
            'CAUSAL DESPIDO',
            'ESTADO',
            'PREFIJO',
            'CARNE',
        );

        $Layout->SetGridContrato($Attributes, $Titles, $Cols, $Model->GetQueryContratoGrid());
        $Layout->RenderMain();
    }

    protected function onclickValidateRow()
    {
        require_once "ContratoModelClass.php";
        $Model = new ContratoModel();
        echo $Model->ValidateRow($this->getConex(), $this->Campos);
    }

    protected function onclickSave()
    {

        require_once "ContratoModelClass.php";
        $Model = new ContratoModel();

        $Model->Save($this->Campos, $this->getConex());
        if ($Model->GetNumError() > 0) {
            exit('Ocurrio una inconsistencia');
        } else {
            exit('Se ingreso correctamente el contrato');
        }
    }

    protected function onclickPrint()
    {

        require_once "Imp_ContratosClass.php";
        $print = new Imp_Contratos($this->getEmpresaId(), $this->getConex());
        $print->printOut();

    }

    protected function onclickUpdate()
    {

        require_once "ContratoModelClass.php";

        $Model = new ContratoModel();

        $contrato_id = $_REQUEST['contrato_id'];
		$usuario_id = $this->getUsuarioId();
		
		$observacion_ren = $_REQUEST['desc_actualizacion1'];
		
        $estado = $Model->selectEstado($contrato_id, $this->getConex());

        if ($estado != 'A') {exit('Solo permite Actualizar Contratos en Estado de Edici&oacute;n');}

        $Model->Update($this->Campos,$usuario_id,$this->getConex());
        if ($Model->GetNumError() > 0) {
            exit('Ocurrio una inconsistencia');
        } else {
            exit('Se actualizo correctamente el contrato');
        }
    }

    protected function onclickDelete()
    {

        require_once "ContratoModelClass.php";
        $Model = new ContratoModel();
        $Model->Delete($this->Campos, $this->getConex());
        if ($Model->GetNumError() > 0) {
            exit('No se puede borrar el contrato');
        } else {
            exit('Se borro exitosamente el contrato');
        }
    }

    protected function onclickCancellation()
    {

        require_once "ContratoModelClass.php";

        $Model = new ContratoModel();
        $manifiesto_id = $this->requestDataForQuery('manifiesto_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $observacion_anulacion = $this->requestDataForQuery('observacion_anulacion', 'text');
        $usuario_anulo_id = $this->getUsuarioId();

        $Model->cancellation($manifiesto_id, $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $this->getConex());

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function setTipoContra()
    {
        require_once "ContratoModelClass.php";
        $Model = new ContratoModel();
        $Data = array();
        $tipo_contrato_id = $_REQUEST['tipo_contrato_id'];
        $Data = $Model->selectTipoContratoId($tipo_contrato_id, $this->getConex());
        echo json_encode($Data);
    }

    protected function calculaFechaFin()
    {
        require_once "ContratoModelClass.php";
        $Model = new ContratoModel();
        $Data = array();
        $tiempo_contrato = $_REQUEST['tiempo_contrato'];
        $fecha_inicio = $_REQUEST['fechai'];
        $Data = $Model->calculaFecha($tiempo_contrato, $fecha_inicio, $this->getConex());

        echo json_encode($Data);
    }

    //BUSQUEDA
    protected function onclickFind()
    {
        require_once "ContratoModelClass.php";
        $Model = new ContratoModel();
        $Data = array();
        $contrato_id = $_REQUEST['contrato_id'];
        $Data = $Model->selectDatosContratoId($contrato_id, $this->getConex());
        echo json_encode($Data);
    }

    protected function SetCampos()
    {

        /********************
        Campos Tarifas Proveedor
         ********************/

        $this->Campos[contrato_id] = array(
            name => 'contrato_id',
            id => 'contrato_id',
            type => 'hidden',
            datatype => array(
                type => 'autoincrement'),
            transaction => array(
                table => array('contrato'),
                type => array('primary_key')),
        );

        $this->Campos[numero_contrato] = array(
            name => 'numero_contrato',
            id => 'numero_contrato',
            type => 'text',
            Boostrap => 'si',
            //required=>'yes',
            size => '10',
            datatype => array(
                type => 'alphanum',
                length => '45'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_inicio] = array(
            name => 'fecha_inicio',
            id => 'fecha_inicio',
            type => 'text',
            value => date('Y-m-d'),
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '45'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_terminacion] = array(
            name => 'fecha_terminacion',
            id => 'fecha_terminacion',
            type => 'text',
            disabled => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_terminacion_real] = array(
            name => 'fecha_terminacion_real',
            id => 'fecha_terminacion_real',
            type => 'text',
            disabled => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empleado_id] = array(
            name => 'empleado_id',
            id => 'empleado_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empleado] = array(
            name => 'empleado',
            id => 'empleado',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'empleado',
                setId => 'empleado_id',
                onclick => 'setDataEmpleado'),
        );

        $this->Campos[tipo_contrato_id] = array(
            name => 'tipo_contrato_id',
            id => 'tipo_contrato_id',
            type => 'select',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'integer',
                length => '9'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[prefijo] = array(
            name => 'prefijo',
            id => 'prefijo',
            type => 'text',
            Boostrap => 'si',
            required => 'no',
            size => '5',
            datatype => array(
                type => 'alphanum',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[cargo_id] = array(
            name => 'cargo_id',
            id => 'cargo_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[cargo] = array(
            name => 'cargo',
            id => 'cargo',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'cargo',
                setId => 'cargo_id',
                onclick => 'setDataCargo'),
        );

        $this->Campos[motivo_terminacion_id] = array(
            name => 'motivo_terminacion_id',
            id => 'motivo_terminacion_id',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            datatype => array(
                type => 'integer',
                length => '45'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[sueldo_base] = array(
            name => 'sueldo_base',
            id => 'sueldo_base',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[subsidio_transporte] = array(
            name => 'subsidio_transporte',
            id => 'subsidio_transporte',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[ingreso_nosalarial] = array(
            name => 'ingreso_nosalarial',
            id => 'ingreso_nosalarial',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_ult_cesantias] = array(
            name => 'fecha_ult_cesantias',
            id => 'fecha_ult_cesantias',
            type => 'text',
            //required=>'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_ult_intcesan] = array(
            name => 'fecha_ult_intcesan',
            id => 'fecha_ult_intcesan',
            type => 'text',
            //required=>'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_ult_prima] = array(
            name => 'fecha_ult_prima',
            id => 'fecha_ult_prima',
            type => 'text',
            //required=>'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_ult_vaca] = array(
            name => 'fecha_ult_vaca',
            id => 'fecha_ult_vaca',
            type => 'text',
            //required=>'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[valor_cesantias] = array(
            name => 'valor_cesantias',
            id => 'valor_cesantias',
            type => 'text',
            Boostrap => 'si',
            //required    =>'yes',
            size => 10,
            datatype => array(
                type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[valor_intcesantias] = array(
            name => 'valor_intcesantias',
            id => 'valor_intcesantias',
            type => 'text',
            Boostrap => 'si',
            //required    =>'yes',
            size => 10,
            datatype => array(
                type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[valor_prima] = array(
            name => 'valor_prima',
            id => 'valor_prima',
            type => 'text',
            Boostrap => 'si',
            //required    =>'yes',
            size => 10,
            datatype => array(
                type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[valor_vacaciones] = array(
            name => 'valor_vacaciones',
            id => 'valor_vacaciones',
            type => 'text',
            Boostrap => 'si',
            //required    =>'yes',
            size => 10,
            datatype => array(
                type => 'numeric'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[centro_de_costo_id] = array(
            name => 'centro_de_costo_id',
            id => 'centro_de_costo_id',
            type => 'select',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(type => 'integer'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[periodicidad] = array(
            name => 'periodicidad',
            id => 'periodicidad',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'T', text => 'TODAS'), array(value => 'S', text => 'SEMANAL'), array(value => 'Q', text => 'QUINCENAL'), array(value => 'M', text => 'MENSUAL'), array(value => 'H', text => 'HORA'), array(value => 'D', text => 'DIAS')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[causal_despido_id] = array(
            name => 'causal_despido_id',
            id => 'causal_despido_id',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            datatype => array(
                type => 'text',
                length => '45'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        /*$this -> Campos[ubicacion_id] = array(
        name    =>'ubicacion_id',
        id        =>'ubicacion_id',
        type    =>'select',
        options    =>null,
        required=>'yes',
        datatype=>array(
        type    =>'alphanum',
        length    =>'11'),
        transaction=>array(
        table    =>array('convocado'),
        type    =>array('column'))
        );*/

        $this->Campos[categoria_arl_id] = array(
            name => 'categoria_arl_id',
            id => 'categoria_arl_id',
            type => 'select',
            Boostrap => 'si',
            options => null,
            required => 'yes',
            datatype => array(
                type => 'alphanum',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[tipo_cta_id] = array(
            name => 'tipo_cta_id',
            id => 'tipo_cta_id',
            type => 'select',
            Boostrap => 'si',
            options => null,
            //required=>'yes',
            //tabindex=>'2',
            datatype => array(
                type => 'integer',
                length => '1'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[banco] = array(
            name => 'banco',
            id => 'banco',
            type => 'text',
            Boostrap => 'si',
            //tabindex=>'7',
            suggest => array(
                name => 'banco',
                setId => 'banco_hidden'),
        );

        $this->Campos[banco_id] = array(
            name => 'banco_id',
            id => 'banco_hidden',
            type => 'hidden',
            value => '',
            //required=>'yes',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[estado] = array(
            name => 'estado',
            id => 'estado',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'A', text => 'ACTIVO', selected => 'A'), array(value => 'R', text => 'RETIRADO'), array(value => 'F', text => 'FINALIZADO'), array(value => 'AN', text => 'ANULADO'), array(value => 'L', text => 'LICENCIA')),
            required => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[area_laboral] = array(
            name => 'area_laboral',
            id => 'area_laboral',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'A', text => 'ADMINISTRATIVO', selected => 'A'), array(value => 'O', text => 'OPERATIVO'), array(value => 'C', text => 'COMERCIAL')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empresa_eps_id] = array(
            name => 'empresa_eps_id',
            id => 'empresa_eps_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empresa_eps] = array(
            name => 'empresa_eps',
            id => 'empresa_eps',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'eps_empresa',
                setId => 'empresa_eps_id'),
        );

        $this->Campos[empresa_pension_id] = array(
            name => 'empresa_pension_id',
            id => 'empresa_pension_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empresa_pension] = array(
            name => 'empresa_pension',
            id => 'empresa_pension',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'pensiones_empresa',
                setId => 'empresa_pension_id'),
        );

        $this->Campos[empresa_arl_id] = array(
            name => 'empresa_arl_id',
            id => 'empresa_arl_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empresa_arl] = array(
            name => 'empresa_arl',
            id => 'empresa_arl',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'arp_empresa',
                setId => 'empresa_arl_id'),
        );

        $this->Campos[empresa_caja_id] = array(
            name => 'empresa_caja_id',
            id => 'empresa_caja_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empresa_caja] = array(
            name => 'empresa_caja',
            id => 'empresa_caja',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'caja_empresa',
                setId => 'empresa_caja_id'),
        );

        $this->Campos[empresa_cesan_id] = array(
            name => 'empresa_cesan_id',
            id => 'empresa_cesan_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[empresa_cesan] = array(
            name => 'empresa_cesan',
            id => 'empresa_cesan',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '20',
            suggest => array(
                name => 'cesan_empresa',
                setId => 'empresa_cesan_id'),
        );

        $this->Campos[escaner_eps] = array(
            name => 'escaner_eps',
            id => 'escaner_eps',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_eps' . date('Y-m-d h:m:s')),
        );

        $this->Campos[escaner_pension] = array(
            name => 'escaner_pension',
            id => 'escaner_pension',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_pension' . date('Y-m-d h:m:s')),
        );

        $this->Campos[escaner_arl] = array(
            name => 'escaner_arl',
            id => 'escaner_arl',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_arl' . date('Y-m-d h:m:s')),
        );

        $this->Campos[escaner_caja] = array(
            name => 'escaner_caja',
            id => 'escaner_caja',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_caja' . date('Y-m-d h:m:s')),
        );

        $this->Campos[escaner_cesan] = array(
            name => 'escaner_cesan',
            id => 'escaner_cesan',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_cesan' . date('Y-m-d h:m:s')),
        );

        $this->Campos[numcuenta_proveedor] = array(
            name => 'numcuenta_proveedor',
            id => 'numcuenta_proveedor',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            //tabindex=>'8',
            datatype => array(
                type => 'alpha_upper',
                length => '20'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        /*    $this -> Campos[insti_medico] = array(
        name =>'insti_medico',
        id =>'insti_medico',
        type =>'text',
        size    =>'20',
        datatype=>array(
        type    =>'text',
        length    =>'200'),
        transaction=>array(
        table    =>array('contrato'),
        type    =>array('column'))

        );*/

        $this->Campos[escaner_bancario] = array(
            name => 'escaner_bancario',
            id => 'escaner_bancario',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_bancario' . date('Y-m-d h:m:s')),
        );

        $this->Campos[examen_medico] = array(
            name => 'examen_medico',
            id => 'examen_medico',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_medico' . date('Y-m-d h:m:s')),
        );

        $this->Campos[examen_egreso] = array(
            name => 'examen_egreso',
            id => 'examen_egreso',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_egreso' . date('Y-m-d h:m:s')),
        );

        $this->Campos[examen_periodico] = array(
            name => 'examen_periodico',
            id => 'examen_periodico',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_periodico' . date('Y-m-d h:m:s')),
        );

        $this->Campos[salud_ocupacional] = array(
            name => 'salud_ocupacional',
            id => 'salud_ocupacional',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_salud_ocu' . date('Y-m-d h:m:s')),
        );

        $this->Campos[cartas_cyc] = array(
            name => 'cartas_cyc',
            id => 'cartas_cyc',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_cartascyc' . date('Y-m-d h:m:s')),
        );

        $this->Campos[entrega_dotacion] = array(
            name => 'entrega_dotacion',
            id => 'entrega_dotacion',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_dotacion' . date('Y-m-d h:m:s')),
        );

        $this->Campos[contrato_firmado] = array(
            name => 'contrato_firmado',
            id => 'contrato_firmado',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_contrato' . date('Y-m-d h:m:s')),
        );

        $this->Campos[incapacidades] = array(
            name => 'incapacidades',
            id => 'incapacidades',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_incapacidades' . date('Y-m-d h:m:s')),
        );

        $this->Campos[paz_salvo] = array(
            name => 'paz_salvo',
            id => 'paz_salvo',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_paz_salvo' . date('Y-m-d h:m:s')),
        );

        $this->Campos[certi_procu] = array(
            name => 'certi_procu',
            id => 'certi_procu',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_procuraduria' . date('Y-m-d h:m:s')),
        );

        $this->Campos[certi_antece] = array(
            name => 'certi_antece',
            id => 'certi_antece',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_antecedentes' . date('Y-m-d h:m:s')),
        );

        $this->Campos[certi_contralo] = array(
            name => 'certi_contralo',
            id => 'certi_contralo',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_contraloria' . date('Y-m-d h:m:s')),
        );

        $this->Campos[certi_liquidacion] = array(
            name => 'certi_liquidacion',
            id => 'certi_liquidacion',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_liquidacion' . date('Y-m-d h:m:s')),
        );

        $this->Campos[certi_laboral] = array(
            name => 'certi_laboral',
            id => 'certi_laboral',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_laboral' . date('Y-m-d h:m:s')),
        );

        $this->Campos[foto] = array(
            name => 'foto',
            id => 'foto',
            type => 'file',
            value => '',
            path => '/transAlejandria/imagenes/nomina/contrato/',
            size => '70',
            //required=>'yes',
            datatype => array(
                type => 'file'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
            namefile => array(
                field => 'yes',
                namefield => 'contrato_id',
                text => '_foto'),
        );

        $this->Campos[horario_ini] = array(
            name => 'horario_ini',
            id => 'horario_ini',
            type => 'text',
            size => '5',
            datatype => array(
                type => 'time',
                length => '5'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),

        );
        $this->Campos[horario_fin] = array(
            name => 'horario_fin',
            id => 'horario_fin',
            type => 'text',

            size => '5',
            datatype => array(
                type => 'time',
                length => '5'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),

        );

        $this->Campos[carne] = array(
            name => 'carne',
            id => 'carne',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '45'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[dotacion] = array(
            name => 'dotacion',
            id => 'dotacion',
            type => 'text',

            required => 'yes',
            datatype => array(
                type => 'date',
                length => '45'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        /*$this -> Campos[carne] = array(
        name =>'carne',
        id =>'carne',
        type    =>'text',
        required=>'yes',
        size=>'10',
        datatype=>array(type=>'int'),
        transaction=>array(
        table =>array('contrato'),
        type =>array('column'))
        );*/

        $this->Campos[lugar_trabajo] = array(
            name => 'lugar_trabajo',
            id => 'lugar_trabajo',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '10',

            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[lugar_expedicion_doc] = array(
            name => 'lugar_expedicion_doc',
            id => 'lugar_expedicion_doc',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            size => '10',

            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[fecha_inicio_eps] = array(
            name => 'fecha_inicio_eps',
            id => 'fecha_inicio_eps',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '15'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );
        $this->Campos[fecha_inicio_pension] = array(
            name => 'fecha_inicio_pension',
            id => 'fecha_inicio_pension',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '15'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );
        $this->Campos[fecha_inicio_arl] = array(
            name => 'fecha_inicio_arl',
            id => 'fecha_inicio_arl',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '15'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );
        $this->Campos[fecha_inicio_compensacion] = array(
            name => 'fecha_inicio_compensacion',
            id => 'fecha_inicio_compensacion',
            type => 'text',

            required => 'yes',
            datatype => array(
                type => 'date',
                length => '15'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );
        $this->Campos[fecha_inicio_cesantias] = array(
            name => 'fecha_inicio_cesantias',
            id => 'fecha_inicio_cesantias',
            type => 'text',

            required => 'yes',
            datatype => array(
                type => 'date',
                length => '15'),
            transaction => array(
                table => array('contrato'),
                type => array('column')),
        );

        $this->Campos[desc_actualizacion] = array(
            name => 'desc_actualizacion',
            id => 'desc_actualizacion',
            type => 'textarea',
			//required => 'yes',
            datatype => array(
                type => 'text'),
        );

        /**********************************
        Botones
         **********************************/

        $this->Campos[guardar] = array(
            name => 'guardar',
            id => 'guardar',
            type => 'button',
            value => 'Guardar',
            // tabindex=>'19'
        );

        $this->Campos[actualizar] = array(
            name => 'actualizar',
            id => 'actualizar',
            type => 'button',
            value => 'Actualizar',
            disabled => 'disabled',
            // tabindex=>'20'
        );

        $this->Campos[anular] = array(
            name => 'anular',
            id => 'anular',
            type => 'button',
            value => 'Anular',
            onclick => 'onclickCancellation(this.form)',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'print',
            value => 'Imprimir',
            displayoptions => array(
                beforeprint => 'beforePrint',
                form => 0,
                title => 'Impresion Contrato',
                width => '700',
                height => '600',
            ),

        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            // tabindex=>'22',
            onclick => 'ContratoOnReset(this.form)',
        );

        $this->Campos[busqueda] = array(
            name => 'busqueda',
            id => 'busqueda',
            type => 'text',
            size => '85',
            Boostrap => 'si',
            placeholder => 'Por favor digite el numero de identificacion, nombre del empleado o numero de contrato',
            // tabindex=>'1',
            suggest => array(
                name => 'contrato',
                setId => 'contrato_id',
                onclick => 'setDataFormWithResponse'),
        );
        $this->SetVarsValidate($this->Campos);
    }
}
$contrato_id = new Contrato();
