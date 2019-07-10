<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\jui\Draggable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Входящие сообщения';
?>

<?php Draggable::begin([
    'clientOptions' => ['grid' => [50, 20]],
]); ?>

<div class="formsbg" >
</div>
<section class="forms" id="writem">
    <img class="imgclose" onclick="closem();" src="image/icons/close.png"/>
    <?= $this->render('_form') ?>
</section>

<?php Draggable::end();?>

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
            <li class="message_nav_active">
                <a href="#">ВХОДЯЩИЕ <?php if(Yii::$app->user->identity->getUnreadMessageCount()>0){ 
                echo '('.Yii::$app->user->identity->getUnreadMessageCount().')'; } ?> </a>
            </li>
            <li>
                <?=Html::a('ИСХОДЯЩИЕ', ['message/out-message']);?>
            </li>
        </ul>
        <p style="margin-bottom:20px"><button class="button" onclick="writemessage();">Написать сообщение</button></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
        'emptyText' => '<p>Входящих сообщений нет</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
</section>


<script>
//Изменение изображений в списке сообщений и их области видимости
var images=document.getElementsByClassName('photo_friend');
for(var t=0;t<images.length;++t){
    images[t].addEventListener('load',ready.call(images[t]));
    }
function ready(){
    var img=this;
        var width=img.width;
        var height=img.height;
        var d1=width/50;
        var d2=height/50;
        if(height<width){
            img.height="50";
            img.width=width/d2;
            img.style.left=(img.width-50)/2*(-1) + "px";
        }
        else{
            img.width="50";
            img.height=height/d1;
            img.style.top=(img.height-50)/2*(-1) + "px";
        }
}
</script>