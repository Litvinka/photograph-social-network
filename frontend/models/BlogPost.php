<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\Expression;
use yii\db\ActiveRecord;
use frontend\models\BlogPostView;

/**
 * This is the model class for table "blog_post".
 * @property integer $id
 * @property string $post_name
 * @property integer $user_id
 * @property string $post
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 */
class BlogPost extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'blog_post';
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
            [['post_name', 'user_id', 'post'], 'required'],
            [['user_id'], 'integer'],
            [['post', 'image'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['post_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_name' => 'Название',
            'user_id' => 'User ID',
            'post' => 'Запись',
            'image' => 'Изображение',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getBlogPostComments()
    {
        return $this->hasMany(BlogPostComments::className(), ['post_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('blog_post_comments', ['post_id' => 'id']);
    }

    public function getBlogPostViews()
    {
        return $this->hasMany(BlogPostView::className(), ['post_id' => 'id']);
    }

    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('blog_post_view', ['post_id' => 'id']);
    }

    public function getBlogTags()
    {
        return $this->hasMany(BlogTags::className(), ['post_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tags_id'])->viaTable('blog_tags', ['post_id' => 'id']);
    }
    
    public function getViewCount($id){
        return Yii::$app->db->createCommand('SELECT COUNT(*) FROM blog_post_view WHERE post_id='.$id)->queryScalar();
    }
    
    public function getCommentCount($id){
        return Yii::$app->db->createCommand('SELECT COUNT(*) FROM blog_post_comments WHERE post_id='.$id)->queryScalar();
    }
    
}
