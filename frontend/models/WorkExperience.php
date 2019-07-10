<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "work_experience".
 * @property integer $id
 * @property string $work_experience_name
 * @property string $work_experience_number
 
 */
class WorkExperience extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'work_experience';
    }

    public function rules()
    {
        return [
            [['work_experience_name', 'work_experience_number'], 'required'],
            [['work_experience_name', 'work_experience_number'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_experience_name' => 'Опыт работы',
            'work_experience_number' => 'Work Experience Number',
        ];
    }

    public function getPhotographResumes()
    {
        return $this->hasMany(PhotographResume::className(), ['experience_id' => 'id']);
    }    
    
}
