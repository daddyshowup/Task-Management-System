console.log("js file works");

$(document).ready(function(){
    // jquery for navbar toggle on small screen
    $("label").click(function(){
        $("nav div ul").toggleClass("active");
    });
    // jquery for FAQ section toggle
    $(".container .box ").click(function(){
        $(this).children('.answer').slideToggle();
        $(this).find('i').toggleClass("fa-arrow-down fa-close");
    });
});