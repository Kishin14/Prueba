<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteIncapacidades extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
	
	
    require_once("reporteIncapacidadesLayoutClass.php");
    require_once("reporteIncapacidadesModelClass.php");
	
    $Layout   = new reporteIncapacidadesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteIncapacidadesModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    //$Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));   
	
	/* $Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex())); */	
	
	$Layout -> SetSi_Pro2($Model -> GetSi_Pro2($this -> getConex()));
	$Layout -> SetIndicadores ($Model -> GetIndicadores ($this -> getConex()));
	 
	$Layout -> RenderMain();    

 }  
  
/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento($this -> getConex());
    $print -> printOut();  
  }*/
  
  protected function generateFileexcel(){
  
    require_once("reporteIncapacidadesModelClass.php");
	
	$Model      	        = new reporteIncapacidadesModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cargo				= $_REQUEST['si_cargo'];
	$cargo_id				= $_REQUEST['cargo_id'];	
    $si_empleado			= $_REQUEST['si_empleado'];
	$empleado_id			= $_REQUEST['empleado_id'];	
	
	//if($tipo == 'MC'){
      	  
    /*}elseif($tipo == 'DU'){
			 $nombre = 'Rep_Ant_DU'.date('Ymd');
	}elseif($tipo == 'DP'){
	  		    $nombre = 'Rep_Ant_DP'.date('Ymd');	
	}*/
	
	$nombre = 'Rep_Conv'.date('Y-m-d'); 	
	if($si_empleado=='ALL' && $si_cargo=='ALL')
		$data = $Model -> getReporteMC1($desde,$hasta,$this -> getConex());
		
		elseif($si_empleado==1 && $si_cargo=='ALL')
		$data = $Model -> getReporteMC2($empleado_id,$desde,$hasta,$this -> getConex());
		
		elseif($si_empleado==1 && $si_cargo==1)
		$data = $Model -> getReporteMC3($empleado_id,$cargo_id,$desde,$hasta,$this -> getConex());

		elseif($si_empleado=='ALL' && $si_cargo==1)
		$data = $Model -> getReporteMC4($cargo_id,$desde,$hasta,$this -> getConex());
		
		
   	$ruta  = $this -> arrayToExcel("Reporte",$nombre,$data,null,"string");	
	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }    
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		type	=>'select',
		options	=>null,
		selected=>0,
		//required=>'yes',
		onchange=>'empleado_si();'
	);
	
		/* $this -> Campos[si_cargo] = array(
		name	=>'si_cargo',
		id		=>'si_cargo',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'cargo_si();'
	); */



/* 	$this -> Campos[cargo_id] = array(
		name	=>'cargo_id',
		id		=>'cargo_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	); */

	$this -> Campos[cie_enfermedades_id] = array(
	   name =>'cie_enfermedades_id',
	   id =>'cie_enfermedades_id',
	   type =>'hidden',
	   //required=>'yes',
	   datatype=>array(type=>'integer'),
	   datatype=>array(
		  type	=>'integer',
		  length	=>'20')
  );

   $this -> Campos[descripcion] = array(
	   name =>'descripcion',
	   id =>'descripcion',
	   type =>'text',
	   //disabled => 'yes',
	   size    =>'40',
	   suggest => array(
			name =>'enfermedades',
			setId =>'cie_enfermedades_id')
  );
	
	  $this -> Campos[empleado_id] = array(
	  name	=>'empleado_id',
	  id	=>'empleado_id',
	  type	=>'hidden',
	  value	=>'',
	  datatype=>array(
		  type	=>'integer',
		  length	=>'20')
	);

	$this -> Campos[empleado] = array(
		name	=>'empleado',
		id		=>'empleado',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'empleado',
			setId	=>'empleado_id')
	);	
	
/* 	$this -> Campos[opciones_estado] = array(
		name	=>'opciones_estado',
		id		=>'opciones_estado',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	); */				
	
	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		required=>'yes',
		options	=>array(array(value => 'L', text => 'LICENCIA'),array(value => 'I', text => 'INCAPACIDAD'))
	); 	
	
	$this -> Campos[indicadores] = array(
		name	=>'indicadores',
		id		=>'indicadores',
		type	=>'select',
		//Boostrap=>'si',
		options	=>null,
		selected=>'A',
		required=>'yes',
		onchange=>'setIndicadores();'
	);

/////// BOTONES 

	$this -> Campos[graficos] = array(
    name   =>'graficos',
    id   =>'graficos',
    type   =>'button',
    value   =>'Generar',
	onclick =>'mostrarGraficos(this.form)'
    ); 

	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
	/*displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Reporte',
      width       => '800',
      height      => '600'*/
    );
	
	$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'IncapacidadesOnReset(this.form)'
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  }


$reporteIncapacidades = new reporteIncapacidades();

?>