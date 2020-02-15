<?php
require_once("../../../framework/clases/ControlerClass.php");

final class mandoContratos extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   
	require_once("mandoContratosLayoutClass.php");
	require_once("mandoContratosModelClass.php");
	
	$Layout = new mandoContratosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new mandoContratosModel();
    
    $Layout -> setIncludes();		
	//// GRID ////
	$Attributes = array(
	  id		=>'numero_contrato',
	  title		=>'CONTRATOS ACTIVOS',
	  sortname	=>'dias',	  	  
	  width		=>'auto',
	  height	=>'auto'
	);
	$Cols = array(
	  array(name=>'numero_contrato',            index=>'numero_contrato',       sorttype=>'text',	width=>'60',	align=>'left'), 
	  array(name=>'tipo_contrato',	            index=>'tipo_contrato',			    sorttype=>'text',   width=>'150',	align=>'left'), 
	  array(name=>'empleado',	                  index=>'empleado',	            sorttype=>'text',	width=>'160',	align=>'left'),
      array(name=>'fecha_inicio',			        index=>'fecha_inicio',			    sorttype=>'text',	width=>'140',   align=>'left'),
      array(name=>'fecha_terminacion',	      index=>'fecha_terminacion',	    sorttype=>'text',	width=>'120',   align=>'left'),
      array(name=>'cargo',	                  index=>'cargo',	                sorttype=>'text',	width=>'120',	align=>'left'), 	  
      array(name=>'estado',	                  index=>'estado',	              sorttype=>'text',	width=>'60',	align=>'left'),
      array(name=>'dias',	                    index=>'dias',	                    sorttype=>'text',	width=>'120',	align=>'left'),
    );

    $Titles = array(
		            'CONTRATO', 
				      	'TIPO CONTRATO', 
					      'EMPLEADO',
                'FECHA INICIO',
                'FECHA TERMINACION',
                'CARGO',
                'ESTADO',	
                'DIAS',				
	);
   
	
	$Layout -> SetGridMandoContratos($Attributes,$Titles,$Cols,$Model -> getQueryMandoContratosGrid());
	
	$Layout -> RenderMain();
   
  }
  
  protected function ProximosVencer(){

    require_once("mandoContratosModelClass.php");
    $Model = new mandoContratosModel();
	
    $result = $Model -> SelectVencimientos($this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       $this -> getArrayJSON($result);
	 }	
  }

  protected function vencidos(){

    require_once("mandoContratosModelClass.php");
    $Model = new mandoContratosModel();
	
    $result = $Model -> SelectVencidos($this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       $this -> getArrayJSON($result);
	 }	
  }

  
}

new mandoContratos();



?>