<?php

namespace app\models\tables;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `app\models\tables\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'amo_paid_view', 'amo_trial_view'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function formName()
    {
        return '';
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $noLimit = null)
    {
        //у авторизованных пользователей показываем данные только по их городу
        $query = \app\custom\CustomSearch::filterByUserCity(Product::find());

        // add conditions that should always apply here
        $dataProviderParams = [
            'query' => $query,
        ];

        if ($noLimit) {
            $dataProviderParams['pagination'] = false;
        }

        $dataProvider = new ActiveDataProvider($dataProviderParams);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'amo_paid_view' => $this->amo_paid_view,
            'amo_trial_view' => $this->amo_trial_view,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
