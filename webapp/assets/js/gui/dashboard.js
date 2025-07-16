$(document).ready(function () {
    loadRooms();
    loadRoof();
    loadDateTime();
    
    checkNightMode();

    // auto reload
    setInterval(checkNightMode, 60000);
    setInterval(loadRooms, 2500);
    setInterval(loadRoof, 15000);
    setInterval(loadDateTime, 15000);

    $('.button-minus').on('click',function () {
        var $input = $(this).parent().find('.quantity-field');
        var count = parseInt($input.val()) - 1;

        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });

    $('.button-plus').on('click', function () {
        var $input = $(this).parent().find('.quantity-field');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
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

function loadRooms() {
    if(location.origin.indexOf('home-app') !== -1){
        var app_link = location.origin;
    }
    else {
        var app_link = location.origin + '/home-app';
    }
    
    $.ajax({
        url: app_link + "/index.php/api/rooms/get_rooms",
        type: "GET",
        success: function (data) {
            $.get(app_link + '/assets/gui/dashboard.mst', function (template) {
                var compiled = Handlebars.compile(template);
                $('.rooms-container').html(compiled(data));
            });
        }
    });
}

function loadRoof() {
    if(location.origin.indexOf('home-app') !== -1){
        var app_link = location.origin;
    }
    else {
        var app_link = location.origin + '/home-app';
    }
    
    $.ajax({
        url: app_link + "/index.php/api/rooms/get_roof",
        type: "GET",
        success: function (data) {
            $.get(app_link + '/assets/gui/roof_temp.mst', function (template) {
                var compiled = Handlebars.compile(template);
                $('#roofTemp').html(compiled(data));
            });
        }
    });
}

function loadDateTime() {
    if(location.origin.indexOf('home-app') !== -1){
        var app_link = location.origin;
    }
    else {
        var app_link = location.origin + '/home-app';
    }
    
    $.ajax({
        url: app_link + "/index.php/home/get_date_time",
        type: "GET",
        success: function (data) {
            $('#currentDateTime').html(data);
        }
    });
}