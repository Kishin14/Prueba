<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Contable extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){
		$this -> noCache();

		require_once("ContableLayoutClass.php");
		require_once("ContableModelClass.php");

		$Layout   = new ContableLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ContableModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		


		//// GRID ////
		$Attributes = array(
			id		=>'concepto_area',
			title	=>'Listado de Conceptos y Codigos Contables',
			sortname=>'descripcion',
			width	=>'auto',
			height	=>'250'
		);

		$Cols = array(
			array(name=>'descripcion',	index=>'descripcion',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon',	index=>'puc_admon',		sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'naturaleza_admon',	index=>'naturaleza_admon',		sorttype=>'text',	width=>'50',	align=>'center'),				
			array(name=>'puc_ventas',	index=>'puc_ventas',		sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'naturaleza_ventas',	index=>'naturaleza_ventas',		sorttype=>'text',	width=>'50',	align=>'center'),				
			array(name=>'puc_prod',	index=>'puc_prod',		sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'naturaleza_prod',	index=>'naturaleza_prod',		sorttype=>'text',	width=>'50',	align=>'center'),				
			array(name=>'contrapartida',	index=>'contrapartida',		sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'naturaleza_contrapartida',	index=>'naturaleza_contrapartida',		sorttype=>'text',	width=>'50',	align=>'center'),				
			array(name=>'base_salarial',	index=>'base_salarial',		sorttype=>'text',	width=>'50',	align=>'center'),				
			array(name=>'tipo_calculo',			index=>'tipo_calculo',			sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'estado',			index=>'estado',			sorttype=>'text',	width=>'150',	align=>'center')
		);

		$Titles = array(
			'NOMBRE',
			'PUC_ADMON',
			'NATU ADMON',
			'PUC VENTAS',
			'NATU VENTAS',
			'PUC PRODUCCION',
			'NATU PRODUCCION',
			'PUC CONTRAPARTIDA',
			'NATU CONTRAPARTIDA',
			'BASE SALARIAL',
			'TIPO CALCULO',				
			'ESTADO'
		);

		$Layout -> SetGridContable($Attributes,$Titles,$Cols,$Model -> GetQueryContableGrid());
		$Layout -> RenderMain();
	}

	protected function onclickValidateRow(){
		require_once("ContableModelClass.php");
		$Model = new ContableModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("ContableModelClass.php");
		$Model = new ContableModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente el código contable');
		}
	}

	protected function onclickUpdate(){

		require_once("ContableModelClass.php");
		$Model = new ContableModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente el código contable');
		}
	}


	protected function onclickDelete(){

		require_once("ContableModelClass.php");
		$Model = new ContableModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar el código contable');
		}else{
			exit('Se borro exitosamente el código contable');
		}
	}


	//BUSQUEDA
	protected function onclickFind(){
		require_once("ContableModelClass.php");
		$Model = new ContableModel();
		$Data                  = array();
		$concepto_area_id   = $_REQUEST['concepto_area_id'];
		if(is_numeric($concepto_area_id)){
			$Data  = $Model -> selectDatosContableId($concepto_area_id,$this -> getConex());
		}
		echo json_encode($Data);
	}


	protected function SetCampos(){

		/********************
		Campos Tarifas Proveedor
		********************/

		$this -> Campos[concepto_area_id] = array(
			name	=>'concepto_area_id',
			id		=>'concepto_area_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('primary_key'))
		);


		$this -> Campos[puc_admon] = array(
				name	=>'puc_admon',
				id		=>'puc_admon',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(type=>'text'),
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc_admon_id_hidden')
			);	  
	
			$this -> Campos[puc_admon_id] = array(
				name	=>'puc_admon_id',
				id	    =>'puc_admon_id_hidden',
				type	=>'hidden',
				required=>'yes',
				datatype=>array(type=>'text'),
				transaction=>array(
					table	=>array('concepto_area'),
					type	=>array('column'))
			);

		$this -> Campos[puc_ventas] = array(
				name	=>'puc_ventas',
				id		=>'puc_ventas',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(type=>'text'),
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc_ventas_id_hidden')
			);	  
	
			$this -> Campos[puc_ventas_id] = array(
				name	=>'puc_ventas_id',
				id	    =>'puc_ventas_id_hidden',
				type	=>'hidden',
				required=>'yes',
				datatype=>array(type=>'text'),
				transaction=>array(
					table	=>array('concepto_area'),
					type	=>array('column'))
			);

			$this -> Campos[puc_prod] = array(
				name	=>'puc_prod',
				id		=>'puc_prod',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				datatype=>array(type=>'text'),
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc_prod_id_hidden')
			);	  
	
			$this -> Campos[puc_prod_id] = array(
				name	=>'puc_prod_id',
				id	    =>'puc_prod_id_hidden',
				type	=>'hidden',
				required=>'yes',
				datatype=>array(type=>'text'),
				transaction=>array(
					table	=>array('concepto_area'),
					type	=>array('column'))
			);

			$this -> Campos[base_salarial] = array(
				name	=>'base_salarial',
				id		=>'base_salarial',
				type	=>'select',
				Boostrap =>'si',
				options	=> array(array(value=>'NO',text=>'NO',selected=>'0'),array(value=>'SI',text=>'SI')),
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('concepto_area'),
					type	=>array('column'))
			);
		
		$this -> Campos[tipo_novedad] = array(
		name =>'tipo_novedad',
		id  =>'tipo_novedad',
		type =>'select',
		Boostrap =>'si',
		options => array(array(value=>'V',text=>'DEVENGADO',selected=>'V'),array(value=>'D',text=>'DEDUCIDO')),
		required=>'yes',
		datatype=>array(
			type =>'text',
			length =>'2'),
		transaction=>array(
		 	table =>array('concepto_area'),
		 	type =>array('column'))
   );
			

		$this -> Campos[descripcion] = array(
			name	=>'descripcion',
			id		=>'descripcion',
			type	=>'text',
			required=>'yes',
			size	=>'65',
			Boostrap =>'si',
			datatype=>array(
				type	=>'text',
				length	=>'45'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[naturaleza_admon] = array(
			name	=>'naturaleza_admon',
			id		=>'naturaleza_admon',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DEBITO',selected=>'0'),array(value=>'C',text=>'CREDITO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[naturaleza_ventas] = array(
			name	=>'naturaleza_ventas',
			id		=>'naturaleza_ventas',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DEBITO',selected=>'0'),array(value=>'C',text=>'CREDITO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[naturaleza_prod] = array(
			name	=>'naturaleza_prod',
			id		=>'naturaleza_prod',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DEBITO',selected=>'0'),array(value=>'C',text=>'CREDITO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);


		$this -> Campos[naturaleza_contrapartida] = array(
			name	=>'naturaleza_contrapartida',
			id		=>'naturaleza_contrapartida',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DEBITO',selected=>'0'),array(value=>'C',text=>'CREDITO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[puc_partida] = array(
			name	=>'puc_partida',
			id		=>'puc_partida',
			type	=>'text',
			Boostrap =>'si',
			//required=>'yes',
			disabled=>'yes',
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_partida_id')
		);	  

		$this -> Campos[puc_partida_id] = array(
			name	=>'puc_partida_id',
			id	    =>'puc_partida_id',
			type	=>'hidden',
			//required=>'yes',
			datatype=>array(type=>'text'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra] = array(
			name	=>'puc_contra',
			id		=>'puc_contra',
			type	=>'text',
			Boostrap =>'si',
			//required=>'yes',
			disabled=>'yes',
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_id')
		);	  

		$this -> Campos[puc_contra_id] = array(
			name	=>'puc_contra_id',
			id	    =>'puc_contra_id',
			type	=>'hidden',
			//required=>'yes',
			datatype=>array(type=>'text'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[naturaleza_partida] = array(
			name	=>'naturaleza_partida',
			id		=>'naturaleza_partida',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DEBITO',selected=>'0'),array(value=>'C',text=>'CREDITO')),
			//required=>'yes',
			disabled=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[naturaleza_contra] = array(
			name	=>'naturaleza_contra',
			id		=>'naturaleza_contra',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'D',text=>'DEBITO',selected=>'0'),array(value=>'C',text=>'CREDITO')),
			//required=>'yes',
			disabled=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);


		$this -> Campos[contabiliza] = array(
			name	=>'contabiliza',
			id		=>'contabiliza',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'SI',text=>'SI',selected=>'NO'),array(value=>'NO',text=>'NO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);

		$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'A',text=>'ACTIVO',selected=>'0'),array(value=>'I',text=>'INACTIVO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
				type	=>array('column'))
		);


		
		$this -> Campos[contrapartida] = array(
				name	=>'contrapartida',
				id		=>'contrapartida',
				type	=>'text',
				Boostrap =>'si',
				datatype=>array(type=>'text'),
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'contrapartida_puc_id_hidden')
			);	  
	
			$this -> Campos[contrapartida_puc_id] = array(
				name	=>'contrapartida_puc_id',
				id	    =>'contrapartida_puc_id_hidden',
				type	=>'hidden',
				required=>'yes',
				datatype=>array(type=>'integer'),
				transaction=>array(
					table	=>array('concepto_area'),
					type	=>array('column'))
			);	

		$this -> Campos[tipo_calculo] = array(
			name	=>'tipo_calculo',
			id		=>'tipo_calculo',
			type	=>'select',
			Boostrap =>'si',
			options	=> array(array(value=>'P',text=>'PORCENTAJE',selected=>'0'),array(value=>'A',text=>'ABSOLUTO')),
			required=>'yes',
			datatype=>array(
				type	=>'alphanum',
				length	=>'11'),
			transaction=>array(
				table	=>array('concepto_area'),
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
				onsuccess=>'ContableOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'ContableOnReset(this.form)'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			Boostrap =>'si',
			placeholder =>'Por favor digite el nombre',
			// tabindex=>'1',
			suggest=>array(
				name	=>'concepto_area',
				setId	=>'concepto_area_id',
				onclick	=>'setDataFormWithResponse')
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}
$concepto_area_id = new Contable();
?>