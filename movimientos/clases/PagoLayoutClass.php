<?php

require_once "../../../framework/clases/ViewClass.php";

final class PagoLayout extends View
{

    private $fields;

    public function SetGuardar($Permiso)
    {
        $this->Guardar = $Permiso;
    }

    public function SetActualizar($Permiso)
    {
        $this->Actualizar = $Permiso;
    }

    public function SetLimpiar($Permiso)
    {
        $this->Limpiar = $Permiso;
    }
    public function SetAnular($Permiso)
    {
        $this->Anular = $Permiso;
    }
    public function SetImprimir($Permiso)
    {
        $this->Imprimir = $Permiso;
    }

    public function SetCampos($campos)
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("PagoClass.php", "PagoForm", "PagoForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../css/pago.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajaxupload.3.6.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/general.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../js/pago.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.filestyle.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());
        $this->assign("BUSQUEDA", $this->objectsHtml->GetobjectHtml($this->fields[busqueda]));
        $this->assign("ABONOID", $this->objectsHtml->GetobjectHtml($this->fields[abono_nomina_id]));
        $this->assign("NUMSOPORTE", $this->objectsHtml->GetobjectHtml($this->fields[numero_soporte]));
        $this->assign("NUMCHEQUE", $this->objectsHtml->GetobjectHtml($this->fields[num_cheque]));
        $this->assign("EMPLEADOID", $this->objectsHtml->GetobjectHtml($this->fields[empleado_id]));
        $this->assign("EMPLEADO", $this->objectsHtml->GetobjectHtml($this->fields[empleado]));
        $this->assign("EMPLEADOS", $this->objectsHtml->GetobjectHtml($this->fields[empleados]));

        $this->assign("EMPLEADONIT", $this->objectsHtml->GetobjectHtml($this->fields[empleado_nit]));
        $this->assign("FECHA", $this->objectsHtml->GetobjectHtml($this->fields[fecha]));
        $this->assign("DESDE", $this->objectsHtml->GetobjectHtml($this->fields[desde]));
        $this->assign("HASTA", $this->objectsHtml->GetobjectHtml($this->fields[hasta]));
        $this->assign("ENCABEZADOID", $this->objectsHtml->GetobjectHtml($this->fields[encabezado_registro_id]));

        $this->assign("VALORPAGO", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_nomina]));
        $this->assign("VALORPAGOPRIMA", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_primas]));
        $this->assign("VALORPAGOCESANTIAS", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_cesantias]));
        $this->assign("VALORPAGOVACACIONES", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_vacaciones]));
        $this->assign("VALORPAGOINTCESANTIAS", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_int_cesantias]));
        $this->assign("VALORPAGOTOTAL", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_total]));
        $this->assign("VALORPAGOLIQ", $this->objectsHtml->GetobjectHtml($this->fields[valor_abono_liq]));

        $this->assign("CONCEPTONOMI", $this->objectsHtml->GetobjectHtml($this->fields[concepto_abono_nomina]));
        $this->assign("FECHAINGRESO", $this->objectsHtml->GetobjectHtml($this->fields[ingreso_abono_nomina]));
        $this->assign("ESTADO", $this->objectsHtml->GetobjectHtml($this->fields[estado_abono_nomina]));

        $this->assign("CAUSACIONNOMI", $this->objectsHtml->GetobjectHtml($this->fields[causaciones_abono_nomina]));
        $this->assign("CAUSACIONPRIMA", $this->objectsHtml->GetobjectHtml($this->fields[causaciones_abono_primas]));
        $this->assign("CAUSACIONCESANTIAS", $this->objectsHtml->GetobjectHtml($this->fields[causaciones_abono_cesantias]));
        $this->assign("CAUSACIONVACACIONES", $this->objectsHtml->GetobjectHtml($this->fields[causaciones_abono_vacaciones]));
        $this->assign("CAUSACIONINTCESANTIAS", $this->objectsHtml->GetobjectHtml($this->fields[causaciones_abono_int_cesantias]));
        $this->assign("CAUSACIONLIQ", $this->objectsHtml->GetobjectHtml($this->fields[causaciones_abono_liq]));

        $this->assign("VALORESPAGO", $this->objectsHtml->GetobjectHtml($this->fields[valores_abono_nomina]));
        $this->assign("VALORESPAGOPRIMAS", $this->objectsHtml->GetobjectHtml($this->fields[valores_abono_primas]));
        $this->assign("VALORESPAGOCESANTIAS", $this->objectsHtml->GetobjectHtml($this->fields[valores_abono_cesantias]));
        $this->assign("VALORESPAGOVACACIONES", $this->objectsHtml->GetobjectHtml($this->fields[valores_abono_vacaciones]));
        $this->assign("VALORESPAGOINTCESANTIAS", $this->objectsHtml->GetobjectHtml($this->fields[valores_abono_int_cesantias]));
        $this->assign("VALORESPAGOLIQ", $this->objectsHtml->GetobjectHtml($this->fields[valores_abono_liq]));

        /***********************
        Anulacion Registro
         ***********************/

        $this->assign("FECHALOG", $this->objectsHtml->GetobjectHtml($this->fields[anul_abono_nomina]));
        $this->assign("OBSERVACIONES", $this->objectsHtml->GetobjectHtml($this->fields[desc_anul_abono_nomina]));

        if ($this->Guardar) {
            $this->assign("GUARDAR", $this->objectsHtml->GetobjectHtml($this->fields[guardar]));
        }

        if ($this->Actualizar) {
            $this->assign("ACTUALIZAR", $this->objectsHtml->GetobjectHtml($this->fields[actualizar]));
            $this->assign("CONTABILIZAR", $this->objectsHtml->GetobjectHtml($this->fields[contabilizar]));

        }

        if ($this->Limpiar) {
            $this->assign("LIMPIAR", $this->objectsHtml->GetobjectHtml($this->fields[limpiar]));
        }

        if ($this->Anular) {
            $this->assign("ANULAR", $this->objectsHtml->GetobjectHtml($this->fields[anular]));
        }

        if ($this->Imprimir) {
            $this->assign("IMPRIMIR", $this->objectsHtml->GetobjectHtml($this->fields[imprimir]));
        }

    }

    public function SetTiposPago($TiposPago)
    {
        $this->fields[cuenta_tipo_pago_id]['options'] = $TiposPago;
        $this->assign("PAGO", $this->objectsHtml->GetobjectHtml($this->fields[cuenta_tipo_pago_id]));
    }

    public function SetDocumento($IdDocumento)
    {
        $this->fields[tipo_documento_id]['options'] = $IdDocumento;
        $this->assign("DOCID", $this->objectsHtml->GetobjectHtml($this->fields[tipo_documento_id]));
    }

    public function setCausalesAnulacion($causales)
    {
        $this->fields[causal_anulacion_id]['options'] = $causales;
        $this->assign("CAUSALESID", $this->objectsHtml->GetobjectHtml($this->fields[causal_anulacion_id]));
    }

    public function setUsuarioId($usuario, $oficina)
    {
        $this->fields[oficina_id]['value'] = $oficina;
        $this->assign("OFICINAID", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
        $this->fields[oficina_anul]['value'] = $oficina;
        $this->assign("OFICINAANUL", $this->objectsHtml->GetobjectHtml($this->fields[oficina_anul]));

        $this->fields[usuario_id]['value'] = $usuario;
        $this->assign("USUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
        $this->fields[anul_usuario_id]['value'] = $usuario;
        $this->assign("ANULUSUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[anul_usuario_id]));

    }

    public function SetGridPago($Attributes, $Titles, $Cols, $Query)
    {
        require_once "../../../framework/clases/grid/JqGridClass.php";
        $TableGrid = new JqGrid();
        $TableGrid->SetJqGrid($Attributes, $Titles, $Cols, $Query);
        $this->assign("GRIDPAGO", $TableGrid->RenderJqGrid());
        $this->assign("TABLEGRIDCSS", $TableGrid->GetJqGridCss());
        $this->assign("TABLEGRIDJS", $TableGrid->GetJqGridJs());
    }

    public function RenderMain()
    {
        $this->RenderLayout('pago.tpl');
    }

}
