<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ReportesUsuarios extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ReportesUsuariosLayoutClass.php");
	require_once("ReportesUsuariosModelClass.php");
	
	$Layout   = new ReportesUsuariosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReportesUsuariosModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	$Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetPermiso($Model -> GetPermiso($this -> getConex()));	
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
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);
	
	$this -> Campos[all_office] = array(
		name	=>'all_office',
		id		=>'all_office',
		type	=>'checkbox',
		onclick =>'ALL_OFFICE();',
		value	=>'NO'
	);

	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
		required=>'yes',
		multiple=>'yes'
	);
	
		$this -> Campos[all_tipos] = array(
		name	=>'all_tipos',
		id		=>'all_tipos',
		type	=>'checkbox',
		onclick =>'ALL_TYPES();',
		value	=>'NO'
	);
	
	$this -> Campos[permiso_id] = array(
		name	=>'permiso_id',
		id		=>'permiso_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);
	
	$this -> Campos[all_permiso] = array(
		name	=>'all_permiso',
		id		=>'all_permiso',
		type	=>'checkbox',
		onclick =>'ALL_PERMISES();',
		value	=>'NO'
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

	$this -> Campos[descargar] = array(
		name   =>'descargar',
		id   =>'descargar',
		type   =>'button',
		value   =>'Descargar Excel',
		onclick =>'descargarexcel(this.form)'
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
		value   =>'Imprimir',
		onclick =>'beforePrint(this.form)'
    );
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$ReportesUsuarios = new ReportesUsuarios();

?>