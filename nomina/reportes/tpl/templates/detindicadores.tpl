
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

{literal}
         <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
        ${demo.css}
        </style>
        <script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
        {/literal}
         {foreach name=detalles from=$DETALLES item=i}
            text: ['Licencias e Incapacidades']
          {/foreach}
        {literal}
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Total Incapacidades',
            data: [
                {/literal}
                {foreach name=detall from=$i.licencia item=l}
                      ['Dias laborados',{$l.dias_laborados}],
                      ['Dias No Laborados',{$l.dias_fallados}]
                {/foreach}
                {literal}
            ]
        }]
    });
    $('#container1').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
        {/literal}
         {foreach name=detalles from=$DETALLES item=i}
            text: ['Novedades']
          {/foreach}
        {literal}
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Total Novedades',
            data: [
                {/literal}
                { assign var= "contadorsito" value="0" }
                {foreach name=detall from=$i.novedad item=n}
                      ['{$n.concepto_area}',{$n.total}],
                      
                { math assign="contadorsito" equation="x + y" x=$contadorsito y=1 } 
                     { if $contadorsito % 2 eq 0}
                      ['{$n.concepto_area}', { $n.total }],
                       {elseif $contadorsito % 1 eq 0}
                       ['', 0]
                      { else}
                      ['{$n.concepto_area}', { $n.total }]
                     {/if}
                {/foreach}
                {literal}
            ]
        }]
    });

    $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
        {/literal}
         {foreach name=detalles from=$DETALLES item=i}
            text: ['Horas Extras']
          {/foreach}
        {literal}
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Horas Extras',
            data: [
                {/literal}
                { foreach name=detalle from=$i.extras item=e }
                      ['Horas Diurnas',{$e.horas_diurnas}],
                      ['Horas Nocturnas',{$e.horas_nocturnas}],
                      ['Horas Diurnas Festivo',{$e.horas_diurnas_fes}],
                      ['Horas Nocturnas Festivo',{$e.horas_nocturnas_fes}],
                      ['Horas Recargo Nocturno',{$e.horas_recargo_noc}],
                      ['Horas Recargo Festivo',{$e.horas_recargo_doc}]
                {/foreach}
                {literal}
            ]
        }]
    });
});


        </script>
{/literal}

  <body>
    <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
    <link rel="stylesheet" href="../../../framework/css/animate.css">
  <script src="../Highcharts-4.1.5/js/highcharts.js"></script>
  <script src="../Highcharts-4.1.5/js/modules/exporting.js"></script> 

        {foreach name=detalles from=$DETALLES item=i}
  <div class="container-fluid">
    <div class="row animated zoomIn">
         { if $i.novedad eq 0}
        <div class="col-sm-10" style="margin-left: 20px;width: 100%;">
        <div style="margin: 25% auto;width: 80%; border: #ebccd1 solid;border-radius: 0.5em;">
          <div class="panel-heading" style="color:#b94a48;background-color:#f2dede;border-radius: 0.5em;">
            <h3 class="panel-title">¡ATENCI&Oacute;N!</h3>
          </div>
          <div class="panel-body">
            <h6 style="font-weight: bold; color: black; text-align: center;">Este empleado no cuenta con novedades creadas.</h6>
          </div>
        </div>
      </div>
              {else}
      <div class="col-sm-4" style="margin-right: 50px;">
        <table  align="left">
          <thead class="thead">
            <th style="border: none; margin-left: 0em;">
              <div id="container1" style="min-width: 310px; height: 300px; max-width: 600px; margin: 0 auto"></div>
            </th>
            <th style="border: none;">
              <table class="table table-bordered table-hover"
                style="min-width: 50px; height: 100px; max-width: 100px; margin: 0 auto" align="left">
                <thead>
                  <th style="font-size: 12px;text-align: center;" colspan="2">{$i.empleado}</th>
                </thead>
                {foreach name=detalles from=$i.novedad item=n}
                <tr>
                  <td align="center"style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Tipo Novedad: </b>
                  </td>
                  <td style="font-size: 12px;">&nbsp;{$n.concepto_area}</td>
                </tr>
                {/foreach}
              </table>
            </th>
          </thead>
          {/if}
        </table>
      </div>
      {foreach name=detalles from=$i.licencia item=l}
            { if $i.licencia eq 0}
            <div class="col-sm-10" style="margin-left: 20px;width: 100%;">
        <div style="margin: 25% auto;width: 80%; border: #ebccd1 solid;border-radius: 0.5em;">
          <div class="panel-heading" style="color:#b94a48;background-color:#f2dede;border-radius: 0.5em;">
            <h3 class="panel-title">¡ATENCI&Oacute;N!</h3>
          </div>
          <div class="panel-body">
            <h6 style="font-weight: bold; color: black; text-align: center;">Este empleado no cuenta con licencias creadas.</h6>
          </div>
        </div>
      </div>
              {else}
      <div class="col-sm-4" style="margin-left: 150px;">
            <table>
              <thead class="thead">
                <th style="border: none;"><div id="container" style="min-width: 310px; height: 300px; max-width: 400px; margin: 0 auto"></div></th>
                <th style="border: none;">
                <table class="table table-bordered table-hover"
                  style="min-width: 50px; height: 100px; max-width: 100px; margin: 0 auto">
                  <thead>
                    <th style="font-size: 12px;text-align: center;" colspan="2">{$i.empleado}</th>
                  </thead>
                  <tr>
                    <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Dias Laborados: </b>
                    </td>
                    </td>
                    <td style="font-size: 12px;">&nbsp;{$l.dias_laborados}</td>
                  <tr>
                    <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Dias No Laborados: </b>
                    <td style="font-size: 12px;">&nbsp;{$l.dias_fallados}</td>
                  </tr>
                  </tr>
                  <tr>
                  <tr>
                    <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Dias
                        Totales: </b>
                    </td>
                    <td style="font-size: 12px;">&nbsp;{$l.dias_totales}</td>
                  </tr>
                </table>
                </th>
              </thead>
              {/if}
            </table>
        </div>
      </div>
      {/foreach}
  </div>
      {foreach name=detalles from=$DETALLES item=i}
          { if $i.extras eq 0}
            <div class="col-sm-10" style="margin-left: 20px;width: 100%;">
        <div style="margin: 25% auto;width: 80%; border: #ebccd1 solid;border-radius: 0.5em;">
          <div class="panel-heading" style="color:#b94a48;background-color:#f2dede;border-radius: 0.5em;">
            <h3 class="panel-title">¡ATENCI&Oacute;N!</h3>
          </div>
          <div class="panel-body">
            <h6 style="font-weight: bold; color: black; text-align: center;">Este empleado no cuenta con extras creadas.</h6>
          </div>
        </div>
      </div>
          {else}
      <div class="col-sm-10" style="margin-left: 20px;width: 100%;">
        <table style="width: 100%;">
          <hr>
          <thead class="thead">
            <th style="border: none;">
              <div id="container2" style="min-width: 610px; height: 600px; max-width: 800px; margin: 0 auto"></div>
            </th>
            <th style="border: none;">
            <table class="table table-bordered table-hover"
              style="min-width: 50px; height: 100px; max-width: 100px; margin: 0 auto">
              <thead>
                <th style="font-size: 12px;text-align: center;" colspan="6">{$i.empleado}</th>
              </thead>
              { foreach name=detalle from=$i.extras item=e }
              <tr>
                <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Horas Diurnas: </b>
                </td>
                <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Horas Nocturnas: </b></td>
                <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Horas Diurnas Festivo: </b></td>
                <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Horas Nocturnas Festivo: </b></td>
                <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Horas Recargo Nocturno: </b></td>
                <td align="center" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Horas Recargo Festivo: </b></td>
              <tr>
                  <td style="font-size: 12px;">&nbsp;{$e.horas_diurnas}</td>
                  <td style="font-size: 12px;">&nbsp;{$e.horas_nocturnas}</td>
                  <td style="font-size: 12px;">&nbsp;{$e.horas_diurnas_fes}</td>
                  <td style="font-size: 12px;">&nbsp;{$e.horas_nocturnas_fes}</td>
                  <td style="font-size: 12px;">&nbsp;{$e.horas_recargo_noc}</td>
                  <td style="font-size: 12px;">&nbsp;{$e.horas_recargo_doc}</td>
              </tr>
              <tr>
                <td align="center" colspan="5" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Dias
                    Totales: </b>
                </td>
                <td style="font-size: 12px;">&nbsp;{$e.total_cant}</td>
              </tr>
              <tr>
                <td align="center" colspan="5" style="background-color: #f5f5f5;font-size: 11px;" valign="top"><b>Vlr.
                    Total: </b>
                </td>
                <td style="font-size: 12px;">&nbsp;{$e.total_valor}</td>
              </tr>
              {/foreach}
            </table>
            </th>
          </thead>
          {/if}
        </table>
      </div>
      {/foreach}
    </div>
  </div>
   {/foreach}
  </body>

</html>