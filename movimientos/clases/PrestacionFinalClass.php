<?php

require_once("../../../framework/clases/ControlerClass.php");

final class PrestacionFinal extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("PrestacionFinalLayoutClass.php");
    require_once("PrestacionFinalModelClass.php");
	
    $Layout = new PrestacionFinalLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new PrestacionFinalModel();
	
    $Layout -> setIncludes();
	$contrato_id=$_REQUEST['contrato_id'];
	$liquidacion_definitiva_id=$_REQUEST['liquidacion_definitiva_id'];
		
	if($contrato_id>0){
		$valor_pagar = 0;
		$prestaciones= 0;
		$liquidacion = 0;
		$deducciones = 0;

		$fecha_final = $_REQUEST['fecha_final'];
		$periodo = substr($fecha_final,0,4);
		$datos_periodo= $Model -> getDatosperiodo($periodo,$this -> getConex());			

		//$dias = $Model -> getDias($_REQUEST['fecha_inicio'],$_REQUEST['fecha_final'],$this -> getConex());
		$dias = $this -> restaFechasCont($_REQUEST['fecha_inicio'],$_REQUEST['fecha_final']);

		
		//prestaciones
		$data = $Model -> getDetallesContrato($contrato_id,$dias,$this -> getConex());
		$x=0;
		$datos=array();
		//cesantias
		$data_ces = $Model -> getDetallesCesantias($contrato_id,$_REQUEST['fecha_final'],$this -> getConex());
		$dias_ces = $data_ces[0]['dias_dif']>0 ?  $data_ces[0]['dias_dif'] : $dias; 
		$valor_cesan = intval((($data[0]['sueldo_base']+$data[0]['subsidio_transporte'])* $dias_ces) / 360);
		$desde_cesan = $data_ces[0]['fecha_ultimo_corte']!='' ? $data_ces[0]['fecha_ultimo_corte'] : $_REQUEST['fecha_inicio'];
		$datos[$x]['concepto']= 'CESANTIAS';	
		$datos[$x]['dias']    = $data_ces[0]['dias_dif']>0 ?  $data_ces[0]['dias_dif'] : $dias; 
		$datos[$x]['periodo']= 	 'De: '.$desde_cesan.' Hasta: '.$_REQUEST['fecha_final'];
		$datos[$x]['debito']= 0; 
		$datos[$x]['valor']= $valor_cesan; 
		$x++;

		
		//int cesantias
		$data_ices = $Model -> getDetallesIntCesantias($contrato_id,$_REQUEST['fecha_final'],$this -> getConex());
		$dias_ices = $data_ices[0]['dias_dif']>0 ?  $data_ices[0]['dias_dif'] : $dias; 
		$valor_icesan = intval(((($data[0]['sueldo_base']+$data[0]['subsidio_transporte'])*0.12)* $dias_ices) / 360);
		$desde_icesan = $data_ices[0]['fecha_ultimo_corte']!='' ? $data_ices[0]['fecha_ultimo_corte'] : $_REQUEST['fecha_inicio'];
		$datos[$x]['concepto']= 'INT. CESANTIAS';	
		$datos[$x]['dias']= 	$data_ices[0]['dias_dif']>0 ?  $data_ices[0]['dias_dif'] : $dias;
		$datos[$x]['periodo']= 	 'De: '.$desde_icesan.' Hasta: '.$_REQUEST['fecha_final'];
		$datos[$x]['debito']= 0; 
		$datos[$x]['valor']= $valor_icesan; 
		$x++;	
		
		// prima
		$data_prima = $Model -> getDetallesPrima($contrato_id,$_REQUEST['fecha_final'],$this -> getConex());
		
		if($data_prima[0]['periodo']==2){
			$fecha_ultima = substr($data_prima[0]['fecha_liquidacion'],0,4).'-12-31';
			$dias_prima = $Model -> getDias($fecha_ultima,$_REQUEST['fecha_final'],$this -> getConex());	
		}elseif($data_prima[0]['periodo']==1){
			$fecha_ultima = substr($data_prima[0]['fecha_liquidacion'],0,4).'-06-30';	
			$dias_prima = $Model -> getDias($fecha_ultima,$_REQUEST['fecha_final'],$this -> getConex());	
		}else{
			$dias_prima =	$dias;
			$fecha_ultima = $_REQUEST['fecha_inicio'];
		}
		$valor_prima = intval(((($data[0]['sueldo_base']+$data[0]['subsidio_transporte']))* $dias_prima) / 360);
		$datos[$x]['concepto']= 'PRIMA SERVICIOS';	
		$datos[$x]['dias']= 	$dias_prima; 
		$datos[$x]['periodo']= 	 'De: '.$fecha_ultima.' Hasta: '.$_REQUEST['fecha_final'];
		$datos[$x]['debito']= 0; 
		$datos[$x]['valor']= $valor_prima; 
		$x++;		

		
		// vacaciones
		$data_vaca = $Model -> getDetallesVacaciones($contrato_id,$_REQUEST['fecha_final'],$this -> getConex());
		$periodos = $dias/365;   
		$dias_dis = intval(15*$periodos); 
		if($data_vaca[0]['dias_va']<=0){
			$dias_deb_vac = $dias; 
		}else{
			$dias_deb_vac = $dias_dis-$data_vaca[0]['dias_va']; 	
		}
		$valor_vacas = intval((($data[0]['sueldo_base'])* $dias_deb_vac) / 720);
		$desde_vacas = $data_vaca[0]['fecha_ultima']!='' ? $data_vaca[0]['fecha_ultima'] : $_REQUEST['fecha_inicio'];
		$datos[$x]['concepto']= 	'PRIMA VACACIONES';	
		$datos[$x]['dias']= 	$dias_deb_vac>0 ?  $dias_deb_vac : $dias;
		$datos[$x]['periodo']= 	 'De: '.$desde_vacas.' Hasta: '.$_REQUEST['fecha_final'];
		$datos[$x]['debito']= 0; 
		$datos[$x]['valor']= $valor_vacas; 
		$x++;				

		$prestaciones = $valor_cesan+$valor_icesan +$valor_prima + $valor_vacas;	
		$datos[$x]['titulo']= 'TOTAL PRESTACIONES SOCIALES'; 
		$datos[$x]['valor']= $prestaciones; 
		$datos[$x]['campo']= 'prestaciones'; 
		$x++;
		//indemnizacion
		if($_REQUEST['justificado']=='S'){ 

			$periodos = $dias/365;
			
			if($periodos>1){
				$periodo_otros = ($periodos-1); 
				$valor_otros = ((($data[0]['sueldo_base']/30)*$datos_periodo[0]['dias_2anio_indem'])*$periodo_otros);
				$valor_indem=intval((($data[0]['sueldo_base']/30)*$datos_periodo[0]['dias_anio_indem'])  + $valor_otros ); 		
				
			}elseif($periodos<1){
				$valor_indem=intval((($data[0]['sueldo_base']/30)*$datos_periodo[0]['dias_anio_indem'])*$periodos); 			

			}elseif($periodos==1){				
				$valor_indem=intval(($data[0]['sueldo_base']/30)*$datos_periodo[0]['dias_anio_indem']); 
			}

			$datos[$x]['concepto']= 	'INDEMNIZACION';	
			$datos[$x]['dias']= 	 $dias;
			$datos[$x]['periodo']= 	 'De: '.$_REQUEST['fecha_inicio'].' Hasta: '.$_REQUEST['fecha_final'];
			$datos[$x]['debito']= 0; 
			$datos[$x]['valor']= $valor_indem; 
			$x++;				

			
		}
		
		//salario
		$data_sal = $Model -> getDetallesSalario($contrato_id,$_REQUEST['fecha_final'],$this -> getConex());
		if($data_sal[0]['dias_dif']>0){

			$valor_salario = (($data[0]['sueldo_base']/30)*$data_sal[0]['dias_dif']);
			$datos[$x]['concepto']= 	'SALARIO';	
			$datos[$x]['dias']= 	 $data_sal[0]['dias_dif'];
			$datos[$x]['periodo']= 	 'De: '.$data_sal[0]['fecha_final'].' Hasta: '.$_REQUEST['fecha_final'];
			$datos[$x]['debito']= 0; 
			$datos[$x]['valor']= $valor_salario; 
			$x++;				

		}elseif($data_sal[0]['dias_dif']<0){
			
		}else{
			
		}


		//subsidio transpore
		$data_sal = $Model -> getDetallesSalario($contrato_id,$_REQUEST['fecha_final'],$this -> getConex());
		if($data_sal[0]['dias_dif']>0){

			$valor_subsidio = (($data[0]['subsidio_transporte']/30)*$data_sal[0]['dias_dif']);
			$datos[$x]['concepto']= 	'SUBSIDIO';	
			$datos[$x]['dias']= 	 $data_sal[0]['dias_dif'];
			$datos[$x]['periodo']= 	 'De: '.$data_sal[0]['fecha_final'].' Hasta: '.$_REQUEST['fecha_final'];
			$datos[$x]['debito']= 0; 
			$datos[$x]['valor']= $valor_subsidio; 
			$x++;				

		}elseif($data_sal[0]['dias_dif']<0){
			
		}else{
			
		}

		$liquidacion =  $prestaciones+$valor_salario+$valor_indem+$valor_subsidio;	
		$datos[$x]['titulo']= 'TOTAL LIQUIDACION'; 
		$datos[$x]['valor']= $liquidacion; 
		$datos[$x]['campo']= 'liquidacion'; 
		$x++;

		//deducciones parafiscales
		if($data_sal[0]['dias_dif']>0){

			$valor_salud = intval(((($data[0]['sueldo_base']/30)*$data_sal[0]['dias_dif']) * $datos_periodo[0]['desc_emple_salud'])/100);
			$datos[$x]['concepto']= 	'APORTE SALUD';	
			$datos[$x]['dias']= 	 $data_sal[0]['dias_dif'];
			$datos[$x]['periodo']= 	 'De: '.$data_sal[0]['fecha_final'].' Hasta: '.$_REQUEST['fecha_final'];
			$datos[$x]['debito']= 0; 
			$datos[$x]['valor']= $valor_salud; 
			$deducciones=$deducciones+$valor_salud;
			$x++;				

			$valor_pension = intval(((($data[0]['sueldo_base']/30)*$data_sal[0]['dias_dif']) * $datos_periodo[0]['desc_emple_pension'])/100);
			$datos[$x]['concepto']= 	'APORTE PENSION';	
			$datos[$x]['dias']= 	 $data_sal[0]['dias_dif'];
			$datos[$x]['periodo']= 	 'De: '.$data_sal[0]['fecha_final'].' Hasta: '.$_REQUEST['fecha_final'];
			$datos[$x]['debito']= 0; 
			$datos[$x]['valor']= $valor_pension; 
			$deducciones=$deducciones+$valor_pension;
			$x++;				

		}		
		//deducciones
		$data_ded = $Model -> getDetallesDeducciones($contrato_id,$dias,$this -> getConex());
		if(count($data_ded)>0){

			for($i=0;$i<count($data_ded);$i++){
				$deta_ded = $Model -> getDetallesDeduccionesDetalle($contrato_id,$data_ded[$i]['concepto_area_id'],$this -> getConex());
				$valor_debe=$data_ded[$i]['valor']-$deta_ded[0]['valor'];

				if($valor_debe>0){//si debe
					$datos[$x]['concepto']= 'DEBE '.$data_ded[$i]['concepto'];		
					$datos[$x]['dias']= 	''; 
					$datos[$x]['periodo']= 	'';
					$datos[$x]['debito']=$valor_debe; 
					$datos[$x]['valor']=$valor_debe; 
					$deducciones=$deducciones+$valor_debe;
					$x++;								
					
				}elseif($valor_debe<0){// si se le devuelve al empleado
					$datos[$x]['concepto']= 'A FAVOR '.$data_ded[$i]['concepto'];	
					$datos[$x]['dias']= 	'';  
					$datos[$x]['periodo']= 	'';
					$datos[$x]['credito']=abs($valor_debe); 
					$datos[$x]['valor']=$valor_debe; 
					$x++;		
				}
			}
			$datos[$x]['titulo']= 'TOTAL DEDUCCIONES';
			$datos[$x]['valor']= $deducciones; 
			$datos[$x]['campo']= 'deduccion'; 
			$x++;

		}
		$valor_pagar = $liquidacion-$deducciones;
		$datos[$x]['titulo']= 'VALOR A PAGAR';
		$datos[$x]['valor']= $valor_pagar; 
		$datos[$x]['campo']= 'valor_pagar'; 
		$x++;
		
	    $Layout -> setDetallesRegistrar($datos);
	}elseif($liquidacion_definitiva_id>0){
		$data1=$Model -> getDetallesLiquidacionPres($liquidacion_definitiva_id,$this -> getConex());
		$y=(count($data1)+1);
		$prestaciones=$data1[0]['total'];
		$data1[$y]['titulo']= 'TOTAL PRESTACIONES SOCIALES';
		$data1[$y]['valor']= $prestaciones; 
		$data1[$y]['campo']= 'prestaciones'; 
		
		$data2=$Model -> getDetallesLiquidacionIndem($liquidacion_definitiva_id,$this -> getConex());
		$data3=$Model -> getDetallesLiquidacionSala($liquidacion_definitiva_id,$this -> getConex());

		$y=(count($data3)+1);
		$liquidacion = $data1[0]['total']+$data2[0]['total']+$data3[0]['total'];
		$data3[$y]['titulo']= 'TOTAL LIQUIDACION';
		$data3[$y]['valor']= $liquidacion; 
		$data3[$y]['campo']= 'liquidacion'; 

		$data4=$Model -> getDetallesLiquidaciondeduc($liquidacion_definitiva_id,$this -> getConex());	
		$y=(count($data4)+1);
		$deducciones = $data4[0]['total'];
		$data4[$y]['titulo']= 'TOTAL DEDUCCIONES';
		$data4[$y]['valor']= $deducciones; 
		$data4[$y]['campo']= 'deduccion'; 
		$y++;
		$valor_pagar = $liquidacion-$deducciones;
		$data4[$y]['titulo']= 'VALOR A PAGAR';
		$data4[$y]['valor']= $valor_pagar; 
		$data4[$y]['campo']= 'valor_pagar'; 

		$datos = array_merge($data1,$data2,$data3,$data4);

		$Layout -> setDetallesRegistrar($datos);
	}
	
    $Layout -> RenderMain();
    
  }
  


  protected function onclickUpdate(){
  
    require_once("PrestacionFinalModelClass.php");
	
    $Model = new PrestacionFinalModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }

  /*protected function restaFechasCont($f1,$f2){

	$aFecha1 = explode('-',$f1); 
	$aFecha2 = explode('-',$f2);  

	$dias	= intval(floor(abs((strtotime($f1)-strtotime($f2))/86400))+1);

	$meses=intval($dias/30);
	$meses_res= (($dias/30)-$meses);

	$ultimoDia=date("d",(mktime(0,0,0,$aFecha1[1]+1,1,$aFecha1[0])-1));
	$ultimoDiaFin =  date("d",(mktime(0,0,0,$aFecha2[1]+1,1,$aFecha2[0])-1)); 

	if($aFecha1[0]==$aFecha2[0] && $aFecha1[1]==$aFecha2[1] && $aFecha1[2]=='01' &&  $aFecha2[2]==$ultimoDia){
		$dias=30;
	}else if($meses==1 && $ultimoDiaFin==31 && $aFecha2[2]==31){
		
		 $dias = intval(floor(abs((strtotime($aFecha1[0].'-'.$aFecha2[1].'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha2[2]))/86400))); 
		 $dias= ($dias+30); 
		
	}else if($meses==1){

		 if($aFecha1[2]<=$aFecha2[2]){
			 $dias = intval(floor(abs((strtotime($aFecha1[0].'-'.$aFecha2[1].'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha2[2]))/86400))); 
			 $dias= ($dias+31); 
			 
		 }else{
			 $dias = intval(floor(abs((strtotime($aFecha2[0].'-'.($aFecha2[1]-1).'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha2[2]))/86400))); 
			 $dias= ($dias+29); 
		 }

	}else if($meses>1){
		 $cont_mes=0;
		 if($aFecha1[0]==$aFecha2[0]){
			 if($aFecha1[2]<=$aFecha2[2]){
				$dia_ult = $aFecha2[2]!=31 ? $aFecha2[2] : 30; 

				$dias_dif = intval(floor(abs((strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$dia_ult))/86400))); 
				
				$cont_mes=($aFecha2[1]-$aFecha1[1]);
				$dias=(($cont_mes*30)+$dias_dif+1);
			 }else{

				$dias_dif = intval(floor(abs((strtotime($aFecha2[0].'-'.($aFecha2[1]-1).'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha2[2]))/86400))+1); 

				 
				$cont_mes=($aFecha2[1]-$aFecha1[1]);
				$dias=((($cont_mes-1)*30)+$dias_dif);
				 
			 }
		 }else{
			 //FALTA CUANDO ES MAS DE UN ANIO A OTRO
			 if($aFecha1[1]<=$aFecha2[1]){
				//ok
				$dias_dif = intval(floor(abs((strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha2[2]))/86400))); 

				$meses_dif_dias=(($aFecha2[1]-$aFecha1[1])*30); 
				
				$dif_year_dias= (($aFecha2[0]-$aFecha1[0])*360);
				$dias = ($dias_dif+$meses_dif_dias+$dif_year_dias);
				 
				   
			 }else{
				//ok
				$dias_dif = intval(floor(abs((strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha1[2])-strtotime($aFecha2[0].'-'.$aFecha2[1].'-'.$aFecha2[2]))/86400))); 
				
				
				$meses_dif_dias=(((12-($aFecha1[1]-$aFecha2[1])))*30); 
				$dif_year_dias= ((($aFecha2[0]-1)-$aFecha1[0])*360);

				$dias = ($dias_dif+$meses_dif_dias+$dif_year_dias);

			 }
			 
		 }
		 
	}

	return $dias;

	  
  }*/


  //CAMPOS
  protected function setCampos(){

	
	$this -> Campos[detalle_liquidacion_novedad_id] = array(
		name	=>'detalle_liquidacion_novedad_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('primary_key'))
	);

	$this -> Campos[liquidacion_novedad_id] = array(
		name	=>'liquidacion_novedad_id',
		id		=>'liquidacion_novedad_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[formula] = array(
		name	=>'formula',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);
	
	$this -> Campos[base] = array(
		name	=>'base',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	

	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	

	$this -> Campos[debito] = array(
		name	=>'debito',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	

	$this -> Campos[credito] = array(
		name	=>'credito',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_inicial] = array(
		name	=>'fecha_inicial',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);		

	$this -> Campos[dias] = array(
		name	=>'dias',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);		

	$this -> Campos[observacion] = array(
		name	=>'observacion',
		type	=>'text',
		datatype=>array(
			type	=>'varchar',
			length	=>'100'),
		transaction=>array(
			table	=>array('detalle_liquidacion_novedad'),
			type	=>array('column'))
	);		


	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$PrestacionFinal = new PrestacionFinal();

?>