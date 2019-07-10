<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="screen" style="background-image: url('image/bg1.jpg');">
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
            <span id="register"><a style="color:#dfe8ed" href="index.php?r=site/login">войти</a></span>
        </section>
    </header>
    <section class="form">
        <?php $form = ActiveForm::begin(['options' => ['class' => ['form_reg']],]); ?>
            <h4>Регистрация</h4>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Логин") ?>
            <?= $form->field($model, 'email')->label("Email") ?>
            <?= $form->field($model, 'password')->passwordInput()->label("Пароль") ?>
            <p>
                <?= Html::submitButton('войти',['class' => 'form_bt']) ?>
            </p>
        <?php ActiveForm::end(); ?>
    </section>
    <footer>
        <small>&copy 2017 Мария Долбич</small>
    </footer>
</section>
