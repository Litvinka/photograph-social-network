<?php

namespace frontend\controllers;

use Yii;
use common\models\Friends;
use common\models\FriendRequests;
use app\models\search\FriendsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;

/**
 * FriendsController implements the CRUD actions for Friends model.
 */
class FriendsController extends Controller
{

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::findBySql('SELECT profile.id,user_id, first_name, last_name, city_id, photo from profile join user ON profile.user_id=user.id join friends ON user.id=user_id1 OR user.id=user_id2 WHERE friends.user_id1='.Yii::$app->user->identity->id.' OR friends.user_id2='.Yii::$app->user->identity->id),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    /**
     * Creates a new Friends model.
     */
    public function actionCreate($user_id1, $user_id2)
    {
        if(!($this->findModel($user_id1, $user_id2))){
            if(FriendRequests::findModel($user_id1,$user_id2)!==null){
                FriendRequests::findModel($user_id1,$user_id2)->delete();
            }
            $model = new Friends();
            $model->user_id1=$user_id1;
            $model->user_id2=$user_id2;
            $model->save();   
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Friends model.
     */
    public function actionDelete($user_id1, $user_id2)
    {
        if(FriendRequests::findModel($user_id1,$user_id2)!==null){
                FriendRequests::findModel($user_id1,$user_id2)->delete();
            }
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($user_id1, $user_id2)
    {
        if (($model = Friends::findOne(['user_id1' => $user_id1, 'user_id2' => $user_id2])) !== null) {
            return $model;
        }
        else if(($model = Friends::findOne(['user_id1' => $user_id2, 'user_id2' => $user_id1])) !== null){
            return $model;
        }
        else {
            return null;
        }
    }
}
