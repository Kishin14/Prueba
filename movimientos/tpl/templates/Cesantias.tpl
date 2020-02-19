<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
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
        {$NOVEDADID}
        <fieldset class="section">
        <table align="center">
          <tr>
            
             <td><label>Empleados?: </label></td>
            <td>{$SIEMPLEADO}</td>
            <td><label>Fecha Liquidaci&oacute;n: </label></td>
            <td>{$FECHALIQ}</td>
          	 <td ><label>Liquidaci&oacute;n N°: </label></td>
            <td >{$CONSECUTIVO}</td>
          </tr>
          
          <tr>
            <td><label>Beneficiario: </label></td>
            <td>{$BENEFICIARIO}</td>
            <td><label>Estado: </label></td>
            <td>{$ESTADO}</td>
             <td ><label>Tipo Liquidaci&oacute;n:</label></td>
            <td >{$TIPOLIQUIDACION}</td>
           
          </tr>
          
          <tr>
            <td><label>Empleado: </label></td>
            <td>{$EMPLEADO}{$EMPLEADOID}{$CONTRATOID}</td>
            <td><label>Num Identificaci&oacute;n: </label></td>
            <td>{$IDENTIFICACION}</td>
            <td><label>Cargo: </label></td>
            <td>{$CARGO}</td>
          </tr>
          
          
          <tr>
           
            <td><label>Observaci&oacute;n: </label></td>
            <td>{$OBSERVACION}</td>
            <td><label>Fecha Inicio Contrato: </label></td>
            <td>{$FECHAINICONT}</td>
           
            
            
            
          </tr> 
          <tr>
            <td align="center" colspan="6">&nbsp;</td>
            
          </tr>
          <tr>  
           <td colspan="6">
           	<fieldset class="section">
            <legend>LIQUIDACION</legend>
            	<table align="center">
                	<tr>
                    	<td><label>Base Liquidaci&oacute;n: </label></td>
            			<td>{$SALARIO}</td>
                    </tr>
                    <tr>
                      	<td><label>Ultimo Corte:</label></td>
            			<td id="fec_ultcorte">{$FECHAULTIMOCORTE}{$FECHAULTIMOCORTE1}</td>
                        <td><label>Fecha Corte: </label></td>
            			<td>{$FECHACORTE}</td>
						<td><label>Dias totales: </label></td>
                        <td>{$DIASPERIODO}</td>
                     </tr>
                     <tr>
                        <td><label>Dias no remunerados: </label></td>
                        <td>{$DIASNOREMU}</td>
                        <td><label>Dias a liquidar: </label></td>
                        <td>{$DIASLIQUIDADOS}</td>
			            <td><label>Valor Liquidaci&oacute;n: </label></td>
            			<td>{$VALORLIQUIDACION}</td>
            		</tr>
           		</table>
                </fieldset>
           
           
           </td>
          </tr>
          
          <tr>  
           <td colspan="6">
           	<fieldset class="section">
            <legend>CONTABILIZACION</legend>
            	<table align="center">
                	<tr>
                        <td><label>Vlr Liquidaci&oacute;n</label></td>
                    	<td><label>Vlr Acumulado</label></td>
                        <td><label>Diferencia</label></td>
                    </tr>
                    <tr>
                        <td>{$VALORLIQUIDACION1}</td>
                    	<td>{$VALORCONSOLIDADO}</td>
                        <td>{$DIFERENCIA}</td>
                    </tr>
           		</table>
                </fieldset>
           
           
           </td>
          </tr>
        
           <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
      </table>
      <table width="100%">
          <tr>
             <td colspan="8" align="center">{$GUARDAR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}&nbsp;{*{$PREVISUAL}*}</td></tr>
     
         <tr><td colspan="8"><iframe id="detalleCesantias" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
         <tr>

           

            <td align="center"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>

            <td align="right" width="60%">

            <table>

              <tr>

                <td><label>DEBITO :</label></td>

                <td><span id="totalDebito">0</span></td>

                <td><label>CREDITO:</label></td>

                <td><span id="totalCredito">0</span></td>

                <td><label>DIFERENCIA:</label></td>

                <td><span id="totalDiferencia">0</span></td>                

              </tr>

            </table></td>

          </tr>

     </table>
        {$FORM1END}
        <div id="divSolicitudFacturas">
            <iframe id="iframeSolicitud" height="300px"></iframe>
        </div>
</fieldset>
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    
  </body>
</html>
