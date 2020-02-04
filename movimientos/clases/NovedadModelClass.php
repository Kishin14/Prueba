<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class NovedadModel extends Db{
	
	public function SetUsuarioId($usuario_id,$oficina_id){	  
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}
	
	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}
	
	public function Save($Campos,$Conex){	
	
		$empleados	= $_REQUEST['si_empleado'];
	
		if($empleados=='1'){ 
			$novedad_fija_id = $this -> DbgetMaxConsecutive("novedad_fija","novedad_fija_id",$Conex,false,1);
			
			$this -> assignValRequest('novedad_fija_id',$novedad_fija_id);
			$this -> Begin($Conex);
				
				$this -> DbInsertTable("novedad_fija",$Campos,$Conex,true,false);
					
			$this -> Commit($Conex);
		}elseif($empleados == "ALL"){
			
			$select="SELECT c.contrato_id FROM contrato c, tipo_contrato t WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND t.prestaciones_sociales=1";
			$result = $this -> DbFetchAll($select,$Conex);
			$this -> Begin($Conex);
			foreach($result as $resultado){
				$novedad_fija_id = $this -> DbgetMaxConsecutive("novedad_fija","novedad_fija_id",$Conex,false,1);
				$this -> assignValRequest('novedad_fija_id',$novedad_fija_id);
				$this -> assignValRequest('contrato_id',$resultado[contrato_id]);
				$this -> DbInsertTable("novedad_fija",$Campos,$Conex,true,false);
				
			}
			$this -> Commit($Conex);
			
		}
		return array(array(novedad_fija_id=>$novedad_fija_id));
	}

	public function selectDataProveedor($contrato_id,$Conex){
		$select ="SELECT p.proveedor_id 
		FROM contrato co, empleado e, proveedor p 
		WHERE co.contrato_id=$contrato_id AND e.empleado_id=co.empleado_id AND p.tercero_id=e.tercero_id"; 
		$result    = $this -> DbFetchAll($select,$Conex,true);
		return $result[0]['proveedor_id'];
	}

	public function GetEnca($novedad_fija_id,$Conex){
		$select ="SELECT	c.*,(SELECT descripcion FROM concepto_area WHERE concepto_area_id=c.concepto_area_id) AS concepto_area,
		(SELECT puc_partida_id FROM concepto_area WHERE concepto_area_id=c.concepto_area_id) AS partida_puc_id,
		(SELECT puc_contra_id FROM concepto_area WHERE concepto_area_id=c.concepto_area_id) AS contra_puc_id,
		(SELECT naturaleza_partida FROM concepto_area WHERE concepto_area_id=c.concepto_area_id) AS naturaleza_partida,
		(SELECT naturaleza_contra FROM concepto_area WHERE concepto_area_id=c.concepto_area_id) AS 	naturaleza_contra,
		(SELECT e.tercero_id FROM contrato co, empleado e WHERE co.contrato_id=c.contrato_id AND e.empleado_id=co.empleado_id) AS 	tercero_id,
		(SELECT p.proveedor_id FROM contrato co, empleado e, proveedor p WHERE co.contrato_id=c.contrato_id AND e.empleado_id=co.empleado_id AND p.tercero_id=e.tercero_id) AS 	proveedor_id,
		(SELECT centro_de_costo_id FROM contrato WHERE contrato_id=c.contrato_id) AS centro_de_costo_id,
		(SELECT cc.codigo FROM contrato co, centro_de_costo cc WHERE co.contrato_id=c.contrato_id AND cc.centro_de_costo_id=co.centro_de_costo_id) AS codigo_centro_costo		
		FROM novedad_fija c	WHERE	c.novedad_fija_id = $novedad_fija_id "; 
		$result    = $this -> DbFetchAll($select,$Conex,true);
		return $result;
	}
	
	public function SaveContab($novedad_fija_id,$encabezado,$debito_part,$credito_part,$debito_contra,$credito_contra,$usuario_id,$oficina_id,$modifica,$empresa_id,$Conex){	

        include_once("UtilidadesContablesModelClass.php");
	    $utilidadesContables = new UtilidadesContablesModel(); 	 		

		$valor  = $encabezado[0]['valor'];
		$fecha  = $encabezado[0]['fecha_inicial'];
		$concepto  = $encabezado[0]['concepto'];
		$fecha_ingreso = date('Y-m-d H:i');
		$partida_puc_id  = $encabezado[0]['partida_puc_id'];
		$contra_puc_id  = $encabezado[0]['contra_puc_id'];
		$tipo_documento_id  = $encabezado[0]['tipo_documento_id'];
		$terceroid= $encabezado[0]['tercero_id'];
		$proveedor_id= $encabezado[0]['proveedor_id'];
		
		$periodo_contable_id =  $utilidadesContables->getPeriodoContableId($fecha,$Conex);
		$mes_contable_id	 = $utilidadesContables->getMesContableId($fecha,$periodo_contable_id,$Conex);
		$consecutivo		 = $utilidadesContables->getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);
		
		if($utilidadesContables->requiereTercero($partida_puc_id,$Conex)){
			$tercero_id= $encabezado[0]['tercero_id'];
			$numero_identificacion= "(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id)";
			$digito_verificacion="(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id)";
		}else{
			$tercero_id= 'NULL';
			$numero_identificacion= 'NULL';
			$digito_verificacion= 'NULL';			
		}

		if($utilidadesContables->requiereTercero($contra_puc_id,$Conex)){
			$tercero_id1= $encabezado[0]['tercero_id'];
			$numero_identificacion1= "(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id)";
			$digito_verificacion1="(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id)";
		}else{
			$tercero_id1= 'NULL';
			$numero_identificacion1= 'NULL';
			$digito_verificacion1= 'NULL';			
		}


		if($utilidadesContables->requiereCentroCosto($partida_puc_id,$Conex)){
			$centro_de_costo_id= $encabezado[0]['centro_de_costo_id'];
			$codigo_centro_costo= "'".$encabezado[0]['codigo_centro_costo']."'";
		}else{
			$centro_de_costo_id= 'NULL';
			$codigo_centro_costo= 'NULL';
		}

		if($utilidadesContables->requiereCentroCosto($contra_puc_id,$Conex)){
			$centro_de_costo_id1= $encabezado[0]['centro_de_costo_id'];
			$codigo_centro_costo1= "'".$encabezado[0]['codigo_centro_costo']."'";
		}else{
			$centro_de_costo_id1= 'NULL';
			$codigo_centro_costo1= 'NULL';
		}

		$this -> Begin($Conex);
		//factura proveedor ok
		$factura_proveedor_id    = $this -> DbgetMaxConsecutive("factura_proveedor","factura_proveedor_id",$Conex,true,1);
		$insert = "INSERT INTO factura_proveedor (factura_proveedor_id,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,usuario_id,oficina_id,ingreso_factura_proveedor,estado_factura_proveedor) 
						VALUES ($factura_proveedor_id,$valor,'$fecha','$fecha','$concepto',$proveedor_id,'NO',$usuario_id,$oficina_id,'$fecha_ingreso','A')"; 
		$this -> query($insert,$Conex,true);			

		//partida item_factura ok
		$item_factura_proveedor_id    = $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
		$insert = "INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,desc_factura_proveedor,deb_item_factura_proveedor,	cre_item_factura_proveedor,contra_factura_proveedor) 
						VALUES ($item_factura_proveedor_id,$factura_proveedor_id,$partida_puc_id,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_de_costo_id,$codigo_centro_costo,'$concepto',$debito_part,$credito_part,0)"; 
		$this -> query($insert,$Conex,true);			

		//contrapartida item_factura ok
		$item_factura_proveedor_id    = $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
		$insert = "INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,desc_factura_proveedor,deb_item_factura_proveedor,	cre_item_factura_proveedor,contra_factura_proveedor) 
						VALUES ($item_factura_proveedor_id,$factura_proveedor_id,$contra_puc_id,$tercero_id1,$numero_identificacion1,$digito_verificacion1,$centro_de_costo_id1,$codigo_centro_costo1,'$concepto', $debito_contra,$credito_contra,1)"; 
		$this -> query($insert,$Conex,true);			

		//contable  ok
		$encabezado_registro_id    = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);
		$insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,id_documento_fuente) 
						VALUES ($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$valor,'$novedad_fija_id',$terceroid,$periodo_contable_id,$mes_contable_id,$consecutivo,'$fecha','$concepto','C','$fecha_ingreso','$modifica',$usuario_id,$novedad_fija_id)"; 
		$this -> query($insert,$Conex,true);			

		//partida contabilidad  ok
		$imputacion_contable_id    = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
		$insert = "INSERT INTO imputacion_contable (imputacion_contable_id,encabezado_registro_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,descripcion,debito,credito)
					VALUES ($imputacion_contable_id,$encabezado_registro_id,$partida_puc_id,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_de_costo_id,$codigo_centro_costo,'$concepto',$debito_part,$credito_part)"; 
		$this -> query($insert,$Conex,true);			

		//contrapartida contabilidad ok
		$imputacion_contable_id    = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
		$insert = "INSERT INTO imputacion_contable (imputacion_contable_id,encabezado_registro_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,descripcion,debito,credito) 
						VALUES ($imputacion_contable_id,$encabezado_registro_id,$contra_puc_id,$tercero_id1,$numero_identificacion1,$digito_verificacion1,$centro_de_costo_id1,$codigo_centro_costo1,'$concepto', $debito_contra,$credito_contra)"; 
		$this -> query($insert,$Conex,true);			


		$update = "UPDATE factura_proveedor SET  estado_factura_proveedor='C', encabezado_registro_id=$encabezado_registro_id WHERE factura_proveedor_id=$factura_proveedor_id"; 
		$this -> query($update,$Conex,true);			

		$update = "UPDATE novedad_fija SET  factura_proveedor_id=$factura_proveedor_id, encabezado_registro_id=$encabezado_registro_id WHERE novedad_fija_id=$novedad_fija_id"; 
		$this -> query($update,$Conex,true);			

		$this -> Commit($Conex);
		return $consecutivo;
	}
	
	public function Update($Campos,$Conex){	
		$this -> DbUpdateTable("novedad_fija",$Campos,$Conex,true,false);
	}
	
	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("novedad_fija",$Campos,$Conex,true,false);
	}	
	
	public function ValidateRow($Conex,$Campos){
	
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"novedad_fija",$Campos);
		return $Data -> GetData();
	}
	
	public function GetSi_Pro($Conex){
		$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
		return $opciones;
	}   
	
	public function GetTipoConcepto($Conex){
		return $this  -> DbFetchAll("SELECT concepto_area_id AS value,descripcion AS text FROM concepto_area WHERE estado='A' ORDER BY descripcion ASC",$Conex,$ErrDb = false);
	}   

	public function GetTipoDocumento($Conex){
		return $this  -> DbFetchAll("SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento WHERE de_niif=0 AND pago_factura=0 ORDER BY nombre ASC",$Conex,$ErrDb = false);
	}   

	public function selectDataConcepto($concepto_area_id,$Conex){
		$select ="SELECT contabiliza,tipo_novedad FROM concepto_area	WHERE	concepto_area_id = $concepto_area_id"; 
		$result    = $this -> DbFetchAll($select,$Conex,true);
		return $result[0];
	}

	public function selectDatosNovedadId($novedad_fija_id,$Conex){
		$select = "SELECT n.*,
		REPLACE(REPLACE(REPLACE(FORMAT(n.valor_cuota, 2), '.', '@'), ',', '.'), '@', ',') AS valor_cuota,
		(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,'-',t.numero_identificacion) 
		AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS contrato,
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)	AS tercero FROM tercero t WHERE t.tercero_id=n.tercero_id )AS tercero,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=n.encabezado_registro_id) AS doc_contable
		FROM novedad_fija n WHERE n.novedad_fija_id = $novedad_fija_id";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function validarFechas($fecha_inicial,$fecha_final,$contrato,$Conex){

		$select = "SELECT c.descripcion,n.fecha_inicial,n.fecha_final FROM novedad_fija n,concepto_area c WHERE n.fecha_inicial >= '$fecha_inicial' AND n.fecha_final <= '$fecha_final' AND c.concepto_area_id=n.concepto_area_id AND n.contrato_id = $contrato";

		$result = $this -> DbFetchAll($select,$Conex);

		return $result;

	}
	
	public function GetQueryNovedadGrid(){
	
		$Query = "SELECT n.novedad_fija_id,n.fecha_novedad,
		(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,'-',t.numero_identificacion) 
		AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS contrato,
		(SELECT descripcion FROM concepto_area WHERE concepto_area_id=n.concepto_area_id) AS tipo_novedad,
		IF(n.tipo_novedad='D','DEDUCIDO','DEVENGADO')AS naturaleza,
		 n.concepto,n.fecha_inicial,n.fecha_final,n.valor,n.cuotas, n.valor_cuota,
		 IF(n.periodicidad='H','HORAS',IF(n.periodicidad='D','DIAS',IF(n.periodicidad='S','SEMANAL',IF(n.periodicidad='Q','QUINCENAL','MENSUAL'))))AS periodicidad, 
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)	FROM tercero t WHERE t.tercero_id=n.tercero_id )AS beneficiario,	
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=n.encabezado_registro_id) AS doc_contable,
		 IF(n.estado='A','ACTIVO','INACTIVO') AS estado
		 FROM novedad_fija n";
		
		return $Query;
	}



}
?>