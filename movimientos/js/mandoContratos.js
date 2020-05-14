// JavaScript Document
function updateGrid() {
    $("#refresh_QUERYGRID_mandoContratos").click();
}


$(document).ready(function () {

    if (intervalo) {
        clearInterval(intervalo);
        var intervalo = window.setInterval(function () { updateGrid() }, 50000);
    } else {
        var intervalo = window.setInterval(function () { updateGrid() }, 50000);
    }


    var QueryString = "ACTIONCONTROLER=ProximosVencer";

    $.ajax({
        url: "mandoContratosClass.php",
        data: QueryString,
        beforeSend: function () {
        },
        success: function (response) {

            var data = $.parseJSON(response);
            
            if(data != null){

                var contratos ='';

                for (var i = 0; i < data.length; i++) {
            
                var numero_contrato = data[i]['numero_contrato'];
                var fecha_inicio = data[i]['fecha_inicio'];
                var fecha_terminacion = data[i]['fecha_terminacion'];
                var empleado = data[i]['empleado'];
                var dias_dif = data[i]['dias_dif'];

                    contratos = contratos + "\n" + empleado + "--" + numero_contrato + "\n <p style='color:red; font-weight:bold;'>Fecha de Terminación: " + fecha_terminacion + " vigencia " + dias_dif + " dias</p><button id = 'actualizar' onclick='submit(numero_contrato);'>Actualizar</button>";

                }
                
                Swal.fire(
                    'Atención',
                    '<h4 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos vencerán proximamente! <br><br>' + contratos + '</h4>',
                    'info'
                )

            }

            var QueryString = "ACTIONCONTROLER=vencidos";

            $.ajax({
                url: "mandoContratosClass.php",
                data: QueryString,
                beforeSend: function () {
                },
                success: function (response) {

                    var data1 = $.parseJSON(response);

                    if (data1 != null) {

                        var contratos1 = '';

                        for (var i = 0; i < data1.length; i++) {

                            var numero_contrato1 = data1[i]['numero_contrato'];
                            var fecha_inicio1 = data1[i]['fecha_inicio'];
                            var fecha_terminacion1 = data1[i]['fecha_terminacion'];
                            var empleado1 = data1[i]['empleado'];
                            var dias_dif1 = data1[i]['dias_dif'];

                            contratos1 = contratos1 + "\n" + empleado1 + "--" + numero_contrato1 + "\n <p style='color:red; font-weight:bold;'>Fecha de Terminación: " + fecha_terminacion1 + " vigencia " + dias_dif1 + " dias</p>";

                        }

                        if(contratos != '' && contratos1 != ''){
                            Swal.fire(
                                'Atención',
                                '<h5 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos vencerán proximamente! <br><br>' + contratos + '<br><br>¡Estos contratos ya sobrepasaron el rango de la fecha de terminación! <br><br> '+ contratos1 +' <br><br>Por favor revise estos contratos ya que es posible que no se le permita liquidar la nomina</h5>',
                                'info'
                            )
                        }else if(contratos != ''){
                            Swal.fire(
                                'Atención',
                                '<h5 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos vencerán proximamente! <br><br>' + contratos + '</h5>',
                                'info'
                            )
                        }else if(contratos1 != ''){
                            Swal.fire(
                                'Atención',
                                '<h5 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos ya sobrepasaron el rango de la fecha de terminación! <br><br>' + contratos + '<br><br>Por favor revise estos contratos ya que es posible que no se le permita liquidar la nomina</h5>',
                                'info'
                            )
                        }

                        

                        

                    }
                }

            });
        }

    });

});

function reloadGrid() {

    $("#refresh_QUERYGRID_mandoContratos").click();

}


function submit(numero_contrato) {
    alert("juan" +numero_contrato);
}