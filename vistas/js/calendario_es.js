function fechaCompleta(date){
    var fecha = new Date( date);
    mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
    dia = fecha.getDate();
    if(dia <= 9){
      dia = "0" + dia;
    }
    ano = fecha.getFullYear()
    var desde =  ano  + '-' + mes  + '-' + dia ;
    return desde
}

function horaCompleta(date){
   var hora = date.getHours();
   var min = date.getMinutes();
    if(min  == 0){ min = "00"}
     if (hora <= 9){
       hora = "0" + hora;
     }
     var inicio =  hora  + ':' + min ;
     return inicio;
}

function horaFin(date,tiempo){
    var hora = date.getHours();
    var min = date.getMinutes();
    var dur = tiempo.substr(-2)
   
    var suma = (parseInt(min) + parseInt(dur));


    if(suma  == 60){ 
      suma = "00";
      hora =  parseInt(hora) + 1;
    }
    if (hora <= 9){
        hora = "0" + hora;
      }
    var fin =  hora  + ':' + suma  ;


    return fin;
}




document.addEventListener('DOMContentLoaded', function() {
        var Hinicio = document.getElementById('txtCalendarioInicio').value;
        var Hfin = document.getElementById('txtCalendarioFin').value;
        var duracion = document.getElementById('txtduracion').value;
        if(duracion <= 9){ 
            duracion = "00:0" + duracion;
         }else if(duracion >= 10 && duracion <= 59){
            duracion = "00:" + duracion;
         }else if(duracion === 60){
             duracion = "01:00";
         }else{
             duracion = "00:30";
         }
    
        var initialLocaleCode = 'es';
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        slotLabelFormat:{
            hour: 'numeric',
            minute: '2-digit',
            omitZeroMinute: false,
            meridiem: 'short'
        },
       // height: 600,
        allDaySlot:false,
        hiddenDays: diasNoMostrar,
        minTime: Hinicio, 
        maxTime: Hfin, 
        slotDuration: duracion,
        slotLabelInterval: duracion,
        defaultView: 'timeGridWeek',
        locale: initialLocaleCode,
        buttonIcons: true, 
        weekNumbers: false,
        navLinks: true, 
        editable: true,
        eventLimit: true,
        titleFormat: { 
            month: 'long',
            day: '2-digit',
        },
        titleRangeSeparator :" al ",
        eventSources: [{
            url: '../request/obtener_citas.php',
            type: 'POST',
            cache: false
        }],
        timeFormat: 'H(:mm)' ,
        dayRender: function (date, cell) {
                var fecha = new Date(date.date);
                var diaRender = fecha.getDate();
                var mesRender = fecha.getMonth() + 1;
                var yearender = fecha.getFullYear();
                Fechacal = diaRender+'/'+mesRender+'/'+yearender;
                var hoy = new Date();
                var dd = hoy.getDate();
                var mm = hoy.getMonth()+1;
                var yyyy = hoy.getFullYear();
                FechaActual =  dd+'/'+mm+'/'+yyyy;
               
                if(Fechacal == FechaActual){
                    date.el.style.borderColor ="#000"
                }
        },
        dateClick: function(date,jsEvent,view) {
            var fecha = fechaCompleta(date.date);
            $("#txtfecha").val(fecha);
            var inicio = horaCompleta(date.date);
            $("#txthorainicio").val(inicio);
            var fin = horaFin(date.date,duracion);
            $("#txthorafin").val(fin);
            $('#crear').modal('show');
        },
        eventClick: function(info) { 
            var url = "../request/obtener_una_cita.php?id=" + info.event.id ;
            $.getJSON(url,function(datos){
                $('#txtfecha_editar').val(datos.Fecha);
                $('#txthorainicio_editar').val(datos.Inicio);
                $('#txthorafin_editar').val(datos.Fin);
                $('#txtcodigo_editar').val(datos.PacienteId);
                $('#txtpaciente_editar').val(datos.Nombre);
                $('#txtcorreo_editar').val(datos.Correo);
                $('#txttelefono_editar').val(datos.Telefono);
                $('#txtcodigo_cita').val(info.event.id);
                $('#txtmotivo_editar').val(datos.Motivo); 

                if(datos.Estado == "Activo"){
                    $("#btneliminar_editar").show();
                }else{
                    $("#btneliminar_editar").hide();
                }
            })       
            $('#editar').modal('show');
        },
        eventDrop: function(date,jsEvent,view){
            let fechadrag = fechaCompleta(date.event.start);
            let iniciodrag = horaCompleta(date.event.start);
            let findrag = horaFin(date.event.end);
            var url ="../request/arrastrar_cita.php";
            $.post(url, {'id':date.event.id,'fecha':fechadrag,'inicio' :iniciodrag, 'fin':findrag}, function(data){
                if(data == 1){
                    alertify.notify('Hecho : Fecha y hora de la cita actualizados', 'success', 5, function(){  console.log('dismissed'); });
                }else{
                    alertify.notify('Error : Error al modificar la hora y la fecha', 'error', 5, function(){  console.log('dismissed'); });
                }
            }); 
            
        },
        eventResize: function(date){
            let fecharesize = fechaCompleta(date.event.start);
            let inicioresize = horaCompleta(date.event.start);
            let finresize = horaFin(date.event.end);
            var url ="../request/resize_cita.php";
            $.post(url, {'id':date.event.id,'fecha':fecharesize,'inicio' :inicioresize, 'fin':finresize}, function(data){
                if(data == 1){
                    alertify.notify('Hecho : Fecha y hora de la cita actualizados', 'success', 5, function(){  console.log('dismissed'); });
                }else{
                    alertify.notify('Error : Error al modificar la hora y la fecha', 'error', 5, function(){  console.log('dismissed'); });
                }
            }); 
         }

});

calendar.render();



});



function crearpaciente(){
    $('#crearpaciente').modal('show');
}

function seleccionarPaciente(){
    $('#seleccionarpaciente').modal('show');
}

$( document ).ready(function(){
    

    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    
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
                            $("#txtpaciente").text(nombre)
                            //limpiar
                            $('#txtnombre').val("");
                            $('#txttelefono').val("");
                            $('#txtemail').val("");
                            $('#txtnombre').val("");
                            $('#crearpaciente').modal('hide');
                      }
          });
        }
        
        return false;


    })

    $('#btnbuscar').click(function(){
        var url = "../request/busqueda_pacientes_calendario.php";
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

    $(document.body).on("click", "tr[data-id]", function (){
        let id = this.dataset.id ;
        let nombre = this.dataset.name;
        $("#txtpacienteid").val(id);
        $("#txtpaciente").text(nombre)
        $('#seleccionarpaciente').modal('hide');
    })

    $("#btnguardar").click(function(){
        if(!$('#txtpacienteid').val()){
            alertify.notify('Debe Seleccionar o crear un paciente', 'error', 5, function(){  console.log(''); });
            return false;
        }else{
            return true;
        }


    })

    $("#btneliminar_editar").click(function(){
        alertify.confirm('Eliminar Cita', 'Esta seguro que desea eliminar la cita seleccionada ?',
         function(){   
                let id = $("#txtcodigo_cita").val();

                var url = "../request/eliminar_cita.php?id=" + id ;
                $.getJSON(url,function(datos){
                    window.location.replace("calendario.php");
                    //location.reload();
                })       
                
          }
        ,function(){ 

        }).set('labels', {ok:'Aceptar', cancel:'Cancelar'});
    });


  
    
  
});
