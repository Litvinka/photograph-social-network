<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "message_condition".
 *
 * @property integer $id
 * @property string $message_condition_name
 *
 * @property Message[] $messages
 */
class MessageCondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_condition_name'], 'required'],
            [['message_condition_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_condition_name' => 'Message Condition Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['message_condition_id' => 'id']);
    }
}
