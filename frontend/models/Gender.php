<?php

namespace frontend\models;

use Yii;
use frontend\models\Profile;

/**
 * This is the model class for table "gender".
 *
 * @property integer $id
 * @property string $gender_name
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender_name'], 'required'],
            [['gender_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gender_name' => 'Пол',
        ];
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['gender_id' => 'id']);
    }
    
}
