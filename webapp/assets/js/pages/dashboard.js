$(document).ready(function () {
    var room_id = false;
    var room_mode = 'manual';
    var modal_manual_settings = $('#modalManualSettings');
    var model_room = $('#modalRoom');
    
    if (location.origin.indexOf('home-app') !== -1) {
        var app_link = location.origin;
    }
    else {
        var app_link = location.origin + '/home-app';
    }

    $('body').on('click', ".room-box", function () {
        room_id = $(this).data('room_id');

        $.ajax({
            url: app_link + "/index.php/api/rooms/get_room",
            type: "GET",
            data: {
                room_id: room_id,          
            },
            success: function () {
                model_room.modal('show');
            }
        });
        
    });

    $('body').on('click', "#manual-tab", function () {
        room_mode = 'manual';
    });

    $('body').on('click', "#rule-tab", function () {
        room_mode = 'rule';
    });

    $('body').on('click', ".quick-duration", function () {
        console.log($(this).closest('.row'))
        $(this).closest('.modal').find('.manual-duration').val($(this).val());
    });

    $('body').on('click', "#btnConfirmRoomMode", function () {
        if(room_mode == 'rule'){
            const rule_id = $('#ruleSelect').val();

            $.ajax({
                url: app_link + "/index.php/api/rooms/up_mode",
                type: "POST",
                data: {
                    mode: 'rule',
                    room_id: room_id,
                    rule_id: rule_id                    
                },
                success: function () {
                    loadRooms();
                    model_room.modal('hide');
                }
            });
        }
        else {
            var duration = model_room.find('.manual-duration').val();
            const temp = model_room.find('.temp').val();

            if(duration == 0){
                duration = 'inf';
            }

            $.ajax({
                url: app_link + "/index.php/api/rooms/up_mode",
                type: "POST",
                data: {
                    mode: 'manual',
                    room_id: room_id,
                    duration: duration,
                    temp: temp                    
                },
                success: function () {
                    loadRooms();
                    model_room.modal('hide');
                }
            });           
        }
    });

    $('body').on('click', ".room-box .btn-circle", function (e) {
        e.stopPropagation();
    });

    $('body').on('click', ".btn-save-room-settings", function () {
        var form = $('#roomSettingsForm');

        var temp_min = form.find('#temp_min').val();
        var temp_max = form.find('#temp_max').val();

        $.ajax({
            url: app_link + "/index.php/home/save_room_settings",
            type: "POST",
            data: {
                room_id: room_id,
                temp_min: temp_min,
                temp_max: temp_max,
            },
            success: function (data) {
                $('#modalRoomSettings').modal('hide');
            }
        });
    });

    $('body').on('click', '.btn-status-manual-all', function () {
        modal_manual_settings.modal('show');
    });

    $('body').on('click', '.btn-status-manual', function () {
        room_id = $(this).data('room');
        modal_manual_settings.modal('show');
    });

    $('body').on('click', '#btnConfirmManualSettings', function () {
        var duration = modal_manual_settings.find('.manual-duration').val();
        const temp = modal_manual_settings.find('.temp').val();

        if(duration == 0){
            duration = 'inf';
        }

        if(room_id){
            $.ajax({
                url: app_link + "/index.php/api/general/up_state_manual",
                type: "POST",
                data: {
                    room_id: room_id,
                    state: '1',
                    duration: duration,
                    temp: temp
                },
                success: function () {
                    loadRooms();
                    modal_manual_settings.modal('hide');
                }
            });

            room_id = false;
        }
        else {
            $.ajax({
                url: app_link + "/index.php/api/general/up_state_manual_all",
                type: "POST",
                data: {
                    state: '1',
                    duration: duration,
                    temp: temp
                },
                success: function () {
                    // loadManualTimeLeft();
                    loadRooms();
                    modal_manual_settings.modal('hide');
                }
            });
        } 
    });

    $('body').on('change', '#switchGeneralStatus', function () {
        const status = $(this).is(':checked') ? '1' : '0';

        if(status == '1'){
            $('#globalSwitchOn').removeClass('off');
            $('#globalSwitchOff').addClass('off');
        }
        else {
            $('#globalSwitchOff').removeClass('off');
            $('#globalSwitchOn').addClass('off');
        }

        $.ajax({
            url: app_link + "/index.php/api/general/up_global_state",
            type: "POST",
            data: {
                state: status
            }
        });
    });
});