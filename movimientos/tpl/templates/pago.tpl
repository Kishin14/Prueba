<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
		<div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>    
        {$FORM1}
        <fieldset class="section">
        <table align="center" width="90%">
            <tr>
        	    <td width="15%"><label>Forma de Pago :</label></td>
            	<td align="left">{$PAGO}</td>
	            <td><label>Tipo de Documento : </label></td>
    	        <td>{$DOCID}</td>
            </tr>
            <tr>
                <td><label>Aplica a: </label></td>
                <td>{$EMPLEADOS}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
            <tr>
                <td><label>Empleado : </label></td>
                <td>{$EMPLEADO}{$EMPLEADOID}</td>
                <td><label>Nit / Identificaci&oacute;n : </label></td>
                <td>{$EMPLEADONIT}</td>
            </tr>
            <tr>
            	<td><label>Buscar Pendientes: </label>&nbsp;<img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar Facturas Pendientes Proveedor"/></td>
                <td>{$CONCEPTONOMI}{$CAUSACIONNOMI}{$VALORESCAUSACION}{$VALORESPAGO}</td>
                <td><label>Fecha de pago : </label></td>
                <td>{$FECHA}</td>
            </tr>
        
            <tr>
                <td><label>Valor Pago : </label></td>
                <td>{$VALORPAGO}</td>
                <td><label>No de Cheque (Si aplica):</label></td>
                <td>{$NUMCHEQUE}</td>
            </tr>
            <tr>
			  <td><label>Doc Contable No :</label></td>
			  <td >{$NUMSOPORTE}{$ABONOID}{$USUARIOID}{$FECHAINGRESO}{$OFICINAID}{$ENCABEZADOID}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>

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
            <iframe id="iframeSolicitud"></iframe>
        </div>
        
	</fieldset>
	<fieldset>{$GRIDPAGO}</fieldset>   
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
