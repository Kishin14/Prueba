<?php
require_once("../../../framework/clases/ViewClass.php");

final class ARLLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   

   public function SetBorrar($Permiso){
      $this -> Borrar = $Permiso;
    }
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ARLClass.php","ARLForm","ARLForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");
	
	 $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/general.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/parametros_modulo/js/arl.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("ARLID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[categoria_arl_id]));	 
     $this -> assign("CLASE",     $this -> objectsHtml -> GetobjectHtml($this -> fields[clase_riesgo]));
     $this -> assign("PORCENTAJE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[porcentaje]));
     $this -> assign("DESCRIPCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
     $this -> assign("ESTADO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 if($this -> Borrar)
        $this -> assign("BORRAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
   
    public function SetGridARL($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('arl.tpl');
    }
}

?>