<?php

require_once("../../../framework/clases/ViewClass.php");

final class FinalizarContratosLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }       
   
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("FinalizarContratosClass.php","FinalizarContratosForm","FinalizarContratosForm");
	 
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
    $this -> TplInclude -> IncludeJs("/application/nomina/movimientos/js/FinalizarContratos.js");
    $this -> TplInclude -> IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
    $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");
    $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.filestyle.js");

    $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> GetCssInclude());
    $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> GetJsInclude());
    $this -> assign("FORM1",				  $Form1 -> FormBegin());
    $this -> assign("FORM1END",			  $Form1 -> FormEnd());
    $this -> assign("BUSQUEDA",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
    $this -> assign("CONTRATOID",  	  $this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));
    $this -> assign("CONTRATO",   	  $this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));
    $this -> assign("FECHAINI",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));
    $this -> assign("FECHAFIN",   	  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_terminacion]));
    $this -> assign("FECHAFINREAL",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_terminacion_real]));
    $this -> assign("FECHAFINALIZA",  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_finaliza]));
    $this -> assign("ESTADO",   		  $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));

	  $this -> assign("USUARIOID",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_finaliza_id]));

	//anulacion
	  $this -> assign("USUARIOANUL_ID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_anulo_id]));
	  $this -> assign("FECHAANUL",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anulacion]));	  
	  $this -> assign("OBS_ANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	  $this -> assign("CAUSALANUL",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));
	 
	  $this -> assign("TIPOIMPRE",	  	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_impresion]));
	  
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",    $this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 }  

	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	      $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }

	//LISTA MENU

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANUL",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   


 	public function SetMotivoTer($TiposMotivoTerm){
      $this -> fields[motivo_terminacion_id]['options'] = $TiposMotivoTerm;
      $this -> assign("MOTIVO_TERMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[motivo_terminacion_id]));
    }

 	public function SetCausalDes($TiposMotivoTerm){
      $this -> fields[causal_despido_id]['options'] = $TiposMotivoTerm;
      $this -> assign("CAUSALDESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_despido_id]));
    }

    public function SetGridFinalizarContratos($Attributes,$Titles,$Cols,$Query){

      require_once("../../../framework/clases/grid/JqGridClass.php");
	    $TableGrid = new JqGrid();
      $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
       
      $this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",  $TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",   $TableGrid -> GetJqGridJs());
      
    }
     
    public function RenderMain(){
      $this ->RenderLayout('FinalizarContratos.tpl');
    }
}

?>