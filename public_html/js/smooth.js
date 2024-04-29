$( () => {
	//Cabecera
	window.addEventListener('scroll', function() {
		var cabecera = document.getElementById('miCabecera');
		if (window.pageYOffset > 0) {
		  cabecera.classList.add('cabecera-sombreada');
		} else {
		  cabecera.classList.remove('cabecera-sombreada');
		}
	  });

	  /*(e) => {
		e.target.scrollTop > 30
		 ? header.classList.add("header-shadow")
		 : header.classList.remove("header-shadow");*/
	  


	//Smooth Scrolling Using Navigation Menu
	$('a[href*="#"]').on('click', function(e){
		$('html,body').animate({
			scrollTop: $($(this).attr('href')).offset().top
		},500);
		e.preventDefault();
	});
	//Cable grua
	

	  /*window.addEventListener('scroll', function(){
		const scrollPosition = window.scrollY;
		if (scroll >= 50) {
			
			document.querySelector('.left').addClass("hide");
			document.querySelector('.left').classList.add('hide')
			document.querySelector('.center').classList.remove('hide');
		  } else {
			document.querySelector('.left:first-of-type').classList.remove('hide');
			document.querySelector('.left:nth-of-type(2)').classList.remove('hide');
			document.querySelector('.center').classList.add('hide');
		  }
	  });*/
	
	/*----------------------------------------------------*/
/* NavBar Effect
------------------------------------------------------ */

var navItems = $('.nav-items');
var selector = $('.nav-items').find('a').length;
var activeItem = navItems.find('.active');
var activeWidth = activeItem.outerWidth();
$(".selector").css({
  "left": activeItem.position.left + "px", 
  "width": activeWidth + "px"
});

$(".nav-items").on("click","a",function(e){
  e.preventDefault();
  $('.nav-items a').removeClass("active");
  $(this).addClass('active');
  var activeWidth = $(this).outerWidth();
  var itemPos = $(this).position();
  $(".selector").css({
    "left":itemPos.left + "px", 
    "width": activeWidth + "px"
  });

});

/*
function detectSectionTop(sectionSelector) {
	const section = document.querySelector(sectionSelector);
	const sectionTop = section.offsetTop;
	const windowHeight = window.innerHeight;
  
	window.addEventListener('scroll', () => {
	  const scrollY = window.scrollY || window.pageYOffset;
	  if (scrollY >= sectionTop && scrollY < sectionTop + windowHeight) {
		console.log(`He llegado a la sección ${sectionSelector}`);
		if(sectionSelector === "#aboutus"){
			console.log('Hola pringado')

		}

		if(sectionSelector === "#works"){
			console.log('Hola PAMPLINAS')

		}
		if(sectionSelector === "#home"){
			console.log('Hola FUNCIONA')

		}
	  }
	});
  }
  
  detectSectionTop('#home');
  detectSectionTop('#aboutus');
  detectSectionTop('#works');

/*----------------------------------------------------*/
/* Quote Loop
------------------------------------------------------ */

/*function fade($ele) {
    $ele.fadeIn(1000).delay(3000).fadeOut(1000, function() {
        var $next = $(this).next('.quote');
        fade($next.length > 0 ? $next : $(this).parent().children().first());
   });
}
fade($('.quoteLoop > .quote').first());
/*jQuery(document).ready(function($) {

	$('.smoothscroll').on('click',function (e) {
		 e.preventDefault();
 
		 var target = this.hash,
		 $target = $(target);
 
		 $('html, body').stop().animate({
			 'scrollTop': $target.offset().top
		 }, 800, 'swing', function () {
			 window.location.hash = target;
		 });
	 });
   
 });*/
 
 
 TweenMax.staggerFrom(".heading", 0.8, {opacity: 0, y: 20, delay: 0.2}, 0.4);


 /*Efecto carrusel*/

  

//Aparecen las cosas desde abajo
function aparecerElementos() {
	var elementos = document.querySelectorAll('*');
	elementos.forEach(function(elemento) {
	  var rect = elemento.getBoundingClientRect();
	  if (rect.top < window.innerHeight && rect.bottom >= 0) {
		elemento.classList.add('aparece');
	  }
	});
  }
  
  window.addEventListener('scroll', aparecerElementos);
  window.addEventListener('resize', aparecerElementos);
  window.addEventListener('load', aparecerElementos);

  // expandir works
  let panelsElement = document.querySelectorAll('.panel');
  
  let removeActiveClasses = () => {
	panelsElement.forEach(panel =>{
		panel.classList.remove('grande');
	});
  };

  panelsElement.forEach(panel => {
	panel.addEventListener('click', () => {
		removeActiveClasses();
		panel.classList.add('grande');
	});
  });
  

  //Mostrar descripciones
  	const descripciones = document.querySelectorAll('.panelInfo');
	const imagenes = document.querySelectorAll('.panel');
	imagenes.forEach((panel, index) => {
		panel.addEventListener('click', () => {
		// Ocultamos todas las descripciones
			descripciones.forEach(panelInfo => {
				panelInfo.style.display = 'none';
			});

			// Mostramos la descripción correspondiente a la imagen clicada
			descripciones[index].style.display = 'block';
		});
	});

});

