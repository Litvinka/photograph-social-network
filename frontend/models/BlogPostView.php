<?php

namespace frontend\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use common\models\User;

/**
 * This is the model class for table "blog_post_view".
 *
 * @property integer $post_id
 * @property integer $user_id
 * @property string $date_view
 *
 * @property BlogPost $post
 * @property User $user
 */
class BlogPostView extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'blog_post_view';
    }

    public function rules()
    {
        return [
            [['post_id', 'user_id'], 'required'],
            [['post_id', 'user_id'], 'integer'],
            [['date_view'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPost::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['date_view'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['date_view'],
            ],
            'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'date_view' => 'Date View',
        ];
    }

    public function getPost()
    {
        return $this->hasOne(BlogPost::className(), ['id' => 'post_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
