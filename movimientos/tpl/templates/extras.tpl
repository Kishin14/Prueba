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
                    <td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Horas Extras : </label></td>
                <td>{$HORAEXTRAID}</td>
            </tr>
            <tr>
                <td><label>Fecha Inicial : </label></td>
                <td>{$FECHAINI}</td>
            </tr>
            <tr>
                <td><label>Fecha Final : </label></td>
                <td>{$FECHAFIN}</td>
            </tr>
            <tr>
                <td><label>Empleados : </label></td>
                <td>{$PERSONAS}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table>
                        <tr id="Todos">
                            <td><label>Archivo :</label></td>
                            <td><a href="../../../framework/ayudas/ArchivoHorasExtras.xls" title="Descargar Plantilla" download="ArchivoHorasExtras"><img src="../../../framework/media/images/general/excel.png" width="25" height="25"/></a>&nbsp;&nbsp;&nbsp;&nbsp;{$ARCHIVO}</td>
                        </tr>
                        <tr id="Uno">
                            <td>
                                <table>
                                    <tr>
                                        <td><label>Contrato No. : </label></td>
                                        <td colspan="3">{$CONTRATO}{$CONTRATOID}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Sueldo Base : </label></td>
                                        <td colspan="3">{$SUELDO}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>CONCEPTO</label></td>
                                        <td><label>VR HORA</label></td>
                                        <td><label>CANT. HORAS</label></td>
                                        <td><label>VR TOTAL HORAS</label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Vr HED : </label>&nbsp;&nbsp;<a href="javascript:void(0);"
                                                title="Presiona aqui para saber acerca de este concepto." name="myBtn"><img
                                                    src="../../../framework/media/images/modulos/manual.png" width="16" height="18"
                                                    onclick="cambio_mensaje('HED',this)" /></a></td>
                                        <td>{$VRHREXTRDIUR}</td>
                                        <td>{$HRSEXTDIUR}</td>
                                        <td>{$VREXTDIUR}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Vr HEN : </label></label>&nbsp;&nbsp;<a href="javascript:void(0);"
                                                title="Presiona aqui para saber acerca de este concepto." name="myBtn"><img
                                                    src="../../../framework/media/images/modulos/manual.png" width="16" height="18"
                                                    onclick="cambio_mensaje('HEN',this)" /></td>
                                        <td>{$VRHREXTRNOC}</td>
                                        <td>{$HRSEXTNOCT}</td>
                                        <td>{$VREXTNOCT}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Vr HEDF :</label>&nbsp;<a href="javascript:void(0);"
                                                title="Presiona aqui para saber acerca de este concepto." name="myBtn"><img
                                                    src="../../../framework/media/images/modulos/manual.png" width="16" height="18"
                                                    onclick="cambio_mensaje('HEDF',this)" /></td>
                                        <td>{$VRHRDIURNO}</td>
                                        <td>{$HRSEXTDIURFEST}</td>
                                        <td>{$VREXTDIURFEST}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Vr HENF :</label>&nbsp;<a href="javascript:void(0);"
                                                title="Presiona aqui para saber acerca de este concepto." name="myBtn"><img
                                                    src="../../../framework/media/images/modulos/manual.png" width="16" height="18"
                                                    onclick="cambio_mensaje('HENF',this)" /></td>
                                        <td>{$VRRECFESTIVO}</td>
                                        <td>{$HRSEXTNOCTFEST}</td>
                                        <td>{$VREXTNOCTFEST}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Vr HRN : </label>&nbsp;&nbsp;<a href="javascript:void(0);"
                                                title="Presiona aqui para saber acerca de este concepto." name="myBtn"><img
                                                    src="../../../framework/media/images/modulos/manual.png" width="16" height="18"
                                                    onclick="cambio_mensaje('HRN',this)" /></td>
                                        <td>{$VRHRNOCTURNO}</td>
                                        <td>{$HRSRECNOCT}</td>
                                        <td>{$VRRECNOCT}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Vr HDF : </label>&nbsp;&nbsp;<a href="javascript:void(0);"
                                                title="Presiona aqui para saber acerca de este concepto." name="myBtn"><img
                                                    src="../../../framework/media/images/modulos/manual.png" width="16" height="18"
                                                    onclick="cambio_mensaje('HDF',this)" /></td>
                                        <td>{$VRRECINICIAL}</td>
                                        <td>{$HRSRECDOCT}</td>
                                        <td>{$VRRECDOCT}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                        <td align="right"><label>Total: </label></td>
                                        <td>{$TOTAL}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td id="state"><label>Estado  : </label></td>
                <td>{$ESTADO}</td>
            </tr>                                                                                    
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;<span id="proces" style="display: none;">{$PROCESAR}&nbsp;</span><span id="procest" style="display: none;">{$PROCESARTODOS}&nbsp;</span>{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        <!--INICIO Cuadro de informacion-->
        <div id="MyModal" class="modal">
        
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h5 id="h5"> </h5>
                <h4 align="center"><img src="/application/framework/media/images/alerts/info.png" /></h4>
                <p id="p"></p>
            </div>
        
        </div>
        <!--FIN Cuadro de informacion-->
    {$FORM1END}
    </fieldset>
    <div id="divAnulacion">
  <form onSubmit="return false">
	<table>              
	  <tr>
		<td><label>Causal :</label></td>
		<td>{$CAUSALANULACIONID}</td>
	  </tr>
	  <tr>
		<td><label>Descripcion :</label></td>
		<td>{$OBSERVANULACION}</td>
	  </tr> 
	  <tr>
		<td colspan="2" align="center">{$ANULAR}</td>
	  </tr>                    
	</table>
  </form>
</div>	
    <fieldset>{$GRIDEXTRAS}</fieldset>
</body>
</html>
