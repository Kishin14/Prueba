<?php

require_once("../../../framework/clases/ViewClass.php");

final class ReportesUsuariosLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   
  
   public function setLimpiar($Permiso){
   $this->Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ReportesUsuariosClass.php","ReportesUsuariosForm","ReportesUsuariosForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../css/Reporte.css");	
	 $this -> TplInclude ->  IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude ->  IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/ReporteUsuarios.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());

	 $this -> assign("TIPO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));	
	 $this -> assign("ALL_TYPES",			$this -> objectsHtml -> GetobjectHtml($this -> fields[all_tipos]));
	 
	 $this -> assign("SI_USUARIO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[si_usuario]));		 
	 $this -> assign("USUARIO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario]));	
	 $this -> assign("USUARIOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
	 $this -> assign("PERMISO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[permiso_id]));
	 $this -> assign("ALL_PERMISES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[all_permiso]));
	 $this -> assign("OFICINA",			 	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
	 $this -> assign("ALL_OFFICE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[all_office]));

     $this -> assign("GENERAR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
 	 $this -> assign("DESCARGAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descargar]));	
     $this -> assign("IMPRIMIR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   
     $this -> assign("LIMPIAR",      $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }

	public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }
	

    public function SetTipo($tipos){
	  $this -> fields[tipo]['options'] = $tipos;
      $this -> assign("TIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
    }
	
	 public function SetPermiso($permiso){
	  $this -> fields[permiso_id]['options'] = $permiso;
      $this -> assign("PERMISO",$this -> objectsHtml -> GetobjectHtml($this -> fields[permiso_id]));
    }
	
    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_usuario]['options'] = $Si_pro;
      $this -> assign("SI_USUARIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_usuario]));
    }


    public function RenderMain(){
      $this ->RenderLayout('ReporteUsuarios.tpl');
    }

}

?>