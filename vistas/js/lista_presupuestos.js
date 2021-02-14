$( document ).ready(function(){

    $("#btnnuevo").click(function(){
       $("#modal-crearpresupuesto").modal("show");
       $("#modal-crearpresupuesto").appendTo("body");

        return false;
    })

    $(document.body).on("click", "a[data-borrar]", function (){
        let index = this.dataset.borrar;
       
        var url ="../request/eliminar_presupuesto.php";
        $.post(url,{ "presupuestoId" : index  }, function(data){
            location.reload();
        }); 

        return false;
    })

    $(document.body).on("click", "tr[data-id]", function (){
        let id = this.dataset.id ;
        let paciente = this.dataset.paciente ;
        window.location.replace("presupuesto.php?id=" + id + '&paciente=' + paciente);
    })

    
});

