<?php

  require_once("../../framework/clases/DbClass.php");

  class UtilidadesContablesModel extends Db{
  
   private $cuentasMovimiento;
  
   public function getEmpresas($Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id ";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }  
   
  public function mesContableEstaHabilitado($oficina_id,$fecha,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE oficina_id = $oficina_id AND '$fecha' BETWEEN fecha_inicio AND fecha_final";
				 
      $result = $this -> DbFetchAll($select,$Conex);				 
	  
	  $this -> mes_contable_id = $result[0]['mes_contable_id'];
	  
	  return $result[0]['estado'] == 1 ? true : false;
	  
  }
	
  public function periodoContableEstaHabilitado($empresa_id,$fecha,$Conex){
	  	
	$anio = substr($fecha,0,4);	 
		 
    $select = "SELECT estado FROM periodo_contable WHERE empresa_id = $empresa_id AND anio = $anio";
	$result = $this -> DbFetchAll($select,$Conex);		 
	
	return $result[0]['estado'] == 1? true : false;		 
	  
  }     
   
    	 
	  public function getPeriodoContableId($fecha,$Conex){
	  
		$anio   = substr($fecha,0,4);
		$select = "SELECT periodo_contable_id FROM periodo_contable WHERE anio = $anio";
		$result = $this  -> DbFetchAll($select,$Conex,true);
		
		if(count($result) > 0){
		  return $result[0]['periodo_contable_id'];
		}else{
			 exit("No existe un periodo contable creado para el año [ $anio ] <br> Comuniquese con el administrador del sistema !!");
		  }	
	  
	  }
	  
	  public function getMesContableId($fecha,$periodo_contable_id,$Conex){
	  
		 $mes    = (int)substr($fecha,5,2);
		 $select = "SELECT mes_contable_id FROM mes_contable WHERE periodo_contable_id = $periodo_contable_id AND mes = $mes";
		 $result = $this  -> DbFetchAll($select,$Conex,true);
		 
		 if(count($result) > 0){
		   return $result[0]['mes_contable_id'];
		 }else{
			 exit("No existe un mes contable creado para la fecha [ $fecha ] <br> Comuniquese con el administrador del sistema !!");
		  }		 
		  
	  }
	  
	  public function getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex){
	  
	      $select = "SELECT * FROM  tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
		  $result = $this -> DbFetchAll($select,$Conex,true);		  
		  
		  $consecutivo_por     = $result[0]['consecutivo_por'];
		  $consecutivo         = $result[0]['consecutivo'];
		  $consecutivo_periodo = $result[0]['consecutivo_periodo'];
		  $fecha               = date("Y-m-d");
		  		  		  		  
		  if($consecutivo_periodo == 1){
		  
            if($consecutivo_por == 'E'){
			
			  $select = "SELECT consecutivo FROM encabezado_de_registro WHERE periodo_contable_id = $periodo_contable_id AND tipo_documento_id 
			             = $tipo_documento_id";
			  $result = $this -> DbFetchAll($select,$Conex,true);
			  
			  if(count($result) > 0){
			
		       $select = "SELECT MAX(consecutivo) AS consecutivo FROM encabezado_de_registro WHERE periodo_contable_id = $periodo_contable_id 
			             AND tipo_documento_id = $tipo_documento_id";
						 
		       $result       = $this -> DbFetchAll($select,$Conex,true);
			   
			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo + 1;
			   }else{
			        $consecutivo = 1;
			     }
			   
			   return $consecutivo;
			
			  }else{
			  
				    $select = "SELECT consecutivo FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id AND empresa_id = (SELECT 
					          empresa_id FROM oficina WHERE oficina_id = $oficina_id)";
							  
 		            $result = $this -> DbFetchAll($select,$Conex,true);							  
			  
			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo;
			   }else{
			        $consecutivo = 1;
			     }
				 			  			  
					return $consecutivo;
				  
			    }  			  
			  			  
			
			}else{
						
			    $select = "SELECT consecutivo FROM encabezado_de_registro WHERE periodo_contable_id = $periodo_contable_id AND 
				oficina_id = $oficina_id AND tipo_documento_id = $tipo_documento_id";
				
			    $result = $this -> DbFetchAll($select,$Conex,true);
							  
			    if(count($result) > 0){
			
		          $select = "SELECT MAX(consecutivo) AS consecutivo FROM encabezado_de_registro WHERE periodo_contable_id = $periodo_contable_id 
			                 AND oficina_id = $oficina_id AND tipo_documento_id = $tipo_documento_id";
						 
		          $result       = $this -> DbFetchAll($select,$Conex,true);				  
				  				  
			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo + 1;
			   }else{
			        $consecutivo = 1;
			     }
				  
				  
				  return $consecutivo;
				  			
			    }else{
				
				    $select = "SELECT consecutivo FROM consecutivo_documento_oficina WHERE tipo_documento_id = $tipo_documento_id AND 
					          oficina_id = $oficina_id";
							  
 		            $result = $this -> DbFetchAll($select,$Conex,true);							  
			  
			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo;
			   }else{
			        $consecutivo = 1;
			     }
				 
					return $consecutivo;
				  
			      }  			  
			  			  
			
			  }			
		  
		  
		  }else{
		  

		  
            if($consecutivo_por == 'E'){
			
			  $select = "SELECT consecutivo FROM encabezado_de_registro WHERE tipo_documento_id = $tipo_documento_id";
			  $result = $this -> DbFetchAll($select,$Conex,true);
			  
			  if(count($result) > 0){
			
		       $select = "SELECT MAX(consecutivo) AS consecutivo FROM encabezado_de_registro WHERE tipo_documento_id = $tipo_documento_id";
						 
		       $result       = $this -> DbFetchAll($select,$Conex,true);

			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo + 1;
			   }else{
			        $consecutivo = 1;
			     }


			   return $consecutivo;
			
			  }else{
			  
				  $select = "SELECT consecutivo FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id AND empresa_id = (SELECT 
					          empresa_id FROM oficina WHERE oficina_id = $oficina_id)";
							  
 		          $result = $this -> DbFetchAll($select,$Conex,true);							  
			  
			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo;
			   }else{
			        $consecutivo = 1;
			     }


				  return $consecutivo;
				  
			    }  			  
			  			  
			
			}else{
						
			    $select = "SELECT consecutivo FROM encabezado_de_registro WHERE oficina_id = $oficina_id AND tipo_documento_id = $tipo_documento_id";
			    $result = $this -> DbFetchAll($select,$Conex,true);
			  
			    if(count($result) > 0){
			
		          $select = "SELECT MAX(consecutivo) AS consecutivo FROM encabezado_de_registro WHERE oficina_id = $oficina_id AND 
				             tipo_documento_id = $tipo_documento_id";
						 
		          $result       = $this -> DbFetchAll($select,$Conex,true);

			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo + 1;
			   }else{
			        $consecutivo = 1;
			     }

				  return $consecutivo;
			
			    }else{
			  
					$select = "SELECT consecutivo FROM consecutivo_documento_oficina WHERE tipo_documento_id = $tipo_documento_id AND 
					          oficina_id = $oficina_id";
							  
 		            $result = $this -> DbFetchAll($select,$Conex,true);							  
			  
			   $consecutivo  = $result[0]['consecutivo'];
			   
			   if($consecutivo > 0){
			     $consecutivo = $consecutivo;
			   }else{
			        $consecutivo = 1;
			     }


					return $consecutivo;
				  
			      }  			  
			  			  
			
			  }			
		  
		  
		    }		  		  
			
		  
	  }
	  
	  public function requiereTercero($puc_id,$Conex){
	  
		 $select = "SELECT requiere_tercero FROM puc WHERE puc_id = $puc_id";
		 $result = $this -> DbFetchAll($select,$Conex,true);	 
		 
		 $requiere_tercero = $result[0]['requiere_tercero'];
		 
		 if($requiere_tercero == 1){
		   return true;
		 }else{
			 return false;
		   }
	  
	  }
	  
	  public function getNumeroIdentificacionTercero($tercero_id,$Conex){
	  
		 $select = "SELECT numero_identificacion FROM tercero WHERE tercero_id = $tercero_id";
		 $result = $this -> DbFetchAll($select,$Conex,true);	 
		 
		 $numero_identificacion = $result[0]['numero_identificacion'];
		 
		 if(is_numeric($numero_identificacion)){
		   return $numero_identificacion;
		 }else{
			 return null;
		   }
	  
	  }	  
	  
	  public function getDigitoVerificacionTercero($tercero_id,$Conex){
	  
		 $select = "SELECT digito_verificacion FROM tercero WHERE tercero_id = $tercero_id";
		 $result = $this -> DbFetchAll($select,$Conex,true);	 
		 
		 $digito_verificacion = $result[0]['digito_verificacion'];
		 
		 if(is_numeric($digito_verificacion)){
		   return $digito_verificacion;
		 }else{
			 return null;
		   }
	  
	  }		  
	  
	  public function requiereCentroCosto($puc_id,$Conex){
	  
		 $select = "SELECT requiere_centro_costo FROM puc WHERE puc_id = $puc_id";
		 $result = $this -> DbFetchAll($select,$Conex,true);	 
		 
		 $requiere_centro_costo = $result[0]['requiere_centro_costo'];
		 
		 if($requiere_centro_costo == 1){
		   return true;
		 }else{
			 return false;
		   }  
	  
	  }     
	  
     public function getCentroCostoId($oficina_id,$Conex){
  
      $select = "SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id = $oficina_id";
      $result = $this -> DbFetchAll($select,$Conex);	 	 
	 
	  if(count($result) > 0){
	   return $result[0]['centro_de_costo_id'];
	  }else{
	       return null;
	    }
  
     }	  

     public function getCentroCostoCod($oficina_id,$Conex){
  
      $select = "SELECT codigo FROM centro_de_costo WHERE oficina_id = $oficina_id";
      $result = $this -> DbFetchAll($select,$Conex);	 	 
	 
	  if(count($result) > 0){
	   return $result[0]['codigo'];
	  }else{
	       return null;
	    }
  
     }	  

	   
		public function getPeriodosContables($Conex){
			
		 $select = "SELECT periodo_contable_id AS value,anio AS text FROM periodo_contable ORDER BY anio ASC";		 
		 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
		 
		 return $result;		
			
		}
		
		public function getTiposDocumento($Conex){
			
		 $select = "SELECT tipo_documento_id AS value,CONCAT(codigo,' - ',nombre) AS text FROM tipo_de_documento ORDER BY codigo ASC";		 
		 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
		 
		 return $result;		
			
		}
		
		public function getFormasPago($Conex){
			
			$select = "SELECT forma_pago_id AS value,nombre AS text FROM forma_pago ORDER BY nombre";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
			return $result;
			
		}
		
		public function getCausalesAnulacion($Conex){
			
			$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
			return $result;		
			
		}
		
   public function getDocumentos($Conex){
   
     $select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY text";
	 $result = $this -> DbFetchAll($select,$Conex); 
	 
	 return $result;
   
   }	
   
   public function getOficinas($empresa_id,$Conex){
   
     $select = "SELECT oficina_id AS value, nombre AS text FROM oficina WHERE empresa_id = $empresa_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
   
   public function getCentrosCosto($empresa_id,$Conex){
   
     $select = "SELECT centro_de_costo_id AS value, nombre AS text FROM centro_de_costo WHERE empresa_id = $empresa_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;	 
   
   }   	
			    
   public function getCentrosCostoTxt($centros_costo,$opciones_centros,$Conex){
   
     if($opciones_centros == 'T'){
	   return 'CONSOLIDADO';
	 }else{
   
       $select          = "SELECT nombre FROM centro_de_costo WHERE centro_de_costo_id IN ($centros_costo)";
       $centrosCosto    = $this -> DbFetchAll($select,$Conex,true);	 
	   $centroCostoText = null;
	 
	   for($i = 0; $i < count($centrosCosto); $i++){
	     $centroCostoText .= $centrosCosto[$i]['nombre'].' - ';	 
	   }
	 
	   $centroCostoText = substr($centroCostoText,0,strlen($centroCostoText) -3);
	 
	   return $centroCostoText;
	 
	 }
   
   }         	  
   
   public function getNivelesPuc($Conex){
   
     $select     = "SELECT DISTINCT nivel AS value,CONCAT('NIVEL ',nivel) AS text FROM puc ORDER BY nivel ASC";
     $nivelesPuc = $this -> DbFetchAll($select,$Conex,true);	 	 
	 
	 return $nivelesPuc;
   
   }
   
   
   private function setCuentasMovimiento($puc_puc_id,$Conex){
   	 
	 if(is_numeric($puc_puc_id)){
	 
	 $select         = "SELECT puc_id,movimiento FROM puc WHERE puc_puc_id = $puc_puc_id";
     $cuentasMenores = $this -> DbFetchAll($select,$Conex,true);	 	 	 
	 
	 if(count($cuentasMenores) > 0){
	 
	   for($i = 0; $i < count($cuentasMenores); $i++){
	   
	      $puc_puc_id = $cuentasMenores[$i]['puc_id'];
		  $movimiento = $cuentasMenores[$i]['movimiento'];
		  
		  if($movimiento == 1){
		    $this -> cuentasMovimiento .= "$puc_puc_id,";
		  }else{
              $this -> setCuentasMovimiento($puc_puc_id,$Conex);	     
		    }
	   
	   }
	   
	 
	 }else{
	 
	     $select     = "SELECT puc_id,movimiento FROM puc WHERE puc_id = $puc_puc_id";
         $dataCuenta = $this -> DbFetchAll($select,$Conex,true);		 
	 	 $movimiento = $dataCuenta[0]['movimiento'];
		  
		  if($movimiento == 1){
		    $this -> cuentasMovimiento .= "$puc_puc_id,";
		  }
	 
	   }
	   
	 }else{
	     return null;
	  } 	 
   
   } 
   
   
   public function getCuentasMovimiento($puc_puc_id,$Conex){   

	  $this -> cuentasMovimiento = null;
   
      $this -> setCuentasMovimiento($puc_puc_id,$Conex);
	  
	  $cuentasMovimiento = $this -> cuentasMovimiento;
	  
	  $this -> cuentasMovimiento = null;
	  
	  $cuentasMovimiento = substr($cuentasMovimiento,0,strlen($cuentasMovimiento) -1);
	  
	  return $cuentasMovimiento;
   
   }
   
  public function getTiposDocumentoContable($Conex){
	  
	$select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }  
  
  public function getCuentasMenores($puc_puc_id,$Conex){
  
     $select = "SELECT * FROM cuentas WHERE puc_puc_id = $puc_puc_id";
	 $result = $this  -> DbFetchAll($select,$Conex);
	
	 return $result;	 
	   
  }
  
    
  public function getCuentaMayor($puc_id,$nivel,$Conex){
  
    if(strlen(trim($puc_id)) > 0){
	
    $select = "SELECT puc_id,nivel FROM puc WHERE puc_id = (SELECT puc_puc_id FROM puc WHERE puc_id = $puc_id)";  
    $result = $this  -> DbFetchAll($select,$Conex);	
	
	$nivelMayor = $result[0]['nivel'];
	$puc_id     = $result[0]['puc_id'];
		
	if($nivelMayor == $nivel){
	   return $puc_id;
	}else{
	     return $this -> getCuentaMayor($puc_id,$nivel,$Conex);
	  }
  
    }else{
	    return null;
	 }
  
  }
  
  
  public function getCondicionSaldosAuxiliares($empresa_id){
  
    $condicion = "(CASE WHEN SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM  
	 encabezado_de_registro WHERE encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id =
	 $empresa_id)) FROM encabezado_de_registro ec WHERE tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento 
	 WHERE de_cierre = 1) AND empresa_id = $empresa_id) WHEN SUBSTRING(p.codigo_puc,1,1) IN (1,2,3) THEN (SELECT IF(MAX(ec.encabezado_registro_id) 
	 > 0, (SELECT fecha FROM encabezado_de_registro WHERE encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM 
	 encabezado_de_registro WHERE empresa_id = $empresa_id)) FROM encabezado_de_registro ec WHERE mes_contable_id IN (SELECT mes_contable_id FROM 
	 mes_contable WHERE mes_trece = 1) AND empresa_id = $empresa_id) ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE 
	 empresa_id = $empresa_id) END)";
	
	return $condicion;
  
  }  
  
  public function getCondicionSaldosBalanceGeneral($empresa_id){
  
    $condicion = "(CASE WHEN SUBSTRING(p.codigo_puc,1,1) IN (1,2,3) THEN (SELECT IF(MAX(ec.encabezado_registro_id) 
	 > 0, (SELECT fecha FROM encabezado_de_registro WHERE encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM 
	 encabezado_de_registro WHERE empresa_id = $empresa_id)) FROM encabezado_de_registro ec WHERE mes_contable_id IN (SELECT mes_contable_id FROM 
	 mes_contable WHERE mes_trece = 1) AND empresa_id = $empresa_id) ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = 
	 $empresa_id) END)";
	
	return $condicion;  
  
  }  
    
  public function getParametrosReportes($Conex){
  
    $select = "SELECT * FROM  parametro_reporte_contable";
    $result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;		
  
  }
  
  public function getNaturalezaTipoPago($forma_pago_id,$puc_id,$Conex){
  
    $select = "SELECT cuenta_tipo_pago_natu FROM cuenta_tipo_pago WHERE forma_pago_id = $forma_pago_id AND puc_id = $puc_id";
    $result = $this  -> DbFetchAll($select,$Conex);
	
	if(count($result) > 0){
	  return $result[0]['cuenta_tipo_pago_natu'];
	}else{
	    return null;
	  }
  
  }
  
  
  }

?>