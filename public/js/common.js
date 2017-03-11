/**
 * Created by alexandr on 10.03.17.
 */
$(document).ready(function () {
    //Управление отделами
    $('#department_form').validate({
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: {
                required: 'Это поле обязательно для заполнения'
            }
        }
    });

    $('.form').submit(function (event) {
        event.preventDefault();

        var formAction = $(this).attr('action');
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: formAction,
            data: formData,
            success: function (data) {
                $.gritter.add({
                    title: 'Уведомление',
                    text: data
                });
            },
            error: function (data) {
                var errors = JSON.parse(data.responseText);
                console.log(errors);
                $.each(errors, function (index, value) {
                    $.gritter.add({
                        title: 'Уведомление',
                        text: value
                    });
                });
            }
        });
    });

    //Управление сотрудниками

    $('#employee_form').validate({
        rules: {
            name: {
                required: true,
            },
            surname: {
                required: true
            },
            salary: {
                required: true,
                number: true
            },
            'departments[]': {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Это поле обязательно для заполнения'
            },
            surname: {
                required: 'Это поле обязательно для заполнения'
            },
            salary: {
                required: 'Это поле обязательно для заполнения',
                number: 'Это поле должно быть целым числом'
            },
            'departments[]': {
                required: 'Это поле обязательно для заполнения',
            }
        }
    });
});