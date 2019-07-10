<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PhotographResume;
use app\models\search\ResumeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\GenresPhoto;
use frontend\models\PhotographResumeGenres;
use frontend\models\PreferencesPhotography;
use frontend\models\PhotographResumePreferences;
use frontend\models\PriceType;
use frontend\models\PhotographPrice;
use yii\data\SqlDataProvider;

/**
 * PhotographResumeController implements the CRUD actions for PhotographResume model.
 */
class PhotographResumeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PhotographResume models.
     * @return mixed
     */
    public function actionIndex()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM photograph_resume')->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT photograph_resume.*, first_name, last_name, photo from photograph_resume join profile ON profile_id=profile.id WHERE published=1 ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 16,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    /**
     Просмотр резюме
     */
    public function actionView($profile_id)
    {
        $model = $this->findModel($profile_id);
        if($model!=null){
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        else{
            return $this->redirect(['create']);
        }
    }

    /**
     Создание новой модели
     */
    public function actionCreate()
    {   
        $model = $this->findModel(Yii::$app->user->identity->getProfileId());
        if($model!=null){
            return $this->redirect(['update', 'profile_id' => $model->profile_id]);
        }
        else{
            $model = new PhotographResume();
            $model->profile_id=Yii::$app->user->identity->getProfileId();
            if ($model->load(Yii::$app->request->post()) && $model->save()){
                PhotographResumeGenres::deleteAll(['photograph_resume_id'=>$model->id]);
                if(!empty($_POST['PhotographResumeGenres']['ganres_photo_id'])){  
                    $length=count($_POST['PhotographResumeGenres']['ganres_photo_id']);
                    for($i=0;$i<$length;++$i){
                        $model2=new PhotographResumeGenres();
                        $model2->photograph_resume_id=$model->id;
                        $model2->ganres_photo_id=$_POST['PhotographResumeGenres']['ganres_photo_id'][$i];
                        $model2->save();
                    }
                }
                PhotographResumePreferences::deleteAll(['resume_id'=>$model->id]);
                if(!empty($_POST['PhotographResumePreferences']['photograph_preferences_id'])){ 
                    $length=count($_POST['PhotographResumePreferences']['photograph_preferences_id']);
                    for($i=0;$i<$length;++$i){
                        $model2=new PhotographResumePreferences();
                        $model2->resume_id=$model->id;
                        $model2->photograph_preferences_id=$_POST['PhotographResumePreferences']['photograph_preferences_id'][$i];
                        $model2->save();
                    }
                }
                PhotographPrice::deleteAll(['resume_id'=>$model->id]);
                for($i=1;$i<=count(PhotographPrice::getPriceTypeList());++$i){
                    if(!empty($_POST['priceType'][$i-1]) && $_POST['currency'][$i-1]){
                        echo $i;
                        $price=new PhotographPrice();
                        $price->resume_id=$model->id;
                        $price->price_type_id=$i;
                        $price->price=$_POST['priceType'][$i-1];
                        $price->currency_id=$_POST['currency'][$i-1];
                        $price->save();
                    }
                }
                return $this->redirect(['update', 'id' => $model->id, 'profile_id' => $model->profile_id]);
            }
            else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     Изменение резюме
     */
    public function actionUpdate($profile_id)
    {
        if(!($model = $this->findModel($profile_id))){
            return $this->redirect(['create']);
        }
        else{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                PhotographResumeGenres::deleteAll(['photograph_resume_id'=>$model->id]);
                if(!empty($_POST['PhotographResumeGenres']['ganres_photo_id'])){  
                    $length=count($_POST['PhotographResumeGenres']['ganres_photo_id']);
                    for($i=0;$i<$length;++$i){
                        $model2=new PhotographResumeGenres();
                        $model2->photograph_resume_id=$model->id;
                        $model2->ganres_photo_id=$_POST['PhotographResumeGenres']['ganres_photo_id'][$i];
                        $model2->save();
                    }
                }
                PhotographResumePreferences::deleteAll(['resume_id'=>$model->id]);
                if(!empty($_POST['PhotographResumePreferences']['photograph_preferences_id'])){ 
                    $length=count($_POST['PhotographResumePreferences']['photograph_preferences_id']);
                    for($i=0;$i<$length;++$i){
                        $model2=new PhotographResumePreferences();
                        $model2->resume_id=$model->id;
                        $model2->photograph_preferences_id=$_POST['PhotographResumePreferences']['photograph_preferences_id'][$i];
                        $model2->save();
                    }
                }
                PhotographPrice::deleteAll(['resume_id'=>$model->id]);
                for($i=1;$i<=count(PhotographPrice::getPriceTypeList());++$i){
                    if(!empty($_POST['priceType'][$i-1]) && $_POST['currency'][$i-1]){
                        echo $i;
                        $price=new PhotographPrice();
                        $price->resume_id=$model->id;
                        $price->price_type_id=$i;
                        $price->price=$_POST['priceType'][$i-1];
                        $price->currency_id=$_POST['currency'][$i-1];
                        $price->save();
                    }
                }
                return $this->redirect(['update', 'id' => $model->id, 'profile_id' => $model->profile_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     Удаление модели
     */
    public function actionDelete($profile_id)
    {
        $this->findModel($profile_id)->delete();
        return $this->redirect(['index']);
    }

    /**
     Поиск модели
     */
    public function findModel($profile_id)
    {
        if (($model = PhotographResume::findOne(['profile_id' => $profile_id])) !== null) {
            return $model;
        } else {
            return null;
        }
    }
    
    
}
