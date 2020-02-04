<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteConvocados extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("reporteConvocadosLayoutClass.php");
    require_once("reporteConvocadosModelClass.php");
	
    $Layout   = new reporteConvocadosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteConvocadosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    //$Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));   
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	
	$Layout -> SetSi_Pro2($Model -> GetSi_Pro2($this -> getConex()));
	$Layout -> RenderMain();    
  }  
  
/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento($this -> getConex());
    $print -> printOut();  
  }*/
  
  protected function generateFileexcel(){
  
    require_once("reporteConvocadosModelClass.php");
	
	$Model      	        = new reporteConvocadosModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_convocatoria				= $_REQUEST['si_convocatoria'];
	$convocatoria_id				= $_REQUEST['convocatoria_id'];	
    $si_convocado			= $_REQUEST['si_convocado'];
	$convocado_id			= $_REQUEST['convocado_id'];	
	
	//if($tipo == 'MC'){
      	  
    /*}elseif($tipo == 'DU'){
			 $nombre = 'Rep_Ant_DU'.date('Ymd');
	}elseif($tipo == 'DP'){
	  		    $nombre = 'Rep_Ant_DP'.date('Ymd');	
	}*/
	
	$nombre = 'Rep_Conv'.date('Y-m-d'); 	
	if($si_convocado=='ALL' && $si_convocatoria=='ALL')
		$data = $Model -> getReporteMC1($desde,$hasta,$this -> getConex());
		
		elseif($si_convocado==1 && $si_convocatoria=='ALL')
		$data = $Model -> getReporteMC2($convocado_id,$desde,$hasta,$this -> getConex());
		
		elseif($si_convocado==1 && $si_convocatoria==1)
		$data = $Model -> getReporteMC3($convocado_id,$convocatoria_id,$desde,$hasta,$this -> getConex());

		elseif($si_convocado=='ALL' && $si_convocatoria==1)
		$data = $Model -> getReporteMC4($convocatoria_id,$desde,$hasta,$this -> getConex());
		
		
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

	$this -> Campos[si_convocado] = array(
		name	=>'si_convocado',
		id		=>'si_convocado',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'convocado_si();'
	);
	
		$this -> Campos[si_convocatoria] = array(
		name	=>'si_convocatoria',
		id		=>'si_convocatoria',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'convocatoria_si();'
	);



	$this -> Campos[convocatoria_id] = array(
		name	=>'convocatoria_id',
		id		=>'convocatoria_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[convocatoria] = array(
		name	=>'convocatoria',
		id		=>'convocatoria',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'convocatoria',
			setId	=>'convocatoria_id')
	);	
	
	  $this -> Campos[convocado_id] = array(
	  name	=>'convocado_id',
	  id	=>'convocado_id',
	  type	=>'hidden',
	  value	=>'',
	  datatype=>array(
		  type	=>'integer',
		  length	=>'20')
	);

	$this -> Campos[convocado] = array(
		name	=>'convocado',
		id		=>'convocado',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'convocado',
			setId	=>'convocado_id')
	);	

/////// BOTONES 

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
				onclick	=>'ConvocadoOnReset(this.form)'
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  }


$reporteConvocados = new reporteConvocados();

?>