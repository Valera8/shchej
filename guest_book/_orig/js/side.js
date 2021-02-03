//demo
$('body').on('click','.header__Logo,.footer__logo',function(e){
    e.preventDefault();
    toastr["warning"]('Вернёмся на гипотетически существующую страницу');
    return false;
});

//common
function show__Err(msg){
    if(msg != undefined){
        toastr["warning"](msg);
    }else{
        toastr["warning"]('Что-то пошло не так');
    }
    return false;
}
$('body').on('mouseover','#toast-container',function () {
    $(this).remove();
})

//valid
$('body').on('input','#name',function () {
    check__name($(this));
});
$('body').on('input','#email',function(){
    check__email( $(this) );
});
$('body').on('input','#comment',function () {
    check__comment( $(this) );
});
$('body').on('click','#btnSend',function () {
    Sender();
});


//checks
function Sender() {
    var fields = {
        name : '#name',
        email : '#email',
        comment : '#comment'
    };
    var err = [];
    for(var i in fields){
        if(eval('check__'+i+'($("body").find("'+fields[i]+'"))') == false){
            err.push(i);
        }
    }
    if(err.length > 0){
        toastr['error']('Вы не заполнили форму!');
    }else{
        var data = [];
        for(var i in fields){
            data[i] = $( fields[i]).val()
        }
        $.ajax({
            url: window.location.protocol+'//'+window.location.host+'/add',
            type: 'post',
            data: {
                name : data['name'],
                email : data['email'],
                comment : data['comment'],
            },
            success: function (data) {
                data = jQuery.parseJSON(data);
                err = true
                if(data != false){
                    if(data.status != undefined && data.body != undefined){
                        err = false;
                        draw__Init({
                            fields : fields,
                            data: data.body
                        });
                    }
                }
                if(err){
                    show__Err('Сохранение комментария завершилось неудачей.');
                }
            },
            error : function (data){
                show__Err('Ошибка на стороне сервера.');
            }
        });
    }
    return false;
}
function check__comment(obj) {
    try{
        if(obj != undefined){
            if(obj.val().length < 3){
                obj.attr('title','Поле комментарий должно содержать от 3 символов');
                $('#comment__req').css('color','#be393b');
                obj.css('border','1px solid #743538');
            }else{
                obj.attr('title','Ваш комментарий');
                $('#comment__req').css('color','#58AD52');
                obj.css('border','1px solid #58AD52');
                return true
            }
        }
    }catch(e){
        show__Err('Проблемы с валидацией комментария');
    }
    return false;
}
function check__name(obj) {
    try{
        if(obj != undefined){
            var pattern=/[^A-ZА-ЯЁ ]/i;
            if(pattern.test($.trim(obj.val())) === true){
                toastr['warning']('Будьте внимательны, вводимое значение не похоже на имя');
            }
            obj.val( obj.val().replace(pattern,''));
            if(obj.val().length >= 3 && obj.val().length < 21){
                obj.attr('title','Ваше имя');
                $('#name__req').css('color','#58AD52');
                obj.css('border','1px solid #58AD52');
                return true;
            }else{
                obj.attr('title','Ваше имя от 3ёх до 20 символов');
                $('#name__req').css('color','#be393b');
                obj.css('border','1px solid #743538');
            }
        }
    }catch(e){
        show__Err('Проблемы с валидацией имени');
    }
    return false;
}
function check__email(obj) {
    try{
        if(obj != undefined){
            var emailReg = /^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,10}$/i;
            if( emailReg.test( obj.val() ) ? true : false === true){
                if(obj.val().length >= 7 && obj.val().length <= 128 ){
                    obj.css('border','1px solid #58AD52');
                    obj.attr('title','Ваш E-mail');
                    $('#email__req').css('color','#58AD52');
                    return true;
                }
            }else{
                if(obj.val().length > 7){
                    toastr['warning']('Будьте внимательны, вводимое значение не похоже на E-mail');
                }
                obj.attr('title','Ваш E-mail от 7 до 128 символов');
                $('#email__req').css('color','#be393b');
                obj.css('border','1px solid #743538');
            }
        }
    }catch(e){
        show__Err('Проблемы с валидацией почты');
    }
    return false;
}

//clear
function clear__Fields_All(fields){
    try{
        if(fields != undefined){
            for(var i in fields){
                obj = $(fields[i]);
                if(obj.length > 0){
                    obj.val('');
                    obj.css('border','1px solid #743538');
                    //label
                    $(fields[i]+'__req').css('color','#be393b');
                }
            }
        }
    }catch(e){
        show__Err('Очистка полей формы завершилась неудачей.');
    }
    return false;
}

//draw
function draw__Init(data) {
    try{
        draw__Empry_St(false);
        clear__Fields_All(data.fields);
        var nodes = {
            wrapper : $('#S_Wrapper'),
            elemets : {
                first : false,
            }
        }
        if(nodes.wrapper.length === 1){
            //color
            var color = 'comments__Item_Dark';
            nodes.elemets.first = nodes.wrapper.children().first();
            if(nodes.elemets.first.length === 1){
                if(nodes.elemets.first.hasClass( color )){
                    color = 'comments__Item_Lite';
                }
            }
            //create
            var newCol = '<div class="comments__Item '+color+' col-md-4">' +
                    '<div class="comments__ItemHeader">'+data.data['name']+'</div>' +
                    '<div class="comments__ItemContain">' +
                        '<div class="comments__ItemEmail">'+data.data['email']+'</div>' +
                        '<div class="comments__ItemMsg">'+data.data['comment']+'</div>' +
                    '</div>' +
                    '</div>' +
                '</div>';
            //insert
            nodes.wrapper.prepend(newCol);
            //scroll
            $("body,html").animate({
                scrollTop: nodes.wrapper.offset().top - 150
            }, 800);
        }else{
            show__Err('Ошибка инициализации контейнера.');
        }
    }catch(e){
        show__Err('В процессе отображения нового комментария возникла ошибка.');
    }
    return false;
}

function draw__Empry_St(status) {
    try{
        if(status != undefined){
            var nodes = {
                wrapper : $('#S_Wrapper'),
                emptyStr : $('body').find('#S_Empty')
            };
            if(status == true){
                if(nodes.wrapper.length === 1){
                    nodes.wrapper.html('<div id="S_Empty" class="alert alert-warning">Оставьте комментарий первым.</div>');
                }
            }else{
                if(nodes.emptyStr.length === 1){
                    nodes.emptyStr.fadeOut('slow');
                    nodes.emptyStr.remove();
                }
            }
        }
    }catch(e){
        show__Err('Инициализация узла завершилась неудачей.');
    }
    return false;
}