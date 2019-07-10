<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Photo */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии';
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
            <li class="active">
                <a href="#">
                    <img src="image/icons/photo.png">фотографии
                </a>
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
    <section id="photoblock"  class="inform">
        <ul class="photoblock_nav">
            <li class="photoblock_nav_active"><a href="#">ПОСЛЕДНИЕ</a></li>
            <li>
                <?=Html::a('ПОПУЛЯРНЫЕ', ['photo/popular', 'id' => Yii::$app->user->identity->id]);?>
            </li>
        </ul>
        <p style="margin-bottom:20px">
            <button class="button"><?=Html::a('Добавить фото', ['photo/create']);?></button>
        </p>
        <div class="all_photos">
        <?php Pjax::begin(); ?>
            <?=ListView::widget([
            'dataProvider' => $listDataProvider,
            'itemView' => '_list',
            'summary' => false,
            'layout'=>"{items}\n<p style='width:100%'>{pager}</p>",
            'pager' => [
                'firstPageLabel' => 'Первая',
                'lastPageLabel' => 'Последняя',
                'nextPageLabel' => '>',
                'prevPageLabel' => '<',        
            ],
            'emptyText' => '<p>Вы не загрузили ни одной фотографии</p>',
            ]);?>
        <?php Pjax::end(); ?>
        </div>
    </section>
</section>

<script>
var images=document.getElementsByClassName('photo-item-img');
    for(var t=0;t<images.length;++t){
        images[t].addEventListener('load',ready.call(images[t]));
        }
    function ready(){
            var img=this;
            img.parentNode.style.width=img.width*200/img.height +"px";
            img.parentNode.style.flexGrow=img.width*200/img.height;
    }

var divs=document.querySelectorAll("#w0 DIV");
for(var i=0;i<divs.length;++i){
    divs[i].addEventListener('mouseover',function(e){
        if(e.target.tagName=="IMG" && e.target.parentNode.tagName=="DIV"){
            var parent=e.target.parentNode;
            parent.querySelector('.image_properties').style.display="block";
            parent.querySelector('hgroup').style.display="block";
            
            e.target.addEventListener('mouseout',function(e){
            if(e.clientX<e.target.getBoundingClientRect().left || e.clientX>e.target.getBoundingClientRect().right
               || e.clientY<e.target.getBoundingClientRect().top || e.clientY>(e.target.getBoundingClientRect().bottom-40)){
                    var parent=e.target.parentNode;
                    parent.querySelector('.image_properties').style.display="none";
                    parent.querySelector('hgroup').style.display="none";
                }
            },false);
    
        }
    },false);
}

</script>