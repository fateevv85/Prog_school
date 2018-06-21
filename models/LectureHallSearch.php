<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LectureHall;

/**
 * LectureHallSearch represents the model behind the search form about `app\models\LectureHall`.
 */
class LectureHallSearch extends LectureHall
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['lecture_hall_id'], 'integer'],
            //[['city', 'metro_station', 'street', 'address'], 'safe'],
            [['lecture_hall_id', 'city_id'], 'integer'],
            //[['title', 'metro_station', 'street', 'address'], 'safe'],
            [['title', 'metro_station', 'place_description'], 'safe'],
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
        $query = LectureHall::find();
        
        //у авторизованных пользователей показываем данные только по их городу
        $query = \app\custom\CustomSearch::filterByUserCity($query);
        
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
            'lecture_hall_id' => $this->lecture_hall_id,
            'city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'metro_station', $this->metro_station])
            //->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'place_description', $this->place_description]);
            //->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
