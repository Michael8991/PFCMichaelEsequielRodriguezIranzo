$( () =>{
	$(".slider-nav").on("click","a",function(e){
		$('.slider-nav a').removeClass("visor");
		$(this).addClass('visor');
	});

	// Obtén una referencia al botón
	const botonAtras = document.getElementById("backButton");

	// Agrega un controlador de eventos al botón para retroceder en la historia
	botonAtras.addEventListener("click", function () {
		window.history.back();
	});

})
