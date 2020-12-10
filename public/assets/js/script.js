// alert("Le JS fonctionne bien");

//Détecter s'il y a du scroll 
//Si la hauteur de la page est plus grande que la hauteur de la fenetre (s'il y a du scroll)
if ($(document).height() <= $(window).height()) {
    //on va retirer la classe sticky to bottom s'il y a du scroll
    $('footer').addClass('sticky-to-bottom');
}

//on doit exécuter le code précédent au resize de la fenêtre
$(window).resize(function (){
    if ($(document).height() <= $(window).height()) {
        $('footer').addClass('sticky-to-bottom');
    } else {
        $('footer').removeClass('sticky-to-bottom');
    }
})