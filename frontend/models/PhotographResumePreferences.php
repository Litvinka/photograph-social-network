<?php

namespace frontend\models;

use Yii;
use frontend\models\PreferencesPhotography;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "photograph_resume_preferences".
 * @property integer $resume_id
 * @property integer $photograph_preferences_id
 */
class PhotographResumePreferences extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'photograph_resume_preferences';
    }

    public function rules()
    {
        return [
            [['resume_id', 'photograph_preferences_id'], 'required'],
            [['resume_id', 'photograph_preferences_id'], 'integer'],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhotographResume::className(), 'targetAttribute' => ['resume_id' => 'id']],
            [['photograph_preferences_id'], 'exist', 'skipOnError' => true, 'targetClass' => PreferencesPhotography::className(), 'targetAttribute' => ['photograph_preferences_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'resume_id' => 'Resume ID',
            'photograph_preferences_id' => 'Photograph Preferences ID',
        ];
    }

    public function getResume()
    {
        return $this->hasOne(PhotographResume::className(), ['id' => 'resume_id']);
    }

    public function getPhotographPreferences()
    {
        return $this->hasOne(PreferencesPhotography::className(), ['id' => 'photograph_preferences_id']);
    }
    
    //Получение всех имен жанров в виде массива
    public static function getPreferencesList()
    {
        $droptions = PreferencesPhotography::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'preferences_photography_name');
    }
    //Получение имени конкретного жанра
    public function getPreferencesName()
    {
        return $this->preferences_photography->preferences_photography_name;
    }
    
}
