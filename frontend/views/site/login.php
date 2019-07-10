<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
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
            <span id="register"><a style="color:#dfe8ed" href="index.php?r=site/signup">регистрация</a></span>
        </section>
    </header>
    <section class="form">
            <?php $form = ActiveForm::begin(['options' => ['class' => ['form_reg']],]); ?>
                <h4>Вход</h4>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Логин") ?>

                <?= $form->field($model, 'password')->passwordInput()->label("Пароль") ?>

                <?= $form->field($model, 'rememberMe',['options' => ['id'=>'rememberMe']])->checkbox()->label("Запомнить меня") ?>

                <div style="font-size: 12px;margin-top:20px;margin-bottom:10px;">
                    <?= Html::a('Восстановить пароль', ['site/request-password-reset']) ?>
                </div>

                <p>
                    <?= Html::submitButton('войти', ['class' => 'form_bt']) ?>
                </p>

            <?php ActiveForm::end(); ?>
    </section>
    <footer>
        <small>&copy 2017 Мария Долбич</small>
    </footer>
</section>
