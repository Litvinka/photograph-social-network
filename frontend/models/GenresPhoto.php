<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "genres_photo"
 * @property integer $id
 * @property string $genres_photo_name
 */
class GenresPhoto extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'genres_photo';
    }

    public function rules()
    {
        return [
            [['genres_photo_name'], 'required'],
            [['genres_photo_name'], 'string', 'max' => 45],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genres_photo_name' => 'Жанры фото',
        ];
    }

    public function getPhotographResumeGenres()
    {
        return $this->hasMany(PhotographResumeGenres::className(), ['ganres_photo_id' => 'id']);
    }

    public function getPhotographResumes()
    {
        return $this->hasMany(PhotographResume::className(), ['id' => 'photograph_resume_id'])->viaTable('photograph_resume_genres', ['ganres_photo_id' => 'id']);
    }
}
