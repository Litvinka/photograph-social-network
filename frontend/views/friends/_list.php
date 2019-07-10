<?php
use yii\helpers\Html;
use common\models\FriendRequests;
use common\models\Friends;
use frontend\models\Profile;
?>

<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session = Yii::$app->session;
    $session->open();} ?>

<?php if($model->user_id!=Yii::$app->user->identity->id){ ?>
<div class="profile-item">
    <figure>
        <a href="/photo/frontend/web/index.php?r=profile/profile&id=<?=$model->id?>">
            <p class="photos_p">
            <img class="photo_friend" src="<?php if($model->photo){ ?> <?=$model->photo?> <?php } else echo 'image/logo.png'?>"> 
            </p>
        </a>
        <hgroup>
        	<a href="/photo/frontend/web/index.php?r=profile/profile&id=<?=$model->id?>">
	            <h4 class="profile_name"><?= Html::encode($model->first_name) ?>  
	            <?= Html::encode($model->last_name) ?></h4>
            </a>
            <h5 class="profile_city"><?= Html::encode($model->city->city_name)?></h5>
        </hgroup> 
    </figure>
    <div class="buttons">
        <button class="button" onclick=" <?php $session->set('id', $model->user_id);?> writemessage();">Написать сообщение</button>
        <button class="button"><?=Html::a('удалить из друзей', ['friends/delete', 'user_id1' => Yii::$app->user->identity->id,'user_id2'=>$model->user_id]);?></button>
    </div>
</div>
<?php } ?>

