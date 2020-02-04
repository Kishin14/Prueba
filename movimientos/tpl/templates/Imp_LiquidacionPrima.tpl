<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
        <link type="text/css" rel="stylesheet" href="/application/framework/css/printer.css" /> 
        <link type="text/css" rel="stylesheet" href="/application/framework/css/printer.css" /> 
        <script language="javascript" type="text/javascript" src="/application/framework/js/printer.js"></script>
        <title>Impresion Liquidaci&oacute;n</title>
    </head>

    <body leftmargin="auto">
      <div align="center">
      {if $TIPOIMPRE neq 'C'} <!-- consolidado y desprendibles -->
      	  {assign var="totaldebito" value="0"}
          {assign var="totalcredito" value="0"}
	      {foreach name=liquidacion_novedad from=$DETALLES item=d}
          	  <div style="page-break-after:always; margin-top:50px;">
              <table class="cellTotal" border="0" cellspacing="0" width="95%">
              	<tr>
                	<td colspan="5">
                      <table  border="0" cellspacing="0" width="100%"> 
                        <tr>
                            <th align="left" valign="top"><img src="{$LOGO}?123" width="280" height="100" /></th><th align="center">&nbsp;{$NOMBREEMPRESA}<br>{$NITEMPRESA}</th><th width="10%">&nbsp;</th>
                        </tr>
                      </table><br />
                    </td>
                </tr>
			  	<tr><td><strong>EMPLEADO:</strong> </td><td>{$d.empleado}</td><td><strong>DOCUMENTO No:</strong></td><td>{$d.identificacion}</td><td align="center"><strong>FECHA:</strong></td></tr>
				<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align="center">DEL {$FECHA_INI} AL {$FECHA_FIN}</td></tr>
                <tr><td><strong>CARGO:</strong></td><td>{$d.cargo}</td><td>&nbsp;</td><td>&nbsp;</td><td align="center">&nbsp;</td></tr>                
              	<tr>
                	<td colspan="5"><br />
                    	<table class="cellTotal" border="1" cellpadding="0" cellspacing="0" width="100%">
                        	<tr><td align="center"><strong>CONCEPTO</strong></td><td align="center"><strong>No DIAS</strong></td><td align="center"><strong>TOTAL A PAGAR</strong></td></tr>
                            {foreach name=detalle_liquidacion_novedad from=$d.detalles item=l}

                            
 
                                    {math assign="totaldebito" equation="x + y" x=$totaldebito y=$l.debito}
                                    {math assign="totalcredito" equation="x + y" x=$totalcredito y=$l.credito}            
                            		<tr><td align="left">&nbsp;{$l.concepto}</td><td align="center">&nbsp;{$l.dias}</td><td align="center">{$l.valor|number_format:0:',':'.'}&nbsp;</td></tr>                                 
                            {/foreach}
                                    <tr><td align="left">&nbsp;TOTAL A PAGAR</td><td align="center">&nbsp;</td><td align="right">$ {$l.valor|number_format:0:',':'.'}&nbsp;</td></tr>
                                   {assign var="totaldebito" value="0"}
                                   {assign var="totalcredito" value="0"}
                        </table>
                    </td>
                </tr>
                <tr>
                	<td colspan="5"><br /><br /><br /><br /><br /><br />
                    	<table width="99%" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td> _____________________________<br>ELABORO<br></td>
                                <td> _____________________________<br>APROBO<br></td>
                                <td> _____________________________<br>RECIBIO  C.C.<br></td>
                            </tr>
                        
                        </table><br /><br />
                    </td>
                </tr>
                
              </table><br>    
              </div>      
          {/foreach}
          
      {else}<!--ok  planilla liquidacion-->
      
          {assign var="cols_deb" value="0"}
          {assign var="cols_cre" value="0"}
          {assign var="cols_total" value="6"}
          {assign var="sueldobasesum" value="0"}
          {assign var="total_debitosum" value="0"}
          {assign var="total_creditosum" value="0"}
          {assign var="total_apagar" value="0"}
          
          {math assign="cols_deb" equation="x + y + z" x=$CONCDEBITO|@count y=1 z=$CONCDEBITOEXT|@count}
          {math assign="cols_cre" equation="x + y + z" x=$CONCCREDITO|@count y=1 z=$CONCCREDITOEXT|@count}
          {math assign="cols_total" equation="x + y" x=$cols_total y=$cols_deb}
           {math assign="cols_total" equation="x + y" x=$cols_total y=$cols_cre}
          <table  border="0" cellspacing="0" width="99%"> 
            <tr>
                <th align="left" valign="top"><img src="{$LOGO}?123" width="280" height="100" /></th><th align="center">&nbsp;{$NOMBREEMPRESA}<br>{$NITEMPRESA}</th><th width="10%">&nbsp;</th>
            </tr>
          </table>
          <table class="cellTotal" border="1" cellspacing="0" width="99%">
          
           <thead>
            <tr>
                <th colspan="{$cols_total}" align="center">&nbsp;PAGO PRIMAS HASTA {$FECHALIQ}</th>
            </tr>
            
            <tr>
             <th rowspan="2">IDENTIFICACION</th>
             <th rowspan="2">NOMBRE Y APELLIDOS</th>
             <th rowspan="2">CARGO</th>
             <th rowspan="2">SUELDO BASE</th>
             <th rowspan="2">DIAS</th>       
             <th rowspan="2">VALOR A PAGAR</th>
            </tr>
            <tr> 
            
             
            
            </tr>
            </thead>
            
            <tbody>
        
            {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
                {math assign="sueldobasesum" equation="x + y" x=$sueldobasesum y=$d.sueldo_base}
                {math assign="total_apagar" equation="x + y" x=$total_apagar y=$d.valor}
                <tr>
                 <td >&nbsp;{$d.identificacion}</td>  
                 <td >&nbsp;{$d.empleado}</td>  
                 <td >&nbsp;{$d.cargo}</td>  
                 <td align="right">&nbsp;${$d.sueldo_base|number_format:0:',':'.'}&nbsp;</td>  
                 <td align="center">{$d.dias}</td>
                 <td align="right">${$d.valor|number_format:0:',':'.'}&nbsp;</td>
                
                 
              
                
                </tr>   
            {/foreach}
           </tbody>
           <tbody>
            <tr>
                <td colspan="3">&nbsp;TOTALES</td>
                <td align="right">$ {$sueldobasesum|number_format:0:',':'.'}&nbsp;</td>
                <td align="right">&nbsp;</td>
    
                
                 <td align="right">&nbsp;${$total_apagar|number_format:0:',':'.'}&nbsp;</td>  
    
            </tr>
           </tbody>
          </table>
      
      {/if}
      </div>
    </body>                            
</html>