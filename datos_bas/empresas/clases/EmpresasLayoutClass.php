<?php

require_once("../../../framework/clases/ViewClass.php");

final class EmpresaLayout extends View{

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
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("EmpresasClass.php","TercerosForm","TercerosForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
	
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/empresas.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TERCEROID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));
     $this -> assign("NUMEROIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));
	 $this -> assign("DIGITOVERIFICACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[digito_verificacion]));
     $this -> assign("PRIMERAPELLIDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[primer_apellido]));
     $this -> assign("SEGUNDOAPELLIDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[segundo_apellido]));
     $this -> assign("PRIMERNOMBRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[primer_nombre]));
     $this -> assign("OTROSNOMBRES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[segundo_nombre]));
	 $this -> assign("RAZON_SOCIAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[razon_social]));
     $this -> assign("SIGLA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[sigla]));
     $this -> assign("UBICACION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
     $this -> assign("UBICACIONID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
 	 $this -> assign("DIRECCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion]));
 	 $this -> assign("TELEFONO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono]));
	 $this -> assign("MOVIL",				$this -> objectsHtml -> GetobjectHtml($this -> fields[movil]));
 	 $this -> assign("TELEFAX",				$this -> objectsHtml -> GetobjectHtml($this -> fields[telefax]));
 	 $this -> assign("APARTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[apartado]));
	 $this -> assign("EMAIL",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[email]));
	 $this -> assign("PAGINAWEB",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[pagina_web]));	$this -> assign("LOGO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[logo]));
	 $this -> assign("LOGOIMG",				$this -> objectsHtml -> GetobjectHtml($this -> fields[logoimg]));
     $this -> assign("EMPRESASID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));
     $this -> assign("REGMERCANTIL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[registro_mercantil]));
     $this -> assign("CAMCOMERCIO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[camara_comercio]));
	 $this -> assign("ESCRITURA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[escritura_constitucion]));
	 $this -> assign("FECHA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
     $this -> assign("NOTARIA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[notaria]));
	 
     /*$this -> assign("RESOLUCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[resolucion]));
     $this -> assign("FECHARES",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_resolucion]));
     $this -> assign("INICIO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[inicio_resolucion]));
     $this -> assign("FINAL",				$this -> objectsHtml -> GetobjectHtml($this -> fields[fin_resolucion]));
     $this -> assign("DISPONIBLE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[inicio_disponible_res]));
     $this -> assign("SALDO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_res]));
	*/ 
	 
	 $this -> assign("ESTADO",            $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));		 
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
   
    public function SetTiposId($TiposId){
      $this -> fields[tipo_identificacion_id]['options'] = $TiposId;
      $this -> assign("TIPOIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
    }
   
    public function SetTiposPersona($TiposPersona){
	  $this -> fields[tipo_persona_id]['options'] = $TiposPersona;
      $this -> assign("TIPOPERSONA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id]));
    }
   
    public function SetAseguradora($Aseguradoras){
   	  $this -> fields[aseguradora]['options'] = $Aseguradoras;
      $this -> assign("ASEGURADORA",$this -> objectsHtml -> GetobjectHtml($this -> fields[aseguradora]));
    }
   
    public function SetGridEmpresas($Attributes,$Titles,$Cols,$Query){
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
      $this ->RenderLayout('empresas.tpl');
    }

}

?>