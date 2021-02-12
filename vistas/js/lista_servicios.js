$(document).ready(function(){

    $(document.body).on("click", "tr[data-id]", function (){

        let id = this.dataset.id;
        let nombre = this.dataset.nombre;
        let estado = this.dataset.estado;
        let categoria = this.dataset.categoria;
        let precio = this.dataset.precio;
        let iva = this.dataset.iva;
         $("#txtservicioid_editar").val(id);
         $("#txtnombre_editar").val(nombre);
         $("#cboestado_editar").val(estado);
         $("#cbocategorias_editar").val(categoria);
         $("#txtprecio_editar").val(precio);
         $("#txtiva_editar").val(iva);

            $("#editar").modal("show");
    })

    $("#btnnuevo").click(function(){
        $("#crear").modal("show");
    });

    $("#btnguardar").click(function(){
        if(!$("#txtnombre").val()){
            alertify.notify('Debe escribir el nombre del servicio', 'error', 5, function(){  console.log('dismissed'); });
            return false;
        }else{
            return true;
        }
    });

});