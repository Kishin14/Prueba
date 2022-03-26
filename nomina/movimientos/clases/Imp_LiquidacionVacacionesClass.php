<?php

final class Imp_LiquidacionVacaciones{

  private $Conex;
  private $empresa_id;

  public function __construct($empresa_id,$Conex){
    $this -> Conex = $Conex; 
	$this -> getEmpresaId = $empresa_id; 
  }

  public function printOut(){
  	
      require_once("Imp_LiquidacionVacacionesLayoutClass.php");
      require_once("Imp_LiquidacionVacacionesModelClass.php");
		
      $Layout = new Imp_LiquidacionVacacionesLayout();
      $Model  = new Imp_LiquidacionVacacionesModel();		
	
      $Layout -> setIncludes();
	  $liquidacion_vacaciones_id = $_REQUEST['liquidacion_vacaciones_id'];
	
	
	  if($_REQUEST['tipo_impresion']=='CL'){
		  $liquidacion1 = $Model -> getLiquidacion2($liquidacion_vacaciones_id,$this -> getEmpresaId,$this -> Conex);
		  
		  $datos = $Model -> getDetalles($liquidacion_vacaciones_id,$this -> getEmpresaId,$this -> Conex);
		  

		  $Layout -> setLiquidacion1($liquidacion1,$datos);

	  }elseif($_REQUEST['tipo_impresion']=='DC'){

		  $liquidacion = $Model -> getLiquidacion3($liquidacion_vacaciones_id,$this -> getEmpresaId,$this -> Conex);
		  $_REQUEST['encabezado_registro_id'] = $liquidacion[0]['encabezado_registro_id'];
		  if( $liquidacion[0]['encabezado_registro_id']>0){ 
			  require_once("Imp_Documento1Class.php"); 
			  $print = new Imp_Documento($this -> Conex); 
			  $print -> printOut();
		  }else{
				exit('Registro No Contabilizado');  
		  }

	  }
	  
      $Layout -> RenderMain();	  
    
  }   
  
	
}

new Imp_LiquidacionVacaciones();

?>