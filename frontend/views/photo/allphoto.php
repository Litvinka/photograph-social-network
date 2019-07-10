<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

if($this->context->route == "photo/all-photo"){
    $this->title = 'Последние фотографии';
}
else if($this->context->route == "photo/all-popular"){
    $this->title = 'Популярные фотографии';
}
?>

<h2><?= Html::encode($this->title) ?></h2>
<section class="site">
    <section class="site_left">
        <div class="all_photos">
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
            'emptyText' => '<p>Вы не загрузили ни одной фотографии</p>',
            ]);?>
        <?php Pjax::end(); ?>
        </div>
    </section>
    <section class="site_right">

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