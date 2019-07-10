<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Заявки в друзья';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li>
                <?=Html::a('<img src="image/icons/home.png">моя страница', ['profile/view', 'id' => Yii::$app->user->identity->id]);?>
            </li>
            <a href="out-request.php"></a>
            <li class="active">
                <a href="#">
                    <img src="image/icons/friends.png">друзья
                </a>
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
    <section id="friends"  class="inform">
        <ul class="friend_nav">
            <li><?=Html::a('ВСЕ', ['friends/index'])?></li>
            <li class="friend_nav_active"><a href="#">ЗАЯВКИ В ДРУЗЬЯ</a></li>
            <li><?=Html::a('ИСХОДЯЩИЕ ЗАЯВКИ', ['friend-requests/outgoing-requests'])?></li>
        </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    Pjax::begin(); ?>
        <?=ListView::widget([
        'dataProvider' => $listDataProvider,
        'itemView' => '_list',
        'summary' => false,
        'layout'=>"{items}\n{pager}",
        'pager' => [
            'firstPageLabel' => 'Первая',
            'lastPageLabel' => 'Последняя',
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',    
        ],
        'emptyText' => '<p>Заявок в друзья нет</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
</section>

<script>
       //Изменение изображений в списке друзей и области видимости
var images=document.getElementsByClassName('photo_friend');
for(var t=0;t<images.length;++t){
    images[t].addEventListener('load',ready.call(images[t]));
    }
function ready(){
    var img=this;
        var width=img.width;
        var height=img.height;
        var d1=width/80;
        var d2=height/80;
        if(height<width){
            img.height="80";
            img.width=width/d2;
            img.style.left=(img.width-80)/2*(-1) + "px";
        }
        else{
            img.width="80";
            img.height=height/d1;
            img.style.top=(img.height-80)/2*(-1) + "px";
        }
}
</script>