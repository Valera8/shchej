<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="/styles/ext/toastr.min.css" rel="stylesheet">
        <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic-ext,latin-ext" rel="stylesheet">
        <!-- side -->
    <link href="/styles/side.css" rel="stylesheet">
    <title>Гостевая книга</title>
</head>
<body>
<div class="wrapper wrapper_dark">
    <div class="wrapper__inner">
        <a href="#" class="header__Logo" title="Вернуться на главную">LOGO</a>
        <div class="Header__IcoComment"></div>
        <div class="blockForm__FormWrapper">
            <div class="blockForm__Form">
                <div class="blockForm__FormLeft col-md-6 ">
                    <!-- name-->
                    <div class="blockForm__FormName">
                        <label title="Поле 'Имя' обязательно для заполнения" for="name" class="blockForm__FormLabel">Имя <span class="blockForm__FormElementRequired" id="name__req">*</span></label>
                        <input title="Ваше имя" type="text" id="name" required placeholder="Ваше имя" class="blockForm__FormField col-md-10">
                    </div>
                    <!-- email-->
                    <div class="blockForm__FormEmail">
                        <label title="Поле 'E-mail' обязательно для заполнения" for="email" class="blockForm__FormLabel">E-Mail <span class="blockForm__FormElementRequired" id="email__req">*</span></label>
                        <input title="Ваш E-mail" type="email" id="email" required placeholder="Ваше имя" class="blockForm__FormField col-md-10">
                    </div>
                </div>
                <div class="blockForm__FormRight col-md-6 ">
                    <div class="blockForm__FormTextarea">
                        <label title="Поле 'Ваш комментарий' обязательно для заполнения" for="email" class="blockForm__FormLabel">Комментарий <span class="blockForm__FormElementRequired" id="comment__req">*</span></label>
                        <textarea title="Ваш комментарий" required placeholder="Ваш комментарий" class="blockForm__FormField blockForm__FormField_Textarea col-md-12" name="" id="comment"></textarea>
                    </div>
                </div>
            </div>
            <div class="blockForm__FormBtns col-md-12">
                <span class="blockForm__FormBtn blockForm__FormBtn_Sender " title="Оставить ваш комментарий" id="btnSend">Записать</span>
            </div>
        </div>
    </div>
</div>

<noscript>
    <div class="wrapper__inner">
        <div class="haveNotJs">
            <div class="haveNotJs__Wrapper">
                <div class="haveNotJs__Header">
                    У вас работает блокировщик и / или вы отключили JavaScript
                </div>
                <div class="haveNotJs__Body">
                    <div class="haveNotJs__Body_H">Дело в JavaScript</div>
                    <div class="haveNotJs__Body_Contain">
                        Если вы не включите JavaScript, то увы, вы не сможете воспользоваться всеми функциональными возможностями сайта. В частности, добавление новых комментарий, временно заблокировано.
                    </div>
                </div>
            </div>
        </div>
    </div>
</noscript>

<div class="wrapper wrapper_lite">
    <div class="wrapper__inner">
        <div class="comments">
            <h1 class="comments__Header">Выводим комментарии</h1>
            <div id="S_Wrapper" class="comments__Items">
                <?
                if(@!empty($data)){
                    for($c = 0; $c < count($data); $c++){
                        print '<div class="comments__Item '.($c%2===0 ? 'comments__Item_Dark' : 'comments__Item_Lite').' col-md-4">
                        <div class="comments__ItemHeader">'.$data[$c]['name'].'</div>
                        <div class="comments__ItemContain">
                            <a href="mailto:'.$data[$c]['email'].'" class="comments__ItemEmail">'.$data[$c]['email'].'</a>
                            <div class="comments__ItemMsg">'.$data[$c]['msg'].'</div>
                        </div>
                    </div>';
                    }
                }else{
                    print '<div id="S_Empty" class="alert alert-warning comments__ItemsEmpty">Оставьте комментарий первым.</div>';
                }
                ?>

            </div>
        </div>
    </div>
</div>

<div class="footer__Wrapper">
    <div class="wrapper__inner footer__inner">
        <a href="#" title="Вернуться на главную" class="footer__logo">LOGO</a>
        <ul class="socialBtns__Items">
           <li class="socialBtns__Item">
               <a target="_blank" title="Перейти в нашу группу вконтакте" href="https://vk.com" class="socialBtns__ItemHref"><i class="fab fa-vk"></i></a>
           </li>
            <li class="socialBtns__Item">
               <a target="_blank" title="Перейти в нашу группу фейсбук" href="https://facebook.com" class="socialBtns__ItemHref"><i class="fab fa-facebook-f"></i></a>
           </li>
        </ul>
    </div>
</div>


<!-- JS -->
<script
    src="http://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="/js/ext/toastr.min.js"></script>
<script src="/js/side.js"></script>
</body>
</html>