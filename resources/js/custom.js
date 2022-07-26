$(document).ready(function () {

    var $body = $('body');

    var width = $('.image-background').width();
    $('.image-background').height(width);

    var width_ = 0;
    $('header ul li').each(function () {
        width_ += $(this).width();
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });

    $("#feedback [name=phone]").mask('999-999-99-99');

    $body.on('submit', '#feedback form', function (event) {
        event.preventDefault()

        let $form = $(this)
        let data = $form.serializeJSON()

        $form.find('button').attr('disabled', true)

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: data,
            success() {
                $form.trigger('reset')
                $('#feedback').modal('hide')
                $form.find('button').attr('disabled', false)
                swal({
                    type: 'success',
                    title: 'Успешно!',
                    text: 'Ваше сообщение успешно отправлено! <br> Ждите звонка менеджера!',
                    html: true
                })
            },
            error() {
                swal('Ошибка!', 'Ваше сообщение не отправлено!', 'error')
                $form.find('button').attr('disabled', false)
            }
        })
    })

    $body.on('submit', 'form#search', function (event) {
        event.preventDefault();
        window.location.href = '/search/' + $(this).find('input').val();
    });

    $('input').attr('autocomplete', 'off');
});