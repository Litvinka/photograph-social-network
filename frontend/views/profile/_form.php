<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use frontend\models\ProfileSpecialization;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
/* @var $form yii\widgets\ActiveForm */

$models= new ProfileSpecialization();
$array = ProfileSpecialization::find()->where(['profile_id'=>$model->id])->asArray()->all();
$spec = ArrayHelper::getColumn($array, 'specialization_id');
?>

<div class="profile-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => ['form_update']],]); ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 225]) ?>
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 225]) ?>
    <?php echo $form->field($model,'birthdate')->widget(DatePicker::className(),
        ['language' => 'ru-Ru',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [ 
            'yearRange' => '1900:2016',
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'firstDay' => '1',
        ]
    ]); ?>
<br/>
    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList, ['prompt'=>'Выберите пол']); ?>
    <?= $form->field($model, 'city_id')->dropDownList($model->cityList, ['prompt'=>'Выберите город']); ?>
    <h5>Контактная информация</h5>
    <?= $form->field($model, 'phone')->textInput(['maxlength'=>20]) ?>
    <?= $form->field($model, 'site')->textInput(['maxlength' => 225]) ?>
    <?= $form->field($model, 'vk')->textInput(['maxlength' => 225]) ?>
    <?= $form->field($model, 'facebook')->textInput(['maxlength' => 225]) ?>
    <?= $form->field($model, 'instagram')->textInput(['maxlength' => 225]) ?>
    <h5>Общая информация</h5>
    <label>Специализация</label>
    <div id="spec">
    <?php
    for($i=1;$i<=count($models->SpecializationList);++$i){  ?>
        <label>
            <input type="checkbox" name="ProfileSpecialization[specialization_id][]" <?php if(in_array($i,$spec)){?> checked <?php } ?>  value="<?=$i?> "/>
            <?= $models->SpecializationList[$i]?>
        </label>
    <?php } ?>
    </div>
    <?= $form->field($model, 'interests')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'about_yourself')->textarea(['rows' => 4]) ?>
    <p>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'button']) ?>
    </p>
    <?php ActiveForm::end(); ?>

</div>
