<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApplicationPhoto */

$this->title = "Просмотр заявки";
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
    <section class="inform" id="application_view">
        <ul class="application_nav">
            <li class="application_nav_active">ПРОСМОТР ЗАЯВКИ</li>
        </ul>
            <?php if(Yii::$app->user->identity->id==$model->user_id){?>
            <p class="icon_p">
                <?= Html::a('<img class="icons" src="image/icons/edit.png">', ['update', 'id' => $model['id']]) ?>
                <?= Html::a('<img class="icons" src="image/icons/close.png"> ', ['delete', 'id' => $model['id']], [
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить данную заявку?',
                        'method' => 'post',
                ],
                ]) ?>  
            </p>
            <?php } ?>
            <dl>
                <dt>Событие:</dt><dd><?= Html::encode($model->event_name) ?></dd>
            </dl>
            <dl>
                <?php if(!empty(Html::encode($model->genres->genres_photo_name))){ ?>
                    <dt>Категория:</dt><dd><?= Html::encode($model->genres->genres_photo_name) ?></dd>
                <?php } ?>
            </dl>
            <dl>
                <?php if(!empty(Html::encode($model->city->city_name))){ ?>
                    <dt>Город:</dt><dd><?= Html::encode($model->city->city_name) ?></dd>
                <?php } ?>
            </dl>
            <dl>
                <?php if(!empty(Html::encode($model->date_event))){ ?>
                    <dt>Дата события:</dt><dd><?= Html::encode($model->date_event) ?></dd>
                <?php } ?>
            </dl>
            <dl>
                <?php if(!empty(Html::encode($model->max_sum))){ ?>
                    <dt>Оплата:</dt><dd><?= Html::encode($model->max_sum) ?></dd>
                <?php } ?>
            </dl>
            <?php if(Yii::$app->user->identity->id!=$model->user_id){ ?>
            <p class="application_bt"><button class="button">Откликнуться</button></p>
            <?php } ?>
    </section>
</section>
