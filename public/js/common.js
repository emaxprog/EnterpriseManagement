/**
 * Created by alexandr on 10.03.17.
 */
$(document).ready(function () {

    //CSRF защита для AJAX запросов и функции по умолчанию при успешных и ошибочных запросов
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $.gritter.add({
                title: 'Уведомление',
                text: data.content
            });
        },
        error: function (data) {
            var errors = JSON.parse(data.responseText);
            console.log(errors);
            $.each(errors, function (index, value) {
                $.gritter.add({
                    title: 'Ошибка',
                    text: value
                });
            });
        }
    });

    //AJAX запросы
    //AJAX запросы сохранения и изменения отделов и сотрудников
    $('.form').submit(function (event) {
        event.preventDefault();

        var formAction = $(this).attr('action');
        var formData = $(this).serialize();
        var formMethod = $('input[name="_method"]').attr('value') == 'PUT' ? 'PUT' : 'POST';
        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData
        });
    });

    //AJAX зпросы удаления отделов и сотрудников

    $('.btn-destroy').click(function (event) {
        event.preventDefault();

        var name = $(this).parent().siblings('td:first').html();

        if (confirm('Вы действительно хотите удалить ' + name + '?')) {
            var btnUrl = $(this).attr('href');

            var tr = $(this).parent().parent();

            $.ajax({
                type: 'DELETE',
                url: btnUrl
            }).done(function () {
                tr.remove();
            });
        }
    });

    //Валидация
    $('#employee_form').validate({
        rules: {
            name: {
                required: true
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
                required: 'Это поле обязательно для заполнения'
            }
        }
    });

    $('#department_form').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Это поле обязательно для заполнения'
            }
        }
    });
});