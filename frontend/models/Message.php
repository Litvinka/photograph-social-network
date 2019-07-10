<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $sent_user_id
 * @property integer $received_user_id
 * @property string $subject
 * @property string $message
 * @property integer $message_condition_id
 * @property string $sent_date
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sent_user_id', 'received_user_id', 'message', 'message_condition_id'], 'required'],
            [['sent_user_id', 'received_user_id', 'message_condition_id','sent_user_visibility','reseived_user_visibility'], 'integer'],
            [['message'], 'string'],
            [['sent_date'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['message_condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => MessageCondition::className(), 'targetAttribute' => ['message_condition_id' => 'id']],
            [['sent_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sent_user_id' => 'id']],
            [['received_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['received_user_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sent_user_id' => 'Отправитель',
            'received_user_id' => 'Получатель',
            'subject' => 'Тема',
            'message' => 'Сообщение',
            'message_condition_id' => 'Message Condition ID',
            'sent_date' => 'Sent Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageCondition()
    {
        return $this->hasOne(MessageCondition::className(), ['id' => 'message_condition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentUser()
    {
        return $this->hasOne(User::className(), ['id' => 'sent_user_id']);
    }

    public function getSentUserName($id){
        $connection=Yii::$app->db;
        $sql='SELECT first_name, last_name FROM profile join user ON user_id=user.id join message ON user.id=sent_user_id WHERE message.id='.$id;
        $dataReader=$connection->createCommand($sql)->query();
        $dataReader->bindColumn(1,$first_name);
        $dataReader->bindColumn(2,$last_name);
        $dataReader->read();
        $str=$first_name.' '.$last_name;
        return $str;
    }


    public function getFriendList(){
        $connection=Yii::$app->db;
        $sql='SELECT user.id, first_name, last_name FROM profile join user ON user_id=user.id join friends ON user.id=user_id1 OR user.id=user_id2 WHERE user_id1='.Yii::$app->user->identity->id.' OR user_id2='.Yii::$app->user->identity->id;
        $dataReader=$connection->createCommand($sql)->queryAll();
        $arr=array();
        foreach ($dataReader as $key => $value) {
            $arr[$value['id']]=$value['first_name'].' '.$value['last_name'];
        }
        if(count($arr)==0){
            $sql='SELECT user_id, first_name, last_name FROM profile WHERE user_id='.Yii::$app->user->identity->id;
            $dataReader=$connection->createCommand($sql)->queryAll();
            $arr=array();
            foreach ($dataReader as $key => $value) {
                $arr[$value['user_id']]=$value['first_name'].' '.$value['last_name'];
            }
        }
        return $arr;
    }

    public function getReceivedUserName($id){
        $connection=Yii::$app->db;
        $sql='SELECT first_name, last_name FROM profile join user ON user_id=user.id join message ON user.id=received_user_id WHERE message.id='.$id;
        $dataReader=$connection->createCommand($sql)->query();
        $dataReader->bindColumn(1,$first_name);
        $dataReader->bindColumn(2,$last_name);
        $dataReader->read();
        $str=$first_name.' '.$last_name;
        return $str;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'received_user_id']);
    }
}
