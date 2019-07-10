<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\Gender;
use frontend\models\City;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;
use frontend\models\ProfileSpecialization;
use frontend\models\PhotographResume;
use frontend\models\Message;
use common\models\FriendRequests;

/**
 * This is the model class for table "profile".
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id','first_name', 'last_name'], 'required'],
            [['user_id', 'gender_id', 'city_id'], 'integer'],
            [['photo','interests', 'about_yourself'], 'string'],
            [['phone'], 'string', 'max'=>20],
            [['first_name', 'last_name', 'site', 'vk', 'facebook', 'instagram'], 'string', 'max'=>255],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['user_id'], 'unique'],
            [['gender_id'],'in', 'range'=>array_keys($this->getGenderList())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'birthdate' => 'Дата рождения',
            'gender_id' => 'Пол',
            'photo' => 'Фотография',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'phone' => 'Телефон',
            'site' => 'Сайт',
            'vk' => 'Vkontakte',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'city_id' => 'Город',
            'interests' => 'Интересы',
            'about_yourself' => 'О себе',
            'genderName' => Yii::t('app', 'Gender'),
            'userLink' => Yii::t('app', 'User'),
            'profileIdLink' => Yii::t('app', 'Profile'),
        ];
    }
    
    /**
    * behaviors to control time stamp, don't forget to use statement for expression
    *
    */
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
    
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }
    /**
    * uses magic getGender on return statement
    *
    */
    public function getGenderName()
    {
        return $this->gender->gender_name;
    }
    /**
    * get list of genders for dropdown
    */
    public static function getGenderList()
    {
        $droptions = Gender::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'gender_name');
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
    * @get Username
    */
    public function getUsername()
    {
        return $this->user->username;
    }
    /**
    * @getUserId
    */
    public function getUserId()
    {
        return $this->user ? $this->user->id : 'none';
    }
    /**
    * @getUserLink
    */
    
    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id'=>$this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }
    /**
    * @getProfileLink
    */
    public function getProfileIdLink()
    {
        $url = Url::to(['profile/update', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }
    
    public function beforeValidate()
    {
        if ($this->birthdate != null) {
        $new_date_format = date('Y-m-d', strtotime($this->birthdate));
        $this->birthdate = $new_date_format;
        }
        return parent::beforeValidate();
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
    
    
    //Получение всех специализаций текущего пользователя
    public function getSpecializationsByProfileId()
    {
        $str="";
        $array = ProfileSpecialization::findAll(['profile_id' => $this->id]);
        $array = ArrayHelper::getColumn($array, 'specialization_id');
        foreach ($array as $key => $value) {
            $value= ProfileSpecialization::getSpecializationList()[$value];
            if($key==0){
                $str=$value;
            }
            else{
                $str.=', '.$value;
            }      
        }  
        return $str;
    }
    
    public function IsFriends($id1,$id2){
        return Yii::$app->db->createCommand('SELECT COUNT(id) FROM friends WHERE user_id1='.$id1.' AND user_id2='.$id2.' OR user_id1='.$id2.' AND user_id2='.$id1)->queryScalar(); 
    }
    
}
