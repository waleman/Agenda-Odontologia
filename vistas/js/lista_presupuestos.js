$( document ).ready(function(){

    $("#btnnuevo").click(function(){
       $("#modal-crearpresupuesto").modal("show");
       $("#modal-crearpresupuesto").appendTo("body");

        return false;
    })

    $(document.body).on("click", "tr[data-id]", function (){
        let id = this.dataset.id ;
        let paciente = this.dataset.paciente ;
        window.location.replace("presupuesto.php?id=" + id + '&paciente=' + paciente);
    })

    
});

