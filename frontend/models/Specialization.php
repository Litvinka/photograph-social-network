<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "specialization".
 * @property integer $id
 * @property string $specialization_name
 */
class Specialization extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'specialization';
    }

    public function rules()
    {
        return [
            [['specialization_name'], 'required'],
            [['specialization_name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'specialization_name' => 'Specialization Name',
        ];
    }

    public function getProfileSpecializations()
    {
        return $this->hasMany(ProfileSpecialization::className(), ['specialization_id' => 'id']);
    }

    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('profile_specialization', ['specialization_id' => 'id']);
    }
}
