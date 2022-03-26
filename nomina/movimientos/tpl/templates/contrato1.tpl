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
  		<legend> {$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        <fieldset class="section">
        <table align="center" width="80%">
        	<tr>
            	<td colspan="4">
                <fieldset class="section">
                	<legend>Datos Contrato</legend>
                
                	<table width="90%">
                      <tr>
                        <td width="20%"><label>Numero de Contrato : </label></td>
                        <td width="7">{$NUMERO_CONTRATO}{$CONTRATO_ID}</td>
                        <td width="20%"><label>Tipo de Contrato : </label></td>
                        <td w>{$TIPO_CONTRATO_ID}</td>
                      </tr>
                      <tr>
                        <td width="20%"><label>Fecha de Inicio : </label></td>
                        <td width="7">{$FECHA_INICIO}</td>
                        <td width="20%"><label>Fecha Terminacion : </label></td>
                        <td width="7">{$FECHA_TERMINACION}</td>
                      </tr>
                      <tr>
                        <td width="20%"><label>Empleado : </label></td>
                        <td width="7">{$EMPLEADO_ID}{$EMPLEADO}</td>
                        <td width="20%"><label>Cargo : </label></td>
                        <td width="7">{$CARGO_ID}{$CARGO}</td>
                      </tr>
                      <tr>
                        <td width="20%"><label>Sueldo Base : </label></td>
                        <td width="7">{$SUELDO_BASE}</td>
                        <td width="20%"><label>Subsidio de Transporte : </label></td>
                        <td width="7">{$SUBSIDIO_TRANSPORTE}</td>
                      </tr>
                      <tr>
                        <td width="20%"><label>Centro de Costo : </label></td>
                        <td width="7">{$CENTRO_DE_COSTO}</td>
                        <td width="20%"><label>Periocidad : </label></td>
                        <td width="7">{$PERIOCIDAD}</td>
                      </tr>
                      <tr>
                        <td><label>Hora Inicio: </label></td>
                        <td>{$HORINI}</td>
                        <td><label>Hora Fin: </label></td>
                        <td>{$HORFIN}</td>
                      </tr>
                      
                      <tr>
                        <td><label>Area: </label></td>
                        <td>{$AREA}</td>
                        <td><label>Estado: </label></td>
                        <td>{$ESTADO}</td>
                      </tr>
					</table>
                    </fieldset>
				</td>
		  </tr>                                                          
          <tr>
          	<td colspan="4">
                <fieldset class="section">
                	<legend>Prestaciones sociales y Certificado M&Eacute;dico</legend>
                    <table width="99%">
                      <tr>                     
                        <td ><label>EPS:</label></td>
                        <td >{$EMPEPS}{$EMPEPSID}</td>
                        <td ><label>Certificado: </label></td>
                        <td width="50%">{$ESCEPS}</td>
                      </tr>
                      <tr>  
                        <td ><label>Pensi&oacute;n: </label></td>
                        <td>{$EMPPEN}{$EMPPENID}</td>
                        <td ><label>Certificado: </label></td>
                        <td>{$ESCPEN}</td>
                      </tr>
                      <tr>
                        <td><label>ARL: </label></td>
                        <td>{$EMPARL}{$EMPARLID}</td>
                        <td ><label>Certificado: </label></td>
                        <td>{$ESCARL}</td>
					  </tr>                        
                      <tr>  
                        <td><label>Caja Compensaci&oacute;n: </label></td>
                        <td>{$EMPCAJ}{$EMPCAJID}</td>
                        <td ><label>Certificado: </label></td>
                        <td>{$ESCCAJA}</td>
                      </tr>

                      <tr>  
                        <td><label>Cesantias: </label></td>
                        <td>{$EMPCES}{$EMPCESID}</td>
                        <td ><label>Certificado: </label></td>
                        <td>{$ESCCESAN}</td>
                      </tr>
                      <tr>  
                        <td><label>Instituto M&eacute;dico: </label></td>
                        <td>{$INSTMED}</td>
                        <td ><label>Certificado: </label></td>
                        <td>{$ESCMED}</td>
                      </tr>

                      
                    </table>
                    
                </fieldset>
            </td>
          </tr>
		  <tr> 
          	<td colspan="4">
                <fieldset class="section">
                	<legend>Datos Terminaci&oacute;n Contrato</legend>
            
                    <table width="90%">
                      <tr>                     
                        <td width="20%"><label>Fecha Terminacion Real : </label></td>
                        <td width="7">{$FECHA_TERMINACION_REAL}</td>
                        <td width="20%"><label>Motivo de Terminacion : </label></td>
                        <td>{$MOTIVO_TERMINACION}</td>
                      </tr>
                      <tr>  
                        <td><label>Causal Despido : </label></td>
                        <td>{$CAUSAL_DESPIDO}</td>
                      </tr>
                    </table>
				</fieldset>                        
			</td>
		 </tr>                            
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$ANULAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
     
        {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
   </fieldset> 
  </body>
</html>
