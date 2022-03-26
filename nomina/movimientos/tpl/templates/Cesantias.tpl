<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  
  {$CSSSYSTEM}
 
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
            <td >{$TIPOLIQUIDACION}&nbsp;<a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','El auxilio de cesantías es una prestación social en favor de los trabajadores que periódicamente se debe liquidar,por tal motivo cuando selecionamos la opcion TOTAL PERIODO le estamos indicando al sistema que este trabajador no laborará mas, por tanto las cesantias deben ser consignadas directamente al empleado, por el contrario cuando se selecciona la opcion PARCIAL PERIODO le indicaremos al sistema que este contrato continuará vigente y por tanto se deben consignar las cesantias al fondo.')"/></a></td>
           
          </tr>
          
          <tr>
            <td><label>Empleado: </label></td>
            <td>{$EMPLEADO}{$EMPLEADOID}{$CONTRATOID}{$ENCABEZADOID}{$USUARIOID}{$FECHAREGISTRO}</td>
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
             <td colspan="8" align="center">{$GUARDAR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}&nbsp;{$IMPRIMIR}&nbsp;{$CONTABILIZAR}&nbsp;{*{$PREVISUAL}*}</td></tr>
     
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
    
    <fieldset> <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
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
    
  </body>
</html>
