<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lesson;

/**
 * LessonSearch represents the model behind the search form about `app\models\Lesson`.
 */
class LessonSearch extends Lesson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'group_id', 'lecture_hall_id', 'teacher_id', 'duration', 'city_id', 'capacity', 'start'], 'integer'],
//            [['cost'], 'number'],
            [['date_start', 'time_start', 'course_id', 'few_lesson_id'], 'safe'],
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
        $query = Lesson::find();

        $lessons = ($str = $params['few_lesson_id']) ? ['in', 'lesson_id', $str] : $this->lesson_id;

        $query->where($lessons);

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
            'group_id' => $this->group_id,
            'lecture_hall_id' => $this->lecture_hall_id,
            'course_id' => $this->course_id,
            'teacher_id' => $this->teacher_id,
            'duration' => $this->duration,
            //'date_start' => $this->date_start,
            'time_start' => $this->time_start,
            'city_id' => $this->city_id,
            'capacity' => $this->capacity,
            'start' => $this->start
        ]);

        if (!is_null($this->date_start)) {
            if (strpos($this->date_start, ' - ') !== false) {
                list($start_date, $end_date) = explode(' - ', $this->date_start);
                $start_date = Yii::$app->formatter->asDate($start_date, 'yyyy-MM-dd');
                $end_date = Yii::$app->formatter->asDate($end_date, 'yyyy-MM-dd');
                $query->andFilterWhere(['between', 'date_start', $start_date, $end_date]);
            } else if (!empty($this->date_start)) {
                $start_date = Yii::$app->formatter->asDate($this->date_start, 'yyyy-MM-dd');
                $query->andFilterWhere(['like', 'date_start', $start_date]);
            }
        }
        $query->andFilterWhere(['like', 'cost', $this->cost]);

        return $dataProvider;
    }
}
