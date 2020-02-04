<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ParametrosLiquidacion extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){
		$this -> noCache();

		require_once("ParametrosLiquidacionLayoutClass.php");
		require_once("ParametrosLiquidacionModelClass.php");

		$Layout   = new ParametrosLiquidacionLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ParametrosLiquidacionModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
		$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
		$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
		$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

		$Layout -> SetCampos($this -> Campos);

		//LISTA MENU
		//$Layout -> SetPeriodoContable($Model -> GetPeriodoContable($this -> getConex()));
		$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	
		$Layout -> SetTiposDocumentoContable($Model -> getTiposDocumentoContable($this -> getConex()));


		//// GRID ////

		$Attributes = array(
			id		=>'ParametrosLiquidacion_Salariales',
			title	=>'Listado de bases salariales',
			sortname=>'parametros_liquidacion_id',
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
			array(name=>'salrio',	index=>'salrio',	sorttype=>'text',	width=>'100',	align=>'left'),
			array(name=>'puc_admon_sal',	index=>'puc_admon_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_ventas_sal',	index=>'puc_ventas_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_produ_sal',	index=>'puc_produ_sal',	sorttype=>'text',	width=>'120',	align=>'left'),
			array(name=>'puc_contra_sal_id',	index=>'puc_contra_sal_id',	sorttype=>'text',	width=>'120',	align=>'left'),
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
			array(name=>'puc_contra_incesan',	index=>'puc_contra_incesan',	sorttype=>'text',	width=>'120',	align=>'left'),//aca

			array(name=>'desc_empre_primaaciones',	index=>'desc_empre_primaaciones',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'desc_empre_prima_serv',	index=>'desc_empre_prima_serv',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'desc_empre_caja_comp',	index=>'desc_empre_caja_comp',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'desc_empre_icbf',	index=>'desc_empre_icbf',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'desc_empre_sena',	index=>'desc_empre_sena',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'val_hr_corriente',	index=>'val_hr_corriente',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'val_hr_ext_diurna',	index=>'val_hr_ext_diurna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'val_hr_ext_nocturna',	index=>'val_hr_ext_nocturna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'val_hor_fest_corriente',	index=>'val_hor_fest_corriente',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'val_hr_ext_festiva_diurna',	index=>'val_hr_ext_festiva_diurna',	sorttype=>'text',	width=>'150',	align=>'left'),
			array(name=>'val_hr_ext_festiva_nocturna',	index=>'val_hr_ext_festiva_nocturna',	sorttype=>'text',	width=>'150',	align=>'left')
		);

		$Titles = array(
			'CODIGO',
			'PERIODO CONTABLE',
			'SALARIO',
			'SUBSIDIO TRANSPORTE',
			'DIAS LABORALES',
			'DIAS LABORALES MES',
			'HORAS AL DÍA',
			'HORAS LABORALES AL DÍA',
			'DESC. SALUD EMPLEADO',
			'DESC PENSION EMPLEADO',
			'DESC SALUD EMPRESA',
			'DESC PENSION EMPRESA',
			'DESC CESANTIAS EMPRESA',
			'DESC CESANTIAS EMPRESA INT',
			'DESC EMPRESA VACACIONES',
			'DESC EMPRESA PRIMA SERV',
			'DESC EMPRESA CAJA COMP',
			'DESC EMPRESA ICBF',
			'DESC EMPRESA SENA',
			'VALOR HORA CORRIENTE',
			'VALOR HORA EXT. DIURNA',
			'VALOR HORA EXT. NOCTURNA',
			'VALOR HORA FEST CORRIENTE',
			'VALOR HORA EXT. FEST. DIURNA',
			'VALOR HORA EXT. FEST. NOCTURNA',
			'VAL REC HORA ORD NOC',
			'VAL REC HORA FEST NOC',
			'EPS',
			'PENSIONES',
			'ARP',
		);

		//$Layout -> SetGridParametrosLiquidacion($Attributes,$Titles,$Cols,$Model -> GetQueryParametrosLiquidacionGrid());
		$Layout -> RenderMain();
	}
	protected function setOficinasCliente(){
  
	require_once("ParametrosLiquidacionLayoutClass.php");
	require_once("ParametrosLiquidacionModelClass.php");
	
	$Layout     = new ParametrosLiquidacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model      = new ParametrosLiquidacionModel();
	$empresa_id = $_REQUEST['empresa_id'];
	$oficina_id = $_REQUEST['oficina_id'];
	
	$oficinas = $Model -> selectOficinasEmpresa($empresa_id,$oficina_id,$this -> getConex());
	

	if(!count($oficinas) > 0){
	  $oficinas = array();
	}

      $field = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		options  => $oficinas,
		transaction=>array(
			table	=>array(('parametros_liquidacion_nomina')),
			type	=>array('column'))
	  );
	  
	print $Layout -> getObjectHtml($field);
	 
  }
	protected function onclickValidateRow(){
		require_once("ParametrosLiquidacionModelClass.php");
		$Model = new ParametrosLiquidacionModel();
		echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
	}


	protected function onclickSave(){

		require_once("ParametrosLiquidacionModelClass.php");
		$Model = new ParametrosLiquidacionModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
		}else{
		exit('Se ingreso correctamente el registro');
		}
	}

	protected function onclickUpdate(){

		require_once("ParametrosLiquidacionModelClass.php");
		$Model = new ParametrosLiquidacionModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente el registro');
		}
	}


	protected function onclickDelete(){

		require_once("ParametrosLiquidacionModelClass.php");
		$Model = new ParametrosLiquidacionModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('No se puede borrar el registro');
		}else{
			exit('Se borro exitosamente el registro');
		}
	}

	//BUSQUEDA
	protected function onclickFind(){
		require_once("ParametrosLiquidacionModelClass.php");
		$Model = new ParametrosLiquidacionModel();
		$Data                  = array();
		$parametros_liquidacion_id  = $_REQUEST['parametros_liquidacion_id'];

		if(is_numeric($parametros_liquidacion_id)){
			$Data  = $Model -> selectDatosParametrosLiquidacionId($parametros_liquidacion_id, $this -> getConex());
		}
		echo json_encode($Data);
	}
	
	 protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  

	protected function SetCampos(){

		/********************
		Campos Parametros liquidacion
		********************/

		$this -> Campos[parametros_liquidacion_id] = array(
			name	=>'parametros_liquidacion_id',
			id		=>'parametros_liquidacion_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('primary_key'))
		);
		
		$this -> Campos[empresa_id] = array(
		name	       =>'empresa_id',
		id		       =>'empresa_id',
		type	       =>'select',
		required       =>'yes',
		options        => array(),
        setoptionslist => array(childId=>'oficina_id'),
		transaction=>array(
			table	=>array(('parametros_liquidacion_nomina')),
			type	=>array('column'))		
	);		
	  	
		
	$this -> Campos[oficina_id] = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		disabled =>'true',
		options  => array(),
		transaction=>array(
			table	=>array(('parametros_liquidacion_nomina')),
			type	=>array('column'))
	);	
	
		
	$this -> Campos[tipo_documento_id] = array(
		name	 =>'tipo_documento_id',
		id		 =>'tipo_documento_id',
		type	 =>'select',
		required =>'yes',		
		options  => array(),
		transaction=>array(
			table	=>array(('parametros_liquidacion_nomina')),
			type	=>array('column'))
	);		

		
		$this -> Campos[puc_vac_cons_id] = array(
			name	=>'puc_vac_cons_id',
			id		=>'puc_vac_cons_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_vac_cons] = array(
			name	=>'puc_vac_cons',
			id		=>'puc_vac_cons',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_vac_cons_id')
		);	  


		/*$this -> Campos[puc_vac_prov_id] = array(
			name	=>'puc_vac_prov_id',
			id		=>'puc_vac_prov_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_vac_prov] = array(
			name	=>'puc_vac_prov',
			id		=>'puc_vac_prov',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_vac_prov_id')
		);	 */ 

		$this -> Campos[puc_vac_contra_id] = array(
			name	=>'puc_vac_contra_id',
			id		=>'puc_vac_contra_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_vac_contra] = array(
			name	=>'puc_vac_contra',
			id		=>'puc_vac_contra',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_vac_contra_id')
		);	  

		//---
		

		$this -> Campos[puc_admon_vac_id] = array(
			name	=>'puc_admon_vac_id',
			id		=>'puc_admon_vac_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_vac] = array(
			name	=>'puc_admon_vac',
			id		=>'puc_admon_vac',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_vac_id')
		);	  


		$this -> Campos[puc_ventas_vac_id] = array(
			name	=>'puc_ventas_vac_id',
			id		=>'puc_ventas_vac_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_vac] = array(
			name	=>'puc_ventas_vac',
			id		=>'puc_ventas_vac',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_vac_id')
		);	  

		$this -> Campos[puc_produ_vac_id] = array(
			name	=>'puc_produ_vac_id',
			id		=>'puc_produ_vac_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_vac] = array(
			name	=>'puc_produ_vac',
			id		=>'puc_produ_vac',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_vac_id')
		);	  
		
		

		$this -> Campos[puc_salud_vac_id] = array(
			name	=>'puc_salud_vac_id',
			id		=>'puc_salud_vac_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_salud_vac] = array(
			name	=>'puc_salud_vac',
			id		=>'puc_salud_vac',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_salud_vac_id')
		);	  

	$this -> Campos[puc_pension_vac_id] = array(
			name	=>'puc_pension_vac_id',
			id		=>'puc_pension_vac_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_pension_vac] = array(
			name	=>'puc_pension_vac',
			id		=>'puc_pension_vac',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_pension_vac_id')
		);	  
		
		$this -> Campos[puc_reintegro_vac_id] = array(
			name	=>'puc_reintegro_vac_id',
			id		=>'puc_reintegro_vac_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_reintegro_vac] = array(
			name	=>'puc_reintegro_vac',
			id		=>'puc_reintegro_vac',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_reintegro_vac_id')
		);	  



		// PARA PRIMAS
		
				
		$this -> Campos[puc_prima_cons_id] = array(
			name	=>'puc_prima_cons_id',
			id		=>'puc_prima_cons_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_prima_cons] = array(
			name	=>'puc_prima_cons',
			id		=>'puc_prima_cons',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_prima_cons_id')
		);	  


		/*$this -> Campos[puc_prima_prov_id] = array(
			name	=>'puc_prima_prov_id',
			id		=>'puc_prima_prov_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_prima_prov] = array(
			name	=>'puc_prima_prov',
			id		=>'puc_prima_prov',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_prima_prov_id')
		);*/	  

		$this -> Campos[puc_prima_contra_id] = array(
			name	=>'puc_prima_contra_id',
			id		=>'puc_prima_contra_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_prima_contra] = array(
			name	=>'puc_prima_contra',
			id		=>'puc_prima_contra',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_prima_contra_id')
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
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_prima] = array(
			name	=>'puc_admon_prima',
			id		=>'puc_admon_prima',
			type	=>'text',
			required=>'yes',
			size=>16,
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
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_prima] = array(
			name	=>'puc_ventas_prima',
			id		=>'puc_ventas_prima',
			type	=>'text',
			required=>'yes',
			size=>16,
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
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_prima] = array(
			name	=>'puc_produ_prima',
			id		=>'puc_produ_prima',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_prima_id')
		);	
		
		$this -> Campos[puc_reintegro_prima_id] = array(
			name	=>'puc_reintegro_prima_id',
			id		=>'puc_reintegro_prima_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_reintegro_prima] = array(
			name	=>'puc_reintegro_prima',
			id		=>'puc_reintegro_prima',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_reintegro_prima_id')
		);	
		
		
  
		
		//--- campos cesantias
		 
		 			
		$this -> Campos[puc_cesantias_cons_id] = array(
			name	=>'puc_cesantias_cons_id',
			id		=>'puc_cesantias_cons_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_cesantias_cons] = array(
			name	=>'puc_cesantias_cons',
			id		=>'puc_cesantias_cons',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_cesantias_cons_id')
		);	  


		/*$this -> Campos[puc_cesantias_prov_id] = array(
			name	=>'puc_cesantias_prov_id',
			id		=>'puc_cesantias_prov_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_cesantias_prov] = array(
			name	=>'puc_cesantias_prov',
			id		=>'puc_cesantias_prov',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_cesantias_prov_id')
		);*/	  

		$this -> Campos[puc_cesantias_contra_id] = array(
			name	=>'puc_cesantias_contra_id',
			id		=>'puc_cesantias_contra_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_cesantias_contra] = array(
			name	=>'puc_cesantias_contra',
			id		=>'puc_cesantias_contra',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_cesantias_contra_id')
		);	  
		 

		$this -> Campos[puc_admon_cesantias_id] = array(
			name	=>'puc_admon_cesantias_id',
			id		=>'puc_admon_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_cesantias] = array(
			name	=>'puc_admon_cesantias',
			id		=>'puc_admon_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_cesantias_id')
		);	  


		$this -> Campos[puc_ventas_cesantias_id] = array(
			name	=>'puc_ventas_cesantias_id',
			id		=>'puc_ventas_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_cesantias] = array(
			name	=>'puc_ventas_cesantias',
			id		=>'puc_ventas_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_cesantias_id')
		);	  

		$this -> Campos[puc_produ_cesantias_id] = array(
			name	=>'puc_produ_cesantias_id',
			id		=>'puc_produ_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_cesantias] = array(
			name	=>'puc_produ_cesantias',
			id		=>'puc_produ_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_cesantias_id')
		);	  
		
		
		$this -> Campos[puc_reintegro_cesantias_id] = array(
			name	=>'puc_reintegro_cesantias_id',
			id		=>'puc_reintegro_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_reintegro_cesantias] = array(
			name	=>'puc_reintegro_cesantias',
			id		=>'puc_reintegro_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_reintegro_cesantias_id')
		);	  
		
		

		//--- campos cesantias
		 
		 			
		$this -> Campos[puc_int_cesantias_cons_id] = array(
			name	=>'puc_int_cesantias_cons_id',
			id		=>'puc_int_cesantias_cons_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_int_cesantias_cons] = array(
			name	=>'puc_int_cesantias_cons',
			id		=>'puc_int_cesantias_cons',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_int_cesantias_cons_id')
		);	  


		/*$this -> Campos[puc_int_cesantias_prov_id] = array(
			name	=>'puc_int_cesantias_prov_id',
			id		=>'puc_int_cesantias_prov_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_int_cesantias_prov] = array(
			name	=>'puc_int_cesantias_prov',
			id		=>'puc_int_cesantias_prov',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_int_cesantias_prov_id')
		);	*/  

		$this -> Campos[puc_int_cesantias_contra_id] = array(
			name	=>'puc_int_cesantias_contra_id',
			id		=>'puc_int_cesantias_contra_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_int_cesantias_contra] = array(
			name	=>'puc_int_cesantias_contra',
			id		=>'puc_int_cesantias_contra',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_int_cesantias_contra_id')
		);	  
		 

		$this -> Campos[puc_admon_int_cesantias_id] = array(
			name	=>'puc_admon_int_cesantias_id',
			id		=>'puc_admon_int_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_admon_int_cesantias] = array(
			name	=>'puc_admon_int_cesantias',
			id		=>'puc_admon_int_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_admon_int_cesantias_id')
		);	  


		$this -> Campos[puc_ventas_int_cesantias_id] = array(
			name	=>'puc_ventas_int_cesantias_id',
			id		=>'puc_ventas_int_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_ventas_int_cesantias] = array(
			name	=>'puc_ventas_int_cesantias',
			id		=>'puc_ventas_int_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_ventas_int_cesantias_id')
		);	  

		$this -> Campos[puc_produ_int_cesantias_id] = array(
			name	=>'puc_produ_int_cesantias_id',
			id		=>'puc_produ_int_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_produ_int_cesantias] = array(
			name	=>'puc_produ_int_cesantias',
			id		=>'puc_produ_int_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_produ_int_cesantias_id')
		);	  
		
		$this -> Campos[puc_reintegro_int_cesantias_id] = array(
			name	=>'puc_reintegro_int_cesantias_id',
			id		=>'puc_reintegro_int_cesantias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array(('parametros_liquidacion_nomina')),
				type	=>array('column'))
		);

		$this -> Campos[puc_reintegro_int_cesantias] = array(
			name	=>'puc_reintegro_int_cesantias',
			id		=>'puc_reintegro_int_cesantias',
			type	=>'text',
			required=>'yes',
			size=>16,
			datatype=>array(type=>'text'),
			suggest=>array(
				name	=>'cuentas_movimiento',
				setId	=>'puc_reintegro_int_cesantias_id')
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
				onsuccess=>'ParametrosLiquidacionOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			// tabindex=>'22',
			onclick	=>'ParametrosLiquidacionOnReset()'
		);

		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			placeholder=>'Por favor digitar la oficina.',
			size	=>'85',
			suggest=>array(
				name	=>'parametros_liquidacion_nomina',
				setId	=>'parametros_liquidacion_id',
				onclick	=>'setDataFormWithResponse')
		);

		$this -> SetVarsValidate($this -> Campos);
	}
}

$id_base = new ParametrosLiquidacion();
?>