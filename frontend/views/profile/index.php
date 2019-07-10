<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поиск пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>
<section class="site">
    <section class="site_left">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?=ListView::widget([
        'dataProvider' => $listDataProvider,
        'itemView' => '_list',
        ]);?>
    </section>
    <section class="site_right">

    </section>
</section>

<script>
    //Изменение изображений в списке всех пользователей и их области видимости
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