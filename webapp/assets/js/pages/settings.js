$(document).ready(function () {
    const modal = $('#editRuleModal');

    if (location.origin.indexOf('home-app') !== -1) {
        var app_link = location.origin;
    }
    else {
        var app_link = location.origin + '/home-app';
    }

    $('body').on('click', '.btn-delete-rule', function () {
        const rule_id = $(this).closest('.options').data('id');
        const row = $(this).closest('tr');

        $.ajax({
            url: app_link + "/index.php/api/rules/delete_rule",
            type: "POST",
            data: {
                rule_id: rule_id
            },
            success: function (data) {
                row.remove();
            }
        });
    });

    $('body').on('click', '.btn-save-rule', function () {
        const data = $("#scheduleForm").serializeArray();

        console.log(data);

        /*$.ajax({
            url: app_link + "/index.php/api/rooms/save_schedule",
            type: "POST",
            data: {
                form_data: data
            },
            success: function (data) {
                // modal.modal('hide');
                // window.location.reload();
            }
        });*/
    });

    $('body').on('click', '.day-selection', function () {
        const day_selected = $(this).data('day');

        $(this).closest('.day-selection-container').find('.active').removeClass('active');
        $(this).addClass('active');
        $('.day-rules-container.active').removeClass('active');
        $('#day-' + day_selected).addClass('active');
    });

    $('body').on('click', '.btn-add-rule-schedule', function () {
        const day_selected = $(this).data('day');
        const num_schedules = $(this).closest('.day-rules-container').find('.rule-schedule').length;

        $.ajax({
            url: app_link + "/index.php/api/rules/get_rule_schedule_form",
            type: "GET",
            data: {
                day: day_selected,
                num: num_schedules
            },
            success: function (data) {
                $('#day-' + day_selected).append(data);
            }
        });
    });

    $('body').on('click', '.btn-delete-rule-schedule', function () {
        $(this).closest('.rule-schedule').remove();
    });
});