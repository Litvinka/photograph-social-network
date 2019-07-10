<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Message */

$this->title = "Сообщение для ".$model->getReceivedUserName($model->id);?>

<div class="message-view">
    <section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li>
                <?=Html::a('<img src="image/icons/home.png">моя страница', ['profile/view', 'id' => Yii::$app->user->identity->id]);?>
            </li>
            <li>
                <?=Html::a('<img src="image/icons/friends.png">друзья', ['friends/index', 'id' => Yii::$app->user->identity->id]);?>
            </li>
            <li class="active">
                <a href="#">
                    <img src="image/icons/message.png">сообщения
                    <?php if(Yii::$app->user->identity->getUnreadMessageCount()>0){
                    echo "(".Yii::$app->user->identity->getUnreadMessageCount().")"; } ?>
                </a>
            </li>
            <li>
                <?=Html::a('<img src="image/icons/photo.png">фотографии', ['photo/index', 'id' => Yii::$app->user->identity->id]);?>
            </li>
            <li>
                <?=Html::a('<img src="image/icons/blog.png">блог', ['blog-post/index', ]);?>
            </li>
            <li>
                <a href="#">
                    <img src="image/icons/calendar.png">календарь
                </a>
            </li>
            <li>
                <?=Html::a('<img src="image/icons/cv.png">резюме', ['photograph-resume/update', 'profile_id' => Yii::$app->user->identity->getProfileId()]);?>
            </li>
            <li>
                <?=Html::a('<img src="image/icons/nastroyki.png">настройки', ['profile/update', 'id' => Yii::$app->user->identity->id]);?>
            </li>
        </ul>
    </section>
    <section id="message"  class="inform">
        <ul class="message_nav">
            <li>
                <a href="/photo/frontend/web/index.php?r=message/index">
                    ВХОДЯЩИЕ <?php if(Yii::$app->user->identity->getUnreadMessageCount()>0){
                        echo "(".Yii::$app->user->identity->getUnreadMessageCount().")"; } ?>
                </a>     
            </li>
            <li>
                <?=Html::a('ИСХОДЯЩИЕ', ['message/out-message']);?>
            </li>
        </ul>
        <section class="one_message">
            <p class="mess_title">Отправленное сообщения</p>
            <?= Html::a('<img src="image/icons/close.png" title="удалить сообщение" class="imgclose"/>', ['delete', 'id' => $model->id], [
            'data' => [
                'confirm' => 'Удалить данное сообщение?',
                'method' => 'post',
            ],
            ]) ?>
            <dl class="dl_first">
                <dt>Отправитель</dt>
                <dd><?=Html::encode($model->getSentUserName($model->id))?></dd>
            </dl>
            <dl>
                <dt>Получатель</dt>
                <dd><?=Html::encode($model->getReceivedUserName($model->id))?></dd>
            </dl>
            <dl>
                <dt>Тема</dt>
                <dd><?=Html::encode($model->subject)?></dd>
            </dl>
            <dl>
                <dt>Сообщение</dt>
                <dd><?=Html::encode($model->message)?></dd>
            </dl>
        </section>
    </section>
</section>

</div>
