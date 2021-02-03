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

        /*get $.ajax({
            url: window.location.protocol+'//'+window.location.host+'/add',
            type: 'get',
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
                    console.info(err);
                    show__Err('Сохранение комментария завершилось неудачей.');
                }
            },
            error : function (data){
                show__Err('Ошибка на стороне сервера.');
            }
        });*/

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
                    console.info(err);
                    show__Err('Сохранение комментария завершилось неудачей.');
                }
            },
            error : function (data){
                show__Err('Ошибка на стороне сервера.');
            }
        });

        /*sendData__XML_HTTP_Request_GET(window.location.protocol+'//'+window.location.host+'/add', {
            name : data['name'],
            email : data['email'],
            comment : data['comment'],
        }, function(data){
            var err = true;
            if(data != undefined){
                if(data !== false){
                    err = false;
                    console.info( data );
                }
            }
            if(err){
                toastr['error']('Беда!');
            }
        });

        sendData__XML_HTTP_Request_POST(window.location.protocol+'//'+window.location.host+'/add', {
            name : data['name'],
            email : data['email'],
            comment : data['comment'],
        }, function(data){
            var err = true;
            if(data != undefined){
                if(data !== false){
                    err = false;
                    console.info( data );
                }
            }
            if(err){
                toastr['error']('Беда!');
            }
        });*/
    }
    return false;
}
    function sendData__XML_HTTP_Request_GET(url, data, rezultat) {

        var params = typeof data == 'string' ? data : Object.keys(data).map(
                function(k){
                    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
            ).join('&');

        var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

        xhr.open('GET', url+'?'+params);

        xhr.onreadystatechange = function() {
            if ( xhr.readyState == 4 ) {
                if(xhr.status==200){
                    return rezultat(xhr.responseText);
                }else{
                    return rezultat(false);
                }
            }else{
                console.info(xhr.readyState);
            }
        };
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send();
        return xhr;
    }

    function sendData__XML_HTTP_Request_POST(url, data, rezultat) {
    //Async. JS & XML
    console.info(data);
        //example
            /*
            was
             {name: "asdas", email: "asdas@asdas.ru", comment: "asdas"}
            now
             name=asdas&email=asdas%40asdas.ru&comment=asdas
            */
        var params = typeof data == 'string' ? data : Object.keys(data).map(
                function(k){
                    // encodeURIComponent(k) = key
                    // data[k] = get value
                    //о encodeURIComponent - метод кодирования
                        //https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent
                    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
            ).join('&');
        console.info( params );

        //object query = его методы и свойства
        var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        //инициализация запроса
            //https://developer.mozilla.org/ru/docs/Web/API/XMLHttpRequest/open
        xhr.open('POST', url);
        //функция, что будет ждать ответа от сервера
        xhr.onreadystatechange = function() {
            //readyState = состояние готовности сервера
                //https://developer.mozilla.org/ru/docs/Web/API/XMLHttpRequest/readyState
            //responseText = ответ в виде строки
            //status = код ответа сервера
                //https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/status
            if ( xhr.readyState == 4 ) {
                if(xhr.status==200){
                    return rezultat(xhr.responseText);
                }else{
                    return rezultat(false);
                }
            }else{
                console.info(xhr.readyState);
            }
        };
        //установка http заголовков
            //https://developer.mozilla.org/ru/docs/Web/API/XMLHttpRequest/setRequestHeader
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(params);
        return xhr;
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
    console.info('draw__Init');
    console.info(data);
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
            var newCol = '<div class="comments__Item '+color+' col-md-4">';
            //tmp
            newCol +='<div class="tmp__BtnDelete" data-id="'+parseInt(data.data['id'])+'" title="Удалить">X</div>';
            //tmpEND
                newCol +='<div class="comments__ItemHeader">'+data.data['name']+'</div>' +
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

//tmp
$('body').on('click','.tmp__BtnDelete',function(){
    var id = false;
    if( $(this).attr('data-id') ){
        id = parseInt($(this).attr('data-id'));
    }
    if( id > 0 ){
         $.ajax({
             url: window.location.protocol+'//'+window.location.host+'/delete',
             type: 'post',
             data: {
                 id : id,
             },
             success: function (data) {
                 data = jQuery.parseJSON(data);
                 err = true
                 if(data != false){
                     if(data.status != undefined && data.body != undefined){
                         //js remove
                         var deleteElement = $('body').find('[data-id="'+id+'"]');
                         if(deleteElement.length == 1){
                             deleteElement.parent().remove();
                             //метка
                             err = false;
                             //msg
                             toastr["warning"]('Удалено');
                             //count
                             countComment = $('body').find('.comments__Item');
                             if(countComment.length == 0){
                                 $('#S_Wrapper').prepend('<div id="S_Empty" class="alert alert-warning comments__ItemsEmpty">Оставьте комментарий первым.</div>');
                             }
                         }
                     }
                 }
                 if(err){
                 show__Err('Удаление комментария завершилось неудачей.');
                 }
             },
             error : function (data){
                show__Err('Ошибка на стороне сервера.');
             }
         });
    }
});