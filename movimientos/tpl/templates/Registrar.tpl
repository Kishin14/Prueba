<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

    
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
   </head><body>
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
               <td><label>Busqueda Empleado: </label></td>
               <td>{$BUSQUEDA}</td>
             </tr>
             <tr>
               <td><label>Busqueda Fechas: </label></td>
               <td>{$BUSQUEDA1}</td>
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
                    <td><label>Liquidacion Novedad No. : </label></td>
                    <td>{$CONSECUTIVO}{$LIQUIDACIONID}{$USUARIO_ID}{$FECHAREG}</td>
                </tr>
          		<tr>
		            <td><label>Fecha Inicial : </label></td>
                    <td>{$FECHAINI}</td>
            		<td><label>Fecha Final : </label></td>
                    <td>{$FECHAFIN}</td>            		
          		</tr>
                
          		<tr>
            		<td><label>Aplica a: </label></td>
                    <td>{$EMPLEADOS}</td>
                    <td><label> Centro: </label></td>
                    <td>{$CENTRO_DE_COSTO}</td>
            	</tr>
                <tr>
            		
                    <td><label>Periodicidad: </label></td>
                    <td>{$PERIODICIDAD}</td>
                    <td><label> Area : </label></td>
                    <td>{$AREAS}</td>
            	</tr>
          		<tr>
                	<td><label>Empleado: </label></td>
                    <td>{$CONTRATO}{$CONTRATOID}</td>
            		<td><label>Estado: </label></td>
                    <td>{$ESTADO}</td>
                    
          		</tr>
          		<tr>
	        		<td>&nbsp;</td>
	        		<td>&nbsp;</td>
          		</tr>
	      		<tr>
	        		<td colspan="4" align="center">{$GUARDAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}&nbsp;{$CONTABILIZAR}&nbsp;{$PREVISUAL}</td>
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
        
      <div><iframe id="detalleRegistrarNovedad" class="editableGrid"></iframe></div>
      
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
	<div id="rangoImp" style="display:none;">
      <div align="center">
	    <p align="center">
		  <table>
		    <tr>
			  <td><b>Tipo:&nbsp;</b></td><td>{$TIPOIMPRE}</td>
             </tr>
             <tr>
               <td><b># Desprendibles:&nbsp;</b></td><td>{$DESPRENDIBLES}&nbsp;&nbsp;&nbsp;</td>
			 </tr>
			 <tr><td colspan="2">&nbsp;</td></tr>
			 <tr>
			   <td align="center" colspan="2">{$PRINTCANCEL}{$PRINTOUT}</td>
			 </tr>
		  </table>
		</p>
	  </div>
	</div>    
  
</body>
</html>