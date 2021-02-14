$(document).ready(function(){
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
      }


    $("#btnnuevo").click(function(){
            $("#nuevousuario").modal("show");

    });


   $("#btnguarda").click(function(){
        if($("#cborol").val() == 0){
            alertify.notify('Debe Seleccionar Rol', 'error', 5, function(){  });
            return false;
        }else if($("#txtpassword").val() != $("#txtpasssword2").val()){
            alertify.notify('Las contraseñas deben ser iguales', 'error', 5, function(){  });
            return false;
        }else if(!validateEmail($("#txtcorreo").val())){
            alertify.notify('Debe escribir un correo valido', 'error', 5, function(){  });
            return false;
        }else{
            return true;
        }
   });
   
   
   $(document.body).on("click", "tr[data-id]", function (){

     let id = this.dataset.id;
     window.location.replace("editar_usuario.php?id=" + id);
    
    })

    $('.tables').DataTable( {
        "pageLength": 50,
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

   
})