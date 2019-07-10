<?php

namespace frontend\models;

use Yii;
use frontend\models\Profile;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photograph_resume".
 * @property integer $id
 * @property integer $profile_id
 * @property integer $experience_id
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at

 */
class PhotographResume extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'photograph_resume';
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ],
            'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['id','profile_id', 'experience_id', 'published'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['experience_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkExperience::className(), 'targetAttribute' => ['experience_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'experience_id' => 'Опыт работы',
            'published' => 'Опубликовать резюме',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPhotographPrices()
    {
        return $this->hasMany(PhotographPrice::className(), ['resume_id' => 'id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    public function getExperience()
    {
        return $this->hasOne(WorkExperience::className(), ['id' => 'experience_id']);
    }
    public function getExperienceName()
    {
        return $this->experience->work_experience_name;
    }

    public static function getExperienceList()
    {
        $droptions = WorkExperience::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'work_experience_name');
    }

    public function getPhotographResumeGenres()
    {
        return $this->hasMany(PhotographResumeGenres::className(), ['photograph_resume_id' => 'id']);
    }

    public function getGanresPhotos()
    {
        return $this->hasMany(GenresPhoto::className(), ['id' => 'ganres_photo_id'])->viaTable('photograph_resume_genres', ['photograph_resume_id' => 'id']);
    }

    public function getPhotographResumePreferences()
    {
        return $this->hasMany(PhotographResumePreferences::className(), ['resume_id' => 'id']);
    }

    public function getPhotographPreferences()
    {
        return $this->hasMany(PreferencesPhotography::className(), ['id' => 'photograph_preferences_id'])->viaTable('photograph_resume_preferences', ['resume_id' => 'id']);
    }
    
    //Получение всех жанров фотографов
    public function getGenresByResumeId($id)
    {
        $str="";
        $array = PhotographResumeGenres::findAll(['photograph_resume_id' => $id]);
        $array = ArrayHelper::getColumn($array, 'ganres_photo_id');
        foreach ($array as $key => $value) {
            $value= PhotographResumeGenres::getGenresPhotoList()[$value];
            if($key==0){
                $str=$value;
            }
            else{
                $str.=', '.$value;
            }      
        }  
        return $str;
    }
    
     //Получение всех предпочтений фотографа
    public function getPreferencesByResumeId($id)
    {
        $str="";
        $array = PhotographResumePreferences::findAll(['resume_id' => $id]);
        $array = ArrayHelper::getColumn($array, 'photograph_preferences_id');
        foreach ($array as $key => $value) {
            $value= PhotographResumePreferences::getPreferencesList()[$value];
            if($key==0){
                $str=$value;
            }
            else{
                $str.=', '.$value;
            }      
        }  
        return $str;
    }
    
    
}
