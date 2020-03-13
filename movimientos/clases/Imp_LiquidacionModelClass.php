<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_LiquidacionModel extends Db{ 
  
  public function getLiquidacion($select_deb_total,$select_cre_total,$select_deb,$select_cre,$select_debExt,$select_creExt,$select_sal,$diasIncapacidad,$oficina_id,$empresa_id,$Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT ln.*, dl.*,

				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',UPPER('oficina : '),nombre) FROM oficina WHERE oficina_id = $oficina_id) AS oficina,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				 $select_deb $select_debExt $select_cre $select_creExt $select_sal $select_deb_total $select_cre_total

				 (SELECT IFNULL(h.vr_horas_diurnas , 0) + IFNULL(h.vr_horas_nocturnas, 0) + IFNULL(h.vr_horas_diurnas_fes , 0) + IFNULL(h. vr_horas_nocturnas_fes , 0) + IFNULL(h.vr_horas_recargo_noc , 0) + IFNULL(h.vr_horas_recargo_doc, 0)
            	FROM hora_extra h WHERE h.estado='L' AND h.contrato_id=ln.contrato_id)AS horas_extras,

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
				FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base 				

				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )  AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND ln.estado!='A' GROUP BY ln.contrato_id ORDER BY empleado";
				
		  $result = $this -> DbFetchAll($select,$Conex,true); 
		
		  for ($i=0; $i < count($result); $i++) { 
		
			if(array_search($result[$i]['contrato_id'],array_column($diasIncapacidad,'contrato_id')) !== false){//SE VALIDA SI ESE CONTRATO ESTA O NO ESTA EN EL ARRAY DE DIAS NO REMUNERADOS
	
				for ($j=0; $j < count($diasIncapacidad); $j++) { 
	
					if($diasIncapacidad[$j]['contrato_id']==$result[$i]['contrato_id']){//SE VALIDA SI ESE CONTRATO ES IGUAL AL CONTRATO EN EL ARRAY DE DIAS NO REMUNERADOS PARA ANEXARLO
	
						$result[$i]['dias_incapacidad'] = $diasIncapacidad[$j]['dias'];
	
					}
					
				}
	
			}else{
				$result[$i]['dias_incapacidad'] = '';//EN CASO CONTRARIO NO ANEXE EL DIA
			}
	
		}

		  
	  
	}else{
   	    $result = array();
	}
	
	return $result;
  }
  public function getDiasIncapacidad($liquidacion_novedad_id,$Conex){
	$select = "SELECT 
	
		l.fecha_inicial, 
		l.fecha_final,
		ln.contrato_id
		
		FROM 
		
		licencia l,
		liquidacion_novedad ln
		
		WHERE 

		l.remunerado=1 AND 
		l.estado='A' AND   
		l.contrato_id=ln.contrato_id AND 
		(ln.fecha_inicial BETWEEN  l.fecha_inicial AND l.fecha_final OR ln.fecha_final  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN ln.fecha_inicial AND ln.fecha_final) AND
		ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)";
		
	$result = $this -> DbFetchAll($select,$Conex,true);

	return $result;
  }

  public function getConceptoDebito($Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT dl.concepto
				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND dl.debito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A' AND dl.concepto_area_id IS NULL
				GROUP BY dl.concepto ORDER BY dl.detalle_liquidacion_novedad_id ASC ";
				
		  $result = $this -> DbFetchAll($select,$Conex,true);
		  //exit(print_r($result));
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getConceptoCredito($Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT dl.concepto
				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND dl.credito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A'  AND dl.concepto_area_id IS NULL
				GROUP BY dl.concepto ORDER BY dl.detalle_liquidacion_novedad_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


  public function getConceptoDebitoExt($Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT dl.concepto_area_id, (SELECT descripcion FROM concepto_area WHERE concepto_area_id=dl.concepto_area_id) AS concepto
				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND dl.debito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A' AND dl.concepto_area_id IS NOT NULL
				GROUP BY dl.concepto_area_id ORDER BY dl.detalle_liquidacion_novedad_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getConceptoCreditoExt($Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT dl.concepto_area_id, (SELECT descripcion FROM concepto_area WHERE concepto_area_id=dl.concepto_area_id) AS concepto
				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND dl.credito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A'  AND dl.concepto_area_id IS NOT NULL
				GROUP BY dl.concepto_area_id ORDER BY dl.detalle_liquidacion_novedad_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


  public function getConceptoSaldo($Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT dl.concepto
				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND (dl.credito+dl.debito)>0  AND dl.sueldo_pagar=1 AND ln.estado!='A' 
				GROUP BY dl.concepto ORDER BY dl.detalle_liquidacion_novedad_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  //desprendible de pago
  public function getLiquidacion1($desprendibles,$empresa_id,$Conex){
 
    $liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT ln.*,
				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base 				

				FROM liquidacion_novedad ln
				WHERE ln.contrato_id =(SELECT contrato_id FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND ln.fecha_final <= (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.estado!='A' AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				 ORDER BY empleado ASC, ln.fecha_final DESC LIMIT 0, $desprendibles";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getDetalles($liquidacion_novedad_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT  dl.*
				FROM  detalle_liquidacion_novedad dl
				WHERE dl.liquidacion_novedad_id = $liquidacion_novedad_id ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	
	return $result;
  }
  
  public function getTotales($select_tot_deb,$select_tot_cre,$select_tot_debExt,$select_tot_creExt,$select_tot_sal,$empresa_id,$Conex){
 
	$liquidacion_novedad_id = $this -> requestDataForQuery('liquidacion_novedad_id','integer');
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT 			

				 $select_tot_deb $select_tot_debExt $select_tot_cre $select_tot_creExt $select_tot_sal 
				 
				 (SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo
							

				FROM liquidacion_novedad ln, detalle_liquidacion_novedad dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )  AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND ln.estado!='A'";

				
	  	$result = $this -> DbFetchAll($select,$Conex,true); 
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


  public function getLiquidacion2($liquidacion_novedad_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT ln.*,
				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base 				

				FROM liquidacion_novedad ln
				WHERE ln.fecha_inicial =(SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id )
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id ) AND ln.estado!='A'  AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id)
				 ORDER BY ln.liquidacion_novedad_id DESC ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getLiquidacion3($liquidacion_novedad_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_novedad_id)){

  	     $select = "SELECT ln.*		FROM liquidacion_novedad ln
				WHERE ln.liquidacion_novedad_id=$liquidacion_novedad_id AND ln.estado!='A' AND ln.area_laboral=(SELECT area_laboral FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND ln.periodicidad=(SELECT periodicidad FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


   
}


?>