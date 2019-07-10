<?php

namespace frontend\controllers;

use Yii;
use common\models\FriendRequests;
use app\models\search\FriendRequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;


class FriendRequestsController extends Controller
{
    /**
     * Lists all FriendRequests models.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::findBySql('SELECT profile.id, user_id, first_name, last_name, city_id, sent_user_id, reseived_user_id from profile join user ON profile.user_id=user.id join friend_requests ON user.id=sent_user_id WHERE reseived_user_id='.Yii::$app->user->identity->id),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }
    
    public function actionOutgoingRequests() {
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::findBySql('SELECT profile.id, user_id, first_name, last_name, city_id, sent_user_id, reseived_user_id from profile join user ON profile.user_id=user.id join friend_requests ON user.id=reseived_user_id WHERE sent_user_id='.Yii::$app->user->identity->id),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('out-request', ['listDataProvider' => $dataProvider]);
    }


    /**
     * Creates a new FriendRequests model.
     */
    public function actionCreate($sent_user_id, $reseived_user_id)
    {
        if(!($this->findModel($sent_user_id, $reseived_user_id))){
            $model = new FriendRequests();
            $model->sent_user_id=$sent_user_id;
            $model->reseived_user_id=$reseived_user_id;
            $model->save();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Deletes an existing FriendRequests model.
     */
    public function actionDelete($sent_user_id, $reseived_user_id)
    {
        $this->findModel($sent_user_id, $reseived_user_id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the FriendRequests model based on its primary key value.
     */
    protected function findModel($sent_user_id, $reseived_user_id)
    {
        if (($model = FriendRequests::findOne(['sent_user_id' => $sent_user_id, 'reseived_user_id' => $reseived_user_id])) !== null) {
            return $model;
        } else {
            return null;
        }
    }
    
}
