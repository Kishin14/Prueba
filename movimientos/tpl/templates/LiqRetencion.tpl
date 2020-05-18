<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
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
                <td width="10%">&nbsp;</td>
                <td valign="top" width="30%" colspan="2"><label>Contrato : &nbsp;&nbsp;</label><br>{$SI_CONTRATO}</td>   
                <td valign="top" colspan="3" width="20%"><label>Desde:&nbsp;&nbsp;</label><br>{$DESDE}</td>
                <td valign="top" colspan="4" width="40%"><label>Hasta:&nbsp;&nbsp;</label><br>{$HASTA}</td>       
            </tr>
            <tr>
                <td width="10%">&nbsp;</td>
                <td valign="top" width="30%" colspan="2">{$CONTRATO}{$CONTRATOID}</td> 
            </tr>
        </table>
    </fieldset>
	{$SOLICITUDID}
    <fieldset class="section">
        <div align="center">{$GENERAR}&nbsp;{* {$GENERAREXCEL}&nbsp; *}{$IMPRIMIR}&nbsp;{$LIMPIAR}</div>
        <div>&nbsp;</div>
        <iframe src="" id="frameRetencion" name="frameRetencion" height="700px"></iframe>
    </fieldset>
    </fieldset>
    {$FORM1END}
     <div id="Renovarmarco" style="display:none;">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
          <fieldset class="section">
          <table align="center" width="100%">
            <tbody>
                <tr>
                    <td>
                        <fieldset class="section">
                        <legend>Información Contrato</legend>
                        <table id="tableGuia" width="100%">

                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="width:100%;">
                                <td>&nbsp;</td>
                                <td><label>Contrato No :</label></td>
                                <td>{$CONTRATOLIQ}{$CONTRATOLIQID}</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><label>Empleado :</label></td>
                                <td>{$EMPLEADOLIQ}</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table width="100%">
                                        <tr>
                                            <td style="width:47%;"></td>
                                            <td style="width:15%;text-align:right;color:green;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Devengado :</td>
                                            <td style="width:28%;text-align:center">${$TOTALSUMA}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="section">
                        <legend>Ingresos no Constitutivos de Renta</legend>
                        <table id="tableGuia" width="100%">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>1.  Aportes obligatorios a Pension. (Art. 55 Estatuto Tributario):</label></td>
                                <td style="width:30%">${$AOP}</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>2.  Aportes obligatorios a salud. (Art. 56 Estatuto Tributario):</label></td>
                                <td style="width:30%">${$AOS}</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>3.  Aportes voluntarios a fondo de Pensiones obligatorias. (Art. 55 no debe exceder el 25% del ingreso, limitado a 2.500 UVT al año):</label></td>
                                <td style="width:30%">${$AVPO}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;color:green;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Total Ingresos no constitutivos:</td>
                                <td style="width:30%">${$STICR}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;color:red;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Subtotal:</td>
                                <td style="width:30%">${$SUB1}</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="section">
                        <legend>Deducciones</legend>
                        <table id="tableGuia" width="100%">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>1.  Pago intereses de vivienda o Costo Financiero Leasing Habitacional. Limite maximo 100 UVT Mensuales ($3.427.000) Dcto 1625 de 2016 Art. 1.2.4.1.23:</label></td>
                                <td style="width:30%">${$PIV}</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>2.  Deduccion por dependientes (Ver Art. 387 E.T.) No puede exceder del 10% del ingreso bruto del trabajador y maximo 32 UVT mensuales. (1.097.000 2019) Se debe exigir certificado para aplicar esta deducción. Dcto 1625 de 2018 Art. 1.2.4.1.18:</label></td>
                                <td style="width:30%">${$DPD}</td>    
                            </tr>
                            <tr>
                                <td style="width:70%"><label>3.  Pagos Por Salud medicina prepagada. No puede Exceder 16 Uvt Mensuales. 548.000 Año 2019):</label></td>
                                <td style="width:30%">${$PPS}</td>    
                            </tr>
                            <tr>
                                <td style="width:70%;color:green;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Total Deduciones:</td>
                                <td style="width:30%">${$STD}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;color:red;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Subtotal:</td>
                                <td style="width:30%">${$SUB2}</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>                        
                <tr>
                    <td>
                        <fieldset class="section">
                        <legend>Rentas Exentas</legend>
                        <table id="tableGuia" width="100%">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>1.  Aportes Voluntarios Empleador Fondo de Pensiones (Art 126 -1 E.T.) :</label></td>
                                <td style="width:30%">${$AVEFP}</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>2.  Aportes a cuentas AFC (Art 126 - 4 E.T.) :</label></td>
                                <td style="width:30%">${$AFC}</td>
                            </tr>
                            <tr>
                                <td  style="width:70%;"><label>3.  Otros rentas exentas. Art. 206 numerales 1 al 8 :</label></td>
                                <td style="width:30%;">${$ORE}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;color:green;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Total Rentas Exentas:</td>
                                <td style="width:30%">${$STRE}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;color:red;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Subtotal:</td>
                                <td style="width:30%">${$SUB3}</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="section">
                        <legend>Rentas de Trabajo Exentas</legend>
                        <table id="tableGuia" width="100%">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>Renta de Trabajo Exenta (25%). Maximo $ 8.224.800 Año 2019. (240 Uvt):</label></td>
                                <td style="width:30%">${$RTE}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;color:red;font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;">Subtotal:</td>
                                <td style="width:30%">${$SUB4}</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="section">
                        <legend>Cifras de Control</legend>
                        <table id="tableGuia" width="100%">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>Cifra control 40% Deducciones y rentas exentas:</label></td>
                                <td style="width:30%">${$CCD}</td>
                            </tr>
                            <tr>
                                <td style="width:69%;"><label>Total deducciones y renta exentas:</label></td>
                                <td style="width:31%">${$TDR}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;"><label>En todo caso el Maximo permitido es de 420 UVT Articulo 1.2.4.1.6 Decreto 1625 de 2016 14.393.400:</label></td>
                                <td style="width:30%">${$VALIDAU}</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="section">
                        <table id="tableGuia" width="100%">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:70%"><label>Ingreso Laboral Mensual Base para Retención en la Fuente:</label></td>
                                <td style="width:30%">${$IGM}{$UVT}</td>
                            </tr>
                            <tr>
                                <td style="width:70%;"><label>Ingreso laboral gravado en UVT:</label></td>
                                <td style="width:30%">{$ILG}</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr> 
                    <td colspan="4" align="center">{$RENOVAR}{* &nbsp;{$ACTUALIZAR} *}</td>
                </tr>
            </tbody>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div><!--Fin del div renovar marco-->
    
</body>
</html>