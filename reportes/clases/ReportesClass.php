<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Reportes extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ReportesLayoutClass.php");
	require_once("ReportesModelClass.php");
	
	$Layout   = new ReportesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReportesModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	$Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
	$Layout -> SetTablas($Model -> GetTablas($this -> getConex()));	
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	


	$Layout -> RenderMain();
  
  }

/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento($this -> getConex());
    $print -> printOut();
  
  }*/


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	

	$this -> Campos[tablas_id] = array(
		name	=>'tablas_id',
		id		=>'tablas_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);

	$this -> Campos[all_tablas] = array(
		name	=>'all_tablas',
		id		=>'all_tablas',
		type	=>'checkbox',
		onclick =>'alltablas();',
		value	=>'NO'
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
		required=>'yes'
	);

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

	$this -> Campos[si_usuario] = array(
		name	=>'si_usuario',
		id		=>'si_usuario',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Usuario_si();'
	);
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);


	$this -> Campos[usuario] = array(
		name	=>'usuario',
		id		=>'usuario',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'usuario_log',
			setId	=>'usuario_id')
	);

	$this -> Campos[palabra] = array(
		name	=>'palabra',
		id		=>'palabra',
		type	=>'text'
	);


	 	  
	/**********************************
 	             Botones
	**********************************/
	 
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

   	$this -> Campos[generar_excel] = array(
		name	=>'generar_excel',
		id		=>'generar_excel',
		type	=>'button',
		value	=>'Generar Excel',
		onclick =>'OnclickGenerarexcel(this.form)'
	);	
	
	   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'usuarioOnReset(this.form)'
	);

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
	disabled=>'disabled',
    value   =>'Imprimir',
	onclick => 'imprimir_reporte(this.form)'
    );

	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Reportes = new Reportes();

?>