<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "currency".
 * @property integer $id
 * @property string $currency_name
 * @property string $currency_designation
 */
class Currency extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'currency';
    }

    public function rules()
    {
        return [
            [['currency_name', 'currency_designation'], 'required'],
            [['currency_name', 'currency_designation'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_name' => 'Currency Name',
            'currency_designation' => 'Currency Designation',
        ];
    }

    public function getPhotographPrices()
    {
        return $this->hasMany(PhotographPrice::className(), ['currency_id' => 'id']);
    }
}
