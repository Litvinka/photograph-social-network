<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => ['form_update'], 'enctype' => 'multipart/form-data'],]); ?>
    <?= $form->field($model, 'post_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($model, 'post')->textarea(['rows' => 10]) ?>
    <img class="small_img" src="<?=$model->image?>">
    <input type="file" id="post_img" name="image" />
    <p>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'button']) ?>
    </p>
    <?php ActiveForm::end(); ?>
</div>


<script type="text/javascript">
//Предпросмотр файла
  function sent(evt) {
    var files = evt.target.files; 
    for (var i = 0, f; f = files[i]; i++) {
      if (!f.type.match('image.*')) {
        continue;
      }
      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          document.querySelector(".small_img").src=e.target.result;
        };
      })(f);
      reader.readAsDataURL(f);
    }
  }
document.getElementById('post_img').addEventListener('change', sent, false);
</script>
