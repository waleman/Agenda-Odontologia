$(document).ready(function(){
   
    $('#btnbuscar').click(function(){
        var url = "../request/busqueda_pacientes.php";
        $.ajax({
            type:"POST",
            url: url,
            data: $("#frmbuscar").serialize(),
            success: function(data){
                    $("#tablapacientes").html(data);
            }
        });
        return false;
    });

    $(document.body).on("click", "tr[data-href]", function (){
        window.location.href = this.dataset.href;
    })


    $("#btnnuevo").click(function(){
        $("#crearpaciente").modal("show");
        return false;
    });

    $("#btnguardarpaciente").click(function(){

        if(!$("#txtnombre").val()){
            console.log("Escriba un nombre");
        }else{
            var url = "../request/guardar_pacientes.php";
                  $.ajax({
                      type:"POST",
                      async: false,
                      url: url,
                      data: $("#frmguardarpaciente").serialize(),
                      success: function(data){
                            let id = data;
                            let nombre = $('#txtnombre').val();
                            $("#txtpacienteid").val(id);
                            $("#txtpaciente").val(nombre)
                            //limpiar
                            $('#txtnombre').val("");
                            $('#txttelefono').val("");
                            $('#txtemail').val("");
                            $('#txtnombre').val("");
                            $('#crearpaciente').modal('hide');
                      }
          });
        }
        
        return true;


    })


    $('.tables').DataTable( {
        "pageLength": 50,
        "bFilter": false, 
         language: {
             processing:    "Procesando...",
             search:        "Buscar&nbsp;:",
             lengthMenu:    "Mostrar _MENU_ registros",
             info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
             infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
             infoFiltered:   "(filtrado de un total de _MAX_ registros)",
             infoPostFix:    "",
             loadingRecords: "Cargando...",
             zeroRecords:    "No se encontraron resultados",
             emptyTable:     "Mostrando registros del 0 al 0 de un total de 0 registros",
             paginate: {
                 first:      "Primero",
                 previous:   "Anterior",
                 next:       "Siguiente",
                 last:       "Ultimo"
             },
             aria: {
                 sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                 sortDescending: ": Activar para ordenar la columna de manera descendente"
             },
         }
        } );


});

