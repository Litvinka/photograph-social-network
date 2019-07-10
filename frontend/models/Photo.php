<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photo".
 *
 * @property integer $id
 * @property string $photo
 * @property string $photo_name
 * @property integer $user_id
 * @property string $photo_description
 * @property string $created_at
 * @property string $updated_at
 */
class Photo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'photo';
    }

    public function rules()
    {
        return [
            [['photo', 'photo_name', 'user_id'], 'required'],
            [['photo', 'photo_description'], 'string'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['photo_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    //Перед добавление и изменением фотографий устанавливается новая дата
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Фотография',
            'photo_name' => 'Название',
            'user_id' => 'User ID',
            'photo_description' => 'Описание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getCommentsPhotos()
    {
        return $this->hasMany(CommentsPhoto::className(), ['photo_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('comments_photo', ['photo_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPhotoLikes()
    {
        return $this->hasMany(PhotoLike::className(), ['photo_id' => 'id']);
    }

    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('photo_like', ['photo_id' => 'id']);
    }

    public function getPhotoTags()
    {
        return $this->hasMany(PhotoTags::className(), ['photo_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('photo_tags', ['photo_id' => 'id']);
    }

    public function getPhotoViews()
    {
        return $this->hasMany(PhotoView::className(), ['photo_id' => 'id']);
    }

    public function getUsers1()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('photo_view', ['photo_id' => 'id']);
    }
    
    
}
