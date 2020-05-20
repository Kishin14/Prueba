<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Bases extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){
		$this -> noCache();

		require_once("BasesLayoutClass.php");
		require_once("BasesModelClass.php");

		$Layout   = new BasesLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new BasesModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		$Layout -> SetPeriodoContable($Model -> GetPeriodoContable($this -> getConex()));
		$Layout -> SetPeriodoContableNuevo($Model -> GetPeriodoContableNuevo($this -> getConex()));
		$Layout -> SetTiposDocumentoContable($Model -> getTiposDocumentoContable($this -> getConex()));

		//// GRID ////

		$Attributes = array(
			id		=>'Bases_Salariales',
			title	=>'Listado de bases salariales',
			sortname=>'periodo',
			width	=>'auto',
			height	=>'250'
		);

		$Cols = array(
			array(name=>'periodo',			index=>'periodo',			sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'dias_lab',	index=>'dias_lab',	sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'dias_lab_mes',	index=>'dias_lab_mes',	sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'horas_dia',	index=>'horas_dia',	sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'horas_lab_dia',	index=>'horas_lab_dia',	sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'val_hr_corriente',	index=>'val_hr_corriente',	sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'limite_subsidio',	index=>'limite_subsidio',	sorttype=>'text',	width=>'80',	align=>'left'),
			array(name=>'salrio',	index=>'salrio',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'puc_admon_sal',	index=>'puc_admon_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_sal',	index=>'puc_ventas_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_sal',	index=>'puc_produ_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_sal',	index=>'puc_contra_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'sub_transporte',	index=>'sub_transporte',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_trans',	index=>'puc_admon_trans',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_trans',	index=>'puc_ventas_trans',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_trans',	index=>'puc_produ_trans',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_trans',	index=>'puc_contra_trans',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_emple_salud',	index=>'desc_emple_salud',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'desc_empre_salud',	index=>'desc_empre_salud',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_salud',	index=>'puc_admon_salud',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_salud',	index=>'puc_ventas_salud',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_salud',	index=>'puc_produ_salud',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_salud',	index=>'puc_contra_salud',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_emple_pension',	index=>'desc_emple_pension',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'desc_empre_pens',	index=>'desc_empre_pens',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_pension',	index=>'puc_admon_pension',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_pension',	index=>'puc_ventas_pension',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_pension',	index=>'puc_produ_pension',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_pension',	index=>'puc_contra_pension',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_cesantias',	index=>'desc_empre_cesantias',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_cesan',	index=>'puc_admon_cesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_cesan',	index=>'puc_ventas_cesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_cesan',	index=>'puc_produ_cesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_cesan',	index=>'puc_contra_cesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_int_cesantias',	index=>'desc_empre_int_cesantias',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_incesan',	index=>'puc_admon_incesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_incesan',	index=>'puc_ventas_incesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_incesan',	index=>'puc_produ_incesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_incesan',	index=>'puc_contra_incesan',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_vacaciones',	index=>'desc_empre_vacaciones',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_vaca',	index=>'puc_admon_vaca',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_vaca',	index=>'puc_ventas_vaca',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_vaca',	index=>'puc_produ_vaca',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_vaca',	index=>'puc_contra_vaca',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_prima_serv',	index=>'desc_empre_prima_serv',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_prima',	index=>'puc_admon_prima',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_prima',	index=>'puc_ventas_prima',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_prima',	index=>'puc_produ_prima',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_prima',	index=>'puc_contra_prima',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_caja_comp',	index=>'desc_empre_caja_comp',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_caja',	index=>'puc_admon_caja',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_caja',	index=>'puc_ventas_caja',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_caja',	index=>'puc_produ_caja',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_caja',	index=>'puc_contra_caja',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_icbf',	index=>'desc_empre_icbf',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_icbf',	index=>'puc_admon_icbf',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_icbf',	index=>'puc_ventas_icbf',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_icbf',	index=>'puc_produ_icbf',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_icbf',	index=>'puc_contra_icbf',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'desc_empre_sena',	index=>'desc_empre_sena',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_sena',	index=>'puc_admon_sena',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_sena',	index=>'puc_ventas_sena',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_sena',	index=>'puc_produ_sena',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_sena',	index=>'puc_contra_sena',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_admon_arl',	index=>'puc_admon_arl',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_arl',	index=>'puc_ventas_arl',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_arl',	index=>'puc_produ_arl',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_arl',	index=>'puc_contra_arl',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'val_hr_ext_diurna',	index=>'val_hr_ext_diurna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_extradiu',	index=>'puc_admon_extradiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_extradiu',	index=>'puc_ventas_extradiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_extradiu',	index=>'puc_produ_extradiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_extradiu',	index=>'puc_contra_extradiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'val_hr_ext_nocturna',	index=>'val_hr_ext_nocturna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_extranoc',	index=>'puc_admon_extranoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_extranoc',	index=>'puc_ventas_extranoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_extranoc',	index=>'puc_produ_extranoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_extranoc',	index=>'puc_contra_extranoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'val_hr_ext_festiva_diurna',	index=>'val_hr_ext_festiva_diurna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_fesdiu',	index=>'puc_admon_fesdiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_fesdiu',	index=>'puc_ventas_fesdiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_fesdiu',	index=>'puc_produ_fesdiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_fesdiu',	index=>'puc_contra_fesdiu',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'val_hr_ext_festiva_nocturna',	index=>'val_hr_ext_festiva_nocturna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_fesnoc',	index=>'puc_admon_fesnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_fesnoc',	index=>'puc_ventas_fesnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_fesnoc',	index=>'puc_produ_fesnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_fesnoc',	index=>'puc_contra_fesnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'val_recargo_nocturna',	index=>'val_recargo_nocturna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_recnoc',	index=>'puc_admon_recnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_recnoc',	index=>'puc_ventas_recnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_recnoc',	index=>'puc_produ_recnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_recnoc',	index=>'puc_contra_recnoc',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'dias_anio_indem',	index=>'dias_anio_indem',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'dias_2anio_indem',	index=>'dias_2anio_indem',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'puc_admon_indem',	index=>'puc_admon_indem',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_indem',	index=>'puc_ventas_indem',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_indem',	index=>'puc_produ_indem',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_indem',	index=>'puc_contra_indem',	sorttype=>'text',	width=>'120',	align=>'left')

			
		);

		$Titles = array(
			'PERIODO',
			'DIAS LABORALES',
			'DIAS LABORALES MES',
			'HORAS AL DÍA',
			'HORAS LABORALES AL DÍA',
			'VALOR HORA CORRIENTE',
			'LIM SALARIO TRANSPORTE',
			'SALARIO',
			'PUC ADMON SALARIO',
			'PUC VENTAS SALARIO',
			'PUC PROD SALARIO',
			'PUC CONTRA SALARIO',
			'SUBSIDIO TRANSP',
			'PUC ADMON TRANSP',
			'PUC VENTAS TRANSP',
			'PUC PROD TRANSP',
			'PUC CONTRA TRANSP',
			'% SALUD EMPLEADO',
			'% SALUD EMPRESA',
			'PUC ADMON SALUD',
			'PUC VENTAS SALUD',
			'PUC PROD SALUD',
			'PUC CONTRA SALUD',
			'% PENSION EMPLEADO',
			'% PENSION EMPRESA',
			'PUC ADMON PENSION',
			'PUC VENTAS PENSION',
			'PUC PROD PENSION',
			'PUC CONTRA PENSION',
			'% CESANTIAS',
			'PUC ADMON CESANTIAS',
			'PUC VENTAS CESANTIAS',
			'PUC PROD CESANTIAS',
			'PUC CONTRA CESANTIAS',
			'% INTERES CESANTIAS',
			'PUC ADMON INTERES CESANTIAS',
			'PUC VENTAS INTERES CESANTIAS',
			'PUC PROD INTERES CESANTIAS',
			'PUC CONTRA INTERES CESANTIAS',
			'% EMPRESA VACACIONES',
			'PUC ADMON VACACIONES',
			'PUC VENTAS VACACIONES',
			'PUC PROD VACACIONES',
			'PUC CONTRA VACACIONES',
			'% EMPRESA PRIMA SERV',
			'PUC ADMON PRIMA',
			'PUC VENTAS PRIMA',
			'PUC PROD PRIMA',
			'PUC CONTRA PRIMA',
			'% EMPRESA CAJA COMP',
			'PUC ADMON CAJA',
			'PUC VENTAS CAJA',
			'PUC PROD CAJA',
			'PUC CONTRA CAJA',
			'% EMPRESA ICBF',
			'PUC ADMON ICBF',
			'PUC VENTAS ICBF',
			'PUC PROD ICBF',
			'PUC CONTRA ICBF',
			'% EMPRESA SENA',
			'PUC ADMON SENA',
			'PUC VENTAS SENA',
			'PUC PROD SENA',
			'PUC CONTRA SENA',
			'PUC ADMON ARL',
			'PUC VENTAS ARL',
			'PUC PROD ARL',
			'PUC CONTRA ARL',
			'VALOR HORA EXT. DIURNA',
			'PUC ADMON EXT. DIURNA',
			'PUC VENTAS EXT. DIURNA',
			'PUC PROD EXT. DIURNA',
			'PUC CONTRA EXT. DIURNA',
			'VALOR HORA EXT. NOCTURNA',
			'PUC ADMON EXT. NOCTURNA',
			'PUC VENTAS EXT. NOCTURNA',
			'PUC PROD EXT. NOCTURNA',
			'PUC CONTRA EXT. NOCTURNA',
			'VALOR HORA EXT. FEST. DIURNA',
			'PUC ADMON FEST. DIURNA',
			'PUC VENTAS FEST. DIURNA',
			'PUC PROD FEST. DIURNA',
			'PUC CONTRA FEST. DIURNA',
			'VALOR HORA EXT. FEST. NOCTURNA',
			'PUC ADMON FEST. NOCTURNA',
			'PUC VENTAS FEST. NOCTURNA',
			'PUC PROD FEST. NOCTURNA',
			'PUC CONTRA FEST. NOCTURNA',
			'VALOR RECARGO NOCTURNA',
			'PUC ADMON REC. NOCTURNA',
			'PUC VENTAS REC. NOCTURNA',
			'PUC PROD REC. NOCTURNA',
			'PUC CONTRA REC. NOCTURNA',
			'DIAS 1 ANO',
			'DIAS + 2 ANO',
			'PUC ADMON INDEMNIZACION',
			'PUC VENTAS INDEMNIZACION',
			'PUC PROD INDEMNIZACION',
			'PUC CONTRA INDEMNIZACION'

		);

		$Layout -> SetGridBases($Attributes,$Titles,$Cols,$Model -> GetQueryBasesGrid());
		$Layout -> RenderMain();
	}

	protected function onclickValidateRow(){
		require_once("BasesModelClass.php");
		$Model = new BasesModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("BasesModelClass.php");
		$Model = new BasesModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente el registro');
		}
	}

	protected function onclickUpdate(){

		require_once("BasesModelClass.php");
		$Model = new BasesModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente el registro');
		}
	}

	protected function onclickDuplicar(){
  
		require_once("BasesModelClass.php");
	  
	  $Model = new BasesModel();
	  $Model -> duplicar($this -> Campos,$this -> getConex());
	  
	  if(strlen($Model -> GetError()) > 0){
		exit('false');
	  }else{
		  exit('true');
	  }
	  
	}


	protected function onclickDelete(){

		require_once("BasesModelClass.php");
		$Model = new BasesModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar el registro');
		}else{
			exit('Se borro exitosamente el registro');
		}
	}

	//BUSQUEDA
	protected function onclickFind(){
		require_once("BasesModelClass.php");
		$Model = new BasesModel();
		$Data                  = array();
		$id_datos  = $_REQUEST['id_datos'];

		if(is_numeric($id_datos)){
			$Data  = $Model -> selectDatosBasesId($id_datos, $this -> getConex());
		}
		echo json_encode($Data);
	}

	protected function SetCampos(){

		/********************
		Campos Tarifas Proveedor
		********************/

		$this -> Campos[id_datos] = array(
			name	=>'id_datos',
			id		=>'id_datos',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('primary_key'))
		);

		$this -> Campos[periodo_contable_id] = array(
			name	=>'periodo_contable_id',
			id		=>'periodo_contable_id',
			type	=>'select',
			Boostrap =>'si',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'int',
				length	=>'11'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[tipo_documento_id] = array(
			name	 =>'tipo_documento_id',
			id		 =>'tipo_documento_id',
			type	 =>'select',
			Boostrap =>'si',
			required =>'yes',		
			options  => array(),
			transaction=>array(
				table	=>array(('datos_periodo')),
				type	=>array('column'))
		);		

		$this -> Campos[salrio] = array(
			name	=>'salrio',
			id		=>'salrio',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'45'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);
		//INICIO div duplica

		$this -> Campos[periodo_contable_nuevo] = array(
			name	=>'periodo_contable_nuevo',
			id		=>'periodo_contable_nuevo',
			type	=>'select',
			Boostrap =>'si',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'int',
				length	=>'11')
		);

		$this -> Campos[salario_nuevo] = array(
			name	=>'salario_nuevo',
			id		=>'salario_nuevo',
			type	=>'text',
			Boostrap =>'si',
			// required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'45')
		);

		$this -> Campos[sub_nuevo] = array(
			name	=>'sub_nuevo',
			id		=>'sub_nuevo',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'45')
		);

		//FIN div duplica


		$this -> Campos[puc_admon_sal_id] = array(
			name	=>'puc_admon_sal_id',
			id		=>'puc_admon_sal_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_sal] = array(
			name	=>'puc_admon_sal',
			id		=>'puc_admon_sal',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_sal_id')
		);	  


		$this -> Campos[puc_ventas_sal_id] = array(
			name	=>'puc_ventas_sal_id',
			id		=>'puc_ventas_sal_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_sal] = array(
			name	=>'puc_ventas_sal',
			id		=>'puc_ventas_sal',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_sal_id')
		);	  

		$this -> Campos[puc_produ_sal_id] = array(
			name	=>'puc_produ_sal_id',
			id		=>'puc_produ_sal_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_sal] = array(
			name	=>'puc_produ_sal',
			id		=>'puc_produ_sal',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_sal_id')
		);	  

		$this -> Campos[puc_contra_sal_id] = array(
			name	=>'puc_contra_sal_id',
			id		=>'puc_contra_sal_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_sal] = array(
			name	=>'puc_contra_sal',
			id		=>'puc_contra_sal',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_sal_id')
		);	  


		$this -> Campos[nossalarial] = array(
			name	=>'nossalarial',
			id		=>'nossalarial',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'45'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_nos_id] = array(
			name	=>'puc_admon_nos_id',
			id		=>'puc_admon_nos_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_nos] = array(
			name	=>'puc_admon_nos',
			id		=>'puc_admon_nos',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_nos_id')
		);	  


		$this -> Campos[puc_ventas_nos_id] = array(
			name	=>'puc_ventas_nos_id',
			id		=>'puc_ventas_nos_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_nos] = array(
			name	=>'puc_ventas_nos',
			id		=>'puc_ventas_nos',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_nos_id')
		);	  

		$this -> Campos[puc_produ_nos_id] = array(
			name	=>'puc_produ_nos_id',
			id		=>'puc_produ_nos_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_nos] = array(
			name	=>'puc_produ_nos',
			id		=>'puc_produ_nos',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_nos_id')
		);	  

		$this -> Campos[puc_contra_nos_id] = array(
			name	=>'puc_contra_nos_id',
			id		=>'puc_contra_nos_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_nos] = array(
			name	=>'puc_contra_nos',
			id		=>'puc_contra_nos',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_nos_id')
		);	  


		$this -> Campos[sub_transporte] = array(
			name	=>'sub_transporte',
			id		=>'sub_transporte',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'45'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[limite_subsidio] = array(
			name	=>'limite_subsidio',
			id		=>'limite_subsidio',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'integer',
				length	=>'3'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);



		$this -> Campos[puc_admon_trans_id] = array(
			name	=>'puc_admon_trans_id',
			id		=>'puc_admon_trans_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_trans] = array(
			name	=>'puc_admon_trans',
			id		=>'puc_admon_trans',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_trans_id')
		);	  


		$this -> Campos[puc_ventas_trans_id] = array(
			name	=>'puc_ventas_trans_id',
			id		=>'puc_ventas_trans_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_trans] = array(
			name	=>'puc_ventas_trans',
			id		=>'puc_ventas_trans',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_trans_id')
		);	  

		$this -> Campos[puc_produ_trans_id] = array(
			name	=>'puc_produ_trans_id',
			id		=>'puc_produ_trans_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_trans] = array(
			name	=>'puc_produ_trans',
			id		=>'puc_produ_trans',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_trans_id')
		);	  

		$this -> Campos[puc_contra_trans_id] = array(
			name	=>'puc_contra_trans_id',
			id		=>'puc_contra_trans_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		

		$this -> Campos[puc_contra_trans] = array(
			name	=>'puc_contra_trans',
			id		=>'puc_contra_trans',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_trans_id')
		);	  

		$this -> Campos[puc_contra_retencion] = array(
			name	=>'puc_contra_retencion',
			id		=>'puc_contra_retencion',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_retencion_id')
		);	  
		
		$this -> Campos[puc_contra_retencion_id] = array(
			name	=>'puc_contra_retencion_id',
			id		=>'puc_contra_retencion_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[dias_lab] = array(
			name	=>'dias_lab',
			id		=>'dias_lab',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'int',
				length	=>'5'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[dias_lab_mes] = array(
			name	=>'dias_lab_mes',
			id		=>'dias_lab_mes',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,			
			datatype=>array(
				type	=>'int',
				length	=>'5'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[horas_dia] = array(
			name	=>'horas_dia',
			id		=>'horas_dia',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,	
			datatype=>array(
				type	=>'int',
				length	=>'5'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[horas_lab_dia] = array(
			name	=>'horas_lab_dia',
			id		=>'horas_lab_dia',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,	
			datatype=>array(
				type	=>'int',
				length	=>'5'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[desc_emple_salud] = array(
			name	=>'desc_emple_salud',
			id		=>'desc_emple_salud',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[desc_empre_salud] = array(
			name	=>'desc_empre_salud',
			id		=>'desc_empre_salud',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);


		$this -> Campos[puc_admon_salud_id] = array(
			name	=>'puc_admon_salud_id',
			id		=>'puc_admon_salud_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_salud] = array(
			name	=>'puc_admon_salud',
			id		=>'puc_admon_salud',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_salud_id')
		);	  


		$this -> Campos[puc_ventas_salud_id] = array(
			name	=>'puc_ventas_salud_id',
			id		=>'puc_ventas_salud_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_salud] = array(
			name	=>'puc_ventas_salud',
			id		=>'puc_ventas_salud',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_salud_id')
		);	  

		$this -> Campos[puc_produ_salud_id] = array(
			name	=>'puc_produ_salud_id',
			id		=>'puc_produ_salud_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_salud] = array(
			name	=>'puc_produ_salud',
			id		=>'puc_produ_salud',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_salud_id')
		);	  

		$this -> Campos[puc_contra_salud_id] = array(
			name	=>'puc_contra_salud_id',
			id		=>'puc_contra_salud_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_salud] = array(
			name	=>'puc_contra_salud',
			id		=>'puc_contra_salud',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_salud_id')
		);	  

		$this -> Campos[desc_emple_pension] = array(
			name	=>'desc_emple_pension',
			id		=>'desc_emple_pension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[desc_empre_pens] = array(
			name	=>'desc_empre_pens',
			id		=>'desc_empre_pens',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);


		$this -> Campos[puc_admon_pension_id] = array(
			name	=>'puc_admon_pension_id',
			id		=>'puc_admon_pension_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_pension] = array(
			name	=>'puc_admon_pension',
			id		=>'puc_admon_pension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_pension_id')
		);	  


		$this -> Campos[puc_ventas_pension_id] = array(
			name	=>'puc_ventas_pension_id',
			id		=>'puc_ventas_pension_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_pension] = array(
			name	=>'puc_ventas_pension',
			id		=>'puc_ventas_pension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_pension_id')
		);	  

		$this -> Campos[puc_produ_pension_id] = array(
			name	=>'puc_produ_pension_id',
			id		=>'puc_produ_pension_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_pension] = array(
			name	=>'puc_produ_pension',
			id		=>'puc_produ_pension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_pension_id')
		);	  

		$this -> Campos[puc_contra_pension_id] = array(
			name	=>'puc_contra_pension_id',
			id		=>'puc_contra_pension_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_pension] = array(
			name	=>'puc_contra_pension',
			id		=>'puc_contra_pension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_pension_id')
		);	  

		$this -> Campos[desc_empre_caja_comp] = array(
			name	=>'desc_empre_caja_comp',
			id		=>'desc_empre_caja_comp',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_caja_id] = array(
			name	=>'puc_admon_caja_id',
			id		=>'puc_admon_caja_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_caja] = array(
			name	=>'puc_admon_caja',
			id		=>'puc_admon_caja',
			type	=>'text',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_caja_id')
		);	  


		$this -> Campos[puc_ventas_caja_id] = array(
			name	=>'puc_ventas_caja_id',
			id		=>'puc_ventas_caja_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_caja] = array(
			name	=>'puc_ventas_caja',
			id		=>'puc_ventas_caja',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_caja_id')
		);	  

		$this -> Campos[puc_produ_caja_id] = array(
			name	=>'puc_produ_caja_id',
			id		=>'puc_produ_caja_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_caja] = array(
			name	=>'puc_produ_caja',
			id		=>'puc_produ_caja',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_caja_id')
		);	  

		$this -> Campos[puc_contra_caja_id] = array(
			name	=>'puc_contra_caja_id',
			id		=>'puc_contra_caja_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_caja] = array(
			name	=>'puc_contra_caja',
			id		=>'puc_contra_caja',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_caja_id')
		);	  

		$this -> Campos[desc_empre_icbf] = array(
			name	=>'desc_empre_icbf',
			id		=>'desc_empre_icbf',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size =>5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_icbf_id] = array(
			name	=>'puc_admon_icbf_id',
			id		=>'puc_admon_icbf_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_icbf] = array(
			name	=>'puc_admon_icbf',
			id		=>'puc_admon_icbf',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_icbf_id')
		);	  


		$this -> Campos[puc_ventas_icbf_id] = array(
			name	=>'puc_ventas_icbf_id',
			id		=>'puc_ventas_icbf_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_icbf] = array(
			name	=>'puc_ventas_icbf',
			id		=>'puc_ventas_icbf',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_icbf_id')
		);	  

		$this -> Campos[puc_produ_icbf_id] = array(
			name	=>'puc_produ_icbf_id',
			id		=>'puc_produ_icbf_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_icbf] = array(
			name	=>'puc_produ_icbf',
			id		=>'puc_produ_icbf',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_icbf_id')
		);	  

		$this -> Campos[puc_contra_icbf_id] = array(
			name	=>'puc_contra_icbf_id',
			id		=>'puc_contra_icbf_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_icbf] = array(
			name	=>'puc_contra_icbf',
			id		=>'puc_contra_icbf',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_icbf_id')
		);	  

		$this -> Campos[desc_empre_sena] = array(
			name	=>'desc_empre_sena',
			id		=>'desc_empre_sena',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_sena_id] = array(
			name	=>'puc_admon_sena_id',
			id		=>'puc_admon_sena_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_sena] = array(
			name	=>'puc_admon_sena',
			id		=>'puc_admon_sena',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_sena_id')
		);	  


		$this -> Campos[puc_ventas_sena_id] = array(
			name	=>'puc_ventas_sena_id',
			id		=>'puc_ventas_sena_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_sena] = array(
			name	=>'puc_ventas_sena',
			id		=>'puc_ventas_sena',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_sena_id')
		);	  

		$this -> Campos[puc_produ_sena_id] = array(
			name	=>'puc_produ_sena_id',
			id		=>'puc_produ_sena_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_sena] = array(
			name	=>'puc_produ_sena',
			id		=>'puc_produ_sena',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_sena_id')
		);	  

		$this -> Campos[puc_contra_sena_id] = array(
			name	=>'puc_contra_sena_id',
			id		=>'puc_contra_sena_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_sena] = array(
			name	=>'puc_contra_sena',
			id		=>'puc_contra_sena',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_sena_id')
		);	  

		$this -> Campos[desc_empre_vacaciones] = array(
			name	=>'desc_empre_vacaciones',
			id		=>'desc_empre_vacaciones',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_vaca_id] = array(
			name	=>'puc_admon_vaca_id',
			id		=>'puc_admon_vaca_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_vaca] = array(
			name	=>'puc_admon_vaca',
			id		=>'puc_admon_vaca',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_vaca_id')
		);	  


		$this -> Campos[puc_ventas_vaca_id] = array(
			name	=>'puc_ventas_vaca_id',
			id		=>'puc_ventas_vaca_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_vaca] = array(
			name	=>'puc_ventas_vaca',
			id		=>'puc_ventas_vaca',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_vaca_id')
		);	  

		$this -> Campos[puc_produ_vaca_id] = array(
			name	=>'puc_produ_vaca_id',
			id		=>'puc_produ_vaca_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_vaca] = array(
			name	=>'puc_produ_vaca',
			id		=>'puc_produ_vaca',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_vaca_id')
		);	  

		$this -> Campos[puc_contra_vaca_id] = array(
			name	=>'puc_contra_vaca_id',
			id		=>'puc_contra_vaca_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_vaca] = array(
			name	=>'puc_contra_vaca',
			id		=>'puc_contra_vaca',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_vaca_id')
		);	  

		$this -> Campos[desc_empre_prima_serv] = array(
			name	=>'desc_empre_prima_serv',
			id		=>'desc_empre_prima_serv',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_prima_id] = array(
			name	=>'puc_admon_prima_id',
			id		=>'puc_admon_prima_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_prima] = array(
			name	=>'puc_admon_prima',
			id		=>'puc_admon_prima',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_prima_id')
		);	  


		$this -> Campos[puc_ventas_prima_id] = array(
			name	=>'puc_ventas_prima_id',
			id		=>'puc_ventas_prima_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_prima] = array(
			name	=>'puc_ventas_prima',
			id		=>'puc_ventas_prima',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_prima_id')
		);	  

		$this -> Campos[puc_produ_prima_id] = array(
			name	=>'puc_produ_prima_id',
			id		=>'puc_produ_prima_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_prima] = array(
			name	=>'puc_produ_prima',
			id		=>'puc_produ_prima',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_prima_id')
		);	  

		$this -> Campos[puc_contra_prima_id] = array(
			name	=>'puc_contra_prima_id',
			id		=>'puc_contra_prima_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_prima] = array(
			name	=>'puc_contra_prima',
			id		=>'puc_contra_prima',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_prima_id')
		);	  

		$this -> Campos[desc_empre_cesantias] = array(
			name	=>'desc_empre_cesantias',
			id		=>'desc_empre_cesantias',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_cesan_id] = array(
			name	=>'puc_admon_cesan_id',
			id		=>'puc_admon_cesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_cesan] = array(
			name	=>'puc_admon_cesan',
			id		=>'puc_admon_cesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_cesan_id')
		);	  


		$this -> Campos[puc_ventas_cesan_id] = array(
			name	=>'puc_ventas_cesan_id',
			id		=>'puc_ventas_cesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_cesan] = array(
			name	=>'puc_ventas_cesan',
			id		=>'puc_ventas_cesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_cesan_id')
		);	  

		$this -> Campos[puc_produ_cesan_id] = array(
			name	=>'puc_produ_cesan_id',
			id		=>'puc_produ_cesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_cesan] = array(
			name	=>'puc_produ_cesan',
			id		=>'puc_produ_cesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_cesan_id')
		);	  

		$this -> Campos[puc_contra_cesan_id] = array(
			name	=>'puc_contra_cesan_id',
			id		=>'puc_contra_cesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_cesan] = array(
			name	=>'puc_contra_cesan',
			id		=>'puc_contra_cesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_cesan_id')
		);	  

		$this -> Campos[desc_empre_int_cesantias] = array(
			name	=>'desc_empre_int_cesantias',
			id		=>'desc_empre_int_cesantias',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_incesan_id] = array(
			name	=>'puc_admon_incesan_id',
			id		=>'puc_admon_incesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_incesan] = array(
			name	=>'puc_admon_incesan',
			id		=>'puc_admon_incesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_incesan_id')
		);	  


		$this -> Campos[puc_ventas_incesan_id] = array(
			name	=>'puc_ventas_incesan_id',
			id		=>'puc_ventas_incesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_incesan] = array(
			name	=>'puc_ventas_incesan',
			id		=>'puc_ventas_incesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_incesan_id')
		);	  

		$this -> Campos[puc_produ_incesan_id] = array(
			name	=>'puc_produ_incesan_id',
			id		=>'puc_produ_incesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_incesan] = array(
			name	=>'puc_produ_incesan',
			id		=>'puc_produ_incesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_incesan_id')
		);	  

		$this -> Campos[puc_contra_incesan_id] = array(
			name	=>'puc_contra_incesan_id',
			id		=>'puc_contra_incesan_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_incesan] = array(
			name	=>'puc_contra_incesan',
			id		=>'puc_contra_incesan',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_incesan_id')
		);	  


		$this -> Campos[puc_admon_arl_id] = array(
			name	=>'puc_admon_arl_id',
			id		=>'puc_admon_arl_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_arl] = array(
			name	=>'puc_admon_arl',
			id		=>'puc_admon_arl',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_arl_id')
		);	  


		$this -> Campos[puc_ventas_arl_id] = array(
			name	=>'puc_ventas_arl_id',
			id		=>'puc_ventas_arl_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_arl] = array(
			name	=>'puc_ventas_arl',
			id		=>'puc_ventas_arl',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_arl_id')
		);	  

		$this -> Campos[puc_produ_arl_id] = array(
			name	=>'puc_produ_arl_id',
			id		=>'puc_produ_arl_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_arl] = array(
			name	=>'puc_produ_arl',
			id		=>'puc_produ_arl',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_arl_id')
		);	  

		$this -> Campos[puc_contra_arl_id] = array(
			name	=>'puc_contra_arl_id',
			id		=>'puc_contra_arl_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_arl] = array(
			name	=>'puc_contra_arl',
			id		=>'puc_contra_arl',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>15,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_arl_id')
		);	  



		$this -> Campos[val_hr_corriente] = array(
			name	=>'val_hr_corriente',
			id		=>'val_hr_corriente',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'10',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);


		$this -> Campos[val_hr_ext_diurna] = array(
			name	=>'val_hr_ext_diurna',
			id		=>'val_hr_ext_diurna',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'10',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_extradiu_id] = array(
			name	=>'puc_admon_extradiu_id',
			id		=>'puc_admon_extradiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_extradiu] = array(
			name	=>'puc_admon_extradiu',
			id		=>'puc_admon_extradiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_extradiu_id')
		);	  


		$this -> Campos[puc_ventas_extradiu_id] = array(
			name	=>'puc_ventas_extradiu_id',
			id		=>'puc_ventas_extradiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_extradiu] = array(
			name	=>'puc_ventas_extradiu',
			id		=>'puc_ventas_extradiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_extradiu_id')
		);	  

		$this -> Campos[puc_produ_extradiu_id] = array(
			name	=>'puc_produ_extradiu_id',
			id		=>'puc_produ_extradiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_extradiu] = array(
			name	=>'puc_produ_extradiu',
			id		=>'puc_produ_extradiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_extradiu_id')
		);	  

		$this -> Campos[puc_contra_extradiu_id] = array(
			name	=>'puc_contra_extradiu_id',
			id		=>'puc_contra_extradiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_extradiu] = array(
			name	=>'puc_contra_extradiu',
			id		=>'puc_contra_extradiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_extradiu_id')
		);	  

		$this -> Campos[val_hr_ext_nocturna] = array(
			name	=>'val_hr_ext_nocturna',
			id		=>'val_hr_ext_nocturna',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'10',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_extranoc_id] = array(
			name	=>'puc_admon_extranoc_id',
			id		=>'puc_admon_extranoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_extranoc] = array(
			name	=>'puc_admon_extranoc',
			id		=>'puc_admon_extranoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_extranoc_id')
		);	  


		$this -> Campos[puc_ventas_extranoc_id] = array(
			name	=>'puc_ventas_extranoc_id',
			id		=>'puc_ventas_extranoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_extranoc] = array(
			name	=>'puc_ventas_extranoc',
			id		=>'puc_ventas_extranoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_extranoc_id')
		);	  

		$this -> Campos[puc_produ_extranoc_id] = array(
			name	=>'puc_produ_extranoc_id',
			id		=>'puc_produ_extranoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_extranoc] = array(
			name	=>'puc_produ_extranoc',
			id		=>'puc_produ_extranoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_extranoc_id')
		);	  

		$this -> Campos[puc_contra_extranoc_id] = array(
			name	=>'puc_contra_extranoc_id',
			id		=>'puc_contra_extranoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_extranoc] = array(
			name	=>'puc_contra_extranoc',
			id		=>'puc_contra_extranoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_extranoc_id')
		);	  



		$this -> Campos[val_hr_ext_festiva_diurna] = array(
			name	=>'val_hr_ext_festiva_diurna',
			id		=>'val_hr_ext_festiva_diurna',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'10',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_fesdiu_id] = array(
			name	=>'puc_admon_fesdiu_id',
			id		=>'puc_admon_fesdiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_fesdiu] = array(
			name	=>'puc_admon_fesdiu',
			id		=>'puc_admon_fesdiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_fesdiu_id')
		);	  


		$this -> Campos[puc_ventas_fesdiu_id] = array(
			name	=>'puc_ventas_fesdiu_id',
			id		=>'puc_ventas_fesdiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_fesdiu] = array(
			name	=>'puc_ventas_fesdiu',
			id		=>'puc_ventas_fesdiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_fesdiu_id')
		);	  

		$this -> Campos[puc_produ_fesdiu_id] = array(
			name	=>'puc_produ_fesdiu_id',
			id		=>'puc_produ_fesdiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_fesdiu] = array(
			name	=>'puc_produ_fesdiu',
			id		=>'puc_produ_fesdiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_fesdiu_id')
		);	  

		$this -> Campos[puc_contra_fesdiu_id] = array(
			name	=>'puc_contra_fesdiu_id',
			id		=>'puc_contra_fesdiu_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_fesdiu] = array(
			name	=>'puc_contra_fesdiu',
			id		=>'puc_contra_fesdiu',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_fesdiu_id')
		);	  

		$this -> Campos[val_hr_ext_festiva_nocturna] = array(
			name	=>'val_hr_ext_festiva_nocturna',
			id		=>'val_hr_ext_festiva_nocturna',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'10',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_fesnoc_id] = array(
			name	=>'puc_admon_fesnoc_id',
			id		=>'puc_admon_fesnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_fesnoc] = array(
			name	=>'puc_admon_fesnoc',
			id		=>'puc_admon_fesnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_fesnoc_id')
		);	  


		$this -> Campos[puc_ventas_fesnoc_id] = array(
			name	=>'puc_ventas_fesnoc_id',
			id		=>'puc_ventas_fesnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_fesnoc] = array(
			name	=>'puc_ventas_fesnoc',
			id		=>'puc_ventas_fesnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_fesnoc_id')
		);	  

		$this -> Campos[puc_produ_fesnoc_id] = array(
			name	=>'puc_produ_fesnoc_id',
			id		=>'puc_produ_fesnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_fesnoc] = array(
			name	=>'puc_produ_fesnoc',
			id		=>'puc_produ_fesnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_fesnoc_id')
		);	  

		$this -> Campos[puc_contra_fesnoc_id] = array(
			name	=>'puc_contra_fesnoc_id',
			id		=>'puc_contra_fesnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_fesnoc] = array(
			name	=>'puc_contra_fesnoc',
			id		=>'puc_contra_fesnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_fesnoc_id')
		);	  


		$this -> Campos[val_recargo_nocturna] = array(
			name	=>'val_recargo_nocturna',
			id		=>'val_recargo_nocturna',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'10',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);
		
		$this -> Campos[puc_admon_recnoc_id] = array(
			name	=>'puc_admon_recnoc_id',
			id		=>'puc_admon_recnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
				transaction=>array(
					table	=>array('datos_periodo'),
					type	=>array('column'))
				);
				
				$this -> Campos[puc_admon_recnoc] = array(
					name	=>'puc_admon_recnoc',
					id		=>'puc_admon_recnoc',
					type	=>'text',
					Boostrap =>'si',
					required=>'yes',
					size=>16,
					datatype=>array(type=>'text'),
					suggest=>array(
						name	=>'cuentas_movimiento',
						setId	=>'puc_admon_recnoc_id')
		);	  


		$this -> Campos[puc_ventas_recnoc_id] = array(
			name	=>'puc_ventas_recnoc_id',
			id		=>'puc_ventas_recnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_recnoc] = array(
			name	=>'puc_ventas_recnoc',
			id		=>'puc_ventas_recnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_recnoc_id')
		);	  

		$this -> Campos[puc_produ_recnoc_id] = array(
			name	=>'puc_produ_recnoc_id',
			id		=>'puc_produ_recnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);
		
		$this -> Campos[puc_produ_recnoc] = array(
			name	=>'puc_produ_recnoc',
			id		=>'puc_produ_recnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_recnoc_id')
		);	  

		$this -> Campos[puc_contra_recnoc_id] = array(
			name	=>'puc_contra_recnoc_id',
			id		=>'puc_contra_recnoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
			);
			
			$this -> Campos[puc_contra_recnoc] = array(
			name	=>'puc_contra_recnoc',
			id		=>'puc_contra_recnoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_recnoc_id')
			);	 
			
			

		
			
			$this -> Campos[val_recargo_dominical] = array(
				name	=>'val_recargo_dominical',
				id		=>'val_recargo_dominical',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size=>10,
				datatype=>array(
					type	=>'numeric',
					length	=>'10',
					presicion=>3),
				transaction=>array(
					table	=>array('datos_periodo'),
					type	=>array('column'))
			);

			$this -> Campos[puc_admon_recdoc_id] = array(
			name	=>'puc_admon_recdoc_id',
			id		=>'puc_admon_recdoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
			);

		$this -> Campos[puc_admon_recdoc] = array(
			name	=>'puc_admon_recdoc',
			id		=>'puc_admon_recdoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_recdoc_id')
		);	  


		$this -> Campos[puc_ventas_recdoc_id] = array(
			name	=>'puc_ventas_recdoc_id',
			id		=>'puc_ventas_recdoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_recdoc] = array(
			name	=>'puc_ventas_recdoc',
			id		=>'puc_ventas_recdoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_recdoc_id')
		);	  

		$this -> Campos[puc_produ_recdoc_id] = array(
			name	=>'puc_produ_recdoc_id',
			id		=>'puc_produ_recdoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_recdoc] = array(
			name	=>'puc_produ_recdoc',
			id		=>'puc_produ_recdoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_recdoc_id')
		);	  

		$this -> Campos[puc_contra_recdoc_id] = array(
			name	=>'puc_contra_recdoc_id',
			id		=>'puc_contra_recdoc_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_recdoc] = array(
			name	=>'puc_contra_recdoc',
			id		=>'puc_contra_recdoc',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_recdoc_id')
		);	  






		$this -> Campos[dias_anio_indem] = array(
			name	=>'dias_anio_indem',
			id		=>'dias_anio_indem',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'3',
				presicion=>0),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[dias_2anio_indem] = array(
			name	=>'dias_2anio_indem',
			id		=>'dias_2anio_indem',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>10,
			datatype=>array(
				type	=>'numeric',
				length	=>'3',
				presicion=>0),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_indem_id] = array(
			name	=>'puc_admon_indem_id',
			id		=>'puc_admon_indem_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_indem] = array(
			name	=>'puc_admon_indem',
			id		=>'puc_admon_indem',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_indem_id')
		);	  


		$this -> Campos[puc_ventas_indem_id] = array(
			name	=>'puc_ventas_indem_id',
			id		=>'puc_ventas_indem_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_indem] = array(
			name	=>'puc_ventas_indem',
			id		=>'puc_ventas_indem',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_indem_id')
		);	  

		$this -> Campos[puc_produ_indem_id] = array(
			name	=>'puc_produ_indem_id',
			id		=>'puc_produ_indem_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_indem] = array(
			name	=>'puc_produ_indem',
			id		=>'puc_produ_indem',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_indem_id')
		);	  

		$this -> Campos[puc_contra_indem_id] = array(
			name	=>'puc_contra_indem_id',
			id		=>'puc_contra_indem_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_indem] = array(
			name	=>'puc_contra_indem',
			id		=>'puc_contra_indem',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_indem_id')
		);	  

		$this -> Campos[tercero_icbf_id] = array(
			name	=>'tercero_icbf_id',
			id		=>'tercero_icbf_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[tercero_icbf] = array(
			name	=>'tercero_icbf',
			id		=>'tercero_icbf',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'tercero',
				setId	=>'tercero_icbf_id')
		);	  

		$this -> Campos[tercero_sena_id] = array(
			name	=>'tercero_sena_id',
			id		=>'tercero_sena_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[tercero_sena] = array(
			name	=>'tercero_sena',
			id		=>'tercero_sena',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'tercero',
				setId	=>'tercero_sena_id')
		);	  



		$this -> Campos[desc_emple_fonpension] = array(
			name	=>'desc_emple_fonpension',
			id		=>'desc_emple_fonpension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size => 5,
			datatype=>array(
				type	=>'numeric',
				length	=>'4',
				presicion=>3),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);


		$this -> Campos[puc_contra_fonpension_id] = array(
			name	=>'puc_contra_fonpension_id',
			id		=>'puc_contra_fonpension_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('datos_periodo'),
				type	=>array('column'))
		);

		$this -> Campos[puc_contra_fonpension] = array(
			name	=>'puc_contra_fonpension',
			id		=>'puc_contra_fonpension',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_contra_fonpension_id')
		);	  

		$this -> Campos[limite_fondo] = array(
			name	=>'limite_fondo',
			id		=>'limite_fondo',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			size=>5,
			datatype=>array(
				type	=>'integer',
				length	=>'3'),
			transaction=>array(
				table	=>array('datos_periodo'),
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

		$this -> Campos[duplicar] = array(
			name	=>'duplicar',
			id		=>'duplicar',
			type	=>'button',
			value	=>'Duplicar',
			// tabindex=>'22',
			onclick	=>'onclickDuplicar()'
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
				onsuccess=>'BasesOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'BasesOnReset()'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			Boostrap =>'si',
			placeholder =>'Por favor digite el periodo',
			suggest=>array(
				name	=>'datos_periodo',
				setId	=>'id_datos',
				onclick	=>'setDataFormWithResponse')
		);

		$this -> SetVarsValidate($this -> Campos);
	}
}

$id_base = new Bases();
?>