document.addEventListener('DOMContentLoaded', function() {
    const enlaces = document.querySelectorAll('.navDashBoard a[data-target]');
    
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('data-target');
            const targetSlide = document.getElementById(targetId);
            if (targetSlide) {
                targetSlide.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

var navItems = $('.navDashBoardContainer');
var selector = $('.navDashBoardContainer').find('a').length;
var activeItem = navItems.find('.active');


$(".navDashBoardContainer").on("click","a",function(e){
  e.preventDefault();
  $('.navDashBoardContainer a').removeClass("active");
  $(this).addClass('active');
});

//Boton de borrar
// Selecciona todos los botones de eliminar por su clase
var botonesBorrar = document.querySelectorAll('.borrar');

// Itera sobre los botones y agrega un controlador de eventos
botonesBorrar.forEach(function(boton) {
    boton.addEventListener('click', function(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado del enlace

        // Obtiene el ID del elemento a eliminar del atributo data-id
        var elementoId = this.getAttribute('data-id');

        // Rellena el campo de input del formulario con el ID del elemento a eliminar
        document.getElementById('elementoIdInput').value = elementoId;

        // Muestra el modal de confirmación
        // Muestra el modal de confirmación usando Bootstrap
         var modal = new bootstrap.Modal(document.getElementById('confirmarEliminar'));
         modal.show();
    });
});

// Función para cerrar el modal de confirmación
function cerrarModal() {
    var modal = new bootstrap.Modal(document.getElementById('confirmarEliminar'));
    modal.hide();
}
//Fin boton borrar

/*Boton agregar reforma*/
// Selecciona todos los botones de eliminar por su clase
var botonAgregar = document.querySelectorAll('.aniadirElementoButtonContainer');

// Itera sobre los botones y agrega un controlador de eventos
botonAgregar.forEach(function(boton) {
    boton.addEventListener('click', function(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado del enlace
        
        // Muestra el modal de confirmación
        var modal = new bootstrap.Modal(document.getElementById('formularioAgregar'));
         modal.show();
    });
});

// Función para cerrar el modal de confirmación
function cerrarModalAgregar() {
    document.getElementById('formularioAgregar').style.display = 'none';
}

/*FIN boton agregar reforma*/