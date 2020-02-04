<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_DocumentoLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../css/Imp_Contratos.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../css/Imp_Contratos.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setdocumento($documento){

     $this -> assign("EMPRESA",$contrato[0]['empresa']);
   /*  $this -> assign("IDENTIFICACIONEMPRESA",$contrato[0]['identificacion_empresa']);
     $this -> assign("SITIOTRABAJO",$contrato[0]['oficina_id']);
     $this -> assign("EMPLEADO",$contrato[0]['empleado']);
     $this -> assign("IDENTIFICACIONEMPLEADO",$contrato[0]['identificacion']);
	 $this -> assign("CARGO",$contrato[0]['cargo_id']);
     $this -> assign("SUELDO_BASE",$contrato[0]['sueldo_base']);
     $this -> assign("FECHA_INICIO",$contrato[0]["fecha_inicio"]);   
	 $this -> assign("REPRESENTANTE_LEGAL",$contrato[0]["representante_legal"]);  */
	 $this -> assign("NOMBRE",$documento[0]['nombre_empleado']); 
	 $salario_letras =  strtoupper($this -> num2letras($documento[0]['sueldo_base']));       
	 $mes_inicio =  date("m", strtotime($documento[0]['fecha_inicio']));  
	 $dia_inicio =  date("d", strtotime($documento[0]['fecha_inicio']));  
     $salario_letras =  strtoupper($this -> num2letras($documento[0]['sueldo_base']));       
	 $cuerpo = $documento[0]['cuerpo_mensaje'];
	 $cuerpo = str_replace("{NOMBRE}",$documento[0]['nombre_empleado'],$cuerpo);
	 $cuerpo = str_replace("{IDENTIFICACION}",$documento[0]['numero_identificacion'],$cuerpo);
	 $cuerpo = str_replace("{FECHA_INICIO}",$documento[0]['fecha_inicio'],$cuerpo);
	 $cuerpo = str_replace("{CARGO}",$documento[0]['cargo'],$cuerpo);	
	 $cuerpo = str_replace("{FECHA_FIN}",$documento[0]['fecha_terminacion'],$cuerpo);	
	 $cuerpo = str_replace("{SUELDO_BASE}",$documento[0]['sueldo_base'],$cuerpo);	
 	 $cuerpo = str_replace("{SUBSIDIO_TRANSPORTE}",$documento[0]['subsidio_transporte'],$cuerpo);		 
	 $cuerpo = str_replace("{TIPO_PERSONA}",$documento[0]['tipo_persona'],$cuerpo);	
	 $cuerpo = str_replace("{TIPO_IDENTIFICACION}",$documento[0]['tipo_identificacion'],$cuerpo);	
	 $cuerpo = str_replace("{DIRECCION}",$documento[0]['direccion'],$cuerpo);	
	 $cuerpo = str_replace("{EMAIL}",$documento[0]['email'],$cuerpo);	
	 $cuerpo = str_replace("{TELEFAX}",$documento[0]['telefax'],$cuerpo);	
	 $cuerpo = str_replace("{TELEFONO}",$documento[0]['telefono'],$cuerpo);	
	 $cuerpo = str_replace("{MOVIL}",$documento[0]['movil'],$cuerpo);	
	 $cuerpo = str_replace("{FECHA_NACIMIENTO_EMPLEADO}",$documento[0]['fecha_nacimiento_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{ESTADO_CIVIL}",$documento[0]['estado_civil_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{TIPO_VIVIENDA}",$documento[0]['tipo_vivienda_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{PROFESION_EMPLEADO}",$documento[0]['profesion_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{NUMERO_HIJOS_EMPLEADO}",$documento[0]['numero_hijos_empleado'],$cuerpo);	
	 $cuerpo = str_replace("{CAUSAL_DESPIDO}",$documento[0]['casual_despido'],$cuerpo);	
	 $cuerpo = str_replace("{HORARIO_INI}",$documento[0]['horario_ini'],$cuerpo);	
	 $cuerpo = str_replace("{HORARIO_FIN}",$documento[0]['horario_fin'],$cuerpo);	
	 $cuerpo = str_replace("{VALOR_LETRAS}",$salario_letras,$cuerpo);	
	 $cuerpo = str_replace("{EXPEDICION_CEDULA}",$documento[0]['lugar_expedicion_doc'],$cuerpo);	
	 $cuerpo = str_replace("{LUGAR_TRABAJO}",$documento[0]['lugar_trabajo'],$cuerpo);	
	 $cuerpo = str_replace("{DURACION_CONTRATO}",$documento[0]['descrip_contrato'],$cuerpo);	
	 $cuerpo = str_replace("{MES_INICIO}",$mes_inicio,$cuerpo);	
	 $cuerpo = str_replace("{DIA_INICIO}",$dia_inicio,$cuerpo);	
	 
	 $this -> assign("TEXTO",$cuerpo);   
   
   }
  
  
   public function RenderMain(){

      //$numero_identificacion = $_REQUEST['numero_identificacion'];
      //$this -> exportToPdf('Imp_contrato.tpl',"$numero_identificacion");
	 
      $this -> RenderLayout('Imp_Documento.tpl');

   }


}

?>