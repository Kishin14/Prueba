<?php

final class Imp_LiquidacionPrima{

  private $Conex;
  private $empresa_id;

  public function __construct($empresa_id,$Conex){
    $this -> Conex = $Conex; 
	$this -> getEmpresaId = $empresa_id; 
  }

  public function printOut(){
  	
      require_once("Imp_LiquidacionPrimaLayoutClass.php");
      require_once("Imp_LiquidacionPrimaModelClass.php");
		
     $Model  = new Imp_LiquidacionPrimaModel();		
	 $Layout = new Imp_LiquidacionPrimaLayout();
	  
	  
      $Layout -> setIncludes();
	   $liquidacion_prima_id = $_REQUEST['liquidacion_prima_id'];
	  if($_REQUEST['tipo_impresion']=='C'){
		  
		  $liquidacion = $Model -> getLiquidacion($desprendibles,$this -> getEmpresaId,$this -> Conex);
		  
		  for($i=0;$i<count($liquidacion);$i++){
			  $liquidacion[$i]['valor']= $Model -> getDetalles($liquidacion[$i]['liquidacion_prima_id'],$this -> getEmpresaId,$this -> Conex);
		  }
		  
		  $Layout -> setLiquidacion1($liquidacion);
		  
	  }elseif($_REQUEST['tipo_impresion']=='DP'){
		  $desprendibles=$_REQUEST['desprendibles'];
		  $liquidacion = $Model -> getLiquidacion1($desprendibles,$this -> getEmpresaId,$this -> Conex);
		  
		  for($i=0;$i<count($liquidacion);$i++){
			  $liquidacion[$i]['detalles']= $Model -> getDetalles($liquidacion[$i]['liquidacion_prima_id'],$this -> getEmpresaId,$this -> Conex);
		  }

		  $Layout -> setLiquidacion1($liquidacion);


	  }elseif($_REQUEST['tipo_impresion']=='CL'){
		  $desprendibles=$_REQUEST['desprendibles'];
		  $liquidacion = $Model -> getLiquidacion2($liquidacion_prima_id,$this -> getEmpresaId,$this -> Conex);
		  
		  for($i=0;$i<count($liquidacion);$i++){
			  $liquidacion[$i]['detalles']= $Model -> getDetalles($liquidacion[$i]['liquidacion_prima_id'],$this -> getEmpresaId,$this -> Conex);
		  }

		  $Layout -> setLiquidacion1($liquidacion);

	  }elseif($_REQUEST['tipo_impresion']=='DC'){
		  $desprendibles=$_REQUEST['desprendibles'];
		  $liquidacion = $Model -> getLiquidacion3($liquidacion_prima_id,$this -> getEmpresaId,$this -> Conex);
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

new Imp_LiquidacionPrima();

?>