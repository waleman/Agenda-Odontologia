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




});