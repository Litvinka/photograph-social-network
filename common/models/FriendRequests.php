<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "friend_requests".
 * @property integer $id
 * @property integer $sent_user_id
 * @property integer $reseived_user_id
 * @property string $sent_date
 */
class FriendRequests extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'friend_requests';
    }

    public function rules()
    {
        return [
            [['sent_user_id', 'reseived_user_id'], 'required'],
            [['id','sent_user_id', 'reseived_user_id'], 'integer'],
            [['sent_date'], 'safe'],
            [['sent_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sent_user_id' => 'id']],
            [['reseived_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reseived_user_id' => 'id']],
        ];
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['sent_date'],
            ],
            'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sent_user_id' => 'Sent User ID',
            'reseived_user_id' => 'Reseived User ID',
            'sent_date' => 'Sent Date',
        ];
    }

    public function getSentUser()
    {
        return $this->hasOne(User::className(), ['id' => 'sent_user_id']);
    }

    public function getReseivedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'reseived_user_id']);
    }
    
    public function findModel($sent_user_id, $reseived_user_id)
    {
        if (($model = FriendRequests::findOne(['sent_user_id' => $sent_user_id, 'reseived_user_id' => $reseived_user_id])) !== null) {
            return $model;
        }else if(($model = FriendRequests::findOne(['sent_user_id' => $reseived_user_id, 'reseived_user_id' => $sent_user_id])) !== null){
            return $model;
        }
        else {
            return null;
        }
    }
    
}
