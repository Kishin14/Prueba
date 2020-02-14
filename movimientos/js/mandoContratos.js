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
            
            if($data != null){
            
                var numero_contrato = data[0]['numero_contrato'];
                var fecha_inicio = data[0]['fecha_inicio'];
                var fecha_terminacion = data[0]['fecha_terminacion'];
                var empleado = data[0]['empleado'];
                var dias_dif = data[0]['dias_dif'];
                
                Swal.fire(
                    'Atención',
                    '<h4 style="font-family:Arial, Helvetica, sans-serif">¡El Contrato <p style="color: #e51920">' + numero_contrato + '</p> Referente al empleado '+ empleado +' vencerá en <p style="color: #e51920">' + dias_dif + '</p> dias </h4>',
                    'info'
                )

            }
        }

    });

});

function reloadGrid() {

    $("#refresh_QUERYGRID_mandoContratos").click();

}