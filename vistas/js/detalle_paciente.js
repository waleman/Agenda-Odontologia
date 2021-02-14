

$( document ).ready(function(){
    //$(".loader").fadeIn("slow");

    $('#cbopais').change(function(){
        let paisId = $('#cbopais').val();

        var url = "../request/ajax_provincias.php?id=" + paisId;
        $.ajax({
            type:"GET",
            url: url,
            data: "",
            success: function(data){
                $("#divprovincia").html(data);
            }
        });


    });

    $("#cboprovincia").unbind('change');
    $(document).on("change","#cboprovincia", function (event, xhr, settings) {
            let localidadId = $('#cboprovincia').val();
        
            var url = "../request/ajax_localidades.php?id=" + localidadId;
            $.ajax({
                type:"GET",
                url: url,
                data: "",
                success: function(data){
                    $("#divpoblacion").html(data);
                }
            });
    });
  

    $("#btnsolicitarfirma").click(function(){
        $(".loader").fadeIn("slow")
        var url = "../request/ajax_solicitarfirma.php?id=" + pacienteId;
        $.ajax({
            type:"GET",
            url: url,
            data: "",
            success: function(data){
                $(".loader").hide();
                location.reload();
            },
            
        });
        return false;
    })
  



});