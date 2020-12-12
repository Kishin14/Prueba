<?php

require_once "../../../framework/clases/ViewClass.php";

final class UsuarioLayout extends View
{

    private $fields;

    public function setGuardar($Permiso)
    {
        $this->Guardar = $Permiso;
    }

    public function setActualizar($Permiso)
    {
        $this->Actualizar = $Permiso;
    }

    public function setBorrar($Permiso)
    {
        $this->Borrar = $Permiso;
    }

    public function setLimpiar($Permiso)
    {
        $this->Limpiar = $Permiso;
    }

    public function setCampos($campos)
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("UsuariosClass.php", "UsuariosForm", "UsuariosForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../../../framework/css/bootstrap.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/generalterceros.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../js/usuarios.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());
        $this->assign("BUSQUEDA", $this->objectsHtml->GetobjectHtml($this->fields[busqueda]));
        $this->assign("TERCEROID", $this->objectsHtml->GetobjectHtml($this->fields[tercero_id]));
        $this->assign("NUMEROIDENTIFICACION", $this->objectsHtml->GetobjectHtml($this->fields[numero_identificacion]));
        $this->assign("PRIMERAPELLIDO", $this->objectsHtml->GetobjectHtml($this->fields[primer_apellido]));
        $this->assign("SEGUNDOAPELLIDO", $this->objectsHtml->GetobjectHtml($this->fields[segundo_apellido]));
        $this->assign("PRIMERNOMBRE", $this->objectsHtml->GetobjectHtml($this->fields[primer_nombre]));
        $this->assign("OTROSNOMBRES", $this->objectsHtml->GetobjectHtml($this->fields[segundo_nombre]));
        $this->assign("USUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
        $this->assign("USUARIO", $this->objectsHtml->GetobjectHtml($this->fields[usuario]));
        $this->assign("CLIENTEID", $this->objectsHtml->GetobjectHtml($this->fields[cliente_id]));
        $this->assign("CLIENTE", $this->objectsHtml->GetobjectHtml($this->fields[cliente]));
        $this->assign("EMAIL", $this->objectsHtml->GetobjectHtml($this->fields[email]));
        $this->assign("CARGO", $this->objectsHtml->GetobjectHtml($this->fields[cargo]));
        $this->assign("FOTO", $this->objectsHtml->GetobjectHtml($this->fields[foto]));
        $this->assign("FOTOIMG", $this->objectsHtml->GetobjectHtml($this->fields[fotoimg]));
        $this->assign("ACTIVO", $this->objectsHtml->GetobjectHtml($this->fields[activo]));
        $this->assign("INACTIVO", $this->objectsHtml->GetobjectHtml($this->fields[inactivo]));
        $this->assign("RAZON_SOCIAL", $this->objectsHtml->GetobjectHtml($this->fields[razon_social]));

        if ($this->Guardar) {
            $this->assign("GUARDAR", $this->objectsHtml->GetobjectHtml($this->fields[guardar]));
        }

        if ($this->Actualizar) {
            $this->assign("ACTUALIZAR", $this->objectsHtml->GetobjectHtml($this->fields[actualizar]));
        }

        if ($this->Borrar) {
            $this->assign("BORRAR", $this->objectsHtml->GetobjectHtml($this->fields[borrar]));
        }

        if ($this->Limpiar) {
            $this->assign("LIMPIAR", $this->objectsHtml->GetobjectHtml($this->fields[limpiar]));
        }

    }

    public function SetTiposId($TiposId)
    {

        $this->fields[tipo_identificacion_id]['options'] = $TiposId;
        $this->assign("TIPOIDENTIFICACION", $this->objectsHtml->GetobjectHtml($this->fields[tipo_identificacion_id]));

    }

    public function SetTiposPersona($TiposPersona)
    {
        $this->fields[tipo_persona_id]['options'] = $TiposPersona;
        $this->assign("TIPOPERSONA", $this->objectsHtml->GetobjectHtml($this->fields[tipo_persona_id]));
    }

    public function setEmpresas($empresas)
    {

        $this->fields[empresa_id]['options'] = $empresas;
        $this->assign("EMPRESAS", $this->objectsHtml->GetobjectHtml($this->fields[empresa_id]));

    }

    public function SetGridTerceros($Attributes, $Titles, $Cols, $Query)
    {

        require_once "../../../framework/clases/grid/JqGridClass.php";

        $TableGrid = new JqGrid();
        $TableGrid->SetJqGrid($Attributes, $Titles, $Cols, $Query);

        $head = "'<head>" .

        $TableGrid->GetJqGridJs() . " " .

        $TableGrid->GetJqGridCss() . "

	 </head>";

        $body = "<body>" . $TableGrid->RenderJqGrid() . "</body>";

        return "<html>" . $head . " " . $body . "</html>";
    }

    public function RenderMain()
    {

        $this->RenderLayout('usuarios.tpl');

    }

}
