<?php
require_once "../../../framework/clases/ControlerClass.php";

final class mandoContratos extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main()
    {

        $this->noCache();

        require_once "mandoContratosLayoutClass.php";
        require_once "mandoContratosModelClass.php";

        $Layout = new mandoContratosLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new mandoContratosModel();
        
        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());


        $Layout->setActualizar($Model->getPermiso(268,'UPDATE', $this->getConex()));
        $Layout->setCampos($this->Campos);

        //// GRID ////
        $Attributes = array(
            id => 'numero_contrato',
            title => 'CONTRATOS ACTIVOS',
            sortname => 'fecha_inicio',
            sortorder => 'desc',
            width => 'auto',
            height => 'auto',
            rowNum => 100,
            align => 'center',
        );
        $Cols = array(
            array(name => 'numero_contrato', index => 'numero_contrato', sorttype => 'text', width => '60', align => 'left'),
            array(name => 'tipo_contrato', index => 'tipo_contrato', sorttype => 'text', width => '150', align => 'left'),
            array(name => 'empleado', index => 'empleado', sorttype => 'text', width => '250', align => 'left'),
            array(name => 'fecha_inicio', index => 'fecha_inicio', sorttype => 'text', width => '100', align => 'left'),
            array(name => 'fecha_terminacion', index => 'fecha_terminacion', sorttype => 'text', width => '100', align => 'left'),
            array(name => 'cargo', index => 'cargo', sorttype => 'text', width => '120', align => 'left'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '60', align => 'left'),
            array(name => 'dias', index => 'dias', sorttype => 'text', width => '50', align => 'left'),
        );

        $Titles = array(
            'CONTRATO',
            'TIPO CONTRATO',
            'EMPLEADO',
            'FECHA INICIO',
            'FECHA TERMINACION',
            'CARGO',
            'ESTADO',
            'DIAS',
        );

        $Layout->SetGridMandoContratos($Attributes, $Titles, $Cols, $Model->getQueryMandoContratosGrid());



        $Layout->RenderMain();

    }

    protected function ProximosVencer()
    {

        require_once "mandoContratosModelClass.php";
        $Model = new mandoContratosModel();

        $result = $Model->SelectVencimientos($this->getConex());

        if ($Model->GetNumError() > 0) {
            exit("false");
        } else {
            $this->getArrayJSON($result);
        }
    }

    protected function vencidos()
    {

        require_once "mandoContratosModelClass.php";
        $Model = new mandoContratosModel();

        $result = $Model->SelectVencidos($this->getConex());

        if ($Model->GetNumError() > 0) {
            exit("false");
        } else {
            $this->getArrayJSON($result);
        }
    }

    protected function getDataContrato()
    {

        require_once "mandoContratosModelClass.php";
        $Model = new mandoContratosModel();
        $contrato_id = $_REQUEST['contrato_id'];
        $data = $Model->selectDataContrato($contrato_id, $this->getConex());

        if (is_array($data)) {
            $this->getArrayJSON($data);
        } else {
            print 'false';
        }

    }

    protected function onclickActualizar()
    {

        require_once "mandoContratosModelClass.php";
        $Model = new mandoContratosModel();
        
        $contrato_id = $_REQUEST['contrato_id'];
        $observacion_ren = $_REQUEST['observacion_ren'];
        $fecha_fin_ren = $_REQUEST['fecha_fin_ren'];

        $Model->Actualizar($contrato_id,$observacion_ren,$fecha_fin_ren,$this->getUsuarioId(), $this->getConex());

        if (strlen($Model->GetError()) > 0) {

            exit('false');
        } else {
            exit('Contrato Actualizado exitosamente!');
        }
    }

    protected function setCampos()
    {

        $this->Campos[numero_contrato] = array(
            name => 'numero_contrato',
            id => 'numero_contrato',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            //tabindex=>'7',

        );

        $this->Campos[contrato_id] = array(
            name => 'contrato_id',
            id => 'contrato_hidden',
            type => 'hidden',
            value => '',
            //required=>'yes',
            datatype => array(
                type => 'integer',
                length => '20'),
        );

        $this->Campos[empleado] = array(
            name => 'empleado',
            id => 'empleado',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            size => '40',
        );

        $this->Campos[fecha_inicio] = array(
            name => 'fecha_inicio',
            id => 'fecha_inicio',
            type => 'text',
            value => date('Y-m-d'),
            disabled => 'yes',
            datatype => array(
                type => 'date',
                length => '45'),
        );

        $this->Campos[fecha_terminacion] = array(
            name => 'fecha_terminacion',
            id => 'fecha_terminacion',
            type => 'text',
            disabled => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
        );

        $this->Campos[sueldo_base] = array(
            name => 'sueldo_base',
            id => 'sueldo_base',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            datatype => array(
                type => 'numeric'),
        );

        $this->Campos[subsidio_transporte] = array(
            name => 'subsidio_transporte',
            id => 'subsidio_transporte',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            datatype => array(type => 'numeric'),
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
        );

        $this->Campos[fecha_fin_ren] = array(
            name => 'fecha_fin_ren',
            id => 'fecha_fin_ren',
            type => 'text',
            Boostrap => 'si',
            datatype => array(
                type => 'date',
                length => '10'),
        );

        $this->Campos[observacion_ren] = array(
            name => 'observacion_ren',
            id => 'observacion_ren',
            type => 'textarea',
            datatype => array(
                type => 'text',
                length => '10'),
        );

        //botones

        $this->Campos[actualizar] = array(
            name => 'actualizar',
            id => 'actualizar',
            type => 'button',
            value => 'Actualizar',
            onclick => 'onclickActualizar(this.form)',
        );

        $this->SetVarsValidate($this->Campos);

    }

}

new mandoContratos();
