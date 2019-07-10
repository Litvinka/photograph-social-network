<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Profile;
use frontend\models\search\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use common\models\PermissionHelpers;
use common\models\RecordHelpers;
use frontend\models\ProfileSpecialization;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\Files;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => [
                [
                'actions' => ['index', 'view','create', 'update', 'delete'],
                'allow' => true,
                'roles' => ['@'],
                ],
                ],
            ],
            'access2' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => [
                [
                'actions' => ['index', 'view','create', 'update', 'delete'],
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                return PermissionHelpers::requireStatus('Active');
                }
                ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'del-img' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::find()->orderBy('created_at ASC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    /**
     Просмотр данных одной модели (профиль пользователя)
     */
   public function actionView()
    {
        if ($already_exists = RecordHelpers::userHas('profile')) {
            $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * from photo WHERE user_id='.$this->user->id.' ORDER BY updated_at DESC',
            'pagination' => [
                'pageSize' => 8,
            ],
            ]);
            return $this->render('view', ['model' => $this->findModel($already_exists), 'listDataProvider' => $dataProvider
        ]);
        } else {
            $model = new Profile();
            $model->user_id = Yii::$app->user->identity->id;
            return $this->render('view',['model' => $model]);
        }
    }
    
    public function actionProfile($id)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * from photo WHERE user_id='.$this->findModel($id)->user_id.' ORDER BY updated_at DESC',
            'pagination' => [
                'pageSize' => 8,
            ],
            ]);
        return $this->render('view', ['model' => $this->findModel($id), 'listDataProvider' => $dataProvider]);
    }

    //Редактирование аватара
    public function actionUpload(){
        if ($already_exists = RecordHelpers::userHas('profile')) {
        return $this->render('upload_img', [
        'model' => $this->findModel($already_exists),
        ]);
        } else {
            $model = new Profile();
            $model->user_id = \Yii::$app->user->identity->id;
            return $this->render('upload_img',['model' => $model]);
        }
    }
    public function actionUploadimg(){
        if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
            $uploaddir = 'profile_image/';
            $uploadfile = $uploaddir.basename($_FILES['photo']['name']);
                if (copy($_FILES['photo']['tmp_name'], $uploadfile))
            {
                $params = [':photo' => "profile_image/".$_FILES['photo']["name"], ':user_id' => Yii::$app->user->identity->id];
                Yii::$app->db->createCommand('UPDATE profile SET photo=:photo WHERE user_id=:user_id',$params)->execute();
            }
            else { 
                echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>"; 
            }
        }
            $already_exists = RecordHelpers::userHas('profile');
            return $this->render('upload_img', [
            'model' => $this->findModel($already_exists),
            ]);
    }
    
    public function actionDelImg($id){
        $params = [':photo' => '', ':id' => $id];
        Yii::$app->db->createCommand('UPDATE profile SET photo=:photo WHERE id=:id',$params)->execute();
        $already_exists = RecordHelpers::userHas('profile');
        return $this->render('upload_img', ['model' => $this->findModel($already_exists),]);
    }
        

    /**
     * Создание новой модели
     */
    public function actionCreate()
    {
        $model = new Profile();
        $model->user_id = \Yii::$app->user->identity->id;
        if ($already_exists = RecordHelpers::userHas('profile')) {
        return $this->render('view', [
        'model' => $this->findModel($already_exists),
        ]);
        } elseif ($model->load(Yii::$app->request->post()) && $model->save()){
            ProfileSpecialization::deleteAll(['profile_id'=>$model->id]);
            if(!empty($_POST['ProfileSpecialization']['specialization_id'])){
                $length=count($_POST['ProfileSpecialization']['specialization_id']);
                for($i=0;$i<$length;++$i){
                    $model2=new ProfileSpecialization();
                    $model2->profile_id=$model->id;
                    $model2->specialization_id=$_POST['ProfileSpecialization']['specialization_id'][$i];
                    $model2->save();
                }
            }
            return $this->redirect(['view']);
        } else {
        return $this->render('create', [
        'model' => $model,
        ]);
        }
    }

    /**
     Обновить модель
     */
    public function actionUpdate($id)
    {        
        if($model = Profile::find()->where(['user_id' =>
        Yii::$app->user->identity->id])->one()) {
        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            ProfileSpecialization::deleteAll(['profile_id'=>$model->id]);
            if(!empty($_POST['ProfileSpecialization']['specialization_id'])){
                $length=count($_POST['ProfileSpecialization']['specialization_id']);
                for($i=0;$i<$length;++$i){
                    $model2=new ProfileSpecialization();
                    $model2->profile_id=$model->id;
                    $model2->specialization_id=$_POST['ProfileSpecialization']['specialization_id'][$i];
                    $model2->save();
                }
            }
            return $this->redirect(['view']);
        } else {
            return $this->render('update', [
            'model' => $model]);
        }
        } else {
        throw new NotFoundHttpException('No Such Profile.');
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $this->findModel($model->id)->delete();
        return $this->redirect(['site/index']);
    }

    /**
     Найти модель
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
