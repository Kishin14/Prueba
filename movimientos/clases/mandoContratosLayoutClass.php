<?php
require_once "../../../framework/clases/ViewClass.php";

final class mandoContratosLayout extends View
{

    private $fields;
    private $Actualizar;

    public function setActualizar($Permiso)
    {
        $this->Actualizar = $Permiso;
    }

    public function setCampos($campos)
    {
        $this->fields = $campos;
        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/DatosBasicos.css");
        $this->TplInclude->IncludeCss("../../../facturacion/Contratos/css/mandoContratos.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 
        $this->TplInclude->IncludeCss("../../../framework/sweetalert2/dist/sweetalert2.min.css");
        $this->TplInclude->IncludeCss("../../../framework/css/bootstrap1.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../../../nomina/movimientos/js/mandoContratos.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
        $this->TplInclude->IncludeJs("../../../framework/sweetalert2/dist/sweetalert2.min.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->getCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->getJsInclude());

        $this->assign("CONTRATO", $this->objectsHtml->GetobjectHtml($this->fields[numero_contrato]));
        $this->assign("CONTRATOID", $this->objectsHtml->GetobjectHtml($this->fields[contrato_id]));
        $this->assign("EMPLEADO", $this->objectsHtml->GetobjectHtml($this->fields[empleado]));
        $this->assign("FECHAINICIO", $this->objectsHtml->GetobjectHtml($this->fields[fecha_inicio]));
        $this->assign("FECHAFIN", $this->objectsHtml->GetobjectHtml($this->fields[fecha_terminacion]));
        $this->assign("SUELDO", $this->objectsHtml->GetobjectHtml($this->fields[sueldo_base]));
        $this->assign("SUBSIDIO", $this->objectsHtml->GetobjectHtml($this->fields[subsidio_transporte]));
        $this->assign("ESTADO", $this->objectsHtml->GetobjectHtml($this->fields[estado]));
        $this->assign("FECHAFINREN", $this->objectsHtml->GetobjectHtml($this->fields[fecha_fin_ren]));
        $this->assign("OBSERVACION", $this->objectsHtml->GetobjectHtml($this->fields[observacion_ren]));

        if ($this->Actualizar) {
            $this->assign("RENOVAR", $this->objectsHtml->GetobjectHtml($this->fields[actualizar]));
        }

    }

//// GRID ////

    public function SetGridMandoContratos($Attributes, $Titles, $Cols, $Query)
    {
        require_once "../../../framework/clases/grid/JqGridClass.php";
        $TableGrid = new JqGrid();
        $TableGrid->SetJqGrid($Attributes, $Titles, $Cols, $Query);
        $this->assign("GRIDmandoContratos", $TableGrid->RenderJqGrid());
        $this->assign("TABLEGRIDCSS", $TableGrid->GetJqGridCss());
        $this->assign("TABLEGRIDJS", $TableGrid->GetJqGridJs());

    }

    public function RenderMain()
    {

        $this->RenderLayout('mandoContratos.tpl');

    }

}
