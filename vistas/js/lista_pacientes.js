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


});

