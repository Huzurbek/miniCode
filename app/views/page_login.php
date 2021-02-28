<?php $this->layout('layout', ['title' => 'User Profile']) ?>
<!-- Place favicon.ico in the root directory -->
<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
<link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="stylesheet" media="screen, print" href="css/page-login-alt.css">


<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Учебный проект</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
<!--        <div class="alert alert-success">-->
<!--            Регистрация успешна-->
<!--        </div>-->
        <?php echo flash()->display();?>
        <form action="/login" method="POST">
            <div class="form-group">
                <label class="form-label" for="username">Email</label>
                <input type="email" id="username" class="form-control" placeholder="Эл. адрес" value="" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input type="password" id="password" class="form-control" placeholder="" name="password" required>
            </div>
            <div class="form-group text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="rememberme" name="remember">
                    <label class="custom-control-label" for="rememberme">Запомнить меня</label>
                </div>
            </div>
            <button type="submit" class="btn btn-default float-right">Войти</button>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        Нет аккаунта? <a href="/register"><strong>Зарегистрироваться</strong>
    </div>
</div>
<video poster="img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
    <source src="media/video/cc.webm" type="video/webm">
    <source src="media/video/cc.mp4" type="video/mp4">
</video>
<script src="js/vendors.bundle.js"></script>
<!--<div class="container">
    <div class=" row col-md-6">
        <form  action="/login" method="POST">
            <div class="form-group">
                <label class="form-label" for="emailverify">Email</label>
                <input type="email" id="emailverify" class="form-control" placeholder="Эл. адрес" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="userpassword">Пароль <br></label>
                <input type="password" id="userpassword" class="form-control" placeholder="" name="password" required>
            </div>
                        <div class="form-group">-->
            <!--                 <label class="form-label" for="username">Username<br></label>-->
            <!--                 <input type="text" id="username" class="form-control" placeholder="Username" name="username" required>-->
            <!--            </div>
            <div class="form-group">
                <button  type="submit" class="btn btn-block btn-success btn-lg mt-3">Submit</button>
            </div>
        </form>
    </div>
</div>-->