<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Каталог фотографов';
?>

<h2><?= Html::encode($this->title) ?></h2>
<section class="site">
    <section class="site_left" id="catalog_photographs">
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
        'emptyText' => '<p>В каталоге нет фотографов</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
    <section class="site_right">

    </section>
</section>

<script>
    function rezumeResizeImg(){
        var p=document.querySelectorAll(".resume_ph .resume_p");
        for(var i=0;i<p.length;++i){
            p[i].style.height=p[i].offsetWidth+"px";
            var img=p[i].firstElementChild;
            var width=img.width;
            var height=img.height;
            if(height<width){
                img.height=p[i].offsetWidth;
                img.width=width/(height/p[i].offsetWidth);
                img.style.left=(img.width-p[i].offsetWidth)/2*(-1) + "px";
            }
            else{
                img.width=p[i].offsetWidth;
                img.height=height/(width/p[i].offsetWidth);
                img.style.top=(img.height-p[i].offsetWidth)/2*(-1) + "px";
            }
        }
    }
    rezumeResizeImg();
    window.addEventListener("resize",function(e){
        rezumeResizeImg();
    })
</script>