<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
use frontend\assets\FontAwesomeAsset;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (!Yii::$app->user->isGuest) { ?>
    <header>
        <section>
                <a href="index.php">
                            <img id="logo" src="image/logo.png" alt="фотопрорубь" title="фотопрорубь"/>
                    </a>
                    <a href="index.php">
                            <h1>ФОТОПРОРУБЬ</h1>
                    </a> 
        </section>
        <img class="gamburger" src="image/gamburger.png"/>
        <nav class="main_nav">
            <ul>
                <li>фотосъемка
                    <ul class="main-nav-ul">
                        <li><?=Html::a('фотографы', ['photograph-resume/index']);?></li>
                        <li><?=Html::a('заявки на фотосьемку', ['application-photo/index']);?></li>
                        <li><?=Html::a('мои заявки', ['application-photo/my-application']);?></li>
                    </ul>
                </li>
                <li>фотографии
                    <ul class="main-nav-ul">
                        <li><?=Html::a('популярные', ['photo/all-popular']);?></li>
                        <li><?=Html::a('последние', ['photo/all-photo']);?></li>
                        <li><a href="">фото дня</a></li>
                        <li><a href="">фото месяца</a></li>
                    </ul>
                </li>
                <li>общение
                    <ul class="main-nav-ul">
                        <li><?=Html::a('поиск людей', ['profile/index']);?></li>
                    </ul>
                </li>
                <li>блоги
                    <ul class="main-nav-ul">
                        <li><?=Html::a('популярные записи', ['blog-post/all-popular']);?></li>
                        <li><?=Html::a('последние записи', ['blog-post/all-post']);?></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <section class="photo_small">
            <div class="mes">
                <a href="/photo/frontend/web/index.php?r=message/index">
                <img src="image/mes.png"/>
                <?php if(Yii::$app->user->identity->getUnreadMessageCount()>0){ ?>
                <p class="num_mes" style="margin-top:-5px;margin-left:-6px;">
                    <span>
                        <?=Yii::$app->user->identity->getUnreadMessageCount()?>
                    </span>
                </p>
                <?php } ?>
                </a>
            </div>
            <div onclick="PhotoNav()">
                <div class="photo_name">
                    <figure>
                        <img id="small_logo" src="<?php if(!empty(Yii::$app->user->identity->profile->photo)){ echo Yii::$app->user->identity->profile->photo;} else{ echo 'image/logo.png';} ?>"/>
                    </figure>
                    <p>
                        <?=Yii::$app->user->identity->username ?> 
                        <img src="image/tr.png" style="width:10px;padding-bottom:5px;"/>
                    </p>
                </div>
                <ul class="photo_nav">
                    <li><?=Html::a('моя страница', ['profile/view']);?></li>
                    <li><a href="#">мои заявки</a></li>
                    <li>
                        <?= Html::a("Выход", ['site/logout'], [
                                'data' => [
                                    'method' => 'post'
                                ],
                            ]
                        );?>
                    </li>
                </ul>
            </div>
        </section>
    </header>
<?php } ?>
    
<?= $content ?>
 
<?php if (!Yii::$app->user->isGuest) { ?>
    <footer id="footer">
        <small>&copy 2017 Мария Долбич</small>
    </footer>
<?php } ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

