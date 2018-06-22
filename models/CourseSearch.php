<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Course;
use app\models\CourseInCity;

/**
 * CourseSearch represents the model behind the search form about `app\models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cost'], 'number'],
//            [['course_id', 'lessons_num'], 'integer'],
            [['course_id', 'lessons_num', 'product_id'], 'integer'],
            [['title', 'description', 'synopses_link'], 'safe'],
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
       /* $courses = Course::find()->indexBy('course_id')->all();
        foreach ($courses as $id => $value) {
            $cis = new CourseInCity();
            $cis->course_id = $id;
            $cis->city_id = 1;
            $cis->save();
        }*/
        
        $query = Course::find();
        
        $identity = \Yii::$app->user->identity;
        
        if (!is_null($identity) && isset($identity->city_id) && !is_null($identity->city_id) && is_numeric($identity->city_id)) {
            if ($identity->role === 'regional_admin') {
                $coursesInCity = CourseInCity::find()->where(['city_id' => $identity->city_id])->indexBy('course_id')->all();
                $coursesInCityIds = array_keys($coursesInCity);
                $query->where(['course_id' => $coursesInCityIds]);
            }
        }
        
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
            'course_id' => $this->course_id,
            'lessons_num' => $this->lessons_num,
            'cost' => $this->cost,
            'product_id' => $this->product_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'synopses_link', $this->synopses_link]);

        return $dataProvider;
    }
}
