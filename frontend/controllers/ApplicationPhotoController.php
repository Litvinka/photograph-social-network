<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ApplicationPhoto;
use frontend\models\search\ApplicationPhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * ApplicationPhotoController implements the CRUD actions for ApplicationPhoto model.
 */
class ApplicationPhotoController extends Controller
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

    /**
     * Lists all ApplicationPhoto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(id) FROM application_photo WHERE date_event >= date("date_event")=curdate() OR date_event IS NULL')->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT application_photo.*, genres_photo_name, city_name from application_photo join genres_photo ON genres_photo.id=category_id join city ON city.id=city_id WHERE date_event >= date("date_event")=curdate() OR date_event IS NULL ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 16,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }
    
    //мои заявки
    public function actionMyApplication()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(id) FROM application_photo WHERE date_event >= date("date_event")=curdate() OR date_event IS NULL AND user_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT application_photo.*, genres_photo_name, city_name from application_photo join genres_photo ON genres_photo.id=category_id join city ON city.id=city_id WHERE date_event >= date("date_event")=curdate() OR date_event IS NULL AND user_id='.Yii::$app->user->identity->id.' ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
        return $this->render('my_application', ['listDataProvider' => $dataProvider]);
    }
    
    //мои отклики
    public function actionMyResponse()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(id) FROM responce_application_photo WHERE photograph_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT application_photo.*, genres_photo_name, city_name from application_photo join genres_photo ON genres_photo.id=category_id join city ON city.id=city_id join responce_application_photo ON application_photo.id=application_photo_id WHERE date_event >= date("date_event")=curdate() OR date_event IS NULL AND photograph_id='.Yii::$app->user->identity->id.' ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
        return $this->render('my_response', ['listDataProvider' => $dataProvider]);
    }
    
    //мои отклики
    public function actionHistoryApplication()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(id) FROM application_photo WHERE date_event < NOW() AND user_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT application_photo.*, genres_photo_name, city_name from application_photo join genres_photo ON genres_photo.id=category_id join city ON city.id=city_id WHERE date_event < NOW() AND user_id='.Yii::$app->user->identity->id.' ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
        return $this->render('history_application', ['listDataProvider' => $dataProvider]);
    }

    /**
     * Displays a single ApplicationPhoto model.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ApplicationPhoto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApplicationPhoto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ApplicationPhoto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ApplicationPhoto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ApplicationPhoto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $user_id
     * @return ApplicationPhoto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApplicationPhoto::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
