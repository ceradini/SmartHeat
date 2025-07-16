$(document).ready(function () {
    checkNightMode();

    // auto reload
    setInterval(checkNightMode, 60000);
    setInterval(function () {
        document.getElementById("weatherIFrame").src += "";
    }, 900000);
});

function checkNightMode() {
    const d = new Date();

    if((d.getHours() >= 21 || d.getHours() < 7) && !$('.body').hasClass('body-night')){
        $('.body').addClass('body-night');
        $('.sidebar').removeClass('bg-light');
        $('.sidebar').addClass('bg-dark');
    }

    if(d.getHours() < 21 && d.getHours() >= 7 && $('.body').hasClass('body-night')){
        $('.body').removeClass('body-night');
        $('.sidebar').addClass('bg-light');
        $('.sidebar').removeClass('bg-dark');
    }
}