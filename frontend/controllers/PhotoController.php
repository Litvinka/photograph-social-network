<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Photo;
use frontend\models\search\Photo as PhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use frontend\models\PhotosCategory;

class PhotoController extends Controller
{

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

    public function actionIndex($id){
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM photo WHERE user_id='.$id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * from photo WHERE user_id='.$id.' ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }
    
    public function actionPopular($id){
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM photo WHERE user_id='.$id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT photo.*, count(comment) AS c from photo LEFT JOIN comments_photo ON photo.id=photo_id WHERE photo.user_id='.$id.' GROUP BY id ORDER BY c DESC, updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('popular', ['listDataProvider' => $dataProvider]);
    }
    
    public function actionAllPhoto(){
    $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM photo')->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * from photo ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('allphoto', ['listDataProvider' => $dataProvider]);
    }
    
    public function actionAllPopular(){
    $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM photo')->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT photo.*, count(comment) AS c from photo LEFT JOIN comments_photo ON photo.id=photo_id GROUP BY id ORDER BY c DESC, updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('allphoto', ['listDataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    //добавление новой фотографии
    public function actionCreate()
    {
        $model = new Photo();
        if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
            $uploaddir = 'photos/';
            $uploadfile = $uploaddir.basename($_FILES['photo']['name']);
                if (copy($_FILES['photo']['tmp_name'], $uploadfile))
            {
                $model->photo="photos/".$_FILES['photo']["name"];
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            PhotosCategory::deleteAll(['photo_id'=>$model->id]);
                if(!empty($_POST['PhotosCategory']['ganres_id'])){  
                    $length=count($_POST['PhotosCategory']['ganres_id']);
                    for($i=0;$i<$length;++$i){
                        $model2=new PhotosCategory();
                        $model2->photo_id=$model->id;
                        $model2->ganres_id=$_POST['PhotosCategory']['ganres_id'][$i];
                        $model2->save();
                    }
                }
            return $this->redirect(['index','id' => Yii::$app->user->identity->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //редактирование фотографии
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
            $uploaddir = 'photos/';
            $uploadfile = $uploaddir.basename($_FILES['photo']['name']);
                if (copy($_FILES['photo']['tmp_name'], $uploadfile))
            {
                $model->photo="photos/".$_FILES['photo']["name"];
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            PhotosCategory::deleteAll(['photo_id'=>$model->id]);
                if(!empty($_POST['PhotosCategory']['ganres_id'])){  
                    $length=count($_POST['PhotosCategory']['ganres_id']);
                    for($i=0;$i<$length;++$i){
                        $model2=new PhotosCategory();
                        $model2->photo_id=$model->id;
                        $model2->ganres_id=$_POST['PhotosCategory']['ganres_id'][$i];
                        $model2->save();
                    }
                }
            return $this->redirect(['index','id' => Yii::$app->user->identity->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->db->createCommand('DELETE FROM photos_category WHERE photo_id='.$id)->execute();
        $this->findModel($id)->delete();
        return $this->redirect(['index','id' => Yii::$app->user->identity->id]);
    }

    protected function findModel($id)
    {
        if (($model = Photo::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
