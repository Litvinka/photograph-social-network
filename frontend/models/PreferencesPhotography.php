<?php

namespace frontend\models;
use Yii;

/**
 * This is the model class for table "preferences_photography".
 * @property integer $id
 * @property string $preferences_photography_name
 */
class PreferencesPhotography extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'preferences_photography';
    }

    public function rules()
    {
        return [
            [['preferences_photography_name'], 'required'],
            [['preferences_photography_name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preferences_photography_name' => 'Preferences Photography Name',
        ];
    }

    public function getPhotographResumePreferences()
    {
        return $this->hasMany(PhotographResumePreferences::className(), ['photograph_preferences_id' => 'id']);
    }

    public function getResumes()
    {
        return $this->hasMany(PhotographResume::className(), ['id' => 'resume_id'])->viaTable('photograph_resume_preferences', ['photograph_preferences_id' => 'id']);
    }
}
