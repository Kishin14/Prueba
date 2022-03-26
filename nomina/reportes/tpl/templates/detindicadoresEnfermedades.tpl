<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

{literal}
         <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
        ${demo.css}
        </style>
        <script type="text/javascript">
$(function () {



   $('#container').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
       {/literal}
        
            text: ['Licencias e Incapacidades'],
        
        {literal}
        
    },
    subtitle: {
        text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        {/literal}


          {foreach name=detalles from=$DETALLES item=i}

          {assign var="array" value=$i.contrato}

          {assign var="variable" value="$variable,'$array'"|replace:"'',":""}
            
          {/foreach}

         categories: [{$variable|substr:1}],
           
        {literal}
      
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 90,
        floating: true,
        borderWidth: 1,
        backgroundColor:'#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
       
        name: 'Numero Licencias o Incapacidades',
       
         {/literal}
            {foreach name=detalles from=$DETALLES item=i}
              
              {assign var="array1" value=$i.numero}

              {assign var="variable1" value="$variable1,$array1"|replace:"'',":""}
           
            {/foreach}

            data: [{$variable1|substr:1}]
           
        {literal}
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
  

    <div class="container-fluid" style="background-color: #e2e2e2;">
    <div class="row animated zoomIn">
            <div class="col-sm-12">
             
                <div id="container" style="width: 700px; height: 380px;  margin: 0 auto; margin-top: 6px; margin-bottom: 8px;"></div>
          
            </div>
    </div>
    <div>
  

  </body>

</html>