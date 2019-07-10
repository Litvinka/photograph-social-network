<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "responce_application_photo".
 *
 * @property string $id
 * @property integer $application_photo_id
 * @property integer $photograph_id
 * @property string $text
 *
 * @property ApplicationPhoto $applicationPhoto
 * @property User $photograph
 */
class ResponceApplicationPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'responce_application_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_photo_id', 'photograph_id', 'text'], 'required'],
            [['application_photo_id', 'photograph_id'], 'integer'],
            [['text'], 'string'],
            [['application_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationPhoto::className(), 'targetAttribute' => ['application_photo_id' => 'id']],
            [['photograph_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['photograph_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_photo_id' => 'Application Photo ID',
            'photograph_id' => 'Photograph ID',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPhoto()
    {
        return $this->hasOne(ApplicationPhoto::className(), ['id' => 'application_photo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotograph()
    {
        return $this->hasOne(User::className(), ['id' => 'photograph_id']);
    }
}
