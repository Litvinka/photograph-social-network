<?php

namespace frontend\models;

use Yii;
use frontend\models\Specialization;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profile_specialization".
 * @property integer $profile_id
 * @property integer $specialization_id
 */
class ProfileSpecialization extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'profile_specialization';
    }

    public function rules()
    {
        return [
            [['profile_id', 'specialization_id'], 'required'],
            [['profile_id', 'specialization_id'], 'integer'],
            [['specialization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialization::className(), 'targetAttribute' => ['specialization_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'specialization_id' => 'Специализация',
        ];
    }

    public function getSpecialization()
    {
        return $this->hasOne(Specialization::className(), ['id' => 'specialization_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
    
    //Получение всех имен специализаций в виде массива
    public static function getSpecializationList()
    {
        $droptions = Specialization::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'specialization_name');
    }
    //Получение имени конкретной специализации
    public function getSpecializationName()
    {
        return $this->specialization->specialization_name;
    }
    
}
