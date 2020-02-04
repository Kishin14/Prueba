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
    <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
    
    {$FORM1}
    {$ENCABEZADOID}{$USUARIOID}{$FECHAREG}
    <fieldset class="section">
	    <legend>Datos Contrato</legend>
        <table align="center" width="70%">
            <tr>
                <td><label>Liquidaci&oacute;n Definitiva No.  : </label></td>
                <td>{$LIQDEFINITIVAID}</td>
            </tr>
            <tr>
                <td><label>Contrato No. : </label></td>
                <td colspan="3">{$CONTRATO}{$CONTRATOID}</td>
            </tr>
            <tr>
                <td><label>Fecha Inicio : </label></td>
                <td>{$FECHAINI}</td>
                <td><label>Fecha Final : </label></td>
                <td>{$FECHAFIN}</td>
                
            </tr>
            <tr>
                <td><label>Motivo  Terminaci&oacute;n : </label></td>
                <td >{$MOTIVO_TERMID}</td>
                <td><label>Causal Despido: </label></td>
                <td >{$CAUSALDESID}</td>
                
            </tr>
            <tr>
                <td><label>Base Liquidaci&oacute;n : </label></td>
                <td>{$BASE_LIQ}</td>
                <td><label>Indemnizaci&oacute;n: </label></td>
                <td>{$JUSTIFICADO}</td>
            </tr>
            <tr>
                <td><label>Dias : </label></td>
                <td>{$DIAS}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
                
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$LIMPIAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$CONTABILIZAR}</td>
            </tr>
        </table>
    </fieldset>         
    <fieldset class="section">
    	<legend>Datos Liquidaci&oacute;n</legend>
        	<div>
            	<iframe name="prestacion" id="prestacion" src="about:blank" height="300px"></iframe>
			</div>
	</fieldset>
    
    {$FORM1END}  
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
    

</body>
</html>
