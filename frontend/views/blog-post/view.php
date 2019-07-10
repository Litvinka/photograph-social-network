<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\models\BlogPostComments;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\BlogPost */

$this->title = "Просмотр записи";
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
            <li> <?=Html::a('ПОСЛЕДНИЕ', ['blog-post/index']);?></li>
            <li>
                <?=Html::a('ПОПУЛЯРНЫЕ', ['blog-post/popular']);?>
            </li>
        </ul>
        <div class="blog-item1">
            <div class="blog_top">
                <hgroup>
                    <h3><?=$model["post_name"]?></h3>
                    <h6><?=$model['updated_at']?></h6>
                </hgroup>
                <p>
                    <?= Html::a('<img class="icons" src="image/icons/edit.png">', ['update', 'id' => $model['id']]) ?>
                    <?= Html::a('<img class="icons" src="image/icons/close.png"> ', ['delete', 'id' => $model['id']], [
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить данную запись?',
                        'method' => 'post',
                    ],
                ]) ?>  
                </p>
            </div>
                <figure class="blog_center1">
                    <p class="blog_center_photo1">
                        <img class="blog_images" src="<?=$model['image']?>"/>
                    </p>
                    <p>
                        <?=$model['post']?>
                    </p>
                </figure>
            <div class="blog_bottom">
                <hgroup>
                    <h6>Автор: <span class="blog_h6"><?=User::findIdentity($model['user_id'])->username?></span></h6>
                    <h6>Теги: </h6>
                </hgroup>
                <ul>
                    <li>
                        <h6><img src="image/icons/eye.png"> <?=$model->getViewCount($model['id'])?></h6>
                    </li>
                </ul>
            </div>
        </div>

        <section id="comments">
            <h4>КОММЕНТАРИИ</h4>
            
                <?=ListView::widget([
                'dataProvider' => $listDataProvider,
                'itemView' => '_comment',
                'summary' => false,
                'layout'=>"{items}\n<p>{pager}</p>",
                'pager' => [
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                    'nextPageLabel' => '>',
                    'prevPageLabel' => '<',        
                ],
                'emptyText' => '<p>Комментариев нет</p>',
                ]);?>
            
            
            <?php $model1=new BlogPostComments();?>
            <div class="blog-post-comments-form">
                <h4>Новый комментарий</h4>
                <?php $form = ActiveForm::begin(['action'=>'/photo/frontend/web/index.php?r=blog-post-comments/create','options' => ['class' => ['form_update'], 'enctype' => 'multipart/form-data'],]); ?>
                <?= $form->field($model1, 'post_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <?= $form->field($model1, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
                <?= $form->field($model1, 'comment')->textarea(['rows' => 6]) ?>
                  <img class="small_img" src="<?=$model1->image?>">
                  <input type="file" id="post_img" name="image" />
                  <p>
                    <?= Html::submitButton('Добавить', ['class' => 'button']) ?>
                    </p>
                <?php ActiveForm::end(); ?>
            </div>
        </section>

    </section>
</section>

<script>
//Изменение изображений блога и области видимости
var image=document.querySelector('.blog_images');
image.addEventListener('load',ready.call(image));
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

<script type="text/javascript">
//Предпросмотр файла
  function sent(evt) {
    var files = evt.target.files; 
    for (var i = 0, f; f = files[i]; i++) {
      if (!f.type.match('image.*')) {
        continue;
      }
      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          document.querySelector(".small_img").src=e.target.result;
        };
      })(f);
      reader.readAsDataURL(f);
    }
  }
document.getElementById('post_img').addEventListener('change', sent, false);
</script>
