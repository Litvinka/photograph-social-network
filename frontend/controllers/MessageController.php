<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Message;
use app\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use frontend\models\Profile;
use yii\db\Expression;




class MessageController extends Controller
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

    public function actionIndex()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM message WHERE reseived_user_visibility=1 AND received_user_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT user_id, profile.id, first_name, last_name, message.id, photo, subject, message, received_user_id, message_condition_id from profile join user ON profile.user_id=user.id join message ON user.id=sent_user_id WHERE reseived_user_visibility=1 AND received_user_id='.Yii::$app->user->identity->id.' ORDER BY sent_date DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    //Исходящие сообщения
    public function actionOutMessage()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM message WHERE sent_user_visibility=1 AND sent_user_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT user_id, profile.id, photo, first_name, last_name, message.id, subject, message, received_user_id, message_condition_id from profile join user ON profile.user_id=user.id join message ON user.id=received_user_id WHERE sent_user_visibility=1 AND sent_user_id='.Yii::$app->user->identity->id.' ORDER BY sent_date DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
                
            ],
        ]);
        return $this->render('out-message', ['listDataProvider' => $dataProvider]);
    }

    /**
     Просмотр одного сообщения
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        if($model && $model->received_user_id==Yii::$app->user->identity->id){
            $model->message_condition_id=1; //сообщение прочитано
            $model->save();
            return $this->render('view', [
            'model' => $model,
        ]);
        }
        else if($model->received_user_id!=Yii::$app->user->identity->id){
            return $this->render('sent', [
            'model' => $model,
            ]);
        }
        else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    }

    public function actionSent(){
        $mess=new Message();
        $mess->subject=$_POST['Message']['subject'];
        $mess->received_user_id=$_POST['Message']['received_user_id'];
        $mess->sent_user_id=Yii::$app->user->identity->id;
        $mess->message=$_POST['Message']['message'];
        $mess->message_condition_id=2;
        $mess->sent_date=date("Y-m-d H:i:sa");
        if($mess->save()){ 
            return $this->redirect(['view', 'id' => $mess->id,]);
        }
        else{
            return false;
        }
    }

    /**
     * Creates a new Message model.
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Message model.
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        if($model->sent_user_id==Yii::$app->user->identity->id && $model->received_user_id!=Yii::$app->user->identity->id){
            $model->sent_user_visibility=0;
        }
        else if($model->sent_user_id!=Yii::$app->user->identity->id && $model->received_user_id==Yii::$app->user->identity->id){
            $model->reseived_user_visibility=0;
        }
        else{
            $model->sent_user_visibility=0;
            $model->reseived_user_visibility=0;
        }
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne(['id' => $id,])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
