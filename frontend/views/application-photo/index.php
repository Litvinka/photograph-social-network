<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Заявки на фотосессию';
?>
<h2 class="title_h2"><span><?= Html::encode($this->title)?></span> <span><?=Html::a('<button class="button">добавить заявку</button>', ['application-photo/create']);?></span></h2>

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
        'emptyText' => '<p>Заявок на фотосессию нет</p>',
        ]);?>
    <?php Pjax::end(); ?>
    </section>
    <section class="site_right">

    </section>
</section>