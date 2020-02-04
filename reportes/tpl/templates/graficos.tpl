


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content = "text/html; charset = utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Graficos</title>
        <link rel="stylesheet"  href="/application/nomina/reportes/css/bootstrap.css">
        <link rel="stylesheet"  href="/application/nomina/reportes/css/bootstrap.min.css">
        <link rel="stylesheet"  href="/application/nomina/reportes/css/style.css">

      
    </head> 

    <body>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class = "paggraf">
                      <h1>Grafico</h1>
                   
                 </div>
              </div>
                    <!--Fin centro -->
            </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
                <script src="/application/nomina/reportes/js/chart.min.js"></script>
                <script src="/application/nomina/reportes/js/Chart.bundle.min.js"></script>
                    <script type="text/javascript">

                          var ctx = document.getElementById("compras").getContext('2d'); 
                          alert("JDFC"+ctx);
                          var compras = new Chart(ctx, {
                              type: 'bar',
                              data: {
                                  labels: [<?php echo $fechasc; ?>],
                                  datasets: [{
                                      label: '# Compras en S/ de los Ãºltimos 10 dÃ­as',
                                      data: [<?php echo $totalesc; ?>],
                                      backgroundColor: [
                                          'rgba(255, 99, 132, 0.2)'
                                      ],
                                      borderColor: [
                                          'rgba(255,99,132,1)'
                                      ],
                                      borderWidth: 1
                                  }]
                              },
                              options: {
                                  scales: {
                                      yAxes: [{
                                          ticks: {
                                              beginAtZero:true
                                          }
                                      }]
                                  }
                              }
                          });

                          </script>
                          </script> 
                          <?php 
                          ob_end_flush();
                          ?>  
  <!--Fin-Contenido-->
  <script src="/application/nomina/reportes/js/bootstrap.js"></script>
  <script src="/application/nomina/reportes/js/bootstrap.min.js"></script>
    </body>
</html>
