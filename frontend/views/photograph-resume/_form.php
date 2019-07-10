<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\WorkExperience;
use frontend\models\GenresPhoto;
use frontend\models\PhotographResumeGenres;
use frontend\models\PhotographResumePreferences;
use frontend\models\PreferencesPhotography;
use frontend\models\Currency;
use frontend\models\PriceType;
use frontend\models\PhotographPrice;
use yii\helpers\ArrayHelper;

$models= new PhotographResumeGenres();
$array = PhotographResumeGenres::find()->where(['photograph_resume_id'=>$model->id])->asArray()->all();
$genres = ArrayHelper::getColumn($array, 'ganres_photo_id');
$models1= new PhotographResumePreferences();
$array1 = PhotographResumePreferences::find()->where(['resume_id'=>$model->id])->asArray()->all();
$pref = ArrayHelper::getColumn($array1, 'photograph_preferences_id');
$price = new PhotographPrice();
$arr= PhotographPrice::find()->where(['resume_id'=>$model->id])->asArray()->all();
$pricetype = ArrayHelper::getColumn($arr, 'price_type_id');
$currency=ArrayHelper::getColumn($arr, 'currency_id');
$pr=ArrayHelper::getColumn($arr, 'price');
?>

<div class="photograph-resume-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => ['form_update']],]); ?>
    <?= $form->field($model, 'published')->checkbox()?>
    <?= $form->field($model, 'experience_id')->dropDownList($model->experienceList, ['prompt'=>'Выберите опыт работы']); ?>
    <label>Жанры</label>
    <div id="spec">
    <?php
    for($i=1;$i<=count($models->GenresPhotoList);++$i){  ?>
        <label>
            <input type="checkbox" name="PhotographResumeGenres[ganres_photo_id][]" <?php if(in_array($i,$genres)){?> checked <?php } ?>  value="<?=$i?> "/>
            <?= $models->GenresPhotoList[$i]?>
        </label>
    <?php } ?>
    </div>
    <label>Предпочтения</label>
    <div id="spec">
    <?php
    for($i=1;$i<=count($models1->PreferencesList);++$i){  ?>
        <label>
            <input type="checkbox" name="PhotographResumePreferences[photograph_preferences_id][]" <?php if(in_array($i,$pref)){?> checked <?php } ?>  value="<?=$i?> "/>
            <?= $models1->PreferencesList[$i]?>
        </label>
    <?php } ?>
    </div>
    <h4>СТОИМОСТЬ УСЛУГ</h4>
    <?php 
        for($i=1;$i<=count($price->PriceTypeList);++$i){ 
            $s=array_search($i,$pricetype);
            ?>
            <div class="pricetype">
                <label><?= $price->PriceTypeList[$i] ?></label>
                <input name="priceType[]" value="<?php if(in_array($i,$pricetype)){ echo $pr[$s]; } ?>" >
                <select name="currency[]">
                    <?php
                    for($j=1;$j<=count($price->CurrencyList);++$j){ ?>
                        <option value="<?=$j?>" <?php if(in_array($i,$pricetype) && ($j==$currency[$s])){?> selected <?php } ?> >
                            <?=$price->CurrencyList[$j]?>
                        </option>
                    <?php } ?>
                </select> 
            </div>
    <?php
        }
    ?>
    
    <p>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'button']) ?>
    </p>

    <?php ActiveForm::end(); ?>

</div>
