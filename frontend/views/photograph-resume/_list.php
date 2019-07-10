<?php
use yii\helpers\Html;
use common\models\User;
use frontend\models\PhotographResume;
?>

<section class="resume_ph">
    <a href="/photo/frontend/web/index.php?r=profile/profile&id=<?=$model['profile_id']?>">
        <p class="resume_p">
        <img src="<?php if(!empty(Html::encode($model['photo']))){ 
            echo Html::encode($model['photo']);} else{ echo 'image/logo.png';}?>">
        </p>
        <h5><?=Html::encode($model['first_name'])?> <?=Html::encode($model['last_name'])?> </h5>
        <h6><?=PhotographResume::getGenresByResumeId($model['id'])?></h6>
    </a>
    <p><button class="button"><?=Html::a('Просмотреть резюме', ['profile/profile', 'id' => $model['profile_id']]);?></button></p>
</section>

