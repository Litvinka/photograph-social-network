<?php
use yii\helpers\Html;
use frontend\models\BlogPost;
use common\models\User;

$m=new BlogPost();

?>
<div class="blog-item">
    <div class="blog_top">
        <hgroup>
            <a href="/photo/frontend/web/index.php?r=blog-post/view&id=<?=$model['id']?>">
                <h3><?=$model["post_name"]?></h3>
            </a>
            <h6><?=$model['updated_at']?></h6>
        </hgroup>
        <?php if($model['user_id']==Yii::$app->user->identity->id){ ?>
        <p>
            <?= Html::a('<img class="icons" src="image/icons/edit.png">', ['update', 'id' => $model['id']]) ?>
            <?= Html::a('<img class="icons" src="image/icons/close.png"> ', ['delete', 'id' => $model['id']], [
            'data' => [
                'confirm' => 'Вы действительно хотите удалить данную запись?',
                'method' => 'post',
            ],
        ]) ?>  
        </p>
        <?php } ?>
    </div>
    <a href="/photo/frontend/web/index.php?r=blog-post/view&id=<?=$model['id']?>">
        <figure class="blog_center">
            <?php if($model['image']){?>
            <p class="blog_center_photo">
                <img class="blog_images" src="<?=$model['image']?>"/>
            </p>
            <?php } ?>
            <p>
                <?=$model['post']?>
            </p>
        </figure>
    </a>
    <div class="blog_bottom">
        <hgroup>
            <h6>Автор: <span class="blog_h6"><?=User::findIdentity($model['user_id'])->username?></span></h6>
            <h6>Теги: </h6>
        </hgroup>
        <ul>
            <li>
                <h6><img src="image/icons/eye.png"> <?=$m->getViewCount($model['id'])?></h6>
            </li>
            <li>
                <h6><img src="image/icons/comment.png"> <?=$m->getCommentCount($model['id'])?></h6>  
            </li> 
        </ul>
    </div>
</div>


