<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "blog_post_comments".
 * @property integer $post_id
 * @property integer $user_id
 * @property string $comment
 * @property string $image
 * @property string $created_at
 */
class BlogPostComments extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'blog_post_comments';
    }

    public function rules()
    {
        return [
            [['post_id', 'user_id', 'comment'], 'required'],
            [['id','post_id', 'user_id'], 'integer'],
            [['comment', 'image'], 'string'],
            [['created_at'], 'safe'],
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
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
            ],
            'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'user_id' => 'Пользователь',
            'comment' => 'Комментарий',
            'image' => 'Изображение',
            'created_at' => 'Добавлен',
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
