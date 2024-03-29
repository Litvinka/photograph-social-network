<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\BlogPostComments;

$model=new BlogPostComments();
/* @var $this yii\web\View */
/* @var $model frontend\models\BlogPostComments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-comments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
