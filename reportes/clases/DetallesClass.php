<?php

require_once("../../../framework/clases/ControlerClass.php");
final class Detalles extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");
		
	$Layout                 = new DetallesLayout();
    $Model                  = new DetallesModel();	
    $tipo 					= $_REQUEST['tipo'];
	$tablas_id				= "'".$_REQUEST['tablas_id']."'";
	$tablas_id				= str_replace(",","','",$tablas_id);
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_usuario				= $_REQUEST['si_usuario'];
	$usuario_id				= $_REQUEST['usuario_id'];	
	$all_tablas				= $_REQUEST['all_tablas'];
	$palabra				= $_REQUEST['palabra'];
	$download				= $_REQUEST['download'];
	
	if($palabra!='' && $palabra!='NULL') $palabra_consul=" AND query LIKE '%".$palabra."%'"; else  $palabra_consul='';
	
    $Layout -> setIncludes();
	if($tipo=='ALL' && $si_usuario==1){
    	$Layout -> setReporteFP1($Model -> getReporteFP1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex()));
		$data= $Model -> getReporteFP1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex());
		
	}elseif($tipo=='IN' && $si_usuario==1){
		$Layout -> setReporteEC1($Model -> getReporteEC1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReporteEC1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex());
		
	}elseif($tipo=='AC' && $si_usuario==1){
		$Layout -> setReportePE1($Model -> getReportePE1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReportePE1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex());
		
	}elseif($tipo=='DL' && $si_usuario==1){
		$Layout -> setReporteDL1($Model -> getReportePE1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReportePE1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$this -> getConex());

	}elseif($tipo=='ALL' && $si_usuario=='ALL'){
    	$Layout -> setReporteFP_ALL($Model -> getReporteFP_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReporteFP_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex());
		
	}elseif($tipo=='IN' && $si_usuario=='ALL'){
		$Layout -> setReporteEC_ALL($Model -> getReporteEC_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReporteEC_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex());
		
	}elseif($tipo=='AC' && $si_usuario=='ALL'){
		$Layout -> setReportePE_ALL($Model -> getReportePE_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReportePE_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex());
		
	}elseif($tipo=='DL' && $si_usuario=='ALL'){
		$Layout -> setReporteDL_ALL($Model -> getReportePE_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex()));
		$data = $Model -> getReportePE_ALL($tablas_id,$desde,$hasta,$palabra_consul,$this -> getConex());

	}
	if($download=='true'){
		$ruta  = $this -> arrayToExcel("Log","Log",$data,null,"string");
		$this -> ForceDownload($ruta);
	}else{
		$Layout -> RenderMain();
	}
    
  }
}

$Detalles = new Detalles();

?>