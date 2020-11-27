<?php

require_once("../../../framework/clases/ViewClass.php");

final class CambioClaveLayout extends View{
   
   public function setCampos($campos){	 	 
   
     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("CambioClaveClass.php","CambioClaveForm","CambioClaveForm");	 	 
	 
     $this -> fields = $campos;       
	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	
     $this -> TplInclude -> IncludeJs("../js/cambioclave.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 
	 
     $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",$Form1 -> FormBegin());
     $this -> assign("FORM1END",$Form1 -> FormEnd());
     $this -> assign("CLAVE",$this -> GetObjectHtml($this -> fields[clave]));	 	 	 	 	 
     $this -> assign("ACTUALIZAR",$this -> GetObjectHtml($this -> fields[actualizar]));	     

   }

   public function  setUsusarioId($UsuarioId){   
     $this -> fields[usuario_id][value] = $UsuarioId;
     $this -> assign("USUARIOID",$this -> GetObjectHtml($this -> fields[usuario_id]));	 	 	 	 	 	 
   }

   public function  setUsusario($Usuario){   
     $this -> fields[usuario][value] = $Usuario;
     $this -> assign("USUARIO",$this -> GetObjectHtml($this -> fields[usuario]));	 	 	 	 	 	 
   }

   public function  setUsusarioNombres($Nombres){   
	 $this -> assign("USUARIONOMBRES",$Nombres);	     	   
   }  
     
   public function RenderMain(){ 
 	  
     $this -> RenderLayout('cambioclave.tpl');
	 
   }
	 

}


?>