<?php

require_once("../../../framework/clases/ViewClass.php");

final class asignarPermisosLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }    
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }   
   
   public function setCampos($campos){	 	

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("OficinasClass.php","OficinasForm","OficinasForm");	 	 
	 
     $this -> fields = $campos;       
  	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("../css/asignarpermisos.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.treeTable.css");	
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/asignarpermisos.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.treeTable.js");	 		 	 
	 
     $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",$Form1 -> FormBegin());
     $this -> assign("FORM1END",$Form1 -> FormEnd());
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("USUARIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario]));	 	 	 	 	 	 	 	 	 	 
     $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_usuario_id]));	 	 	 	 	 	 	 	 	 	 	 
	 	 	 	 	 
     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));	 	 	 
	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
   }
	 
   
   public function setEmpresas($Empresas){
   
     $this -> fields[empresa_id]['options'] = $Empresas;
	 $this -> assign("EMPRESAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	

   }
   
   
   public function SetGridOficinas($Attributes,$Titles,$Cols,$Query){

     require_once("../../../framework/clases/grid/JqGridClass.php"); 
	 
	 $TableGrid = new JqGrid();   
	 	 
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 
     $this -> assign("GRIDOFICINAS",$TableGrid -> RenderJqGrid());	 	 	 	 	 	 	 	 
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());	 	 	 	 	 	 	 	 
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());	  	 	 	 	 	 	 	 

   
   }
     
   public function RenderMain(){ 
 	  
     $this -> RenderLayout('asignarpermisos.tpl');
	 
   }
	 

}


?>