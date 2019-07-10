<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "friends".
 * @property integer $id
 * @property integer $user_id1
 * @property integer $user_id2
 */
class Friends extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'friends';
    }

    public function rules()
    {
        return [
            [['user_id1', 'user_id2'], 'required'],
            [['user_id1', 'user_id2'], 'integer'],
            [['user_id1'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id1' => 'id']],
            [['user_id2'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id2' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id1' => 'User Id1',
            'user_id2' => 'User Id2',
        ];
    }

    public function getUserId1()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id1']);
    }

    public function getUserId2()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id2']);
    }
    
    public function findModel($user_id1, $user_id2)
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
