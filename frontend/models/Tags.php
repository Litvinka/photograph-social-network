<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $tag_blog_count
 * @property integer $tag_photo_count
 *
 * @property BlogTags[] $blogTags
 * @property BlogPost[] $posts
 * @property PhotoTags[] $photoTags
 * @property Photo[] $photos
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_name'], 'required'],
            [['tag_blog_count', 'tag_photo_count'], 'integer'],
            [['tag_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'tag_blog_count' => 'Tag Blog Count',
            'tag_photo_count' => 'Tag Photo Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTags::className(), ['tags_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(BlogPost::className(), ['id' => 'post_id'])->viaTable('blog_tags', ['tags_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoTags()
    {
        return $this->hasMany(PhotoTags::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['id' => 'photo_id'])->viaTable('photo_tags', ['tag_id' => 'id']);
    }
}
