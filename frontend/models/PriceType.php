<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "price_type".
 * @property integer $id
 * @property string $price_type_name
 */
class PriceType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'price_type';
    }

    public function rules()
    {
        return [
            [['price_type_name'], 'required'],
            [['price_type_name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_type_name' => 'Price Type Name',
        ];
    }

    public function getPhotographPrices()
    {
        return $this->hasMany(PhotographPrice::className(), ['price_type_id' => 'id']);
    }
}
