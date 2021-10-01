/**
 * Created by mmoweb on 15.10.2017.
 */
function type(value) {
    var regex = /^\[object (\S+?)\]$/;
    var matches = Object.prototype.toString.call(value).match(regex) || [];
    return (matches[1] || 'undefined').toLowerCase();
}

window.auth_ulogin = function (token) {
    send_ajax('module_form=Modules%5CGlobals%5CSignIn%5CSignIn&module=signin_social&token=' + token, true);
};

(function ($) {
    $.fn.serializefiles = function () {
        var obj = $(this);
        /* ADD FILE TO PARAM AJAX */

        var formData = new FormData();
        $.each($(obj).find("input[type='file']"), function (i, tag) {
            $.each($(tag)[0].files, function (i, file) {
                formData.append(tag.name, file);
            });
        });
        var params = $(obj).serializeArray();
        $.each(params, function (i, val) {
            formData.append(val.name, val.value);
        });
        return formData;
    };
})(jQuery);

$(document).ready(function () {
    /*
        .submit-btn - class btn
        atribut - data-post="get_param"
        atribut - data-action="url"
        atribut - data-method="POST or GET"
     */
    $('body').on('click', '.submit-btn, .submit-form', function (e) {
        e.preventDefault();
        var el = $(this);
        var post = el.data('post') || $(el).parents('form').serializefiles();
        var response_loc = el.parents('form').attr('name');
        var action = el.data('action') || el.parents('form').attr('action') || "/input";
        var method = el.parents('form').attr('method') || "POST";
        var elBlock = jQuery(e.currentTarget).closest('.block');
        var contentType = false;
        var processData = false;

        if (typeof post === 'string' || post instanceof String) {
            contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
            processData = true;
        }

        $.ajax({
            url: action,
            data: post,
            type: method,
            cache: false,
            dataType: 'json',
            contentType: contentType,
            processData: processData,
            beforeSend: function beforeSend() {
                el.attr("disabled", "disabled");
                jQuery('#page-header-loader').addClass('show');

                if (elBlock.length) {
                    elBlock.toggleClass('block-mode-loading');
                }
            },
            error: function error(xhr, ajaxOptions, thrownError) {
                $('.ci-logs').append("<p>Result : " + xhr.responseText + "</p>");
                console.log("Result : " + xhr.responseText);
                el.removeAttr("disabled");
                jQuery('#page-header-loader').removeClass('show');

                if (elBlock.length) {
                    elBlock.removeClass('block-mode-loading');
                }
            }
        }).done(function (response) {
            if (response.text !== undefined) {
                if (response.input !== undefined) {
                    $.each(response.input, function (name, text) {
                        response.text += '<br>' + text;
                    });
                }

                jQuery.notify({
                    icon: response.icon || '',
                    message: response.text,
                    url: response.url || ''
                }, {
                    element: 'body',
                    type: response.status || 'info',
                    allow_dismiss: true,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 10000,
                    delay: response.time_show || 5000,
                    timer: 1000,
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOutDown'
                    }
                });
            }

            if (response.popup !== undefined) {
                $('.modal-ajax-title').html('');
                $('.modal-ajax-content').html('');
                $('.modal-ajax-footer').html('');
                $('.modal-ajax-title').html(response.title);
                $('.modal-ajax-content').html(response.content);
                $('.modal-ajax-footer').html(response.footer);

                if (response.size !== undefined) {
                    $('#modal-ajax>.modal-dialog').removeClass('modal-sm modal-lg modal-xl').addClass(response.size);
                } else {
                    $('#modal-ajax>.modal-dialog').removeClass('modal-sm modal-lg modal-xl');
                }

                jQuery('#modal-ajax').modal('show');
            }

            if (response.input !== undefined) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                $.each(response.input, function (name, text) {
                    var inp = $(":input[name*='" + name + "']").addClass("is-invalid").closest('div');

                    if (inp.hasClass('input-group') == false) {
                        inp.append('<div class="invalid-feedback">' + text + '</div>');
                    }
                });
            } else {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
            }

            if (response.html !== undefined) {
                if (response.html_div !== undefined) {
                    if ($(response.html_div).is("input")) $(response.html_div).val(response.html);else $(response.html_div).html(response.html);
                } else if (response_loc !== undefined) {
                    $('.show_' + response_loc).html(response.html);
                }
            }

            if (response.location && response.post) {
                const form = document.createElement('form');
                form.action = response.location;
                form.method = 'post';

                for (const key in response.post) {
                    if (response.post.hasOwnProperty(key)) {
                        const hiddenField = document.createElement('input');
                        hiddenField.type = 'hidden';

                        if (type(response.post[key]) == "object") {
                            for (const __key in response.post[key]) {
                                hiddenField.name = key + '[]';
                                hiddenField.value = response.post[key][__key];
                            }
                        } else {
                            hiddenField.name = key;
                            hiddenField.value = response.post[key];
                        }

                        form.appendChild(hiddenField);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            } else if (response.location) {
                setTimeout(() => {
                    document.location.href = response.location;
                }, response.time_sleep);
            }

            if (response.eval) {
                jQuery.globalEval(response.eval);
            }

            if (response.select_set) {
                $(response.select_el).empty();
                $.each(response.select_set, function (key, option) {
                    $(response.select_el).append($('<option></option>').attr('value', option.value).text(option.name));
                });
            }

            if (response.callback) {
                eval(response.callback)(response.data);
            }
        }).always(function () {
            setTimeout(function () {
                el.removeAttr("disabled");

                if (elBlock.length) {
                    elBlock.removeClass('block-mode-loading');
                }

                jQuery('#page-header-loader').removeClass('show');
            }, 500);
        });
    });
    $('body').on("change", '#change_lang', function () {
        document.location.href = this.value;
    });
});

window.send_ajax = function (data, async) {
    return $.ajax({
        url: "/input",
        data: data,
        type: "POST",
        cache: false,
        dataType: 'json',
        async: async,
        beforeSend: function beforeSend() {
            jQuery('#page-header-loader').addClass('show');
        },
        error: function error(xhr, ajaxOptions, thrownError) {
            console.log("Result : " + xhr.responseText);
            jQuery('#page-header-loader').removeClass('show');
        }
    }).done(function (response) {
        if (response.text !== undefined) {
            jQuery.notify({
                icon: response.icon || '',
                message: response.text,
                url: response.url || ''
            }, {
                element: 'body',
                type: response.status || 'info',
                allow_dismiss: true,
                newest_on_top: true,
                showProgressbar: false,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                offset: 20,
                spacing: 10,
                z_index: 10000,
                delay: response.time_show || 5000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOutDown'
                }
            });
        }

        if (response.popup !== undefined) {
            $('.modal-ajax-title').html('');
            $('.modal-ajax-content').html('');
            $('.modal-ajax-footer').html('');
            $('.modal-ajax-title').html(response.title);
            $('.modal-ajax-content').html(response.content);
            $('.modal-ajax-footer').html(response.footer);

            if (response.size !== undefined) {
                $('#modal-ajax>.modal-dialog').removeClass('modal-sm modal-lg modal-xl').addClass(response.size);
            } else {
                $('#modal-ajax>.modal-dialog').removeClass('modal-sm modal-lg modal-xl');
            }

            jQuery('#modal-ajax').modal('show');
        }

        if (response.html !== undefined) {
            if (response.html_div !== undefined) {
                $(response.html_div).html(response.html);
            }
        }

        if (response.location && response.post) {
            const form = document.createElement('form');
            form.action = response.location;
            form.method = 'post';

            for (const key in response.post) {
                if (response.post.hasOwnProperty(key)) {
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';

                    if (type(response.post[key]) == "object") {
                        for (const __key in response.post[key]) {
                            hiddenField.name = key + '[]';
                            hiddenField.value = response.post[key][__key];
                        }
                    } else {
                        hiddenField.name = key;
                        hiddenField.value = response.post[key];
                    }

                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        } else if (response.location) {
            setTimeout(() => {
                document.location.href = response.location;
            }, response.time_sleep);
        }

        if (response.eval) {
            jQuery.globalEval(response.eval);
        }

        if (response.select_set) {
            $(response.select_el).empty();
            $.each(response.select_set, function (key, option) {
                $(response.select_el).append($('<option></option>').attr('value', option.value).text(option.name));
            });
        }

        if (response.callback) {
            eval(response.callback)(response.data);
        }

        jQuery('#page-header-loader').removeClass('show');
    });
};