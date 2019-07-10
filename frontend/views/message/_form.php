<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Message;

/* @var $this yii\web\View */
/* @var $model frontend\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$mess=new Message();
?>

<div class="message-form">
    <?php if(!isset($model)){$model=new Message();$model->sent_user_id='';}?>
    <?php $form = ActiveForm::begin(['action' =>['message/sent'], 'options' => ['class' => ['form_update'], ],]); ?>
    <?= $form->field($mess, 'received_user_id')->dropDownList($mess->getFriendList(), ['prompt'=>'Выберите получателя', 'options' => ["$model->sent_user_id"=>['selected'=>'selected']]]); ?> 
    <?= $form->field($mess, 'subject')->textInput(['maxlength' => true, 'value'=>$model->subject]) ?>
    <?= $form->field($mess, 'message')->textarea(['rows' => 6]) ?>
   <p>
        <?= Html::submitButton('Отправить', ['class' => 'button', ]) ?>
    </p>

    <?php ActiveForm::end(); ?>

</div>
<script>
    document.querySelector('form').addEventListener('submit',function(e){
    e.preventDefault();
    closem();
    var form = $(this);
    $.post(form.attr('action'), form.serialize).complete(function() {  alert("Сообщение отправлено!"); });
    });

//ВСПЛЫВАЮЩЕЕ ОКНО ПЕРЕТАСКИВАЕТСЯ
(function(){
    $("#writem").draggable({
       containment:[0,0,$(window).width()-$("#writem").width()-40,$(window).height()-$("#writem").height()-40]});
    });

//ВСПЛЫВАЮЩЕЕ ОКНО (видимо)
function writemessage(){
    document.querySelector(".formsbg").style.display="block";
    var form=document.querySelector(".forms");
    form.style.display="block";
    form.style.top="20%";
    form.style.left="25%";
};
//ВСПЛЫВАЮЩЕЕ ОКНО (невидимо)
function closem(){
    document.querySelector(".formsbg").style.display="none";
    document.querySelector(".forms").style.display="none";
};
</script>