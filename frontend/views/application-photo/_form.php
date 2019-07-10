<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

?>

<div class="application-photo-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => ['form_update'], 'enctype' => 'multipart/form-data'],]); ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($model, 'event_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'category_id')->dropDownList($model->genresList, ['prompt'=>'Выберите категорию']); ?>
    <?= $form->field($model, 'city_id')->dropDownList($model->cityList, ['prompt'=>'Выберите город']); ?>
    <?= $form->field($model, 'date_event')->widget(DatePicker::className(),
['clientOptions' => ['dateFormat' => 'yy-mm-dd']]); ?>
    <?= $form->field($model, 'max_sum')->textInput() ?>
    <p>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'button']) ?>
    </p>
    <?php ActiveForm::end(); ?>

</div>
