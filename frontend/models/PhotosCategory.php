<?php

namespace frontend\models;

use Yii;
use frontend\models\GenresPhoto;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "photos_category".
 * @property integer $photo_id
 * @property integer $ganres_id
 * @property GenresPhoto $ganres
 * @property Photo $photo
 */
class PhotosCategory extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'photos_category';
    }

    public function rules()
    {
        return [
            [['photo_id', 'ganres_id'], 'required'],
            [['photo_id', 'ganres_id'], 'integer'],
            [['ganres_id'], 'exist', 'skipOnError' => true, 'targetClass' => GenresPhoto::className(), 'targetAttribute' => ['ganres_id' => 'id']],
            [['photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Photo::className(), 'targetAttribute' => ['photo_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'photo_id' => 'Photo ID',
            'ganres_id' => 'Ganres ID',
        ];
    }

    public function getGanres()
    {
        return $this->hasOne(GenresPhoto::className(), ['id' => 'ganres_id']);
    }

    public function getPhoto()
    {
        return $this->hasOne(Photo::className(), ['id' => 'photo_id']);
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
