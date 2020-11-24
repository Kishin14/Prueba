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
    {$BASEID}
    <fieldset class="section">
    <fieldset class="section">
    <legend>Devengados</legend>
        <table width="99%">
            <tr>
                <td><label>Periodo Contable : </label></td>
                <td>{$PERIODOCONTABLE}</td>
                <td colspan="4">                	
					<table width="95%">
                        <tr>
                            <td><label>Días Laborales : </label></td>
                            <td>{$DIASLAB}</td>
                            <td><label>Días Lab Mes : </label></td>
                            <td>{$DIASLABMES}</td>
                            <td><label>Horas al Día :</label></td>
                            <td>{$HORASDIA}</td>
						</tr>
                        <tr>                                
                            <td><label>Horas Lab Día : </label></td>
                            <td>{$HORASLABDIA}</td>
                            <td><label>Hora Corriente : </label></td>
                            <td>{$HORACORRIENTE}</td>
                            <td><label>Limite Salario Subsidio : </label></td>
                            <td>{$LIMSUB}</td>
                    	</tr>
                        <tr>
                            <td><label>Limite fondo pensional :</label></td>
                            <td>{$LIMITEFONDO}</td>
                        </tr>
                    </table>                                                            
            	</td>
            	<td>&nbsp;</td>
            </tr>
            <tr>
                <td><label>Documento Contable :</label></td>
                <td>{$DOCUMENTOCONTABLE}</td>
            	<td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center"><label>Concepto</label></td>
                <td><label>Puc Admon</label></td>
                <td><label>Puc Ventas</label></td>
                <td><label>Puc Producci&oacute;n</label></td>
                <td><label>Puc Contrapartida</label></td>
            </tr>
            <tr>
                <td><label>Salario Minimo : </label></td>
                <td>{$SALARIO}</td>
                <td>{$PUCADMONSAL}{$PUCADMONSALID}</td>
                <td>{$PUCVENTASSAL}{$PUCVENTASSALID}</td>
                <td>{$PUCPRODUCCSAL}{$PUCPRODUCCSALID}</td>
                <td>{$PUCCONTRASAL}{$PUCCONTRASALID}</td>
            </tr>
            <tr>
                <td><label>Subsidio Transporte : </label></td>
                <td>{$SUBTRANSPORTE}</td>
                <td>{$PUCADMONTRANS}{$PUCADMONTRANSID}</td>
                <td>{$PUCVENTASTRANS}{$PUCVENTASTRANSID}</td>
                <td>{$PUCPRODUCCTRANS}{$PUCPRODUCCTRANSID}</td>
                <td>{$PUCCONTRATRANS}{$PUCCONTRATRANSID}</td>
            </tr>  
            <tr>
                <td><label>%Ingreso no Salarial: </label></td>
                <td>{$NOSALARIAL}</td>
                <td>{$PUCADMONNOS}{$PUCADMONNOSID}</td>
                <td>{$PUCVENTASNOS}{$PUCVENTASNOSID}</td>
                <td>{$PUCPRODUCCNOS}{$PUCPRODUCCNOSID}</td>
                <td>{$PUCCONTRANOS}{$PUCCONTRANOSID}</td>
            </tr>

            <tr>
                <td><label>% Hora Extra Diurna : </label></td>
                <td>{$HORAEXTRADIURNA}</td>
                <td>{$PUCADMONEXTRADIU}{$PUCADMONEXTRADIUID}</td>
                <td>{$PUCVENTASEXTRADIU}{$PUCVENTASEXTRADIUID}</td>
                <td>{$PUCPRODUCCEXTRADIU}{$PUCPRODUCCEXTRADIUID}</td>
                <td>{$PUCCONTRAEXTRADIU}{$PUCCONTRAEXTRADIUID}</td>
            </tr>
            <tr>
                <td><label>% Hora Extra Nocturna : </label></td>
                <td>{$HORAEXTRANOCTURNA}</td>
                <td>{$PUCADMONEXTRANOC}{$PUCADMONEXTRANOCID}</td>
                <td>{$PUCVENTASEXTRANOC}{$PUCVENTASEXTRANOCID}</td>
                <td>{$PUCPRODUCCEXTRANOC}{$PUCPRODUCCEXTRANOCID}</td>
                <td>{$PUCCONTRAEXTRANOC}{$PUCCONTRAEXTRANOCID}</td>
            </tr>
            <tr>
                <td><label>% Hora Fest Diurna : </label></td>
                <td>{$HORAFESTDIURNA}</td>
                <td>{$PUCADMONFESDIU}{$PUCADMONFESDIUID}</td>
                <td>{$PUCVENTASFESDIU}{$PUCVENTASFESDIUID}</td>
                <td>{$PUCPRODUCCFESDIU}{$PUCPRODUCCFESDIUID}</td>
                <td>{$PUCCONTRAFESDIU}{$PUCCONTRAFESDIUID}</td>
            </tr>
            <tr>
                <td><label>% Hora Fest Nocturna : </label></td>
                <td>{$HORAFESTNOCTURNA}</td>
                <td>{$PUCADMONFESNOC}{$PUCADMONFESNOCID}</td>
                <td>{$PUCVENTASFESNOC}{$PUCVENTASFESNOCID}</td>
                <td>{$PUCPRODUCCFESNOC}{$PUCPRODUCCFESNOCID}</td>
                <td>{$PUCCONTRAFESNOC}{$PUCCONTRAFESNOCID}</td>
            </tr>
            <tr>
                <td><label>% Recargo Nocturno : </label></td>
                <td>{$HORARECNOCTURNA}</td>
                <td>{$PUCADMONRECNOC}{$PUCADMONRECNOCID}</td>
                <td>{$PUCVENTASRECNOC}{$PUCVENTASRECNOCID}</td>
                <td>{$PUCPRODUCCRECNOC}{$PUCPRODUCCRECNOCID}</td>
                <td>{$PUCCONTRARECNOC}{$PUCCONTRARECNOCID}</td>
            </tr>
            <tr>
                <td><label>% Recargo Dominical o Festivo : </label></td>
                <td>{$HORARECDOMINICAL}</td>
                <td>{$PUCADMONRECDOC}{$PUCADMONRECDOCID}</td>
                <td>{$PUCVENTASRECDOC}{$PUCVENTASRECDOCID}</td>
                <td>{$PUCPRODUCCRECDOC}{$PUCPRODUCCRECDOCID}</td>
                <td>{$PUCCONTRARECDOC}{$PUCCONTRARECDOCID}</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Seguridad Social</legend>
        <table width="99%">   
            <tr>
                <td align="center"><label>Concepto</label></td>
                <td align="center"><label>% Empleado</label></td>
                <td align="center"><label>% Empresa</label></td>                  
                <td><label>Puc Admon</label></td>
                <td><label>Puc Ventas</label></td>
                <td><label>Puc Producci&oacute;n</label></td>
                <td><label>Puc Contrapartida</label></td>
            </tr>
            <tr>
                <td><label>Salud </label></td>
                <td>{$DESCEMPLESALUD}</td>
                <td>{$DESCEMPRESALUD}</td>
                <td>{$PUCADMONSALUD}{$PUCADMONSALUDID}</td>
                <td>{$PUCVENTASSALUD}{$PUCVENTASSALUDID}</td>
                <td>{$PUCPRODUCCSALUD}{$PUCPRODUCCSALUDID}</td>
                <td>{$PUCCONTRASALUD}{$PUCCONTRASALUDID}</td>
            </tr>
            <tr>
                <td><label>Pensi&oacute;n</label></td>
                <td>{$DESCEMPLEPENSION}</td>
                <td>{$DESCEMPREPENSION}</td>
                <td>{$PUCADMONPENSION}{$PUCADMONPENSIONID}</td>
                <td>{$PUCVENTASPENSION}{$PUCVENTASPENSIONID}</td>
                <td>{$PUCPRODUCCPENSION}{$PUCPRODUCCPENSIONID}</td>
                <td>{$PUCCONTRAPENSION}{$PUCCONTRAPENSIONID}</td>
            </tr>
            <tr>
                <td><label>ARL</label></td>
                <td>0%</td>
                <td>100%</td>
                <td>{$PUCADMONARL}{$PUCADMONARLID}</td>
                <td>{$PUCVENTASARL}{$PUCVENTASARLID}</td>
                <td>{$PUCPRODUCCARL}{$PUCPRODUCCARLID}</td>
                <td>{$PUCCONTRAARL}{$PUCCONTRAARLID}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Prestaciones Sociales</legend>
        <table width="99%">   
            <tr>
                <td align="center"><label>Concepto</label></td>
                <td align="center"><label>% Empleado</label></td>
                <td align="center"><label>% Empresa</label></td>                  
                <td><label>Puc Admon</label></td>
                <td><label>Puc Ventas</label></td>
                <td><label>Puc Producci&oacute;n</label></td>
                <td><label>Puc Contrapartida</label></td>
            </tr>
            <tr>
                <td><label>Cesantias</label></td>
                <td>&nbsp;</td>
                <td>{$DESCESANTIAS}</td>                  
                <td>{$PUCADMONCESAN}{$PUCADMONCESANID}</td>
                <td>{$PUCVENTASCESAN}{$PUCVENTASCESANID}</td>
                <td>{$PUCPRODUCCCESAN}{$PUCPRODUCCCESANID}</td>
                <td>{$PUCCONTRACESAN}{$PUCCONTRACESANID}</td>
            </tr>
            <tr>
                <td><label>Intereses Cesan.</label></td>
                <td>&nbsp;</td>
                <td>{$DESCESANTIASINT}</td>
                <td>{$PUCADMONINCESAN}{$PUCADMONINCESANID}</td>
                <td>{$PUCVENTASINCESAN}{$PUCVENTASINCESANID}</td>
                <td>{$PUCPRODUCCINCESAN}{$PUCPRODUCCINCESANID}</td>
                <td>{$PUCCONTRAINCESAN}{$PUCCONTRAINCESANID}</td>
            </tr>
            <tr>
                <td><label>Vacaciones</label></td>
                <td>&nbsp;</td>
                <td>{$DESCEMPREVACACIONES}</td>
                <td>{$PUCADMONVACA}{$PUCADMONVACAID}</td>
                <td>{$PUCVENTASVACA}{$PUCVENTASVACAID}</td>
                <td>{$PUCPRODUCCVACA}{$PUCPRODUCCVACAID}</td>
                <td>{$PUCCONTRAVACA}{$PUCCONTRAVACAID}</td>
            </tr>
            <tr>
                <td><label>Prima Servicios</label></td>
                <td>&nbsp;</td>
                <td>{$DESCPRIMASERV}</td>
                <td>{$PUCADMONPRIMA}{$PUCADMONPRIMAID}</td>
                <td>{$PUCVENTASPRIMA}{$PUCVENTASPRIMAID}</td>
                <td>{$PUCPRODUCCPRIMA}{$PUCPRODUCCPRIMAID}</td>
                <td>{$PUCCONTRAPRIMA}{$PUCCONTRAPRIMAID}</td>
            </tr>
            <tr>
                <td><label>Fondo Pensi&oacute;n</label></td>
                <td>{$DESC_FONDO}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>{$PUCCONTRAFONDPEN}{$PUCCONTRAFONDPENID}</td>
            </tr>
            <tr>
                <td><label>Retenci&oacute;n</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>{$PUCRETENCION}{$PUCRETENCIONID}</td>
            </tr>
            
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Parafiscales</legend>
        <table width="99%">
            <tr>
                <td align="center" ><label>Concepto</label></td>
                <td align="center" ><label>% Empresa</label></td>
                <td><label>Tercero</label></td>
                <td><label>Puc Admon</label></td>
                <td><label>Puc Ventas</label></td>
                <td><label>Puc Producci&oacute;n</label></td>
                <td><label>Puc Contrapartida</label></td>
            </tr>
            <tr>
                <td><label>Caja:</label></td>
                <td>{$DESCAJACOMP}</td>
                <td>&nbsp;</td>
                <td>{$PUCADMONCAJA}{$PUCADMONCAJAID}</td>
                <td>{$PUCVENTASCAJA}{$PUCVENTASCAJAID}</td>
                <td>{$PUCPRODUCCCAJA}{$PUCPRODUCCCAJAID}</td>
                <td>{$PUCCONTRACAJA}{$PUCCONTRACAJAID}</td>
            </tr>
            <tr>
                <td><label>ICBF:</label></td>
                <td>{$DESCICBF}</td>
                <td>{$TERCEROICBF}{$TERCEROICBFID}</td>
                <td>{$PUCADMONICBF}{$PUCADMONICBFID}</td>
                <td>{$PUCVENTASICBF}{$PUCVENTASICBFID}</td>
                <td>{$PUCPRODUCCICBF}{$PUCPRODUCCICBFID}</td>
                <td>{$PUCCONTRAICBF}{$PUCCONTRAICBFID}</td>
            </tr>
            <tr>
                <td><label>SENA:</label></td>
                <td>{$DESCSENA}</td>
                <td>{$TERCEROSENA}{$TERCEROSENAID}</td>
                <td>{$PUCADMONSENA}{$PUCADMONSENAID}</td>
                <td>{$PUCVENTASSENA}{$PUCVENTASSENAID}</td>
                <td>{$PUCPRODUCCSENA}{$PUCPRODUCCSENAID}</td>
                <td>{$PUCCONTRASENA}{$PUCCONTRASENAID}</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend>Indemnizaci&oacute;n</legend>
        <table width="99%">
            <tr>
                <td align="center" width="10%"><label>1 A&Ntilde;0</label></td>
                <td align="center" width="10%"><label>2 o m&aacute;s A&ntilde;os</label></td>
                <td><label>Puc Admon</label></td>
                <td><label>Puc Ventas</label></td>
                <td><label>Puc Producci&oacute;n</label></td>
                <td><label>Puc Contrapartida</label></td>
            </tr>
            <tr>
                <td>{$DIASINDEM}</td>
                <td>{$DIAS2INDEM}</td>
                <td>{$PUCADMONINDEM}{$PUCADMONINDEMID}</td>
                <td>{$PUCVENTASINDEM}{$PUCVENTASINDEMID}</td>
                <td>{$PUCPRODUCCINDEM}{$PUCPRODUCCINDEMID}</td>
                <td>{$PUCCONTRAINDEM}{$PUCCONTRAINDEMID}</td>
            </tr>
        </table>
    </fieldset>
    <table width="99%">     
        <tr>
            <td  align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$DUPLICAR}&nbsp;{$LIMPIAR}</td>
        </tr>
    </table>
    <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    {$FORM1END}
    </fieldset>
   
    <div id="divAnulacion" style="display:none">
      <form>
        <table>       
          <tr>
            <td><label>Periodo contable :</label></td>
            <td>{$PERIODONUEVO}</td>
          </tr>          
          <tr>
            <td><label>Salario mínimo :</label></td>
            <td>{$SALARIONUEVO}</td>
          </tr>
          <tr>
            <td><label>Subsidio Transporte :</label></td>
            <td>{$SUBSIDIONUEVO}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$DUPLICAR}</td>
          </tr>                    
        </table>
      </form>
    </div>

</body>
</html>
