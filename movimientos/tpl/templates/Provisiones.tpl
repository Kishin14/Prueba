<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8"></head><body>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}     
    {$TITLETAB}

    <fieldset>
      <legend>{$TITLEFORM}</legend>
      <div id="table_find">
        <table>
            <tbody>
             <tr>
               <td><label>Busqueda: </label></td>
               <td>{$BUSQUEDA}</td>
             </tr>
             
            </tbody>
        </table>
   	  </div>

        {$OFICINAHIDDEN}
        {$OFICINAIDHIDDEN}
        {$FECHASTATIC}
		{$FORM1}
        <fieldset class="section">
		<table align="center" width="70%">
        	<tbody>
                <tr>
                    <td><label>Liquidacion Provisi&oacute;n No. : </label></td>
                    <td>{$CONSECUTIVO}{$LIQUIDACIONID}{$USUARIO_ID}{$FECHAREG}{$ENCABEZADOID}</td>
                </tr>
          		<tr>
		            <td><label>Fecha Inicial : </label></td>
                    <td>{$FECHAINI}</td>
            		<td><label>Fecha Final : </label></td>
                    <td>{$FECHAFIN}</td>            		
          		</tr>
                
          		<tr>
            		<td><label>Estado : </label></td>
                    <td>{$ESTADO}</td>
          		</tr>
          		<tr>
	        		<td>&nbsp;</td>
	        		<td>&nbsp;</td>
          		</tr>
	      		<tr>
	        		<td colspan="4" align="center">{$GUARDAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}&nbsp;{$CONTABILIZAR}</td>
          		</tr>
      		</tbody>
		</table>
      	</fieldset>
      	<table id="toolbar">
        	<tbody>
            	<tr>
            		<td id="messages"><div>&nbsp;</div></td>
            		<td id="detailToolbar">
	      				<img src="../../../framework/media/images/grid/save.png" id="saveDetallesSoliServi" title="Guardar Seleccionados">
            		</td>
          		</tr>               
      		</tbody>
      	</table>
        
      <div><iframe id="detalleProvisionesNovedad" class="editableGrid"></iframe></div>
      
      {$FORM1END}
    </fieldset>

    <fieldset>{$GRIDLIQ_NOVEDAD}</fieldset>
    <div id="divAnulacion" style="display:none;">
      <form onSubmit="return false">
        <table>              
          <tr>
            <td><label>Causal :</label></td>
            <td>{$CAUSALANUL}</td>
          </tr>
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$OBS_ANULACION}{$USUARIOANUL_ID}{$FECHAANUL}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>	
  
</body>
</html>