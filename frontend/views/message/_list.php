<?php
use yii\helpers\Html;
use common\models\FriendRequests;
use common\models\Friends;
use frontend\models\Profile;
?>
<div class="message-item <?php if($model['message_condition_id']==2){echo 'mess_unread';} ?>">
    <?= Html::a('<img class="imgclose" src="image/icons/close.png"> ', ['delete', 'id' => $model['id']], [
        'data' => [
            'confirm' => 'Вы действительно хотите удалить данное сообщение?',
            'method' => 'post',
        ],
    ]) ?>  
    <figure>
        <a href="/photo/frontend/web/index.php?r=photograph-resume/view&id=<?=$model['id']?>">
            <div class="photos_message">
            <img class="photo_friend" src="<?php if($model['photo']){ ?> <?=$model['photo']?> <?php } else echo 'image/logo.png'?>"> 
            </div>
        </a>
        <a href="/photo/frontend/web/index.php?r=message/view&id= <?=$model['id']?>">
        <hgroup>
            <h4 class="profile_name"><?= Html::encode($model['first_name']) ?>  
            <?= Html::encode($model['last_name']) ?></h4>
            <h5 class="message_thema">
            	<?= Html::encode($model['subject']) ?>  
            </h5>
            <p class="message_text">
            	<?=Html::encode($model['message'])?>
            </p>
        </hgroup> 
        </a>
    </figure>
</div>

