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
            text: ['Licencias e Incapacidades'],
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
                      ['Numero Incapacidades',{$l.licencia_id}],
                      
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
            <div class="col-sm-12">
              <div id="container" style="width: 500px; height: 500px;  margin: 0 auto"></div>
            </div>
        </div>
    <div>
    {/foreach}

  </body>

</html>