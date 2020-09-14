
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
         <title>Impresion Liquidaci&oacute;n</title>
    </head>

    <body leftmargin="auto">
      <div align="center">
      
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
                <th colspan="{$cols_total}" align="center">&nbsp;NOMINA DEL {$FECHA_INI} AL {$FECHA_FIN} </th>
            </tr>
            
            <tr>
             <th rowspan="2">IDENTIFICACION</th>
             <th rowspan="2">NOMBRE Y APELLIDOS</th>
             <th rowspan="2">CARGO</th>
             <th rowspan="2">SUELDO BASE</th>
            <th rowspan="2"><p>DIAS SALARIO</p></th>
             <th rowspan="2"><p>DIAS INCAPACIDADES</p></th> 
             <th rowspan="2"><p>DIAS LICENCIAS</p></th> 
                 
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
                {math assign="sueldobasesum" equation="x + y" x=$sueldobasesum y=$d.sueldo_base}
                {math assign="total_debitosum" equation="x + y" x=$total_debitosum y=$d.total_debito}
                {math assign="total_creditosum" equation="x + y" x=$total_creditosum y=$d.total_credito}            
                
                <tr>
                 <td >{$d.identificacion}</td>  
                 <td >&nbsp;{$d.empleado}</td>  
                 <td >&nbsp;{$d.cargo}</td>  
                 <td align="right">${$d.sueldo_base|number_format:0:',':'.'}</td>  
                 <td align="center">{$d.dias}</td>
                 <td align="center">{$d.dias_incapacidad}</td>
                 <td align="center">{$d.dias_licencia}</td>
                
                {foreach name=debito from=$CONCDEBITO1 item=i}
                    <td align="right">{$d[$i.concepto]}</td> 
                 {/foreach}
                 {foreach name=debito from=$CONCDEBITOEXT1 item=h}
                    <td align="right">{$d[$h.concepto]}</td> 
                 {/foreach}
                 
                 <td align="right">{$d.total_debito}</td>  
                 {foreach name=credito from=$CONCCREDITO1 item=j}
                    <td align="right">{$d[$j.concepto]}</td> 
                 {/foreach}

                 {foreach name=credito from=$CONCCREDITOEXT1 item=l}
                    <td align="right">{$d[$l.concepto]}</td> 
                 {/foreach}
                 
                  <td align="right">{$d.total_credito}</td> 
                 
                 {foreach name=saldo from=$CONCSALDO1 item=j}
                    <td align="right">{$d[$j.concepto]}</td> 
                    {math assign="total_apagar" equation="x + y" x=$total_apagar y=$d[$j.concepto]} 
                 {/foreach}
                </tr>   
            {/foreach}
           </tbody>
           <tbody>
            <tr>
                <td colspan="3">&nbsp;TOTALES</td>
                <td align="right">{$sueldobasesum}</td> 
                <td align="right">&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td align="right">&nbsp;</td>
                
    			
                 {foreach name=debito from=$CONCDEBITO1 item=i}
                    <td align="right">{$TOTALES[0][$i.concepto]}</td>
                 {/foreach}
                 {foreach name=debito from=$CONCDEBITOEXT1 item=i}
                    <td align="right">{$TOTALES[0][$i.concepto]}</td>
                 {/foreach}
                 
                 <td align="right">{$total_debitosum}</td>  
                 {foreach name=credito from=$CONCCREDITO1 item=j}
                    <td align="right">{$TOTALES[0][$j.concepto]}</td>
                 {/foreach}
                 {foreach name=credito from=$CONCCREDITOEXT1 item=j}
                    <td align="right">{$TOTALES[0][$j.concepto]}</td>
                 {/foreach}
                
                 <td align="right">{$total_creditosum}</td>  
                 <td align="right">{$total_apagar}</td>  
    
            </tr>
           </tbody>
          </table>

      </div>
    </body>                            
</html>