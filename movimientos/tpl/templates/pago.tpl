<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
   {$JAVASCRIPT}
   
   {$CSSSYSTEM} 
  
  
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
		<div id="table_find">
        <table align="center">
         <tr>
            <td><label>Busqueda : </label></td>
         </tr>
         <tr>
            <td>{$BUSQUEDA}</td>
         </tr>
        </table>
        </div>    

        {$FORM1}
        <fieldset class="section">
        <table align="center" width="100%">
            <table width="90%" align="center">
            <tr>
        	    <td><label>Forma de Pago :</label></td>
            	<td align="left">{$PAGO}</td>
	            <td colspan="2"><label>Tipo de Documento : </label></td>
    	        <td colspan="2">{$DOCID}</td>
            </tr>
            <tr>
                <td><label>Aplica a: </label></td>
                <td>{$EMPLEADOS}</td>
                <td><a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','El rango de fechas (DESDE --- HASTA) se utiliza para que al momento de dar clik en el icono de buscar pendientes, nos filtre solamente las liquidaciones que coincidan con los rangos de fecha estipulados, teniendo en cuenta de que estos campos no son obligatorios.')"/></a>&nbsp;<label>Desde: </label></td>
                <td>{$DESDE}</td>
                <td><label>Hasta: </label></td>
                <td>{$HASTA}</td>
            </tr>
            
            <tr>
                <td><label>Empleado : </label></td>
                <td>{$EMPLEADO}{$EMPLEADOID}</td>
                <td><label>Nit / Identificaci&oacute;n : </label></td>
                <td>{$EMPLEADONIT}</td>
            </tr>
            <tr>
            	<td><label>Buscar Pendientes: </label>&nbsp;<img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar Facturas Pendientes Proveedor"/></td>
                <td>{$CONCEPTONOMI}{$CAUSACIONNOMI}{$CAUSACIONPRIMA}{$CAUSACIONCESANTIAS}{$CAUSACIONINTCESANTIAS}{$CAUSACIONLIQ}{$CAUSACIONVACACIONES}{$VALORESCAUSACION}{$VALORESPAGO}{$VALORESPAGOPRIMAS}{$VALORESPAGOCESANTIAS}{$VALORESPAGOINTCESANTIAS}{$VALORESPAGOVACACIONES}{$VALORESPAGOLIQ}</td>
                <td><label>Fecha de pago : </label></td>
                <td>{$FECHA}</td>
            </tr>
            </table>
            <table width="55%" align="center">
        
            <tr>
                <td><label>Valor Pago Nomina : </label></td>
                <td>{$VALORPAGO}</td>
                <td><label>No de Cheque (Si aplica):</label></td>
                <td>{$NUMCHEQUE}</td>
            </tr>
            
            <tr>
                <td><label>Valor Pago Prima : </label></td>
                <td>{$VALORPAGOPRIMA}</td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td><label>Valor Pago Cesantias : </label></td>
                <td>{$VALORPAGOCESANTIAS}</td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td><label>Valor Pago Vacaciones : </label></td>
                <td>{$VALORPAGOVACACIONES}</td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                 <td><label>Valor Pago Intereses Cesantias : </label></td>
                <td>{$VALORPAGOINTCESANTIAS}{$VALORPAGOTOTAL}</td>
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
                 <td><label>Valor Pago Liquidacion Final : </label></td>
                <td>{$VALORPAGOLIQ}</td>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <tr>
              <td><label>Doc Contable No :</label></td>
              <td >{$NUMSOPORTE}{$ABONOID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$ENCABEZADOID}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
        </table>
            

            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
                            <td width="15%" align="right" >
                                <img src="../../../framework/media/images/grid/save.png" id="saveDetallepuc" title="Guardar Seleccionados"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
		<table width="100%">
			<tr><td colspan="7"><iframe id="detalles" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
          	<tr>
                <td align="left" width="20%">{$CONTABILIZAR}</td>
                <td align="center" width="30%"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>
                <td align="right"  width="10%"></td>
                <td width="10%"><label>DEBITO :</label></td>
                <td width="10%"><span id="totalDebito">0</span></td>
                <td width="10%"><label>CREDITO:</label></td>
                <td width="10%"><span id="totalCredito">0</span></td>
                
            </tr>    
		</table>   
        </fieldset>     
		{$FORM1END}
        
        <div id="divSolicitudFacturas">
           <iframe id="iframeSolicitud"  style="height:100%"></iframe> 
             <!-- <iframe id="iframePendientes" style="height:100%"></iframe>-->
        </div>

        <!--INICIO Cuadro de informacion-->
    <div id="MyModal" class="modal">
    
        <!-- Modal content -->
        <div class="modal-content" style="width:70%;">
            <span class="close">&times;</span>
            <h3 id="h5" align="center"> </h3>
            <h4 align="center"><img src="../../../framework/media/images/alerts/info.png" /></h4>
            <p id="p" align="center"></p>
        </div>
    
    </div>
    <!--FIN Cuadro de informacion-->
    
        
	</fieldset>
	<fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>   
    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}{$ANULUSUARIOID}{$OFICINAANUL}</td>
          </tr>          
          <tr>
            <td><label>Causal :</label></td>
            <td>{$CAUSALESID}</td>
          </tr>
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$OBSERVACIONES}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>

    
</body>
</html>
