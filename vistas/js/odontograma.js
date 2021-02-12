var canvas = document.getElementById('canvas');
let tratamiento ="";
let servicio ="";
var engine = new Engine();
var presupuesto = [];
let dientesAfectados = {
    presupuestoid : "",
    id:"",
    cara:"",
    caraid:"",
    categoria:"",
    servicio:"",
    observacion:"",
}

engine.setCanvas(canvas);

engine.init();

canvas.addEventListener('mousedown', function (event) {
    engine.onMouseClick(event);
}, false);

canvas.addEventListener('mousemove', function (event) {
    engine.onMouseMove(event);
}, false);

// window.addEventListener('keydown', function (event) {
//     engine.onButtonClick(event);
//     console.log(event)
// }, false);


engine.toggleObserverState(true);

observer = function(id){
    console.log(id)

    let diente = engine.getToothById(id);
    let cara = "";
    let caraid = "";

    //Cuando el usuario selecciona una categoria y tramben selecciona un tratamiento
    if(servicio != ""){
        let verificar = id.toString().indexOf("_");
        //si selecciona un diente
        if(verificar == "-1"){
            var myImage = new Image();
            var direccionimage = seleccionarImagen(id,tratamiento)
            if(direccionimage != "" ){
                myImage.src = direccionimage
                diente.image = myImage;
            }
            dientesAfectados.id = id;

            if(tratamiento != "Obturaciòn"){
                dientesAfectados.servicio = obtenerServicio(servicio);
                dientesAfectados.categoria = tratamiento;
                let servicioNombre = dientesAfectados.servicio.Nombre
                asignarvalores(id,cara,tratamiento,servicioNombre)
                $("#modaltramiento").modal({backdrop: 'static', keyboard: false});
                $("#modaltramiento").modal("show");
            }
          
        }else{ // si selecciona una cara
            tratamiento = "Obturaciòn"; 
            caraid = id;
            id = id.substr(0,2);
            diente = engine.getToothById(parseInt(id));
            let caras = diente.checkBoxes;
            caras.forEach(lado => {
                if(lado.id == caraid){
                    lado.state =1;
                    cara = obtenerCara(id,caraid);
                }
            });
            dientesAfectados.id = id;
            dientesAfectados.caraid = caraid
            dientesAfectados.cara = cara

            dientesAfectados.servicio = obtenerServicio(servicio);
            dientesAfectados.categoria = tratamiento;
            let servicioNombre = dientesAfectados.servicio.Nombre
            asignarvalores(id,cara,tratamiento,servicioNombre)
            $("#modaltramiento").modal({backdrop: 'static', keyboard: false});
            $("#modaltramiento").modal("show");
        } 
   
    }

    
   engine.start();
};



engine.setObserver(observer);


// function resetDiente(id){
//    let  obs = function(id){
//         let diente = engine.getToothById(id);
//         var myImage = new Image();
//         var direccionimage = seleccionarImagen(id,"normal")
//         myImage.src = direccionimage
//         diente.image = myImage;
//     }
// }


function asignarvalores(id,cara,categoria,tratamiento){
    $("#txtpieza").val(id)
    $("#txtcara").val(cara)
    $("#txttratamiento").val(categoria)
    $("#txtservicio").val(tratamiento)
}

function asignarvaloresEditar(id,cara,categoria,tratamiento,comentario){
    $("#txteditarpieza").val(id)
    $("#txteditarcara").val(cara)
    $("#txteditartratamiento").val(categoria)
    $("#txteditarservicio").val(tratamiento)
    $("#txteditarobservacion").val(comentario)
}

function limpiarTextbox(){
    $("#txtpieza").val("");
    $("#txtcara").val("");
    $("#txttratamiento").val("");
    $("#txtservicio").val("");
    $("#txtobservacion").val("");
}

function limpiarArray(){
    let limpio = {
        id:"",
        cara:"",
        categoria:"",
        servicio:"",
        observacion:"",
    }

    return limpio

}

function QuitarClicked(){
    $(".card").removeClass("clicked");
}

function QuitarlistClicked(){
    $("li").removeClass("listcliked");
}

function obtenerServicios(numero){

    var url = "../request/lista_servicios.php?id=" + numero;
    $.ajax({
        type:"GET",
        url: url,
        success: function(data){
            $("#servicios").html(data);
        }
    });
}

function obtenerServicio(servicio){
    let datosservicio;
    var url = "../request/obtener_servicio.php?id=" + servicio;
    $.ajax({
        async:false,
        type:"GET",
        url: url,
        success: function(data){
           var obj = JSON.parse(data);
           datosservicio = obj[0];
        }
    }); 

     return datosservicio;
}


function agregarFila(obj){

    //Contamos la cantidad de filas que tiene la tabla
     var nrows = 0;
    $("#contenido tr").each(function() {
        nrows++;
    });
    let porcentaje = obj.servicio.IVA;
    let iva 
    let precio = parseFloat(obj.servicio.Precio).toFixed(2);
    if(obj.servicio.IVA != 0){
        iva =  parseFloat((obj.servicio.IVA /100) * precio).toFixed(2);
    }else{
        iva = 0.00
    }
   
    total = (parseFloat(precio) + parseFloat(iva)).toFixed(2);
    
    var tbody = $("#contenido tbody");
    let fila = "<tr id='fila"+ nrows +"'>";
    fila += "<td> <a  data-id='"+ nrows  +"' class='btn btn-success btn-raised btn-xs'><i class='zmdi zmdi-refresh'></i><div class='ripple-container'></div></a> ";
    fila += "<a data-borrar='"+ nrows  +"' class='btn btn-danger btn-raised btn-xs'><i class='zmdi zmdi-delete'></i><div class='ripple-container'></div></a> </td>";
    fila += "<td>" + obj.servicio.Nombre + "</td>";
    fila += "<td>" + obj.id + "</td>";
    fila += "<td>" + obj.cara + "</td>";
    fila += "<td> <input type='text' class='textboxprecio' id='txtprecio" + nrows + "' name='txtprecio" + nrows + "' size='16' value='"+ precio +"'>€ </td>";
    fila += "<td class='textboxprecio'><span  class='' id='txtiva"+ nrows +"'>" + iva + "€ </span><input type='hidden' id='txtivaporcentaje"+ nrows +"' value='"+ porcentaje+"'></td>";
    fila += "<td class='textboxprecio'><span  class='' id='txttotal"+ nrows +"'>" + total + "€ </span></td>";
    fila += "</tr>";

    tbody.append(fila);
}
 

function obtenerCara(id,caraid){
    cara = "";
    if(id >=11  && id <=18 ){ //arriba derecha
        let verificar = caraid.toString().indexOf("V");
        if(verificar == 3){ cara = "Vestibular" }
        verificar = caraid.toString().indexOf("0");
        if(verificar == 3){ cara = "Oclusal" }
        verificar = caraid.toString().indexOf("L");
        if(verificar == 3){ cara = "Palatino" }
        verificar = caraid.toString().indexOf("D");
        if(verificar == 3){ cara = "Mesial" }
        verificar = caraid.toString().indexOf("M");
        if(verificar == 3){ cara = "Distal" }       
    }else if(id >=21 && id <=28  ){ // arriba izquierda
        let verificar = caraid.toString().indexOf("V");
        if(verificar == 3){ cara = "Vestibular" }
        verificar = caraid.toString().indexOf("0");
        if(verificar == 3){ cara = "Oclusal" }
        verificar = caraid.toString().indexOf("L");
        if(verificar == 3){ cara = "Palatino" }
        verificar = caraid.toString().indexOf("D");
        if(verificar == 3){ cara = "Distal" }
        verificar = caraid.toString().indexOf("M");
        if(verificar == 3){ cara = "Mesial" }
    }else if(id >=31 && id <=38  ){ //abajo izquierda
        let verificar = caraid.toString().indexOf("V");
        if(verificar == 3){ cara = "Lingual" }
        verificar = caraid.toString().indexOf("0");
        if(verificar == 3){ cara = "Oclusal" }
        verificar = caraid.toString().indexOf("L");
        if(verificar == 3){ cara = "Vestibular" }
        verificar = caraid.toString().indexOf("D");
        if(verificar == 3){ cara = "Distal" }
        verificar = caraid.toString().indexOf("M");
        if(verificar == 3){ cara = "Mesial" }
    }else if(id >=41 && id <=48  ){
        let verificar = caraid.toString().indexOf("V");
        if(verificar == 3){ cara = "Lingual" }
        verificar = caraid.toString().indexOf("0");
        if(verificar == 3){ cara = "Oclusal" }
        verificar = caraid.toString().indexOf("L");
        if(verificar == 3){ cara = "Vestibular" }
        verificar = caraid.toString().indexOf("D");
        if(verificar == 3){ cara = "Mesial" }
        verificar = caraid.toString().indexOf("M");
        if(verificar == 3){ cara = "Distal" }
    }else{
        console.log("leche");
    }


   return cara;
}


function seleccionarImagen(diente,tratamiento){
    var imagendir= "";
    switch (tratamiento) {
        case "normal":
            imagendir = "../theme/odontograma/images/normales/"+ diente +".png";
        break;
        case "obturacion":
            
        break;
        case "extraccion":
            if(diente >= 11 && diente <= 28){
                imagendir = "../theme/odontograma/images/otros/extraccion-arriba-pendiente.png";
            }else{
                imagendir = "../theme/odontograma/images/otros/extraccion-abajo-pendiente.png";
            }
        break;
        case "extraccionraiz":
                imagendir = "../theme/odontograma/images/pendiente/extraccionRaiz/"+ diente +".png";
        break;
        case "corona":
            imagendir = "../theme/odontograma/images/pendiente/coronas/"+ diente +".png";
        break;
        case "endodoncia":
            imagendir = "../theme/odontograma/images/pendiente/endodoncia/"+ diente +".png";
        break;
        case "implante":
            imagendir = "../theme/odontograma/images/implanteCompleto/"+ diente +".png";
        break;
        case "munon":
            imagendir = "../theme/odontograma/images/pendiente/munon/"+ diente +".png";
        break;
        default:
            break;
    }
    return imagendir;
}




//botones


$(document.body).on("click", "a[data-codigo]", function (){
    let index = this.dataset.codigo;

        
    var url ="../request/obtener_detalle_presuspuesto.php";
        $.post(url,{ "presupuestoDetalleId" : index  }, function(data){
            let respuesta = JSON.parse(data);
            $('#txteditarobservacion').val(respuesta[0].Observacion);
            $('#txteditarpieza').val(respuesta[0].Diente);
            $('#txteditarcara').val(respuesta[0].Cara);
            $('#txteditartratamiento').val(respuesta[0].Categoria);
            $('#txteditarservicio').val(respuesta[0].Servicio);
        }); 



    $("#txtidepresupuesto").val(index);
    $("#modaleditartramiento").modal({backdrop: 'static', keyboard: false});
    $("#modaleditartramiento").modal("show");
})

$(document.body).on("click", "a[data-borrar]", function (){
    let index = this.dataset.borrar;
    $("#txtideliminar").val(index);
    $("#modaleliminartramiento").modal({backdrop: 'static', keyboard: false});
    $("#modaleliminartramiento").modal("show");
})

$(document).on('keyup', '.textboxprecio',  function(){
    this.value = this.value.replace(/[^0-9\.]/g,'');
});



$(document).on('blur', '.textboxprecio',  function(){
    var precio =   this.value;
    var index = $(this).attr('id');
    var url ="../request/editar_precio_presupuesto.php";
    $.post(url,{"detallepresupuestoid": index,"presupuestoid":presupuestoid,"precio":precio}, function(data){
        $("#tablapresupuesto").html(data);
    }); 
    
});


$('body').on('click', '#servicios li', function(){
    servicio = $(this).attr('id');
    QuitarlistClicked();
    $("#" + servicio).addClass("listcliked");
    if(tratamiento == "limpieza"|| tratamiento =="otro"){

         dientesAfectados.servicio = obtenerServicio(servicio);
         dientesAfectados.categoria = tratamiento;
         let servicioNombre = dientesAfectados.servicio.Nombre
         asignarvalores("Todos","",tratamiento,servicioNombre)
        $("#modaltramiento").modal({backdrop: 'static', keyboard: false});
        $("#modaltramiento").modal("show");
    }
})

$("#btnguardartratamiento").click(function(){
        dientesAfectados.observacion = $("#txtobservacion").val();
        dientesAfectados.presupuestoid = presupuestoid;

        var url ="../request/guardar_detalle_presupuesto.php";
        $.post(url,dientesAfectados, function(data){
            $("#tablapresupuesto").html(data);
        }); 
      
      
        limpiarTextbox();
        $("#modaltramiento").modal("hide");
    return false;
})

$("#btneditartratamiento").click(function(){
    let index = $("#txtidepresupuesto").val(); 
    let nuevaobser = $("#txteditarobservacion").val();


    var url ="../request/editar_detall_presupuesto.php";
    $.post(url,{"detallepresupuestoid": index,"observaciones":nuevaobser,"presupuestoid":presupuestoid}, function(data){
        $("#tablapresupuesto").html(data);
    }); 
   
    $("#modaleditartramiento").modal("hide");
    return false;
})

$("#btneliminartratamiento").click(function(){
    let index = $("#txtideliminar").val();
    var url ="../request/eliminar_detalle_presupuesto.php";
    $.post(url,{"detallepresupuestoid": index,"presupuestoid":presupuestoid}, function(data){
        $("#tablapresupuesto").html(data);
    }); 

    $("#modaleliminartramiento").modal("hide");
    return false;
})

$("#btnsalirtratamiento").click(function(){
        limpiarTextbox();
        $("#modaltramiento").modal("hide");
    return false;
})

$("#btnobturacion").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(1);
    tratamiento = "Obturaciòn";
})
$("#btnextraccion").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(2);
    tratamiento = "extraccion";
})
$("#btncorona").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(3);
    tratamiento ="corona";
})
$("#btnimplante").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(4);
    tratamiento ="implante";
})
$("#btnendodoncia").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(5);
    tratamiento ="endodoncia";
})
$("#btnmunon").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(6);
    tratamiento ="munon";
})
$("#btnlimpieza").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(7);
    tratamiento = "limpieza";
})

$("#btnotro").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(8);
    tratamiento = "otro";
})
$("#btnextraccionraiz").click(function(){
    QuitarClicked();
    $(this).addClass("clicked");
    obtenerServicios(9);
    tratamiento ="extraccionraiz";
})

$("#btnguardar").click(function(){
   // console.log(presupuesto);
})

$("#btnnino").click(function(){
    if(engine.adultShowing == true){
        $("#imgnino").attr("src","../public/imagenes/adulto.svg");

         engine.adultShowing = false;
         engine.mouth = engine.odontChild;
         engine.spaces = engine.odontSpacesChild;
         engine.update();
    }else{
        $("#imgnino").attr("src","../public/imagenes/nino.svg");
        engine.adultShowing = true;
        engine.mouth = engine.odontAdult;
        engine.spaces = engine.odontSpacesAdult;
        engine.update();
    }
});




  
  