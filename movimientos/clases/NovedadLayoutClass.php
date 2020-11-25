<?php
require_once("../../../framework/clases/ViewClass.php");

final class NovedadLayout extends View{

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
   
   public function setNovedadFrame($novedad_fija_id){

	   $this -> fields[novedad_fija_id]['value'] = $novedad_fija_id;

     $this -> assign("NOVEDADID",$this -> objectsHtml -> GetobjectHtml($this -> fields[novedad_fija_id]));	  	   

   }

   public function setImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   

   public function setCampos($campos){	 	

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("NovedadClass.php","NovedadForm","NovedadForm");	 	 
	 
	 $this -> fields = $campos;       
  	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 	
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/novedad.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 	 		 
	 
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("BUSQUEDANOVEDAD",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda_novedad]));
     $this -> assign("NOVEDADID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[novedad_fija_id]));	 
     $this -> assign("CONCEPTO",    		$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));
     $this -> assign("FECHANOV",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_novedad]));	 
     $this -> assign("FECHAINI",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicial]));
     $this -> assign("FECHAFIN",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));
     $this -> assign("CUOTAS",     			$this -> objectsHtml -> GetobjectHtml($this -> fields[cuotas]));
     $this -> assign("VALOR",     			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));
     $this -> assign("VALORCUOTA",     		$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_cuota]));
     $this -> assign("PERIODICIDAD",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[periodicidad]));
     $this -> assign("CONTRATOID",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));
     $this -> assign("CONTRATO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));
     $this -> assign("TERCEROID",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));
     $this -> assign("TERCERO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));
     $this -> assign("TIPO_NOVEDAD",   		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_novedad]));
     $this -> assign("ESTADO",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
     $this -> assign("SPORTEANEXO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[documento_anexo]));

     $this -> assign("ENCREGID",   			$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));
     $this -> assign("FACTPROID",  			$this -> objectsHtml -> GetobjectHtml($this -> fields[factura_proveedor_id]));
     $this -> assign("DOCCONTABLE",  			$this -> objectsHtml -> GetobjectHtml($this -> fields[doc_contable]));
     $this -> assign("LIQFINAL",  			$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_final]));

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
      $this -> fields[concepto_area_id]['options'] = $TiposConcepto;
      $this -> assign("CONCEPTOAREA",$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_area_id]));
    }

 	public function SetTipoDocumento($TiposDocumento){
      $this -> fields[tipo_documento_id]['options'] = $TiposDocumento;
      $this -> assign("TIPODOCUMENTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
    }

    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_empleado]['options'] = $Si_pro;
      $this -> assign("SI_CON",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_empleado]));
    }	
      
    public function SetGridNovedad($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
    
     $head = "'<head>".
	 
     $TableGrid -> GetJqGridJs()." ".
     
     $TableGrid -> GetJqGridCss()."
     
     </head>";
     
     $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
     
     return "<html>".$head." ".$body."</html>";
    }   
   
        
   public function RenderMain(){ 
 	  
     $this -> RenderLayout('novedad.tpl');
	 
   }
}
?>