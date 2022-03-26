<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ContratosLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../css/Imp_Contratos.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../css/Imp_Contratos.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setcontrato($contrato){

     /*$this -> assign("EMPRESA",$contrato[0]['empresa']);
     $this -> assign("IDENTIFICACIONEMPRESA",$contrato[0]['identificacion_empresa']);
     $this -> assign("SITIOTRABAJO",$contrato[0]['oficina_id']);*/
     $this -> assign("EMPLEADO",$contrato[0]['empleado']);
     $this -> assign("IDENTIFICACIONEMPLEADO",$contrato[0]['identificacion']);
	 $this -> assign("CARGO",$contrato[0]['cargo']);
	 $this -> assign("FECHA_TERMINACION",$contrato[0]["fecha_terminacion"]);
     $this -> assign("CARNE",$contrato[0]['carne']); 
	 $this -> assign("EMPEPSID",$contrato[0]['eps']);  
	 $this -> assign("FOTO",$contrato[0]["foto"]);
	 $this -> assign("LOGO",$contrato[0]["logo"]);
	 //$this -> assign("NUMERO_CONTRATO",$contrato[0]["numero_contrato"]);
	 $this -> assign("NOMBRE",$contrato[0]['nombre_empleado']); 
	 $cuerpo = $contrato[0]['cuerpo_mensaje'];
	 $cuerpo = str_replace("{NOMBRE}",$contrato[0]['nombre_empleado'],$cuerpo);
	 $cuerpo = str_replace("{IDENTIFICACION}",$contrato[0]['numero_identificacion'],$cuerpo);
	 $cuerpo = str_replace("{FECHA_INICIO}",$contrato[0]['fecha_inicio'],$cuerpo);
	 $cuerpo = str_replace("{CARGO}",$contrato[0]['cargo'],$cuerpo);	
	 $cuerpo = str_replace("{FECHA_INICIO}",$contrato[0]['fecha_inicio'],$cuerpo);	
	 $cuerpo = str_replace("{SUELDO_BASE}",$contrato[0]['sueldo_base'],$cuerpo);	
 	 $cuerpo = str_replace("{SUBSIDIO_TRANSPORTE}",$contrato[0]['subsidio_transporte'],$cuerpo);		 
	 $cuerpo = str_replace("{TIPO_PERSONA}",$contrato[0]['tipo_persona'],$cuerpo);	
	 $cuerpo = str_replace("{TIPO_IDENTIFICACION}",$contrato[0]['tipo_identificacion'],$cuerpo);	
	 $cuerpo = str_replace("{DIRECCION}",$contrato[0]['direccion'],$cuerpo);	
	 $cuerpo = str_replace("{EMAIL}",$contrato[0]['email'],$cuerpo);	
	 $cuerpo = str_replace("{TELEFAX}",$contrato[0]['telefax'],$cuerpo);	
	 $cuerpo = str_replace("{TELEFONO}",$contrato[0]['telefono'],$cuerpo);	
	 $cuerpo = str_replace("{MOVIL}",$contrato[0]['movil'],$cuerpo);	
	 $cuerpo = str_replace("{FECHA_NACIMIENTO_EMPLEADO}",$contrato[0]['fecha_nacimiento_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{ESTADO_CIVIL}",$contrato[0]['estado_civil_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{TIPO_VIVIENDA}",$contrato[0]['tipo_vivienda_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{PROFESION_EMPLEADO}",$contrato[0]['profesion_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{NUMERO_HIJOS_EMPLEADO}",$contrato[0]['numero_hijos_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{CAUSAL_DESPIDO}",$contrato[0]['casual_despido'],$cuerpo);	
	 $cuerpo = str_replace("{HORARIO_INI}",$contrato[0]['horario_ini'],$cuerpo);	
	 $cuerpo = str_replace("{HORARIO_FIN}",$contrato[0]['horario_fin'],$cuerpo);
	 $this -> assign("TEXTO",$cuerpo);  
   }
  
   public function RenderMain(){

      //$numero_identificacion = $_REQUEST['numero_identificacion'];
      //$this -> exportToPdf('Imp_contrato.tpl',"$numero_identificacion");
	 
      $this -> RenderLayout('Imp_Contratos.tpl');

   }


}

?>