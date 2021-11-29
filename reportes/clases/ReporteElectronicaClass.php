<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ReporteElectronica extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("ReporteElectronicaLayoutClass.php");
    require_once("ReporteElectronicaModelClass.php");
	
    $Layout   = new ReporteElectronicaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReporteElectronicaModel();
    
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

  protected function generateView(){
    require_once("ReporteElectronicaLayoutClass.php");
    require_once("ReporteElectronicaModelClass.php");
      
    $Layout         = new ReporteElectronicaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model      	= new ReporteElectronicaModel();	
    $desde			= $_REQUEST['desde'];
    $hasta			= $_REQUEST['hasta'];
    $si_empleado	= $_REQUEST['si_empleado'];
    $empleado_id	= $_REQUEST['empleado_id']>0 ? $_REQUEST['empleado_id'] : '';	
    $empresa_id     = $this->getEmpresaId();

	$data = $Model -> getReporte($desde,$hasta,$empresa_id,$empleado_id,$this -> getConex());

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/reportes.css");						
    $Layout -> setCssInclude("../css/reportes.css","print");
    $Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
    $Layout -> setJsInclude("../../../framework/js/funciones.js");
    $Layout -> setJsInclude("../../../transporte/reportes/js/detalles.js");
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());		

    $Layout -> setVar('EMPRESA',$empresa);	
    $Layout -> setVar('NIT',$nitEmpresa);	
    $Layout -> setVar('CENTROS',$centrosTxt);													
    $Layout -> setVar('DESDE',$desde);															
    $Layout -> setVar('HASTA',$hasta);

    $Layout -> setVar('parametros',$parametros); 
    $Layout -> setVar('DETALLES',$data); 
    $Layout -> setVar('USUARIO',$this -> getUsuarioNombres());		  	  	  	  	  

    $Layout -> RenderLayout('ReporteElectronicaResultado.tpl');	  
  }    
    
  protected function generateFileexcel(){
  
    require_once("ReporteElectronicaModelClass.php");
	
	$Model      	        = new ReporteElectronicaModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
    $si_empleado			= $_REQUEST['si_empleado'];
	$empleado_id	        = $_REQUEST['empleado_id']>0 ? $_REQUEST['empleado_id'] : '';
    $empresa_id             = $this->getEmpresaId(); 
	
	$nombre = 'Rep_NomElec'.date('Ymd_Hi');  
    $data = $Model -> getReporte($desde,$hasta,$empresa_id,$empleado_id,$this -> getConex());
   	$ruta  = $this -> arrayToExcel("Rep_NomElec",$nombre,$data,null,"string");	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }    
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		type	=>'select',
		Boostrap => 'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'empleado_si();'
	);
	
		$this -> Campos[si_cargo] = array(
		name	=>'si_cargo',
		id		=>'si_cargo',
		type	=>'select',
		Boostrap => 'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'cargo_si();'
	);



	$this -> Campos[cargo_id] = array(
		name	=>'cargo_id',
		id		=>'cargo_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[cargo] = array(
		name	=>'cargo',
		id		=>'cargo',
		type	=>'text',
		Boostrap => 'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cargo',
			setId	=>'cargo_id')
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
		Boostrap => 'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'empleado',
			setId	=>'empleado_id')
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
				onclick	=>'ContratoOnReset()'
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  }

$ReporteElectronica = new ReporteElectronica();

?>