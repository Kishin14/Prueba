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
    <legend><img src="/colpinones/produccion/movimientos/media/images/MenuArbol/contrato.png" height="50"><p style="color: #FFF">FINALIZACI&Oacute;N DE CONTRATOS NO LABORALES</p></legend> 

   <div id="table_find">
      <table align="center">
       <tr>
         <td ><label>Busqueda : </label></td>
         <td>{$BUSQUEDA}</td>
       </tr>
     </table>
   </div>
    
    {$FORM1}
    {$USUARIOID}{$FECHAFINALIZA}
    <fieldset class="section">
	    <legend>Datos Contrato</legend>
        <table align="center" width="70%">
            
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
                <td><label>Fecha Final Real: </label></td>
                <td >{$FECHAFINREAL}</td>
            </tr>

            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
                 <td><label>Causal Despido: </label></td>
                <td >{$CAUSALDESID}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$ACTUALIZAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    </fieldset>         
    
    {$FORM1END}      
    {$GRIDPARAMETROS}
</body>
</html>
