<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
        <link type="text/css" rel="stylesheet" href="../../../framework/css/printer.css" /> 
        <script language="javascript" type="text/javascript" src="../../../framework/js/printer.js"></script>
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
                            <th align="left" valign="top"><img src="{$LOGO}?123" width="280" height="100" /></th><th align="center">&nbsp;{$NOMBREEMPRESA}<br>{$NITEMPRESA}<br> {$OFICINA}</th><th width="10%">&nbsp;</th>
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
                        	<tr><td align="center"><strong>CONCEPTO</strong></td><td align="center"><strong>No DIAS / Hr</strong></td><td align="center"><strong>DEVENGADO</strong></td><td align="center"><strong>DEDUCIDO</strong></td><td align="center"><strong>TOTAL A PAGAR</strong></td></tr>
                            {foreach name=detalle_liquidacion_novedad from=$d.detalles item=l}

                            
                            	{if $l.sueldo_pagar eq '0' }
                                    {math assign="totaldebito" equation="x + y" x=$totaldebito y=$l.debito}
                                    {math assign="totalcredito" equation="x + y" x=$totalcredito y=$l.credito}            
                            		<tr><td align="left">&nbsp;{$l.concepto}</td><td align="center">&nbsp;{if $l.cant_horas_extras eq '0'}{$l.dias}{else}{$l.cant_horas_extras}{/if}</td><td align="right">{if $l.debito > 0 && $l.sueldo_pagar eq '0'}$ {$l.debito|number_format:0:',':'.'}{/if}</td> <td align="right">{if $l.credito > 0 && $l.sueldo_pagar eq '0'}$ {$l.credito|number_format:0:',':'.'}{/if}</td> <td align="center">&nbsp;</td></tr>
								{else}
                                	<tr><td align="left">&nbsp;TOTAL A PAGAR</td><td align="center">&nbsp;</td><td align="right">$ {$totaldebito|number_format:0:',':'.'}</td> <td align="right">$ {$totalcredito|number_format:0:',':'.'}</td> <td align="right">$ {$l.credito|number_format:0:',':'.'}</td> </tr>
                                   {assign var="totaldebito" value="0"}
                                   {assign var="totalcredito" value="0"}
                                    
                                {/if}                                    
                            {/foreach}
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
              
              <table class="cellTotal" border="0" cellspacing="0" width="95%">
              	<tr>
                	<td colspan="5">
                      <table  border="0" cellspacing="0" width="100%"> 
                       <tr>
                            <th align="left" valign="top"><img src="{$LOGO}?123" width="280" height="100" /></th><th align="center">&nbsp;{$NOMBREEMPRESA}<br>{$NITEMPRESA}<br> {$OFICINA}</th><th width="10%">&nbsp;</th>
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
                        	<tr><td align="center"><strong>CONCEPTO</strong></td><td align="center"><strong>No DIAS / Hr</strong></td><td align="center"><strong>DEVENGADO</strong></td><td align="center"><strong>DEDUCIDO</strong></td><td align="center"><strong>TOTAL A PAGAR</strong></td></tr>
                            {foreach name=detalle_liquidacion_novedad from=$d.detalles item=l}

                            
                            	{if $l.sueldo_pagar eq '0' }
                                    {math assign="totaldebito" equation="x + y" x=$totaldebito y=$l.debito}
                                    {math assign="totalcredito" equation="x + y" x=$totalcredito y=$l.credito}            
                            		<tr><td align="left">&nbsp;{$l.concepto}</td><td align="center">&nbsp;{if $l.cant_horas_extras eq '0'}{$l.dias}{else}{$l.cant_horas_extras}{/if}</td><td align="right">{if $l.debito > 0 && $l.sueldo_pagar eq '0'}$ {$l.debito|number_format:0:',':'.'}{/if}</td> <td align="right">{if $l.credito > 0 && $l.sueldo_pagar eq '0'}$ {$l.credito|number_format:0:',':'.'}{/if}</td> <td align="center">&nbsp;</td></tr>
								{else}
                                	<tr><td align="left">&nbsp;TOTAL A PAGAR</td><td align="center">&nbsp;</td><td align="right">$ {$totaldebito|number_format:0:',':'.'}</td> <td align="right">$ {$totalcredito|number_format:0:',':'.'}</td> <td align="right">$ {$l.credito|number_format:0:',':'.'}</td> </tr>
                                   {assign var="totaldebito" value="0"}
                                   {assign var="totalcredito" value="0"}
                                    
                                {/if}                                    
                            {/foreach}
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
      
          {assign var="cols_deb"         value="0"}
          {assign var="cols_cre"         value="0"}
          {assign var="cols_total"       value="6"}
          {assign var="sueldobasesum"    value="0"}
          {assign var="total_debitosum"  value="0"}
          {assign var="total_creditosum" value="0"}
          {assign var="total_apagar"     value="0"}
          
          {math assign="cols_deb"     equation="x + y + z"   x=$CONCDEBITO|@count  y=1          z=$CONCDEBITOEXT|@count}
          {math assign="cols_cre"     equation="x + y + z"   x=$CONCCREDITO|@count y=1          z=$CONCCREDITOEXT|@count}
          {math assign="cols_total"   equation="x + y"       x=$cols_total         y=$cols_deb}
          {math assign="cols_total"   equation="x + y"       x=$cols_total         y=$cols_cre}

          <table  border="0" cellspacing="0" width="99%"> 
            <tr>
                <th align="left" valign="top"><img src="{$LOGO}?123" width="280" height="100" /></th><th align="center">&nbsp;{$NOMBREEMPRESA}<br>{$NITEMPRESA}<br> {$OFICINA}</th><th width="10%">&nbsp;</th>
            </tr>
          </table>
          <table class="cellTotal" border="1" cellspacing="0" width="99%">
          
           <thead>
            <tr>
                <th colspan="{$cols_total}" align="center">&nbsp;NOMINA DEL {$FECHA_INI} AL {$FECHA_FIN} </th>
            </tr>
            
            <tr>
             <th rowspan="2">IDENTIFICACION</th>
             <th rowspan="2">NOMBRE Y APELLIDOS</th>
             <th rowspan="2">CARGO</th>
             <th rowspan="2">SUELDO BASE</th>
             <th rowspan="2"><p>DIAS TRABAJADOS</p></th>
             <th rowspan="2"><p>DIAS INCAPACIDADES</p></th> 
            
             <th colspan="{$cols_deb}" align="center">DEVENGADO</th>
             <th colspan="{$cols_cre}" align="center">DEDUCCIONES</th>
             <th rowspan="2">VALOR A PAGAR</th>
            </tr>
            <tr> 
             {foreach name=debito from=$CONCDEBITO item=i}
                <th>{$i.concepto}&nbsp;</th>
             {/foreach}
             {foreach name=debito from=$CONCDEBITOEXT item=h}
                <th>{$h.concepto}&nbsp;</th>
             {/foreach}
             
             <th  align="center">TOTAL DEVEN</th>         
             {foreach name=credito from=$CONCCREDITO item=j}
                <th>{$j.concepto}&nbsp;</th>
             {/foreach}
             {foreach name=credito from=$CONCCREDITOEXT item=l}
                <th>{$l.concepto}&nbsp;</th>
             {/foreach}
             
             <th  align="center">TOTAL DEDUC</th>
            </tr>
            </thead>
            
            <tbody>
        
            {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
                {math assign="sueldobasesum"    equation="x + y" x=$sueldobasesum     y=$d.sueldo_base}
                {math assign="total_debitosum"  equation="x + y" x=$total_debitosum   y=$d.total_debito}
                {math assign="total_creditosum" equation="x + y" x=$total_creditosum  y=$d.total_credito}            
                <tr>
                 <td >&nbsp;{$d.identificacion}</td>  
                 <td >&nbsp;{$d.empleado}</td>  
                 <td >&nbsp;{$d.cargo}</td>  
                 <td align="right">&nbsp;${$d.sueldo_base|number_format:0:',':'.'}</td>  
                 <td align="center">{$d.dias}</td>
                 <td align="center">{$d.dias_incapacidad}</td>
                 
                 {foreach name=debito from=$CONCDEBITO1 item=i}
                    <td align="right">${$d[$i.concepto]|number_format:0:',':'.'}</td> 
                 {/foreach}
                 {foreach name=debito from=$CONCDEBITOEXT1 item=h}
                    <td align="right">${$d[$h.concepto]|number_format:0:',':'.'}</td> 
                 {/foreach}
                 
                 <td align="right">&nbsp;${$d.total_debito|number_format:0:',':'.'}</td>  
                 {foreach name=credito from=$CONCCREDITO1 item=j}
                    <td align="right">${$d[$j.concepto]|number_format:0:',':'.'}</td> 
                 {/foreach}

                 {foreach name=credito from=$CONCCREDITOEXT1 item=l}
                    <td align="right">${$d[$l.concepto]|number_format:0:',':'.'}</td> 
                 {/foreach}
                 
                  <td align="right">&nbsp;${$d.total_credito|number_format:0:',':'.'}</td> 
                 {foreach name=saldo from=$CONCSALDO1 item=j}
                    <td align="right">${$d[$j.concepto]|number_format:0:',':'.'}</td> 
                    {math assign="total_apagar" equation="x + y" x=$total_apagar y=$d[$j.concepto]} 
                 {/foreach}
                </tr>   
            {/foreach}
           </tbody>
           <tbody>
            <tr>
                <td colspan="3">&nbsp;TOTALES</td>
                <td align="right">$ {$sueldobasesum|number_format:0:',':'.'}</td> 
                <td align="right">&nbsp;</td>
                
                <td align="right">&nbsp;</td>
                
    			
                 {foreach name=debito from=$CONCDEBITO1 item=i}
                    <td align="right">{$TOTALES[0][$i.concepto]|number_format:0:',':'.'}</td>
                 {/foreach}
                 {foreach name=debito from=$CONCDEBITOEXT1 item=i}
                    <td align="right">{$TOTALES[0][$i.concepto]|number_format:0:',':'.'}</td>
                 {/foreach}
                 
                 <td align="right">&nbsp;${$total_debitosum|number_format:0:',':'.'}</td>  
                 {foreach name=credito from=$CONCCREDITO1 item=j}
                    <td align="right">{$TOTALES[0][$j.concepto]|number_format:0:',':'.'}</td>
                 {/foreach}
                 {foreach name=credito from=$CONCCREDITOEXT1 item=j}
                    <td align="right">{$TOTALES[0][$j.concepto]|number_format:0:',':'.'}</td>
                 {/foreach}
                
                 <td align="right">&nbsp;${$total_creditosum|number_format:0:',':'.'}</td>  
                 <td align="right">&nbsp;${$total_apagar|number_format:0:',':'.'}</td>  
    
            </tr>
           </tbody>
          </table>
      
      {/if}
      </div>
    </body>                            
</html>