<?php

require_once "../../../framework/clases/ControlerClass.php";

final class ModulosClass extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main()
    {

        $this->noCache();

        require_once "ModulosLayoutClass.php";
        require_once "ModulosModelClass.php";

        $Layout = new ModulosLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new ModulosModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $modulos = $Model->getEmpresasTree($this->getConex());

        $Layout->setCampos();

        $Layout->setModulos($modulos);

        //$Layout->setChildren($children);

        $Layout->RenderMain();

    }

    protected function moduleOnOff(){

        require_once "ModulosModelClass.php";
        $Model = new ModulosModel();

        $consecutivo = $_REQUEST['consecutivo'];
        
        $estado = $Model->updateModule($consecutivo, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('Error : ' . $Model->GetError());
        } else {
            exit($estado);
        }

    }

}

$ModulosClass = new ModulosClass();
