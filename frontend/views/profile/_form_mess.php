<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Message;
use frontend\models\Profile;
?>

<?php
$mess=new Message();
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(['action' =>['message/sent'], 'options' => ['class' => ['form_update'], ],]); ?>
    <?= $form->field($mess, 'received_user_id')->dropDownList($mess->getFriendList(), ['prompt'=>'Выберите получателя', 'options' => ["$model->user_id"=>['selected'=>'selected']]] ); ?> 
    <?= $form->field($mess, 'subject')->textInput(['maxlength' => true]) ?>
    <?= $form->field($mess, 'message')->textarea(['rows' => 6]) ?>
   <p>
        <?= Html::submitButton('Отправить', ['class' => 'button', ]) ?>
    </p>

    <?php ActiveForm::end(); ?>

</div>
<script>
    document.querySelector('form').addEventListener('submit',function(e){
    e.preventDefault()
    closem();
    var form = $(this);
    $.post(form.attr('action'), form.serialize).complete(function() {  alert("Сообщение отправлено!"); });
    });
</script>