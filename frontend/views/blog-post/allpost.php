<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

if($this->context->route == "blog-post/all-post"){
    $this->title = 'Последние записи в блогах';
}
else if($this->context->route == "blog-post/all-popular"){
    $this->title = 'Популярные записи в блогах';
}
?>

<h2><?= Html::encode($this->title) ?></h2>
<section class="site">
    <section class="site_left">
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
        'emptyText' => '<p>Записей в блоге нет</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
    <section class="site_right">

    </section>
</section>

<script>
var images=document.getElementsByClassName('blog_images');
for(var t=0;t<images.length;++t){
    images[t].addEventListener('load',ready.call(images[t]));
       //Изменение изображений блога и области видимости
    }
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