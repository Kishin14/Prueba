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

    contratos();

});

function reloadGrid() {

    $("#refresh_QUERYGRID_mandoContratos").click();

}

function contratos() {


    var QueryString = "ACTIONCONTROLER=ProximosVencer";

    $.ajax({
        url: "mandoContratosClass.php",
        data: QueryString,
        beforeSend: function () {
        },
        success: function (response) {

            var data = $.parseJSON(response);

            if (data != null) {

                var contratos = '';

                for (var i = 0; i < data.length; i++) {

                    var numero_contrato = data[i]['numero_contrato'];
                    var contrato_id = data[i]['contrato_id'];
                    var fecha_inicio = data[i]['fecha_inicio'];
                    var fecha_terminacion = data[i]['fecha_terminacion'];
                    var empleado = data[i]['empleado'];
                    var dias_dif = data[i]['dias_dif'];

                    contratos = contratos + "\n" + empleado + "-" + numero_contrato + "\n <p style='color:red; font-weight:bold;'>Fecha Terminación: " + fecha_terminacion + " vigencia " + dias_dif + " dias</p><button class = 'btn btn-danger' id = 'actualizar' onclick='renovar(" + contrato_id + ");'>Actualizar</button>";

                }
                if (contratos != ''){
                    Swal.fire(
                        'Atención',
                        '<h4 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos vencerán proximamente! <br><br>' + contratos + '<br></h4>',
                        'info'
                    )
                }

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
                            var contrato_id = data1[i]['contrato_id'];
                            var fecha_inicio1 = data1[i]['fecha_inicio'];
                            var fecha_terminacion1 = data1[i]['fecha_terminacion'];
                            var empleado1 = data1[i]['empleado'];
                            var dias_dif1 = data1[i]['dias_dif'];

                            contratos1 = contratos1 + "\n" + empleado1 + "-" + numero_contrato1 + "\n <p style='color:red; font-weight:bold;'>Fecha Terminación: " + fecha_terminacion1 + " vigencia " + dias_dif1 + " dias</p><button class = 'btn btn-danger' id = 'actualizar' onclick='renovar(" + contrato_id + ");'>Actualizar</button><br>";

                        }

                        if (contratos != '' && contratos1 != '') {
                            Swal.fire(
                                'Atención',
                                '<h5 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos ya sobrepasaron el rango de la fecha de terminación! <br><br> ' + contratos1 + ' <br><br>Por favor revise estos contratos ya que es posible que no se le permita liquidar la nomina</h5>',
                                'info'
                            )
                        } else if (contratos != '') {
                            Swal.fire(
                                'Atención',
                                '<h5 style="font-family:Arial, Helvetica, sans-serif">¡Estos contratos vencerán proximamente! <br><br>' + contratos + '</h5>',
                                'info'
                            )
                        } else if (contratos1 != '') {
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
    
}


function renovar(contrato_id) {
    Swal.close();
    if (parseInt(contrato_id) > 0) {

        $("#Renovarcontrato").dialog({
            title: 'Renovar Contrato',
            width: 800,
            height: 450,
            closeOnEscape: true
        });

    } else {
        alertJquery("Por favor seleccione un contrato!", "Validaci&oacute;n");

    }    
    setDataContrato(contrato_id);
}

function setDataContrato(contrato_id) {
    var QueryString = "ACTIONCONTROLER=getDataContrato&contrato_id=" + contrato_id;
    
    $.ajax({
        url: "mandoContratosClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function () {
            showDivLoading();
        },
        success: function (resp) {
            

            try {
                var dataResp = $.parseJSON(resp);

                $("#contrato_hidden").val(dataResp[0]['contrato_id']);
                $("#numero_contrato").val(dataResp[0]['numero_contrato']);
                $("#fecha_inicio").val(dataResp[0]['fecha_inicio']);				 
                $("#fecha_terminacion").val(dataResp[0]['fecha_terminacion']);				 
                $("#empleado").val(dataResp[0]['empleado']);				 
                $("#sueldo_base").val(dataResp[0]['sueldo_base']);				 
                $("#sueldo_base").val(dataResp[0]['sueldo_base']);				 
                $("#subsidio_transporte").val(dataResp[0]['subsidio_transporte']);				 
                $("#estado").val(dataResp[0]['estado']);				         

            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }

            removeDivLoading();
        }

    });
    
}

function onclickActualizar(formulario) {

    if (ValidaRequeridos(formulario)) {

        var contrato_id = $("#contrato_hidden").val();
        var fecha_fin_ren = $("#fecha_fin_ren").val();
        var observacion_ren = $("#observacion_ren").val();

        

        if (parseInt(contrato_id) > 0) {
            var QueryString = "ACTIONCONTROLER=onclickActualizar&contrato_id="+contrato_id+"&fecha_fin_ren="+ fecha_fin_ren+"&observacion_ren="+observacion_ren;

            $.ajax({
                url: "mandoContratosClass.php?rand=" + Math.random(),
                data: QueryString,
                beforeSend: function () {
                    showDivLoading();
                },
                success: function (resp) {
                    try {

                        alertJquery(resp, "Actualizar Contrato");
                        $("#Renovarcontrato").dialog('close');
                        contratos();

                    } catch (e) {
                        alertJquery(resp, "Error :" + e);
                
                    }
                    removeDivLoading();
                    
                }
            });
        } else {
            alertJquery("Por favor seleccione un contrato.", "Validacion");
        }
    }
}