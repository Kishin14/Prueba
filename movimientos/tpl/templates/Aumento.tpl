<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <!--<link rel="stylesheet" href="../../../framework/css/bootstrap.css">-->
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>
<body>
    <fieldset>
    <legend>{$TITLEFORM}</legend>
    {$FORM1}
    <fieldset class="section">
        <table width="100%">
            <tr>
            	<!--<td valign="top" width="18%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            	<td valign="top" width="18%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
                <td width="10%">&nbsp;</td>
                <td valign="top" width="30%" colspan="2"><label>Contrato : &nbsp;&nbsp;</label>{$CONTRATO}{$CONTRATOID}</td>
                <td valign="top" colspan="3" width="20%"><label>Desde:&nbsp;&nbsp;</label> {$DESDE}</td>
                <td valign="top" colspan="4" width="40%"><label>Hasta:&nbsp;&nbsp;</label> {$HASTA}</td>      
            </tr>
        </table>
    </fieldset>
	{$SOLICITUDID}
    <fieldset class="section">
        <div align="center">{$GENERAR}&nbsp;{$GENERAREXCEL}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</div>
        <div>&nbsp;</div>
        <iframe src="" id="frameDepreciados" name="frameDepreciados" height="700px"></iframe>
    </fieldset>
    </fieldset>
    {$FORM1END}
     <div id="Renovarmarco" style="display:none">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
	      <fieldset class="section">
		  <table id="tableGuia" width="100%">
          	<th colspan="5">Información Contrato</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Contrato No :</label></td>
                <td>{$CLIENTERENUEVA}{$CONSECUTIVORENUEVA}{$CANONVIEJO}</td>
                <td colspan="2"><label>Fecha Contrato :</label></td>
                <td>{$FECHAINICIO2}</td>
            </tr>
            <tr>
                <td><label>Empleado :</label></td>
                <td colspan="4">{$NUMESES}</td>
            </tr>
            <tr>
            	<td><label>Sueldo Base :</label></td>
                <td>${$CANONRENUEVA}</td>
                <td colspan="2"><label>Subsidio Transporte :</label></td>
                <td>${$ADMINISTRACION}</td>
            </tr>
            <tr>
                <td><label>Fecha Terminacion :</label></td>
                <td colspan="4">{$FECHAFINAL2}</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td colspan="4">{$PROPIETARIORENUEVA}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <th colspan="5">Información Renovar</th>
            <tr><td>&nbsp;</td></tr>
            <!--<tr>
             	<td><label>Canon :</label></td>
                <td colspan="2">{$CANONRENUEVA}</td>
                <td><label>Administración :</label></td>
                <td>{$ADMINISTRACION}</td>
            </tr>-->
            <tr>
                <td><label>Fecha Inicio :</label></td>
                <td colspan="2">{$FECHAINIRENOVACION}</td>
                <td><label>Fecha Final :</label></td>
                <td>{$FECHAFINRENOVACION}</td>              
            </tr>    
            <tr>
           		<!--<td><label>No. Meses de Contrato :</label> </td>  
                <td colspan="2">{$NUMESES}</td> -->
                <td><label>Observación Renueva :</label></td>
                <td colspan="2">{$OBSERVACIONRENUEVA}</td>
            </tr>       
			 <tr> <td>&nbsp;</td> </tr>
			 <tr> <td colspan="5" align="center">{$RENOVAR}</td>
            </tr>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div><!--Fin del div renovar marco-->
    
     <div id="Finalizarmarco" style="display:none">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
	      <fieldset class="section">
		  <table id="tableGuia" width="100%">
          	<th colspan="5">Información Contrato</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Contrato No :</label></td>
                <td>{$CONSECUTIVO2}</td>
                <td colspan="2"><label>Fecha Contrato :</label></td>
                <td>{$FECHACONTRATO}</td>
            </tr>
            <tr>
                <td><label>Inmobiliaria :</label></td>
                <td colspan="4">{$CLIENTEFINALIZA}</td>
            </tr>
            <tr>
                <td><label>Propietario :</label></td>
                <td colspan="4">{$PROPIETARIO}</td>
            </tr>
            <tr>
                <td><label>Arrendatario :</label></td>
                <td colspan="4">{$ARRENDATARIO}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <th colspan="5">Información Renovar</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
            	<td>&nbsp;</td>
                    <td><label>Fecha Retiro :</label></td>
                    <td colspan="3">{$FECHARETIRO}</td>
            </tr>
          	<tr>
            	<td>&nbsp;</td>
                    <td><label>Fecha Entrega :</label></td>
                    <td colspan="3">{$FECHAENTREGA}</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><label>Observación Retiro :</label></td>
                <td colspan="3">{$OBSERVACION}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>  
			 <tr> <td align="center" colspan="5">{$FINALIZAR}</td></tr>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div><!--Fin del div finalizar marco-->
    
    <div id="Actualizarmarco" style="display:none">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
	      <fieldset class="section">
		  <table id="tableGuia" width="100%">
          	<th colspan="5">Información Contrato</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Contrato No :</label></td>
                <td>{$CONSECUTIVOACTUALIZA}</td>
                <td colspan="2"><label>Fecha Contrato :</label></td>
                <td>{$FECHASOLICACTUALIZA}</td>
            </tr>
            <tr>
            	<td><label>Fecha Inicio :</label></td>
                <td>{$FECHAINI2ACTUALIZA}</td>
                <td colspan="2"><label>Fecha Final :</label></td>
                <td>{$FECHAFIN2ACTUALIZA}</td>
            </tr>
            <tr>
                <td><label>Inmobiliaria :</label></td>
                <td colspan="4">{$CLIENTEACTUALIZA}</td>
            </tr>
            <tr>
                <td><label>Propietario :</label></td>
                <td colspan="4">{$PROPIETARIOACTUALIZA}</td>
            </tr>
            <tr>
                <td><label>Arrendatario :</label></td>
                <td colspan="4">{$ARRENDATARIOACTUALIZA}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <th colspan="5">Información para Actualizar</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
             	<td><label>Canon :</label></td>
                <td colspan="2">{$CANONACTUALIZA}{$CANONANTIGUOACTUALIZA}</td>
                <td><label>Administración :</label></td>
                <td>{$ADMINISTRACIONACTUALIZA}</td>
            </tr>
            <tr>
                <td><label>Fecha Inicio :</label></td>
                <td colspan="2">{$FECHAINICIOACTUALIZA}</td>
                <td><label>Fecha Final :</label></td>
                <td>{$FECHAFINALACTUALIZA}{$FECHARENOVACION}</td>
            </tr>    
            <tr>
            	<td><label>No. Meses de Contrato :</label> </td>  
                <td colspan="2">{$NUMESESACTUALIZA}</td>
                <td><label>Observación Actualiza :</label></td>
                <td>{$OBSERVACIONACTUALIZA}</td>
            </tr>       
			 <tr> <td>&nbsp;</td> </tr>
			 <tr> <td colspan="5" align="center">{$ACTUALIZAR}</td>
            </tr>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div><!--Fin del div actualizar marco-->
</body>
</html>