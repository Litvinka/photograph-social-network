<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Фотопрорубь - социальная сеть для фотографов и клиентов';
?>

<section class="screen" id="screen1" style="background-image: url('image/bg1.jpg');">
    <header>
            <section>
                    <a href="index.php">
                            <img id="logo" src="image/logo.png" alt="фотопрорубь" title="фотопрорубь"/>
                    </a>
                    <a href="index.php">
                            <h1>ФОТОПРОРУБЬ</h1>
                    </a>
            </section>
            <img class="gamburger" src="image/gamburger.png"/>
            <section>
                <span id="login"><a style="color:#dfe8ed" href="index.php?r=site/login">войти</a></span>
                <span id="register"><a style="color:#dfe8ed" href="index.php?r=site/signup">регистрация</a></span>
            </section>
    </header>
    <h2>Социальная сеть для фотографов и клиентов</h2>
    <article class="center_screen">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form_reg'],]); ?>
            <h4>Регистрация</h4>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Логин") ?>
            <?= $form->field($model, 'email')->label("Email") ?>
            <?= $form->field($model, 'password')->passwordInput()->label("Пароль") ?>
            <p>
                <?= Html::submitButton('регистрация',['class' => 'form_bt']) ?>
            </p>
        <?php ActiveForm::end(); ?>

    <img src="image/png.png" id="png" alt="Фотопрорубь" title="Фотопрорубь"/>
    </article>
    <p class="buttons1 bt">
            <a href="#screen2"><img src="image/down.png"></a>
    </p>
</section>

<section class="screen" id="screen2" style="background-image: url('image/bg2.jpg');">
    <p class="buttons2 bt">
            <a href="#screen1"><img src="image/up.png"></a>
    </p>
    <article>
            <section class="screen_text">
                    <span>1.</span>
                    <hgroup>
                            <h3 class="text_name">ФОТОГРАФИИ НА ЛЮБОЙ ВКУС</h3>
                            <h4 class="small_text">Портрет, репортаж, пейзаж, уличная фотография, натюрморт 
                            архитектурная съёмка, макросъёмка, фотоохота, флора, фауна и другие виды фотографии. 			
                            </h4>
                    </hgroup>
            </section>
            <section class="photo">
                    <img src="image/photo.jpg">
                    <img src="image/photo.jpg">
                    <img src="image/photo.jpg">
            </section>
    </article>
    <p class="buttons1 bt">
            <a href="#screen3"><img src="image/down.png"></a>
    </p>
</section>

<section class="screen" id="screen3" style="background-image: url('image/bg3.jpg');">
    <p class="buttons2 bt">
            <a href="#screen2"><img src="image/up.png"></a>
    </p>
    <article>
            <section class="screen_text">
                    <span>2.</span>
                    <hgroup>
                            <h3 class="text_name">ФОТОГРАФЫ НА ВСЕ СЛУЧАИ ЖИЗНИ</h3>
                            <h4 class="small_text">Свадебная, семейная, детская съемка, аэрофотосъемка, lovestory, съемка животных,
                            студийная съемка, репортаж, реклама и другие виды фотосъемки			
                            </h4>
                    </hgroup>
            </section>
            <section class="photography">
                    <figure>
                            <img src="image/ph.jpg">
                            <h4>Виктор Радько</h4>
                            <h5>съемка свадеб, lovestory, семейная, детская и др.</h5>
                    </figure>
                    <figure>
                            <img src="image/ph.jpg">
                            <h4>Виктор Радько</h4>
                            <h5>съемка свадеб, lovestory, семейная, детская и др.</h5>
                    </figure>
                    <figure>
                            <img src="image/ph.jpg">
                            <h4>Виктор Радько</h4>
                            <h5>съемка свадеб, lovestory, семейная, детская и др.</h5>
                    </figure>
                    <figure>
                            <img src="image/ph.jpg">
                            <h4>Виктор Радько</h4>
                            <h5>съемка свадеб, lovestory, семейная, детская и др.</h5>
                    </figure>
            </section>
    </article>
    <p class="buttons1 bt">
            <a href="#screen4"><img src="image/down.png"></a>
    </p>
</section>

<section class="screen" id="screen4" style="background-image: url('image/bg4.jpg');">
    <p class="buttons2 bt">
            <a href="#screen3"><img src="image/up.png"></a>
    </p>
    <article>
            <section class="screen_text">
                    <span>3.</span>
                    <hgroup>
                            <h3 class="text_name">ОТЛИЧНЫЕ ИДЕИ ДЛЯ ФОТО</h3>
                            <h4 class="small_text">Познавательные статьи, интересные фотографии, идеи для фото в машине, на улице, в доме, необычные эффекты, общение с единомышленниками и много другое.			
                            </h4>
                    </hgroup>
            </section>
            <p class="illustration">
                    <img src="image/igly.png">
            </p>
    </article>
    <footer>
            <small>&copy 2017 Мария Долбич</small>
    </footer>
</section>

