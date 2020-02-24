<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class Empleado extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("EmpleadoLayoutClass.php");
			require_once("EmpleadoModelClass.php");

			$Layout   = new EmpleadoLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new EmpleadoModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
			$Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
			$Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
			$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));

			$Layout -> SetCampos($this -> Campos);

			//LISTA MENU
			$Layout -> SetTiposId     ($Model -> GetTipoId($this -> getConex()));
        	$Layout -> SetTiposPersona($Model -> GetTipoPersona($this -> getConex()));
			$Layout -> SetEstadoCiv($Model -> GetEstadoCiv($this -> getConex()));
			//$Layout -> SetProfesion($Model -> GetProfesion($this -> getConex()));
			$Layout -> SetConvocados($Model -> GetConvocados($this -> getConex()));
			// $Layout -> SetCivil($Model -> GetCivil($this -> getConex()));

			//// GRID ////
			$Attributes = array(
				id		=>'empleado',
				title	=>'Listado de Empleados',
				sortname=>'empleado_id',
				width	=>'auto',
				height	=>'250'
			);

			$Cols = array(
				array(name=>'empleado_id',			index=>'empleado_id',			sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'sexo',			        index=>'sexo',			        sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'fecha_nacimiento',		index=>'fecha_nacimiento',		sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'estado_civil_id',		index=>'estado_civil_id',		sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'tipo_vivienda',		index=>'tipo_vivienda',			sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'profesion_id',			index=>'profesion_id',			sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'num_hijos',			index=>'num_hijos',			    sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'estado',			    index=>'estado',			    sorttype=>'text',	width=>'120',	align=>'center'),
				array(name=>'convocado_id',			index=>'convocado_id',			sorttype=>'text',	width=>'210',	align=>'center'),
				array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',sorttype=>'text',	width=>'80',	align=>'center'),
                array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'100',	align=>'center'),
     		    array(name=>'digito_verificacion',	index=>'digito_verificacion',	sorttype=>'int',	width=>'22',	align=>'center'),
				array(name=>'tipo_persona_id',		index=>'tipo_persona_id',		sorttype=>'text',	width=>'100',	align=>'center'),	
				array(name=>'primer_apellido',		index=>'primer_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'segundo_apellido',		index=>'segundo_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'primer_nombre',			index=>'primer_nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'segundo_nombre',			index=>'segundo_nombre',		sorttype=>'text',	width=>'150',	align=>'center')


			);

			$Titles = array(			
				'EMPLEADO',
				'SEXO',
				'FECHA DE NACIMIENTO',
				'ESTADO CIVIL',
				'TIPO DE VIVIENDA',
				'PROFESION',
				'NUMERO DE HIJOS',
				'ESTADO',
				'CONVOCADO',
				'TIPO ID',
				'IDENTIFICACION',
				'DV',
				'TIPO CONTRIBUYENTE',
				'PRIMER APELLIDO',
				'SEGUNDO APELLIDO',
				'PRIMER NOMBRE',
				'OTROS NOMBRES'
				
			);

			$Layout -> SetGridEmpleado($Attributes,$Titles,$Cols,$Model -> GetQueryEmpleadoGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("EmpleadoModelClass.php");
			$Model = new EmpleadoModel();
			echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
		}


		protected function onclickSave(){

			require_once("EmpleadoModelClass.php");
			$Model = new EmpleadoModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
			}else{
			exit('Se ingreso correctamente el empleado');
			}
		}

		protected function onclickUpdate(){

			require_once("EmpleadoModelClass.php");
			$Model = new EmpleadoModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente el empleado');
			}
		}


		protected function onclickDelete(){

			require_once("EmpleadoModelClass.php");
			$Model = new EmpleadoModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('No se puede borrar el empleado');
			}else{
				exit('Se borro exitosamente el empleado');
			}
		}
		
  
   /*protected function setDataProfesion(){

    require_once("EmpleadoModelClass.php");

    $Model = new EmpleadoModel();    

    $profesion_id = $_REQUEST['profesion_id'];

    $data = $Model -> getDataProfesion($profesion_id,$this -> getConex());

    $this -> getArrayJSON($data);

  }*/
  
		   protected function setcargaDatos(){
		
			require_once("EmpleadoModelClass.php");
			$Model = new EmpleadoModel();    
			$convocado_id = $_REQUEST['convocado_id'];
			$data = $Model -> getcargaDatos($convocado_id,$this -> getConex());
			$this -> getArrayJSON($data);  
		
		  }
		


		//BUSQUEDA
		protected function onclickFind(){

			require_once("EmpleadoModelClass.php");
			$Model = new EmpleadoModel();
			$Data                  = array();
			$empleado_id   = $_REQUEST['empleado_id'];
			$numero_identificacion = $_REQUEST['numero_identificacion'];
			if(is_numeric($empleado_id )){
				$Data  = $Model -> selectDatosEmpleadoId($empleado_id,$this -> getConex());
			}else if(is_numeric($numero_identificacion)){
		  		$Data  = $Model -> selectDatosNumId($numero_identificacion,$this -> getConex());
	  		}
			echo json_encode($Data);
		}


		protected function SetCampos(){

			/********************
			Campos Tarifas Proveedor
			********************/
			
			$this -> Campos[empleado_id] = array(
				name	=>'empleado_id',
				id		=>'empleado_id',
				type	=>'hidden',
				datatype=>array(
				type	=>'autoincrement'),
				transaction=>array(
				table	=>array('empleado'),
        		type	=>array('primary_key'))
			);	
			
			$this -> Campos[sexo] = array(
				name	=>'sexo',
				id		=>'sexo',
				type	=>'select',
				options	=> array(array(value=>'F',text=>'FEMENINO',selected=>'0'),array(value=>'M',text=>'MASCULINO')),
				required=>'yes',
				Boostrap =>'si',
			 	datatype=>array(
					type	=>'text',
					length	=>'1'),
				transaction=>array(
					table	=>array('empleado'),
					type	=>array('column'))
			);
			
			$this -> Campos[fecha_nacimiento] = array(
				name	=>'fecha_nacimiento',
				id		=>'fecha_nacimiento',
				type	=>'text',
				
				required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'11'),
				transaction=>array(
					table	=>array('empleado'),
					type	=>array('column'))
			);	

			$this -> Campos[tipo_vivienda] = array(
				name	=>'tipo_vivienda',
				id		=>'tipo_vivienda',
				type	=>'select',
				Boostrap =>'si',
				options	=> array(array(value=>'P',text=>'PROPIA',selected=>'0'),array(value=>'A',text=>'ARRIENDO')),
				required=>'yes',
				datatype=>array(
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('empleado'),
					type	=>array('column'))
			);

			$this -> Campos[num_hijos] = array(
				name	=>'num_hijos',
				id		=>'num_hijos',
				type	=>'text',
				Boostrap =>'si',
				size  	=>'5',
				//required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'2'),
				transaction=>array(
					table	=>array('empleado'),
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
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('empleado'),
					type	=>array('column'))
			);

			$this -> Campos[convocado_id] = array(
				name	=>'convocado_id',
				id		=>'convocado_id',
				type	=>'text',
				Boostrap =>'si',
				required=>'no',
				datatype=>array(
					type	=>'text',
					length	=>'2'),
				transaction=>array(
					table	=>array('empleado'),
					type	=>array('column'))
			);

			
			$this -> Campos[tercero_id] = array(
		  		name	=>'tercero_id',
				id		=>'tercero_id',
				type	=>'hidden',
				datatype=>array(
				type	=>'autoincrement'),
				transaction=>array(
				table	=>array('tercero','empleado'),
				type	=>array('primary_key','column'))
			);
			
		$this -> Campos[profesion_id] = array(
			name	=>'profesion_id',
			id	=>'profesion_hidden',
			type	=>'hidden',
			//required=>'yes',
			datatype=>array(type=>'integer'),
			transaction=>array(
				table	=>array('empleado'),
				type	=>array('column'))
		);

			$this -> Campos[profesion] = array(
			name	=>'profesion',
			id	=>'profesion',
			type	=>'text',
			Boostrap =>'si',
					size    =>'30',
			suggest => array(
				name	=>'profesion',
				setId	=>'profesion_hidden',
				onclick => 'setDataProfesion')
		);
			
			$this -> Campos[numero_identificacion] = array(
				name	=>'numero_identificacion',
				id		=>'numero_identificacion',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				size	=>'12',
				//tabindex=>'3',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('tercero'),
					type	=>array('column'))
			);
			
			$this -> Campos[primer_apellido] = array(
				name	=>'primer_apellido',
				id		=>'primer_apellido',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				//tabindex=>'5',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'100'),
				transaction=>array(
					table	=>array('tercero'),
					type	=>array('column'))
			);
			 
			$this -> Campos[segundo_apellido] = array(
				name	=>'segundo_apellido',
				id		=>'segundo_apellido',
				type	=>'text',
				Boostrap =>'si',
				//tabindex=>'6',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'100'),
				transaction=>array(
					table	=>array('tercero'),
					type	=>array('column'))
			);
			 
			$this -> Campos[primer_nombre] = array(
				name	=>'primer_nombre',
				id		=>'primer_nombre',
				type	=>'text',
				Boostrap =>'si',
				required=>'yes',
				//tabindex=>'7',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'100'),
				transaction=>array(
					table	=>array('tercero'),
					type	=>array('column'))
			);
			 
			$this -> Campos[segundo_nombre] = array(
				name	=>'segundo_nombre',
				id		=>'segundo_nombre',
				type	=>'text',
				Boostrap =>'si',
				//tabindex=>'8',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'10'),
				transaction=>array(
					table	=>array('tercero'),
					type	=>array('column'))
			);
			
			
			
			$this -> Campos[estado_civil_id] = array(
				name	=>'estado_civil_id',
				id		=>'estado_civil_id',
				type	=>'select',
				Boostrap =>'si',
				//options	=>null,
				required=>'yes',
				datatype=>array(
					type	=>'alphanum',
					length	=>'11'),
				transaction=>array(
					table	=>array('empleado'),
					type	=>array('column'))
			);

			
			$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(),
		required=>'yes',
		//tabindex=>'1',
	 	datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	  
	$this -> Campos[tipo_persona_id] = array(
		name	=>'tipo_persona_id',
		id		=>'tipo_persona_id',
		type	=>'select',
		Boostrap =>'si',
		options	=> array(array(value=>'N',text=>'NATURAL',selected=>'N'),array(value=>'J',text=>'JURIDICA')),
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);			
	
		$this -> Campos[direccion] = array(
					name	=>'direccion',
					id		=>'direccion',
					type	=>'text',
					Boostrap =>'si',
					required=>'yes',
					datatype=>array(
						type	=>'text',
						length	=>'45'),
					transaction=>array(
						table	=>array('tercero'),
						type	=>array('column'))
				);
	
				$this -> Campos[telefono] = array(
					name	=>'telefono',
					id		=>'telefono',
					type	=>'text',
					Boostrap =>'si',
					required=>'no',
					datatype=>array(
						type	=>'integer',
						length	=>'45'),
					transaction=>array(
						table	=>array('tercero'),
						type	=>array('column'))
				);
	
				$this -> Campos[movil] = array(
					name	=>'movil',
					id		=>'movil',
					type	=>'text',
					Boostrap =>'si',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'45'),
					transaction=>array(
						table	=>array('tercero'),
						type	=>array('column'))
				);
				
				$this -> Campos[foto] = array(
					name	=>'foto',
					id		=>'foto',
					type	=>'file',
					//required =>'yes',
					value	=>'',
					path	=>'/application/imagenes/nomina/empleado/',
					size	=>'40',	
					datatype=>array(
						type	=>'file'),
					transaction=>array(
						table	=>array('empleado'),
						type	=>array('column')),
					namefile=>array(
						field	=>'yes',
						namefield=>'numero_identificacion',
						text	=>'_foto')
				);	
				

				$this -> Campos[certificados] = array(
					name	=>'certificados',
					id		=>'certificados',
					type	=>'file',
					//required =>'yes',
					value	=>'',
					path	=>'/application/imagenes/nomina/certificados/',
					size	=>'40',	
					datatype=>array(
						type	=>'file'),
					transaction=>array(
						table	=>array('empleado'),
						type	=>array('column')),
					namefile=>array(
						field	=>'yes',
						namefield=>'numero_identificacion',
						text	=>'_certificado')
				);	
					
				$this -> Campos[documentos] = array(
					name	=>'documentos',
					id		=>'documentos',
					type	=>'file',
					//required =>'yes',
					value	=>'',
					path	=>'/application/imagenes/nomina/documentos/',
					size	=>'40',	
					datatype=>array(
						type	=>'file'),
					transaction=>array(
						table	=>array('empleado'),
						type	=>array('column')),
					namefile=>array(
						field	=>'yes',
						namefield=>'numero_identificacion',
						text	=>'_documento')
				);	



			/**********************************
			Botones
			**********************************/
			
			$this -> Campos[importConvocado] = array(
				name	=>'importConvocado',
				id		=>'importConvocado',
				type	=>'button',
				value	=>'Importar Convocado'
	 	  );	

			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Guardar'
				// tabindex=>'19'
			);

			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Actualizar',
				disabled=>'disabled'
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
					onsuccess=>'EmpleadoOnSaveOnUpdateonDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				onclick =>'EmpleadoOnReset(this.form)',
				// tabindex=>'22',
			);

			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				Boostrap =>'si',
				placeholder =>'Por favor digite el numero de identificacion o el nombre',
				// tabindex=>'1',
				suggest=>array(
					name	=>'empleado',
					setId	=>'empleado_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$empleado_id = new empleado();
?>