<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DepositsHistory;

/**
 * DepositsHistorySearch represents the model behind the search form about `common\models\DepositsHistory`.
 */
class DepositsHistorySearch extends DepositsHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deposit_id', 'deposit_operation_id', 'created_at', 'created_by'], 'integer'],
            [['sum_before', 'sum_change', 'percent'], 'number'],
            [['comment'], 'safe'],
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
    public function search($params, $depositId)
    {
        $query = DepositsHistory::find();

        if ($depositId) {
            $query->where('deposit_id = :deposit', [':deposit' => $depositId]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id'=>SORT_ASC
                ]
            ],
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
            'deposit_id' => $this->deposit_id,
            'deposit_operation_id' => $this->deposit_operation_id,
            'sum_before' => $this->sum_before,
            'sum_change' => $this->sum_change,
            'percent' => $this->percent,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
