const prioridadAlta = document.querySelectorAll('.prioridad-Alta');

prioridadAlta.forEach(elemento=>{
   elemento.innerHTML = `<i class="fa-solid fa-angles-up me-1"></i></i>Alta` 
});
const prioridadMedia = document.querySelectorAll('.prioridad-Media');

prioridadMedia.forEach(elemento=>{
   elemento.innerHTML = `<i class="fa-solid fa-angle-up me-1"></i>Media` 
});
const prioridadBaja = document.querySelectorAll('.prioridad-Baja');

prioridadBaja.forEach(elemento=>{
   elemento.innerHTML = `<i class="fa-solid fa-angle-down me-1"></i>Baja`
});