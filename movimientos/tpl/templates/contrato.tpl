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
        <div id="table_find">
            <table>
                <tr>
                    <td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {assign var="TITULO_H" value="Ingreso No salarial"} 
    {assign var="PARRAFO_P" value="El artículo 128 del código sustantivo del trabajo señala los pagos que no constituyen salario en los siguientes términos: Pagos que no constituyen salarios. No constituyen salario las sumas que ocasionalmente y por mera liberalidad recibe el trabajador del empleador, como primas, bonificaciones o gratificaciones ocasionales, participación de utilidades, excedentes de las empresas de economía solidaria y lo que recibe en dinero o en especie no para su beneficio, ni para enriquecer su patrimonio, sino para desempeñar a cabalidad sus funciones, como gastos de representación, medios de transporte, elementos de trabajo y otros semejantes. Tampoco las prestaciones sociales de que tratan los títulos VIII y IX, ni los beneficios o auxilios habituales u ocasionales acordados convencional o contractualmente u otorgados en forma extralegal por el empleador, cuando las partes hayan dispuesto expresamente que no constituyen salario en dinero o en especie, tales como la alimentación, habitación o vestuario, las primas extralegales, de vacaciones, de servicios o de navidad. Pagos que no constituyen salario limitados al 40% del total de la remuneración."} 
     
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
                        <td width="7">{$PREFIJO}  {$NUMERO_CONTRATO}{$CONTRATO_ID}</td>
                        <td width="20%"><label>Tipo de Contrato : </label></td>
                        <td>{$TIPO_CONTRATO_ID} <input type="hidden" id="tiempo_contrato" name="tiempo_contrato"></td>
                    </tr>
                    <tr>
                        <td width="20%"><label>Fecha de Inicio : </label></td>
                        <td width="7">{$FECHA_INICIO}</td>
                        <td width="20%"><label>Fecha Terminaci&oacute;n : </label></td>
                        <td width="7">{$FECHA_TERMINACION}</td>
                    </tr>
                    <tr>
                        <td width="20%"><label>Colaborador : </label></td>
                        <td width="7">{$EMPLEADO_ID}{$EMPLEADO}</td>
                        <td width="20%"><label>Cargo : </label></td>
                        <td width="7">{$CARGO_ID}{$CARGO}</td>
                    </tr>
                    <tr>
                        <td width="20%"><label>Lugar Expedicion cedula : </label></td>
                        <td width="7">{$LUGAREXP}</td>
                        <td width="20%"><label>Lugar de trabajo : </label></td>
                        <td width="7">{$LUGARTRAB}</td>
                    </tr>
                    <tr>
                        <td width="20%"><label>Sueldo Base : </label></td>
                        <td width="7">{$SUELDO_BASE}</td>
                        <td width="20%"><label>Subsidio de Transporte : </label></td>
                        <td width="7">{$SUBSIDIO_TRANSPORTE}</td>
                    </tr>
                    <tr>
                        <td width="20%"><label>Ingreso No salarial: &nbsp;&nbsp;<a href="javascript:void(0);"   title="Presiona aqui para saber acerca de este concepto."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'{$TITULO_H}','{$PARRAFO_P}')"/></a></label></td>
                        <td width="7">{$INGRESO_NOSALARIAL}</td>
                        <td width="20%">&nbsp;</td>
                        <td width="7">&nbsp;</td>
                    </tr>

                    <tr>
                        <td width="20%"><label>Centro de Costo: </label></td>
                        <td width="7">{$CENTRO_DE_COSTO}</td>
                        <td width="20%"><label>Periocidad: </label></td>
                        <td width="7">{$PERIOCIDAD}</td>
                    </tr>
                    <tr>
                        <td><label>Hora Inicio : </label></td>
                        <td>{$HORINI}</td>
                        <td><label>Hora Fin : </label></td>
                        <td>{$HORFIN}</td>
                    </tr>
                    <tr>
                        
                        <td><label>Estado: </label></td>
                        <td>{$ESTADO}</td>
                   
                    	<td><label>Area: </label></td>
                        <td>{$AREA}</td>
                   </tr>
                    <tr>
                         <td><label>Categoria ARL: </label></td>
           				 <td>{$ARLID}</td>
                        <td><label>Fecha Vencimiento Carné: </label></td>
                        <td>{$CARNE}</td>
                    </tr>
                    <tr>
                        <td><label>Fecha Vencimiento Dotaci&oacute;n: </label></td>
                        <td>{$DOTACION}</td>
                         
                    </tr>
                </table>
            </fieldset>
            </td>
		</tr>                                                          
        <tr>
            <td colspan="4">
            <fieldset class="section">
            <legend>Datos Ultimas Liquidaciones Prestaciones Sociales del Contrato</legend>
                <table width="95%">
                    <tr>
                        <td width="15%"><label>Fecha Cesantias: </label></td>
                        <td width="15%">{$FECHA_ULTCES}</td>
                        <td width="12%"><label>Valor: </label></td>
                        <td >{$VALOR_ULTCES}</td>
                        <td width="17%"><label>Fecha Int. Cesantias: </label></td>
                        <td width="15%">{$FECHA_ULTINTCES}</td>
                        <td width="12%"><label>Valor: </label></td>
                        <td >{$VALOR_ULTINTCES}</td>
                        
                    </tr>
                    <tr>
                        <td><label>Fecha Prima: </label></td>
                        <td>{$FECHA_ULTPRIMA}</td>
                        <td><label>Valor: </label></td>
                        <td >{$VALOR_ULTPRIMA}</td>
                        <td><label>Fecha Vacaciones: </label></td>
                        <td>{$FECHA_ULTVACA}</td>
                        <td><label>Valor: </label></td>
                        <td >{$VALOR_ULTVACA}</td>
                         
                    </tr>
                </table>
            </fieldset>
            </td>
		</tr>                                                          

        <tr>
            <td colspan="4">
        	<fieldset class="section">
        	<legend>Prestaciones sociales y Documentos Contratacion</legend>
                <table width="50%">
                    <tr>                     
                        <td ><label>EPS :</label></td>
                        <td >{$EMPEPS}{$EMPEPSID}</td>
                        <td width="10%"><label>Fecha inicio : </label></td>
                        <td >{$FECINIEPS}</td>
                        <td ><label>Certificado : </label></td>
                        <td >{$ESCEPS}</td>
                    </tr>
                    <tr>  
                        <td ><label>Pensi&oacute;n : </label></td>
                        <td>{$EMPPEN}{$EMPPENID}</td>
                        <td ><label>Fecha inicio : </label></td>
                        <td >{$FECINIPEN}</td>
                        <td ><label>Certificado : </label></td>
                        <td>{$ESCPEN}</td>
                    </tr>
                    <tr>
                        <td><label>ARL : </label></td>
                        <td>{$EMPARL}{$EMPARLID}</td>
                        <td ><label>Fecha inicio : </label></td>
                        <td >{$FECINIARL}</td>
                        <td ><label>Certificado : </label></td>
                        <td>{$ESCARL}</td>
                    </tr>                        
                    <tr>  
                        <td><label>Caja Compensaci&oacute;n : </label></td>
                        <td>{$EMPCAJ}{$EMPCAJID}</td>
                        <td ><label>Fecha inicio : </label></td>
                        <td >{$FECINICOM}</td>
                        <td ><label>Certificado : </label></td>
                        <td>{$ESCCAJA}</td>
                    </tr>
                    <tr>  
                        <td><label>Cesantias : </label></td>
                        <td>{$EMPCES}{$EMPCESID}</td>
                        <td ><label>Fecha inicio : </label></td>
                        <td >{$FECINICES}</td>
                        <td ><label>Certificado : </label></td>
                        <td>{$ESCCESAN}</td>
                    </tr>
                   <tr>  
                        <td><label>Entidad Bancaria :</label></td>
                        <td>{$BANCO}{$BANCOID}</td>
                        <td><label>Tipo de Cuenta :</label></td>
                		<td colspan="2">{$TIPOCUENTA}</td>
                    </tr>
                     <tr>  
                        <td><label>Numero de cuenta : </label></td>
                        <td>{$NUMCUENTA}</td>
                        <td ><label>Certificado : </label></td>
                        <td colspan="2">{$CERTBANC}</td>
                    </tr>
                    <tr>  
                        <td><label>Examen Medico : </label></td>
                        <td>{$EXAMENMEDICO}</td>
                        <td ><label>Salud Ocupacional : </label></td>
                        <td colspan="2">{$SALUDOCU}</td>
                    </tr>
                    <tr>  
                        <td><label>Examen Periodico : </label></td>
                        <td>{$EXAMENPERIODICO}</td>
                        <td ><label>Examen Egreso : </label></td>
                        <td colspan="2">{$EXAMENEGRESO}</td>
                    </tr>                    
                     <tr>  
                        <td><label>Cartas CyC : </label></td>
                        <td>{$CARTASCYC}</td>
                        <td ><label>Entrega Dotacion : </label></td>
                        <td colspan="2">{$ENTRDOTACION}</td>
                    </tr>
                    <tr>  
                       
                        <td ><label>Contrato Firmado : </label></td>
                        <td>{$CONTRATOFIRMADO}</td>
                         <td><label>Foto : </label></td>
                        <td colspan="2">{$FOTO}</td>
                    </tr>
                    <tr>  
                       
                        <td ><label>Incapacidades : </label></td>
                        <td>{$INCAPACIDADES}</td>
                         <td><label>Paz y Salvo : </label></td>
                        <td colspan="2">{$PAZYSALVO}</td>
                    </tr>
                    <tr>  
                       
                        <td ><label>Certificado de Procuradur&iacute;a : </label></td>
                        <td>{$CERTI_PROCURADURIA}</td>
                         <td><label>Certificado de Antecedentes : </label></td>
                        <td colspan="2">{$CERTI_ANTECEDENTES}</td>
                    </tr>
                    <tr>  
                       
                        <td ><label>Certificado de Contralor&iacute;a : </label></td>
                        <td>{$CERTI_CONTRALORIA}</td>
                         <td><label>Liquidaci&oacute;n : </label></td>
                        <td>{$CERTI_LIQUIDACION}</td>
                    </tr>
                    <tr>  
                        <td ><label>Certificado Laboral : </label></td>
                        <td>{$CERTI_LABORAL}</td>
                         <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
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
                        <td width="20%"><label>Fecha Terminaci&oacute;n Real : </label></td>
                        <td width="7">{$FECHA_TERMINACION_REAL}</td>
                        <td width="20%"><label>Motivo de Terminaci&oacute;n : </label></td>
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
    <!--INICIO Cuadro de informacion-->
    <div id="MyModal" class="modal">
    
        <!-- Modal content -->
        <div class="modal-content" style="width:70%;">
            <span class="close">&times;</span>
            <h5 id="h5"> </h5>
            <h4 align="center"><img src="../../../framework/media/images/alerts/info.png" /></h4>
            <p id="p"></p>
        </div>
    
    </div>
    <!--FIN Cuadro de informacion-->
    
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>
</body>
</html>
