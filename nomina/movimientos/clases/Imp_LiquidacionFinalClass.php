<?php

final class Imp_LiquidacionFinal{

  private $Conex;
  private $empresa_id;

  public function __construct($empresa_id,$Conex){
    $this -> Conex = $Conex; 
	$this -> getEmpresaId = $empresa_id; 
  }

  public function printOut(){
  	
      require_once("Imp_LiquidacionFinalLayoutClass.php");
      require_once("Imp_LiquidacionFinalModelClass.php");
		
      $Layout = new Imp_LiquidacionFinalLayout();
      $Model  = new Imp_LiquidacionFinalModel();		
	
      $Layout -> setIncludes();
	   $liquidacion_definitiva_id = $_REQUEST['liquidacion_definitiva_id'];
	


	  if($_REQUEST['tipo_impresion']=='CL'){
		  $liquidacion1 = $Model -> getLiquidacion2($liquidacion_definitiva_id,$this -> getEmpresaId,$this -> Conex);
		  

			$data1=$Model -> getDetallesLiquidacionPres($liquidacion_definitiva_id,$this -> Conex);
			$y=(count($data1)+1);
			$prestaciones=$data1[0]['total'];
			$data1[$y]['titulo']= 'TOTAL PRESTACIONES SOCIALES';
			$data1[$y]['valor']= $prestaciones; 
			$data1[$y]['campo']= 'prestaciones'; 
			
			$data2=$Model -> getDetallesLiquidacionIndem($liquidacion_definitiva_id,$this -> Conex);
			$data3=$Model -> getDetallesLiquidacionSala($liquidacion_definitiva_id,$this -> Conex);
			
			$y=(count($data3)+1);
			$liquidacion = $data1[0]['total']+$data2[0]['total']+$data3[0]['total'];
			$data3[$y]['titulo']= 'TOTAL LIQUIDACION';
			$data3[$y]['valor']= $liquidacion; 
			$data3[$y]['campo']= 'liquidacion'; 
			
			$data4=$Model -> getDetallesLiquidaciondeduc($liquidacion_definitiva_id,$this -> Conex);	
			$y=(count($data4)+1);
			$deducciones = $data4[0]['total'];
			$data4[$y]['titulo']= 'TOTAL DEDUCCIONES';
			$data4[$y]['valor']= $deducciones; 
			$data4[$y]['campo']= 'deduccion'; 
			
			$data5 = $Model->getDetallesLiquidaciondeven($liquidacion_definitiva_id, $this -> Conex);
			
			$y = (count($data5) + 1);
			$devengados = $data5[0]['total'];
			$data5[$y]['titulo'] = 'TOTAL DEVENGADOS';
			$data5[$y]['valor'] = $devengados;
			$data5[$y]['campo'] = 'devengado';
			$y++;
			
			$valor_pagar = $liquidacion + $devengados - $deducciones;
			$data5[$y]['titulo']= 'VALOR A PAGAR';
			$data5[$y]['valor']= $valor_pagar; 
			$data5[$y]['campo']= 'valor_pagar'; 
			
			$datos = array_merge($data1, $data2, $data3, $data4, $data5);


		  $Layout -> setLiquidacion1($liquidacion1,$datos);

	  }elseif($_REQUEST['tipo_impresion']=='DC'){

		  $liquidacion = $Model -> getLiquidacion3($liquidacion_definitiva_id,$this -> getEmpresaId,$this -> Conex);
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

new Imp_LiquidacionFinal();

?>