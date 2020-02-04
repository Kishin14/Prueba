<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_DocumentoLayout extends View{

  private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("/application/framework/css/reset.css");	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
     
   public function setEncabezado($encabezado){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSENCABEZADO",$encabezado[0]);       
   }

   public function setimputaciones($imputaciones){  
     $this -> assign("IMPUTACIONES",$imputaciones);       
   }

   public function setTotal($total){  
     $this -> assign("TOTAL",$total[0]);       
   }
   public function setTotales($totales){  
     $this -> assign("TOTALES", $this -> num2letras($totales[0][total]));       
   }

  
   public function RenderMain(){
   	 
	  $view = $_REQUEST['view'];
	  	 
	  if($view == 'window'){
         $this -> renderLayout('Imp_Documento.tpl','Documento');	  	  
	  }else{
            $this -> exportToPdf('Imp_Documento.tpl','Documento');	  
	    }
   	 
   }
   
   public function setErrorMessage(){
     $this -> assign("ERROR",1);   
   }

}

?>