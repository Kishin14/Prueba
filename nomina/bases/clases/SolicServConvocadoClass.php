<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicServToConvocado extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
   	
    require_once("SolicServToConvocadoLayoutClass.php");
    require_once("SolicServToConvocadoModelClass.php");
	
    $Layout = new SolicServToConvocadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new SolicServToConvocadoModel();
	
    $Layout -> setIncludes();	
    $Layout -> setCampos($this -> Campos);
	
			//// GRID ////
			$Attributes = array(
				id		=>'SolicServToConvocados',
				title	=>'Lista de Convocados',
				sortname=>'numero_identificacion',
				width	=>'auto',
				height	=>'200'
			);

			$Cols = array(
				array(name=>'link',                  index=>'link',      sorttype=>'text',	width=>'20',	align=>'center'),		  
				array(name=>'convocado_id',				index=>'convocado_id',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',	sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'numero_identificacion',	index=>'numero_identificacion',		sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'primer_nombre',			index=>'primer_nombre',				sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'segundo_nombre',			index=>'segundo_nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'primer_apellido',			index=>'primer_apellido',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'segundo_apellido',			index=>'segundo_apellido',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'direccion',				index=>'direccion',					sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'telefono',					index=>'telefono',					sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'movil',					index=>'movil',						sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'ubicacion_id',				index=>'ubicacion_id',				sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'estado',					index=>'estado',					sorttype=>'text',	width=>'150',	align=>'center')
			);

			$Titles = array(
				'&nbsp;',			
				'CONVOCADO',
				'TIPO IDENTIFICACION',
				'IDENTIFICACION',
				'PRIMER NOMBRE',
				'SEGUNDO NOMBRE',
				'PRIMER APELLIDO',
				'SEGUNDO APELLIDO',
				'DIRECCION',
				'TELEFONO',
				'MOVIL',
				'UBICACION',
				'ESTADO'
			);

			$Layout -> SetGridSolicServToConvocados($Attributes,$Titles,$Cols,$Model -> GetQuerySolicServToConvocadosGrid());
			$Layout -> RenderMain();
  }
  
  protected function setSolicitud(){
  
    require_once("SolicServToConvocadoModelClass.php");
	
    $Model          = new SolicServToConvocadoModel();		
    $solicitud_id   = $_REQUEST['convocado_id'];
    $detalles_ss_id = $_REQUEST['detalles_ss_id'];
	
    $return = $Model -> SelectConvocado($detalles_ss_id,$convocado_id,$this -> getConex());
	
    if(count($return) > 0){
      $this -> getArrayJSON($return);	
    }else{
	    exit('false');
       }
  
  }
  

  protected function setCampos(){
		
	//botones
	$this -> Campos[convocado] = array(
		name	=>'convocado',
		id		=>'convocado',
		type	=>'button',
		value=>'Importar',
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicServToConvocado = new SolicServToConvocado();

?>