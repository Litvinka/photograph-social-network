<?php

namespace frontend\models;

use Yii;
use frontend\models\Currency;
use frontend\models\PriceType;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "photograph_price".
 * @property integer $resume_id
 * @property integer $price_type_id
 * @property integer $currency_id
 * @property double $price
 */
class PhotographPrice extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'photograph_price';
    }

    public function rules()
    {
        return [
            [['resume_id', 'price_type_id', 'currency_id', 'price'], 'required'],
            [['resume_id', 'price_type_id', 'currency_id'], 'integer'],
            [['price'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhotographResume::className(), 'targetAttribute' => ['resume_id' => 'id']],
            [['price_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PriceType::className(), 'targetAttribute' => ['price_type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'resume_id' => 'Resume ID',
            'price_type_id' => 'Price Type ID',
            'currency_id' => 'Currency ID',
            'price' => 'Price',
        ];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getResume()
    {
        return $this->hasOne(PhotographResume::className(), ['id' => 'resume_id']);
    }

    public function getPriceType()
    {
        return $this->hasOne(PriceType::className(), ['id' => 'price_type_id']);
    }
    
    //Получение всех обозначений валют в виде массива
    public static function getCurrencyList()
    {
        $droptions = Currency::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'currency_designation');
    }
    //Получение обозначения конкретной валюты
    public function getCurrencyDesignation()
    {
        return $this->currency->currency_designation;
    }
    
    public static function getPriceTypeList()
    {
        $droptions = PriceType::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'price_type_name');
    }
    public function getPriceTypeName()
    {
        return $this->price_type->price_type_name;
    }
    
}
