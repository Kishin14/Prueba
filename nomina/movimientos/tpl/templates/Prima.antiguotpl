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

        <div id="table_find"><table>
        <tr><td><label>Busqueda liquidacion : </label></td><td>{$BUSQUEDA}</td></tr>
        <tr><td><label>Busqueda por fechas  : </label></td><td>{$BUSQUEDA1}</td></tr>
        </table></div>
        
        {$FORM1}
        {$NOVEDADID}
        <fieldset class="section">
        <table align="center">
          <tr>
            
             <td><label>Empleados ?  : </label></td>
            <td>{$SIEMPLEADO}</td>
            <td><label>Fecha  : </label></td>
            <td>{$FECHALIQ}</td>
          	 <td ><label>Liquidacion N°  : </label></td>
            <td >{$CONSECUTIVO}{$LIQUIDACIONPRIMAID}</td>
          </tr>
          <tr>
            <td><label>Empleado  : </label></td>
            <td>{$EMPLEADO}{$EMPLEADOID}</td>
            <td><label>Num Identificacion  : </label></td>
            <td>{$IDENTIFICACION}</td>
            <td><label>Cargo  : </label></td>
            <td>{$CARGO}</td>
          </tr>
          
          <tr>
            <td colspan="2">&nbsp;</td>
            <td><label>Salario Base  : </label></td>
            <td>{$SALARIO}</td>
            <td><label>Fecha Inicio Contrato  : </label></td>
            <td>{$FECHAINICONT}</td>
          </tr>
          <tr>
            <td ><label>Tipo Liquidacion :</label></td>
            <td >{$TIPOLIQUIDACION}</td>
           
           	<td><label>Valor Liquidacion : </label></td>
            <td>{$VALORLIQUIDACION}</td>
            <td><label>Estado  : </label></td>
            <td>{$ESTADO}</td>
            
          </tr>
         <!-- <tr>
            <td><label>Fecha inicio : </label></td>
            <td>{$FECHAINI}</td>
            <td><label>Fecha final : </label></td>
            <td>{$FECHAFIN}</td>
            <td><label>Fecha reintegro : </label></td>
            <td>{$FECHAREINTEGRO}</td>
          </tr>-->
          <tr>
           
            <td><label>Observacion  : </label></td>
            <td>{$OBSERVACION}</td>
            
            <td><label>Periodo  : </label></td>
            <td>{$PERIODO}</td>
            
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
             <td colspan="8" align="center">{$GUARDAR}&nbsp;{$IMPRIMIR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td></tr>
     
         <tr><td colspan="8"><iframe id="detallePrima" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
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
</fieldset>
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    
  </body>
</html>
