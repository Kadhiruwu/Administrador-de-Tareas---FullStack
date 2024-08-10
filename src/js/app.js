const mobileMenuBtn = document.querySelector('#mobile-menu');
const cerrarMenuBtn = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');

if(mobileMenuBtn){
    mobileMenuBtn.addEventListener('click', function(){
        sidebar.classList.add('mostrar');  //toggle paara añadir y eliminar
    });
}

if(cerrarMenuBtn){
    cerrarMenuBtn.addEventListener('click', function(){

        sidebar.classList.add('ocultar');
        setTimeout(() => {
            sidebar.classList.remove('mostrar');
            sidebar.classList.remove('ocultar');
        }, 1000);
    })
}

//Elimina la clase de mostrar en un tamaño de tablet a mas -- 
//DESAPAREZCA EL MENU ABIERTO EN MOBILE, sin esto no aparece la barra de aptask cuando se agranda
const anchoPantalla = document.body.clientWidth;
window.addEventListener('resize', function(){
    const anchoPantalla = document.body.clientWidth;
    if(anchoPantalla >= 768){
        sidebar.classList.remove('mostrar');
    }
})