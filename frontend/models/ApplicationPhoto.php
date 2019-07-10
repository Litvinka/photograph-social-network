<?php

namespace frontend\models;
use common\models\User;
use yii\db\Expression;
use yii\db\ActiveRecord;
use frontend\models\City;
use frontend\models\GenresPhoto;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "application_photo".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $event_name
 * @property integer $category_id
 * @property integer $city_id
 * @property string $date_event
 * @property double $max_sum
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property ResponceApplicationPhoto[] $responceApplicationPhotos
 */
class ApplicationPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'event_name'], 'required'],
            [['user_id', 'category_id', 'city_id'], 'integer'],
            [['date_event', 'created_at', 'updated_at'], 'safe'],
            [['max_sum'], 'number'],
            [['event_name'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
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
    
    public function beforeValidate()
    {
        if ($this->date_event != null) {
        $new_date_format = date('Y-m-d', strtotime($this->date_event));
        $this->date_event = $new_date_format;
        }
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'event_name' => 'Событие',
            'category_id' => 'Категория',
            'city_id' => 'Город',
            'date_event' => 'Дата события',
            'max_sum' => 'Оплата',
            'created_at' => 'Добавлено',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponceApplicationPhotos()
    {
        return $this->hasMany(ResponceApplicationPhoto::className(), ['application_photo_id' => 'id']);
    }
    
    /**
    * @getCity
    */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
    /**
    * @getCityName
    */
    public function getCityName()
    {
        return $this->city->city_name;
    }
    /**
    * @getAllCity as list
    */
    public static function getCityList()
    {
        $droptions = City::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'city_name');
    }
    /**
    * @getCity
    */
    public function getGenres()
    {
        return $this->hasOne(GenresPhoto::className(), ['id' => 'category_id']);
    }
    /**
    * @getAllGenres as list
    */
    public static function getGenresList()
    {
        $droptions = GenresPhoto::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'genres_photo_name');
    }
    
}
