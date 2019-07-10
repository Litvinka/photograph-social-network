<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Популярные записи блога';
?>
<section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li>
                <?=Html::a('<img src="image/icons/home.png">моя страница', ['profile/view', ]);?>
            </li>
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
            <li class="active">
                <a href="#">
                    <img src="image/icons/blog.png">блог
                </a>
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
    <section id="blog"  class="inform">
        <ul class="blog_nav">
            <li>
                <?=Html::a('ПОСЛЕДНИЕ', ['blog-post/index']);?>
            </li>
            <li class="blog_nav_active"><a href="#">ПОПУЛЯРНЫЕ</a></li>
        </ul>
        <p style="margin-bottom:20px">
            <button class="button"><?=Html::a('Добавить запись', ['blog-post/create']);?></button>
        </p>
    <?php Pjax::begin(); ?>
        <?=ListView::widget([
        'dataProvider' => $listDataProvider,
        'itemView' => '_list',
        'summary' => false,
        'layout'=>"{items}\n<p>{pager}</p>",
        'pager' => [
            'firstPageLabel' => 'Первая',
            'lastPageLabel' => 'Последняя',
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',        
        ],
        'emptyText' => '<p>Записей в блоге нет</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
</section>

<script>
document.addEventListener("DOMContentLoaded", ready);
function ready(){
//Изменение изображений блога и области видимости
    var images=document.getElementsByClassName("blog_images");
    for(var i=0;i<images.length;++i){
        var width=images[i].width;
        var height=images[i].height;
        var d1=width/270;
        var d2=height/180;
        if(images[i].height>images[i].width){
            images[i].width='270';
            images[i].height=height/d1;
        }
        else{
            images[i].width=width/d2;
            images[i].height='180';
        }
        images[i].style.left=(images[i].width-270)/2*(-1) + "px";
        images[i].style.top=(images[i].height-180)/2*(-1) + "px";
    }
}
</script>