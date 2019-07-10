<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textarea(['maxlength' => 45]) ?>

    <?= $form->field($model, 'last_name')->textarea(['maxlength' => 45]) ?>
    <br/>
    <?php echo $form->field($model,'birthdate')->widget(DatePicker::className(),
['clientOptions' => ['dateFormat' => 'yy-mm-dd']]); ?>
<br/>
   
    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList, ['prompt'=>'Выберите пол']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
