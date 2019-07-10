<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Блог';
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
            <li class="blog_nav_active"><a href="#">ПОСЛЕДНИЕ</a></li>
            <li>
                <?=Html::a('ПОПУЛЯРНЫЕ', ['blog-post/popular']);?>
            </li>
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
var images=document.getElementsByClassName('blog_images');
for(var t=0;t<images.length;++t){
    images[t].addEventListener('load',ready.call(images[t]));
       //Изменение изображений блога и области видимости
    }
function ready(){
    var img=this;
        var width=img.width;
        var height=img.height;
        var d1=width/270;
        var d2=height/180;
        if(img.height>img.width){
            img.width='270';
            img.height=height/d1;
        }
        else{
            img.width=width/d2;
            img.height='180';
        }
        img.style.left=(img.width-270)/2*(-1) + "px";
        img.style.top=(img.height-180)/2*(-1) + "px"; 
}

</script>