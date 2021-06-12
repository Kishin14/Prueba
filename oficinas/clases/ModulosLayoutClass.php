<?php

require_once "../../../framework/clases/ViewClass.php";

final class ModulosLayout extends View
{


    public function setCampos()
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("ModulosClass.php", "ModulosClass", "ModulosClass");

        $this->TplInclude->IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../css/modulos.css");
        $this->TplInclude->IncludeCss("../css/ToggleSwitch.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.treeTable.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../js/modulos.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.treeTable.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());

    }

    public function setModulos($modulos){

        $this->assign("modulos", $modulos);

    }

    public function setChildren($children){

        $this->assign("children", $children);

    }

    public function RenderMain()
    {

        $this->RenderLayout('modulos.tpl');

    }

}
