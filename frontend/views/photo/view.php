<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Photo */

$this->title = "Просмотр фотографии";
?>
<section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li>
                <?=Html::a('<img src="image/icons/home.png">моя страница', ['profile/view', ]);?>
            <li>
                <?=Html::a('<img src="image/icons/friends.png">друзья', ['friends/index', ]);?>
            </li>
            <li>
                <a href="/photo/frontend/web/index.php?r=message/index">
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
    <section class="inform">
        
    </section>
</section>
