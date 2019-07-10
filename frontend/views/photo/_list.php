<?php
use yii\helpers\Html;
use frontend\models\BlogPost;
use common\models\User;
?>

<img class="photo-item-img" src="<?=$model['photo']?>"/>

<p class="image_properties">
    <?php if($model['user_id']==Yii::$app->user->identity->id){ ?>
    <?= Html::a('<img class="icons" src="image/icons/edit.png">', ['update', 'id' => $model['id']]) ?>
    <?= Html::a('<img class="icons" src="image/icons/close.png"> ', ['delete', 'id' => $model['id']], [
        'data' => [
            'confirm' => 'Вы действительно хотите удалить данную запись?',
            'method' => 'post',
        ],
    ]) ?>  
    <?php } ?>
</p>

<hgroup>
    <p class="photo_about"><?=$model['photo_name']?></p>
    <h6><?=User::findIdentity($model['user_id'])->username?></h6>
</hgroup>

