<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
   <script src="../../../framework/js/moment.min.js"></script>
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
        <table width="85%" align="center">
          <tr>
            
             <td><label>Empleado  : </label></td>
            <td>{$SIEMPLEADO}</td>
            <td><label>Fecha  : </label></td>
            <td>{$FECHALIQ}</td>
            <td ><label>Liquidacion N°  : </label></td>
            <td >{$CONSECUTIVO}</td>
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
            <td ><label>Buscar Periodos  : </label></td>
            <td ><img src="../../../framework/media/images/grid/magb.png" id="Buscar" title="Buscar"/>{$CONCEPTO}{$CONCEPTOITEM}</td>
            <td><label>Fecha Inicio Contrato  : </label></td>
            <td>{$FECHAINICONT}</td>
          </tr>
         
          <tr>
           
            <td><label>Observacion  : </label></td>
            <td>{$OBSERVACION}</td>
            <td><label>Estado  : </label></td>
            <td>{$ESTADO}</td>
            
          </tr> 

      </table>
      <br>
      <table width="70%" align="center">
      <tr>
          <td><a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','El rango de fechas no debe ser superior a los dias a disfrutar mas el 20%')"/></a></td>
      </tr> 
          <tr>
            <td><label>Fecha inicio : </label></td>
            <td>{$FECHAINI}</td>
            <td><label>Fecha final : </label></td>
            <td>{$FECHAFIN}</td>
            <td><label>Fecha reintegro : </label></td>
            <td>{$FECHAREINTEGRO}</td>
        </tr>
      </table>
      
       <fieldset class="section">
           <legend>LIQUIDACION</legend>
           <table align="center" width="75%">
           <tr>
              <td><label>Salario Base  : </label></td>
              <td colspan="2">{$SALARIO}</td>
           </tr>
            <tr>
              <td><label>Dias a descontar : </label></td>
              <td>{$DIASDESCONTAR}</td>
          </tr>
            <tr>
              <td><label>Dias a disfrutar  : </label></td>
              <td>{$DIASDISFRUTAR}</td>
              <td><label>Valor : </label></td>
              <td>{$VALORLIQUIDACION}</td>
          </tr>
           <tr>
              <td id="dias_pagar"><label>Dias a pagar  : </label></td>
              <td>{$DIASPAGAR}</td>
              <td id="valor_pagar"><label>Valor : </label></td>
              <td>{$VALORLIQUIDACIONPAGAR}</td>
          </tr>
           <tr>
              <td colspan="2">&nbsp;</td>
              <td><label>Valor Total Liquidacion : </label></td>
              <td>{$VALORTOTAL}</td>
          </tr>        
          </table>
          </fieldset> 
      <table width="100%">
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
             <td colspan="8" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td></tr>
     
         <tr><td colspan="8"><iframe id="detalleVacacion" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
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
        
        <div id="rangoImp" style="display:none;">
      <div align="center">
	    <p align="center">
		  <table>
		    <tr>
			  <td><b>Tipo:&nbsp;</b></td><td>{$TIPOIMPRE}</td>
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
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>

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
