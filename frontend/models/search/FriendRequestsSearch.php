<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FriendRequests;

/**
 * FriendRequestsSearch represents the model behind the search form about `common\models\FriendRequests`.
 */
class FriendRequestsSearch extends FriendRequests
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sent_user_id', 'reseived_user_id'], 'integer'],
            [['sent_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FriendRequests::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sent_user_id' => $this->sent_user_id,
            'reseived_user_id' => $this->reseived_user_id,
            'sent_date' => $this->sent_date,
        ]);

        return $dataProvider;
    }
}
