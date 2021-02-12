var contadorAfk = 0;
$(document).ready(function () {
    //Cada minuto se lanza la función ctrlTiempo
    var contadorAfk = setInterval(ctrlTiempo, 120000); 

    //Si el usuario mueve el ratón cambiamos la variable a 0.
    $(this).mousemove(function (e) {
        contadorAfk = 0;
    });
    //Si el usuario presiona alguna tecla cambiamos la variable a 0.
    $(this).keypress(function (e) {
        contadorAfk = 0;
    });
});

function ctrlTiempo() {
    //Se aumenta en 1 la variable.
    contadorAfk++;
    //Se comprueba si ha pasado del tiempo que designemos.
    if (contadorAfk > 6) { // Más de 12 minutos, lo detectamos como ausente o inactivo.
        window.location.href = "calendario.php";
    }
}
