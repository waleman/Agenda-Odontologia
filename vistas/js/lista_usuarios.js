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
   
})