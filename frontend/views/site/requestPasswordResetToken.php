<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
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
            <span id="login"><a style="color:#dfe8ed" href="index.php?r=site/login">войти</a></span>
            <span id="register"><a style="color:#dfe8ed" href="index.php?r=site/signup">регистрация</a></span>
        </section>
    </header>
    <section class="form">
            <?php $form = ActiveForm::begin(['options' => ['class' => ['form_reg']],]); ?>
                <h4>Сброс пароля</h4>
                <p style="font-size:12px; margin-bottom:15px">Введите адрес электронной почты. На него будет отправлена ссылка для сброса пароля.</p>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <p>
                    <?= Html::submitButton('Отправить', ['class' => 'form_bt']) ?>
                </p>

            <?php ActiveForm::end(); ?>
   </section>
    <footer>
        <small>&copy 2017 Мария Долбич</small>
    </footer>
</section>
