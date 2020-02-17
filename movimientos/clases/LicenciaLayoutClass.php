<?php
require_once("../../../framework/clases/ViewClass.php");

final class LicenciaLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
   
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }      
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }  
   
   public function setLicenciaFrame($licencia_id){

	   $this -> fields[licencia_id]['value'] = $licencia_id;

     $this -> assign("LICENCIAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[licencia_id]));	  	   

   }

   public function setImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   

   public function setCampos($campos){	 	

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("LicenciaClass.php","LicenciaForm","LicenciaForm");	 	 
	 
	 $this -> fields = $campos;       
  	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/licencia.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		 
	 
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("LICENCIAID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[licencia_id]));	 
     $this -> assign("CONCEPTO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));
     $this -> assign("FECHALIC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_licencia]));	 
     $this -> assign("FECHAINI",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicial]));
     $this -> assign("FECHAFIN",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));
     $this -> assign("CONTRATOID",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));
     $this -> assign("CONTRATO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));
     $this -> assign("ENFERMEDADID",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[cie_enfermedades_id]));
     $this -> assign("ENFERMEDAD",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));

     $this -> assign("DIAS",   				$this -> objectsHtml -> GetobjectHtml($this -> fields[dias]));
     $this -> assign("REMUNERADO", 			$this -> objectsHtml -> GetobjectHtml($this -> fields[remunerado]));	 
     $this -> assign("ESTADO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 
	 $this -> assign("DIAGNOSTICO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[diagnostico]));
     

     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));	 	 	 
	   
	 if($this -> Actualizar) 
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));	
	   
	 if($this -> Imprimir) 
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	     
	   	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
   }
   
 	public function SetTipoConcepto($TiposConcepto){
      $this -> fields[tipo_incapacidad_id]['options'] = $TiposConcepto;
      $this -> assign("CONCEPTOAREA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_incapacidad_id]));
    }

    public function SetGridLicencia($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDNOVEDAD",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }   
   
        
   public function RenderMain(){ 
 	  
     $this -> RenderLayout('licencia.tpl');
	 
   }
}
?>