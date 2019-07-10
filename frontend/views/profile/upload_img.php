<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;
use common\models\User;
use common\models\RecordHelpers;


/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = $model->user->username . " профиль";
?>

<section class="information">
    <section class="local_nav">
        <ul id="local_nav">
            <li class="active">
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
    <section id="update" class="inform">
        <h4>ЗАГРУЗКА АВАТАРА</h4>
        <form id="upload_form" action="/photo/frontend/web/index.php?r=profile/uploadimg" enctype="multipart/form-data" method="post">
            <p style="position:relative;">
                <?php if(!empty($model->photo)){ echo Html::a('<img class="icons avatar_close" src="image/icons/close.png">', ['del-img', 'id' => Yii::$app->user->identity->getProfileId()],
                    ['data' => [
                    'confirm' => 'Вы действительно хотите удалить данную аватарку?',
                    'method' => 'post',
                ],]); }?>
                <img id="avatarka" src="<?php if(!empty($model->photo)){ echo $model->photo;}?>"/>
            </p>
            <?php if(!empty($model->photo)){ ?> <label style="width:100%">Загрузить новое фото</label> <?php } ?>
            <img class="small_img" src="">
            <input type="file" id="post_img" name="photo"/>
            <p>
                <?= Html::submitButton('Сохранить', ['class' => 'button']) ?>
            </p>
        </form>
    </section>
</section>

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
