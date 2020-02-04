<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class ProvisionesLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }

   public function SetImprimir($Permiso){
	 $this -> Imprimir = $Permiso;
   } 

   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }     
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("ProvisionesClass.php","ProvisionesForm","ProvisionesForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/application/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/application/framework/css/general.css"); 
     $this -> TplInclude -> IncludeCss("/application/framework/css/jquery.alerts.css");	
 
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery-uploader/swfobject.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
     $this -> TplInclude -> IncludeJs("/application/nomina/movimientos/js/Provisiones.js");
     $this -> TplInclude -> IncludeJs("/application/framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));

	 
     $this -> assign("LIQUIDACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_provision_id]));
	 $this -> assign("CONSECUTIVO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));
     $this -> assign("FECHAINI",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicial]));
     $this -> assign("FECHAFIN",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));
     $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 $this -> assign("USUARIO_ID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
	 $this -> assign("FECHAREG",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));	
	 $this -> assign("ENCABEZADOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));

	//anulacion
	 $this -> assign("USUARIOANUL_ID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_anulo_id]));
	 $this -> assign("FECHAANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anulacion]));	  
	 $this -> assign("OBS_ANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	 $this -> assign("CAUSALANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));
	 
	 

     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
     if($this -> Actualizar){
	   //$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
 	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	 }

	if($this -> Imprimir){
		$this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	}
	
     if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
	   
     if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANUL",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   


//// GRID ////
   public function SetGridProvisiones($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery){

     require_once("../../../framework/clases/grid/JqGridClass.php");

     $TableGrid = new JqGrid();
     $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery);
     $this -> assign("GRIDLIQ_NOVEDAD",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());

   }


   public function RenderMain(){
   
        $this -> RenderLayout('Provisiones.tpl');
	 
   }


}


?>