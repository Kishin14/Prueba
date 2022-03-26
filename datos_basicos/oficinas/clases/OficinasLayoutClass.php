<?php

require_once("../../../framework/clases/ViewClass.php");

final class OficinaLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this->Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this->Actualizar = $Permiso;
   }   
   
   public function setBorrar($Permiso){
   	 $this->Borrar = $Permiso;
   }      
   
   public function setLimpiar($Permiso){
  	 $this->Limpiar = $Permiso;
   }   
   
   public function setCampos($campos){	 	

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("OficinasClass.php","OficinasForm","OficinasForm");	 	 
	 
	 $this->fields = $campos;       
  	 
     $this->TplInclude->IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
     $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
     $this->TplInclude->IncludeCss("../../../framework/css/general.css");	
     $this->TplInclude->IncludeCss("../css/oficinas.css");	 
     $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this->TplInclude->IncludeCss("../../../framework/css/jquery.treeTable.css");	
	 
     $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
     $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
     $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");	
     $this->TplInclude->IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
     $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
     $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this->TplInclude->IncludeJs("../js/oficinas.js");
     $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");	 		 
     $this->TplInclude->IncludeJs("../../../framework/js/jquery.treeTable.js");	 		 	 
	 
     $this->assign("CSSSYSTEM",		$this->TplInclude->GetCssInclude());
     $this->assign("JAVASCRIPT",	$this->TplInclude->GetJsInclude());
     $this->assign("FORM1",		$Form1->FormBegin());
     $this->assign("FORM1END",		$Form1->FormEnd());
     $this->assign("BUSQUEDA",		$this->objectsHtml->GetobjectHtml($this->fields[busqueda]));
     $this->assign("OFICINAID",		$this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
     $this->assign("NOMBRE",		$this->objectsHtml->GetobjectHtml($this->fields[nombre]));
     $this->assign("CODIGOCENTRO",	$this->objectsHtml->GetobjectHtml($this->fields[codigo_centro]));	 
     $this->assign("UBICACION",		$this->objectsHtml->GetobjectHtml($this->fields[ubicacion]));	 	 	 	 	
     $this->assign("UBICACIONID",	$this->objectsHtml->GetobjectHtml($this->fields[ubicacion_id]));	 
     $this->assign("DIRECCION",		$this->objectsHtml->GetobjectHtml($this->fields[direccion]));	 
     $this->assign("TELEFONO",		$this->objectsHtml->GetobjectHtml($this->fields[telefono]));	 
     $this->assign("MOVIL",		$this->objectsHtml->GetobjectHtml($this->fields[movil]));	 	 	 	 
     $this->assign("EMAIL",		$this->objectsHtml->GetobjectHtml($this->fields[email]));	 	 	 	  
     $this->assign("SUCURSALSI",	$this->objectsHtml->GetobjectHtml($this->fields[sucursal_si]));
     $this->assign("SUCURSALNO",	$this->objectsHtml->GetobjectHtml($this->fields[sucursal_no]));	 	 	 	 	
     $this->assign("SUPERIOR",		$this->objectsHtml->GetobjectHtml($this->fields[cen_oficina_id]));	 	 	 
     $this->assign("RESPONSABLE",	$this->objectsHtml->GetobjectHtml($this->fields[responsable]));	 	 	 
     $this->assign("RESPONSABLEID",	$this->objectsHtml->GetobjectHtml($this->fields[responsable_id]));	 	 	 
     $this->assign("PLANTILLA",	$this->objectsHtml->GetobjectHtml($this->fields[plantilla]));	 	 	 	 	 

 
     if($this->Guardar)    
	   $this->assign("GUARDAR",$this->objectsHtml->GetobjectHtml($this->fields[guardar]));	 	 	 
	   
	 if($this->Actualizar) 
	   $this->assign("ACTUALIZAR",$this->objectsHtml->GetobjectHtml($this->fields[actualizar]));	     
	   
	 if($this->Borrar)     
	   $this->assign("BORRAR",$this->objectsHtml->GetobjectHtml($this->fields[borrar]));	 	 	 	 
	   
	 if($this->Limpiar)    
	   $this->assign("LIMPIAR",$this->objectsHtml->GetobjectHtml($this->fields[limpiar]));		 	 	 	 	 	 	 
   }
	 
   
   public function setEmpresas($Empresas){
   
     $this->fields[empresa_id]['options'] = $Empresas;
	 $this->assign("EMPRESAS",$this->objectsHtml->GetobjectHtml($this->fields[empresa_id]));	

   }
   
        
   public function RenderMain(){ 
 	  
     $this->RenderLayout('oficinas.tpl');
	 
   }
	 

}


?>