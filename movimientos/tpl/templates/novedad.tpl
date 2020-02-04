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
        <div id="table_find">
            <table>
                <tr>
                    <td><label>Busqueda X colaborador: </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
                <tr>
                    <td><label>Busqueda X novedad: </label></td>
                    <td>{$BUSQUEDANOVEDAD}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table width="90%" align="center">
            <tr>
                <td colspan="2">
                <fieldset class="section">
                <legend>Informaci&oacute;n Base</legend>                    
                    <table width="90%" align="center">
                        <tr>
                            <td><label>Novedad No. </label></td>
                            <td>{$NOVEDADID}</td>
                            <td><label>Fecha Novedad : </label></td>
                            <td>{$FECHANOV}</td>                
                        </tr>
                        <tr>
                            <td><label>Empleados? : </label></td>
                            <td>{$SI_CON}</td>
                            <td><label>Empleado : </label></td>
                            <td>{$CONTRATO}{$CONTRATOID}</td>
                        </tr>
                        <tr>
                            <td><label>Tipo Novedad : </label></td>
                            <td>{$CONCEPTOAREA}</td>
                            <td><label>Naturaleza : </label></td>
                            <td>{$TIPO_NOVEDAD}</td>
                        </tr>            
                        <tr>
                            <td><label>Concepto : </label></td>
                            <td >{$CONCEPTO}</td>
                            <td><label>Beneficiario : </label></td>
                            <td>{$TERCERO}{$TERCEROID}</td>                    
                        </tr>
                        <tr>
                            <td><label>Fecha Inicial : </label></td>
                            <td>{$FECHAINI}</td>
                            <td><label>Fecha Final : </label></td>
                            <td>{$FECHAFIN}</td>                            
                        </tr>
                        <tr>
                            <td><label>Periodicidad : </label></td>
                            <td>{$PERIODICIDAD}</td>                
                            <td><label>Estado : </label></td>
                            <td>{$ESTADO}</td>              
                    	</tr>
            		</table>
        		</fieldset>
        		</td>
        	</tr>                                                                           
        	<tr>
            	<td valign="top">
                <fieldset class="section">
                <legend>VALORES</legend>
                    <table width="100%">
                        <tr>
                            <td width="36%"><label>Valor Total : </label></td>
                            <td width="64%">{$VALOR}</td>                                                        
                        </tr>
                        <tr>
                            <td><label>No. Cuotas : </label></td>
                            <td>{$CUOTAS}</td>
                        </tr>
                        <tr>
                            <td><label>Valor Cuota : </label></td>
                            <td>{$VALORCUOTA}</td>
                        </tr>
                    </table>
                </fieldset>
        		</td>
        		<td  valign="top">
                <fieldset class="section">
                <legend>ANEXO</legend>
                    <table width="100%">
                        <tr>
                            <td><label>Documento Soporte : </label></td>
                            <td colspan="3" >{$SPORTEANEXO}{$ENCREGID}{$FACTPROID}</td>                                                        
                        </tr>
                        <tr>
                            <td><label>Tipo Documento : </label></td>
                            <td>{$TIPODOCUMENTO}</td>                                                        
                            <td><label>Documento Contable : </label></td>
                            <td>{$DOCCONTABLE}</td>                                                        
                        </tr>
                    </table>
                </fieldset>
        		</td>
        	</tr>
        	<tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
        	<tr>
       			<td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
        	</tr>
        </table>		 
        <div>
        	<iframe name="detalleNovedad" id="detalleNovedad" src="about:blank"></iframe>
        </div>
    </fieldset>
    {$FORM1END}
    <fieldset>{$GRIDNOVEDAD}</fieldset>

</body>
</html>