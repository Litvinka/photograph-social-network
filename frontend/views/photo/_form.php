<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\PhotosCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Photo */
/* @var $form yii\widgets\ActiveForm */

$models= new PhotosCategory();
$array = PhotosCategory::find()->where(['photo_id'=>$model->id])->asArray()->all();
$genres = ArrayHelper::getColumn($array, 'ganres_id');
?>

<div class="photo-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => ['form_update'], 'enctype' => 'multipart/form-data'],]); ?>
    <img class="small_img" src="<?=$model->photo?>">
    <input type="file" id="post_img" name="photo" />
    <?= $form->field($model, 'photo_name')->textInput(['maxlength' => true]) ?>
    <label>Категории фотографии</label>
    <div id="spec">
    <?php
    for($i=1;$i<=count($models->GenresPhotoList);++$i){  ?>
        <label>
            <input type="checkbox" name="PhotosCategory[ganres_id][]" <?php if(in_array($i,$genres)){?> checked <?php } ?>  value="<?=$i?> "/>
            <?= $models->GenresPhotoList[$i]?>
        </label>
    <?php } ?>
    </div>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($model, 'photo_description')->textarea(['rows' => 4]) ?>
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