<?php

namespace frontend\models;

use Yii;
use frontend\models\GenresPhoto;
use yii\helpers\ArrayHelper;
/**
 * @property integer $photograph_resume_id
 * @property integer $ganres_photo_id
 */
class PhotographResumeGenres extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'photograph_resume_genres';
    }

    public function rules()
    {
        return [
            [['photograph_resume_id', 'ganres_photo_id'], 'required'],
            [['photograph_resume_id', 'ganres_photo_id'], 'integer'],
            [['ganres_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => GenresPhoto::className(), 'targetAttribute' => ['ganres_photo_id' => 'id']],
            [['photograph_resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhotographResume::className(), 'targetAttribute' => ['photograph_resume_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'photograph_resume_id' => 'Photograph Resume ID',
            'ganres_photo_id' => 'Ganres Photo ID',
        ];
    }

    public function getGanresPhoto()
    {
        return $this->hasOne(GenresPhoto::className(), ['id' => 'ganres_photo_id']);
    }

    public function getPhotographResume()
    {
        return $this->hasOne(PhotographResume::className(), ['id' => 'photograph_resume_id']);
    }
    
    //Получение всех имен жанров в виде массива
    public static function getGenresPhotoList()
    {
        $droptions = GenresPhoto::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'genres_photo_name');
    }
    //Получение имени конкретного жанра
    public function getGenresPhotoName()
    {
        return $this->genres_photo->genres_photo_name;
    }
}
