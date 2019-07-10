<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Друзья';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    $session = Yii::$app->session;
    if(!$session->isActive){
    $session->open();} ?>

<section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li>
                <?=Html::a('<img src="image/icons/home.png">моя страница', ['profile/view', 'id' => Yii::$app->user->identity->id]);?>
            </li>
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
            <li class="friend_nav_active"><a href="#">ВСЕ</a></li>
            <li><?=Html::a('ЗАЯВКИ В ДРУЗЬЯ', ['friend-requests/index'])?></li>
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
        'emptyText' => '<p>У Вас нет друзей</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
</section>

<div class="formsbg">
</div>
<section class="forms" id="writem">
    <img class="imgclose" onclick="closem();" src="image/icons/close.png"/>
    <?= $this->render('_form_mess',['id'=>$session->get('id')]) ?>
</section>


<script>
//ВСПЛЫВАЮЩЕЕ ОКНО ПЕРЕТАСКИВАЕТСЯ
(function(){
    $("#writem").draggable({
       containment:[0,0,$(window).width()-$("#writem").width()-40,$(window).height()-$("#writem").height()-40]});
    });

//ВСПЛЫВАЮЩЕЕ ОКНО (видимо)
function writemessage(){
    document.querySelector(".formsbg").style.display="block";
    var form=document.querySelector(".forms");
    form.style.display="block";
    form.style.top="20%";
    form.style.left="25%";
};
//ВСПЛЫВАЮЩЕЕ ОКНО (невидимо)
function closem(){
    <?php unset($_SESSION['id']); ?>
    document.querySelector(".formsbg").style.display="none";
    document.querySelector(".forms").style.display="none";
};

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

