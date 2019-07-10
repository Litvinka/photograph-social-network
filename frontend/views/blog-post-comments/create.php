<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\BlogPostComments */

$this->title = 'Create Blog Post Comments';
$this->params['breadcrumbs'][] = ['label' => 'Blog Post Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
