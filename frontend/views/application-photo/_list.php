<?php
use yii\helpers\Html;
use frontend\models\City;
use common\models\User;
?>

<section class="resume_ph">
    <?php if(Yii::$app->user->identity->id==$model['user_id']){?>
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
    <a href="/photo/frontend/web/index.php?r=application-photo/view&id=<?=$model['id']?>">
        <h4><?=$model['event_name']?></h4>
        <?php if($model['genres_photo_name']){?><h5 class="labl">Категория: <span class="span"><?= mb_strtolower($model['genres_photo_name']) ?></span></h5><?php } ?>
        <?php if($model['city_name']){?><h5 class="labl">Город: <span class="span"><?= $model['city_name']?></span></h5><?php } ?>
        <?php if($model['date_event']){?><h5 class="labl">Дата события: <span class="span"><?=$model['date_event'] ?></span></h5><?php } ?>
        <?php if($model['max_sum']){?><h5 class="labl">Оплата: <span class="span"><?=$model['max_sum']?></span></h5><?php } ?>
    </a>
    <p><button class="button"><?=Html::a('Просмотреть заявку', ['application-photo/view', 'id' => $model['id']]);?></button></p>
</section>


