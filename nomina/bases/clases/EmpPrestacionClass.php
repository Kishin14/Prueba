<?php
require_once("../../../framework/clases/ControlerClass.php");

final class EmpPrestacion extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){
		$this -> noCache();

		require_once("EmpPrestacionLayoutClass.php");
		require_once("EmpPrestacionModelClass.php");

		$Layout   = new EmpPrestacionLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new EmpPrestacionModel();
		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		$Layout -> SetTipoPersonas($Model -> GetTipoPersonas($this -> getConex()));
		$Layout -> SetRegimen($Model -> GetRegimen($this -> getConex()));
		$Layout -> SetIdentificacion($Model -> GetIdentificacion($this -> getConex()));

		$Layout -> RenderMain();
	}
	
	protected function showGrid(){
	  
		require_once("EmpPrestacionLayoutClass.php");
		require_once("EmpPrestacionModelClass.php");

		$Layout   = new EmpPrestacionLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new EmpPrestacionModel();
		  
		  //// GRID ////
		$Attributes = array(
			id		=>'empresa_prestaciones',
			title	=>'Listado de Prestaciones sociales',
			sortname=>'numero_identificacion',
			width	=>'auto',
			height	=>'250'
		);

		$Cols = array(
			array(name=>'tipo_persona_id',	index=>'tipo_persona_id',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'numero_identificacion',			index=>'numero_identificacion',			sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'digito_verificacion',			index=>'digito_verificacion',			sorttype=>'text',	width=>'50',	align=>'left'),
			array(name=>'razon_social',			index=>'razon_social',			sorttype=>'text',	width=>'200',	align=>'left'),
			array(name=>'sigla',			index=>'sigla',			sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'email',			index=>'email',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'telefax',			index=>'telefax',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'telefono',			index=>'telefono',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'movil',			index=>'movil',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'codigo',	index=>'codigo',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'salud',	index=>'salud',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'pension',	index=>'pension',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'arl',	index=>'arl',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'caja_compensacion',	index=>'caja_compensacion',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'cesantias',	index=>'cesantias',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'parafiscales',	index=>'parafiscales',	sorttype=>'text',	width=>'100',	align=>'left'),			
			array(name=>'estado',			index=>'estado',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'retei_proveedor',			index=>'retei_proveedor',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'autoret_proveedor',			index=>'autoret_proveedor',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'ubicacion_id',			index=>'ubicacion_id',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'tipo_identificacion_id',			index=>'tipo_identificacion_id',			sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'regimen_id',			index=>'regimen_id',			sorttype=>'text',	width=>'100',	align=>'center')
		);

		$Titles = array(
			'TIPO PERSONA',
			'IDENTIFICACION',
			'DV',
			'RAZON SOCIAL',
			'SIGLA',
			'EMAIL',
			'TELEFAX',
			'TELEFONO',
			'MOVIL',
			'CODIGO',
			'SALUD',
			'PENSION',
			'ARL',
			'CAJA',
			'CESANTIAS',
			'PARAFISCALES',
			'ESTADO',
			'RETEI',
			'AUTORET',
			'UBICACION',
			'TIPO IDENTIFICACION',
			'REGIMEN'
		);
		
		$html = $Layout -> SetGridEmpPrestacion($Attributes,$Titles,$Cols,$Model -> GetQueryEmpPrestacionGrid());
		 
		 print $html;
		  
	  }

	protected function onclickValidateRow(){
		require_once("EmpPrestacionModelClass.php");
		$Model = new EmpPrestacionModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("EmpPrestacionModelClass.php");
		$Model = new EmpPrestacionModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente la prestación social');
		}
	}

	protected function onclickUpdate(){

		require_once("EmpPrestacionModelClass.php");
		$Model = new EmpPrestacionModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente la prestación social');
		}
	}


	protected function onclickDelete(){

		require_once("EmpPrestacionModelClass.php");
		$Model = new EmpPrestacionModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar la prestación social');
		}else{
			exit('Se borro exitosamente la prestación social');
		}
	}


	//BUSQUEDA
	protected function onclickFind(){
		require_once("EmpPrestacionModelClass.php");
		$Model = new EmpPrestacionModel();
		$Data                  = array();
		$tercero_id   = $_REQUEST['tercero_id'];
		$numero_identificacion = $_REQUEST['numero_identificacion'];
		if(is_numeric($tercero_id)){
			$Data  = $Model -> selectDatosEmpresa($tercero_id,$this -> getConex());
		}else if(is_numeric($numero_identificacion)){
			  
			$Data  = $Model -> selectDatosEmpresaNumeroId($numero_identificacion,$this -> getConex());
		 }
		echo json_encode($Data);
	}


	protected function SetCampos(){

		/********************
		Campos Tarifas Proveedor
		********************/

		$this -> Campos[empresa_id] = array(
			name	=>'empresa_id',
			id		=>'empresa_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('primary_key'))
		);

		$this -> Campos[tercero_id] = array(
			name	=>'tercero_id',
			id		=>'tercero_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'20'),
			transaction=>array(
				table	=>array('tercero','empresa_prestaciones'),
				type	=>array('primary_key','column'))
		);

		$this -> Campos[codigo] = array(
			name	=>'codigo',
			id		=>'codigo',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'5'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		$this -> Campos[salud] = array(
			name	=>'salud',
			id		=>'salud',
			type	=>'select',
			Boostrap =>'si',
			required=>'yes',
			options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),				
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		$this -> Campos[pension] = array(
			name	=>'pension',
			id		=>'pension',
			type	=>'select',
			Boostrap =>'si',
			required=>'yes',
			options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),				
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		$this -> Campos[arl] = array(
			name	=>'arl',
			id		=>'arl',
			type	=>'select',
			Boostrap =>'si',
			required=>'yes',
			options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		$this -> Campos[caja_compensacion] = array(
			name	=>'caja_compensacion',
			id		=>'caja_compensacion',
			type	=>'select',
			Boostrap =>'si',
			required=>'yes',
			options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		$this -> Campos[cesantias] = array(
			name	=>'cesantias',
			id		=>'cesantias',
			type	=>'select',
			Boostrap =>'si',
			required=>'yes',
			options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		$this -> Campos[parafiscales] = array(
			name	=>'parafiscales',
			id		=>'parafiscales',
			type	=>'select',
			Boostrap =>'si',
			required=>'yes',
			options	=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('empresa_prestaciones'),
				type	=>array('column'))
		);

		//Tabla Tercero
		$this -> Campos[ubicacion_id] = array(
			name	=>'ubicacion_id',
			id		=>'ubicacion_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[ubicacion] = array(
			name	=>'ubicacion',
			id		=>'ubicacion',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			suggest=>array(
				name	=>'ciudad',
				setId	=>'ubicacion_id'),
			datatype=>array(
				type	=>'text',
				length	=>'150')
		);

		$this -> Campos[tipo_persona_id] = array(
			name	=>'tipo_persona_id',
			id		=>'tipo_persona_id',
			type	=>'select',
			Boostrap =>'si',
			options	=> null,
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[tipo_identificacion_id] = array(
			name	=>'tipo_identificacion_id',
			id		=>'tipo_identificacion_id',
			type	=>'select',
			Boostrap =>'si',
			options	=> null,
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[numero_identificacion] = array(
			name	=>'numero_identificacion',
			id		=>'numero_identificacion',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			//tabindex=>'2',
			onblur =>'calculaDigitoTercero()',
			datatype=>array(
				type	=>'integer',
				length	=>'9',
				precision=>'0'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[digito_verificacion] = array(
			name	=>'digito_verificacion',
			id		=>'digito_verificacion',
			type	=>'text',
			Boostrap =>'si',
			readonly=>'readonly',
			size	=>'1',
			//tabindex=>'3',
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);


		$this -> Campos[razon_social] = array(
			name	=>'razon_social',
			id		=>'razon_social',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[sigla] = array(
			name	=>'sigla',
			id		=>'sigla',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[direccion] = array(
			name	=>'direccion',
			id		=>'direccion',
			type	=>'text',
			required=>'yes',
			Boostrap =>'si',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[email] = array(
			name	=>'email',
			id		=>'email',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'100'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[telefax] = array(
			name	=>'telefax',
			id		=>'telefax',
			type	=>'text',
			Boostrap =>'si',
			//required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'20'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[telefono] = array(
			name	=>'telefono',
			id		=>'telefono',
			type	=>'text',
			required=>'yes',
			Boostrap =>'si',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[movil] = array(
			name	=>'movil',
			id		=>'movil',
			type	=>'text',
			Boostrap =>'si',
			//required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DISPONIBLE',selected=>'D'),array(value=>'B',text=>'BLOQUEADO')),
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[regimen_id] = array(
			name	=>'regimen_id',
			id		=>'regimen_id',
			type	=>'select',
			Boostrap =>'si',
			options	=> null,
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[retei_proveedor] = array(
			name	=>'retei_proveedor',
			id		=>'retei_proveedor',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'N',text=>'NO',selected=>'N'),array(value=>'S',text=>'SI')),
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);

		$this -> Campos[autoret_proveedor] = array(
			name	=>'autoret_proveedor',
			id		=>'autoret_proveedor',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'N',text=>'NO',selected=>'N'),array(value=>'S',text=>'SI')),
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'250'),
			transaction=>array(
				table	=>array('tercero'),
				type	=>array('column'))
		);





		/**********************************
		Botones
		**********************************/

		$this -> Campos[guardar] = array(
			name	=>'guardar',
			id		=>'guardar',
			type	=>'button',
			value	=>'Guardar',
			// tabindex=>'19'
		);

		$this -> Campos[actualizar] = array(
			name	=>'actualizar',
			id		=>'actualizar',
			type	=>'button',
			value	=>'Actualizar',
			disabled=>'disabled',
			// tabindex=>'20'
		);

		$this -> Campos[borrar] = array(
			name	=>'borrar',
			id		=>'borrar',
			type	=>'button',
			value	=>'Borrar',
			disabled=>'disabled',
			// tabindex=>'21',
			property=>array(
				name	=>'delete_ajax',
				onsuccess=>'EmpPrestacionOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'EmpPrestacionOnReset(this.form)'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			Boostrap =>'si',
			placeholder =>'Por favor Digite el Nit o Nombre de la Empresa',
			// tabindex=>'1',
			suggest=>array(
				name	=>'empresa_prestaciones',
				setId	=>'tercero_id',
				onclick	=>'setDataFormWithResponse')
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}
$empresa_id = new EmpPrestacion();
?>