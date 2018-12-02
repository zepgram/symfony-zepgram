var $ = require('jquery');
'use strict';

// custom
$(document).ready(function () {
    randomColor();
    runColorCycle();
    contactForm();
    triggers();
    setBannerWidth();
    dialog('data-dialog-contact');
    dialog('data-dialog-skills');
    dialog('data-dialog-document');
    $(window).resize(function() {
        setBannerWidth();
    });
});

function setBannerWidth() {
    var nav = $('#nav').outerWidth();
    $('#banner').innerWidth(nav);
}

function triggers() {
    $('#profile').click(function() {
        $('.icon-skills').trigger('click');
    });
    $('#button3').click(function() {
        $('.icon-contact').trigger('click');
    });
}

function runColorCycle() {
    setTimeout(function () {
        randomColor();
        runColorCycle();
    }, 7000);
}

function randomColor() {
    var profile      = $('#profile'),
        banner       = $('#banner'),
        icon         = $('.container-font'),
        button       = $('button'),
        input        = $('.form-control'),
        classCycle   = [
            [0, 'color1'],
            [1, 'color2'],
            [2, 'color3'],
            [3, 'color4'],
            [4, 'color5'],
            [5, 'color6'],
            [6, 'color7'],
            [7, 'color8'],
        ],
        randomNumber = Math.floor(Math.random() * 8),
        classToAdd   = classCycle[randomNumber][1];

    if (profile.hasClass(classToAdd)) {
        if (randomNumber + 1 in classCycle) {
            classToAdd = classCycle[randomNumber + 1][1];
        } else {
            classToAdd = classCycle[randomNumber - 1][1];
        }
    }
    profile.removeClass();
    profile.addClass(classToAdd);

    banner.removeClass();
    banner.addClass(classToAdd);

    icon.removeClass();
    icon.addClass('container-font');
    icon.addClass(classToAdd + '-icon');

    button.removeClass();
    button.addClass(classToAdd + '-button');

    input.removeClass();
    input.addClass('form-control');
    input.addClass(classToAdd);
}

function dialog(selector) {
    var dlgtrigger = document.querySelector('[' + selector + ']'),
        dialog     = document.getElementById(dlgtrigger.getAttribute(selector)),
        dlg        = new DialogFx(dialog);

    dlgtrigger.addEventListener('click', dlg.toggle.bind(dlg));
    particle(selector);
}

function particle(element) {
    var canvasDiv      = document.getElementById(element),
        options        = {
            particleColor: '#ccc',
            background: '#ffffff00',
            interactive: true,
            speed: 'medium',
            density: 'high'
        },
        particleCanvas = new ParticleNetwork(canvasDiv, options);
}

function contactForm() {
    var submit_button = $('#contact_send');
    $('#contact-form').on('submit', function (e) {
        $('.response').hide(0);
        submit_button.prop('disabled',true);
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/contact',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (data) {
                submit_button.prop('disabled',false);
                $('.response.' + data.status).fadeIn(300);
                if (data.status === 'success') {
                    $('#contact button').hide(0);
                    $('#contact-form').trigger('reset');
                    setTimeout(function() {
                        $('#contact button').show(0);
                        $('.response').hide(0);
                        $('#close').trigger('click');
                    }, 5000);
                    return true;
                }
                if (data.exception !== '') {
                    console.log('exception', data.exception);
                }
                return false;
            }
        })
    });
}
