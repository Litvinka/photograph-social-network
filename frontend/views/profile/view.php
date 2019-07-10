<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;
use common\models\User;
use common\models\RecordHelpers;
use yii\widgets\ListView;
use frontend\models\PhotographResume;
use frontend\controllers\PhotographResumeController;


/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$model1 = PhotographResumeController::findModel($model->id);

$this->title = $model->user->username . " профиль";
?>
<div class="formsbg" >
</div>
<section class="forms" id="writem">
    <img class="imgclose" onclick="closem();" src="image/icons/close.png"/>
    <?= $this->render('_form_mess', ['model' => $model,]) ?>
</section>

<section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li <?php if(Yii::$app->user->identity->id==$model->user_id) {?>class="active" <?php } ?> >
                <a href="#">
                    <img src="image/icons/home.png">моя страница
                </a>
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
        <?php if ($already_exists = RecordHelpers::userHas('profile')){ ?>
        <section id="profile">
            <figure class="profile_photo" style="width:130px;"">
                <p id="p_avatar"><img id="avatar" src="<?php if(!empty($model->photo)){ echo $model->photo;} else{ echo 'image/logo.png';} ?>" />
                <?php if($model->user_id==Yii::$app->user->identity->id){ ?>
                    </p>
                <p class="edit_img"><?=Html::a('изменить фотографию', ['profile/upload', ]);?></p>
                <?php } elseif ($model->IsFriends ($model->id, Yii::$app->user->identity->id)!=0) { ?>
                    <p><button onclick="writemessage();" id="sents_button">Написать сообщение</button>
                    </p>
                <?php } ?>
            </figure>
            <section class="profile_inform">
                <h3><?= Html::encode($model->first_name) ?> <?= Html::encode($model->last_name) ?> (<?= Html::encode($model->user->username)?>)</h3>
                <dl>
                    <?php if(!empty(Html::encode($model->gender->gender_name))){ ?>
                    <dt>Пол:</dt><dd><?= Html::encode($model->gender->gender_name) ?></dd>
                    <?php } ?>
                </dl>  
                <dl>
                    <?php if(!empty(Html::encode($model->birthdate))){ ?>
                    <dt>Дата рождения:</dt><dd><?= Html::encode($model->birthdate) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if(!empty(Html::encode($model->city->city_name))){ ?>
                    <dt>Город:</dt><dd><?= Html::encode($model->city->city_name) ?></dd>
                    <?php } ?>
                </dl>
            <?php if($model1){?>    <p>Резюме фотографа</p>
                <dl>
                    <?php if(!empty(Html::encode($model1->experience->work_experience_name))){ ?>
                        <dt>Опыт работы:</dt><dd><?= Html::encode($model1->experience->work_experience_name) ?></dd>
                    <?php } ?>
                </dl> 
                <dl>
                    <?php if($model1->getGenresByResumeId($model1->id)!=""){ ?>
                    <dt>Жанры</dt>
                    <dd><?= Html::encode($model1->getGenresByResumeId($model1->id)) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if($model1->getPreferencesByResumeId($model1->id)!=""){ ?>
                    <dt>Предпочтения</dt>
                    <dd><?= Html::encode($model1->getPreferencesByResumeId($model1->id)) ?></dd>
                    <?php } ?>
                </dl>
            <?php } ?>
                <p>Контактная информация</p>
                <dl>
                    <?php if(!empty(Html::encode($model->phone))){ ?>
                        <dt>Телефон:</dt><dd><?= Html::encode($model->phone) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if(!empty(Html::encode($model->user->email))){ ?>
                        <dt>Email:</dt><dd><?= Html::encode($model->user->email) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if(!empty(Html::encode($model->site))){ ?>
                        <dt>Сайт:</dt><dd><?= Html::encode($model->site) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if(!empty(Html::encode($model->vk))){ ?>
                        <dt>Вконтакте:</dt><dd><?= Html::encode($model->vk) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if(!empty(Html::encode($model->facebook))){ ?>
                        <dt>Facebook:</dt><dd><?= Html::encode($model->facebook) ?></dd>
                    <?php } ?>
                </dl>
                <dl>
                    <?php if(!empty(Html::encode($model->instagram))){ ?>
                        <dt>Instagram:</dt><dd><?= Html::encode($model->instagram) ?></dd>
                    <?php } ?>
                </dl>
                <?php if(!empty(Html::encode($model->interests)) || !empty(Html::encode($model->about_yourself))){ ?>
                    <p>Общая информация</p>
                    <dl>
                        <?php if($model->getSpecializationsByProfileId()!=""){ ?>
                        <dt>Специализация</dt>
                        <dd><?= Html::encode($model->getSpecializationsByProfileId()) ?></dd>
                        <?php } ?>
                    </dl>
                    <dl>
                        <?php if(!empty(Html::encode($model->interests))){ ?>
                            <dt>Интересы:</dt><dd><?= Html::encode($model->interests) ?></dd>
                        <?php } ?>
                    </dl>
                    <dl>
                        <?php if(!empty(Html::encode($model->about_yourself))){ ?>
                            <dt>О себе:</dt><dd><?= Html::encode($model->about_yourself) ?></dd>
                        <?php } ?>
                    </dl>
               <?php } ?>
                    
            </section>
        </section>
        
        <?php if(User::hasPhotos($model->user_id)){?>
        <section class="profile_photos">  
            <h3>ФОТОГРАФИИ</h3>
            <article id="prof_photos">
                <?=ListView::widget([
                'dataProvider' => $listDataProvider,
                'itemView' => 'photolist',
                'summary' => false,
                'emptyText' => '<p>Фотографий нет</p>',
                ]);?>
            </article>
            <p><button class="button"><?=Html::a('все фотографии', ['photo/index', 'id' => $model->user->id]);?></button></p>
        </section>
        <?php } }else{?>
            <p>Вы еще не создали профиль пользователя</p>
            <button>
                <?=Html::a('создать профиль', ['create', 'id' => $model->id]);?>
            </button>
        <?php } ?>
    </section>
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
    document.querySelector(".formsbg").style.display="none";
    document.querySelector(".forms").style.display="none";
};

document.getElementById('avatar').onload(ready());
function ready(){
    var avatar=document.getElementById('avatar');
    avatar.style.height=avatar.style.width;
    //Изменение изображений аватарки и области видимости
    var width=avatar.width;
    var height=avatar.height;
    if(height<width){
        var $d=height/130;
        avatar.height="130";
        avatar.width=width/$d;
        avatar.style.left=(avatar.width-130)/2*(-1) + "px";
    }
    else{
        var $d=width/130;
        avatar.width="130";
        avatar.height=height/$d;
        avatar.style.top=(avatar.height-130)/2*(-1) + "px";
    }
}



</script>