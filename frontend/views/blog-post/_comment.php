<?php
use yii\helpers\Html;
use frontend\models\BlogPost;
use frontend\models\BlogPostComments;
use common\models\User;
?>

<div class="comment">
	<hgroup>
		<h5><?=$model['username']?></h5>
		<h6><?=$model['created_at']?></h6>
	</hgroup>
	<section>
                <?php if($model['image']){?><img src="<?=$model['image']?>"> <?php } ?>
		<p><?=$model['comment']?></p>
	</section>
</div>

