<?php

namespace app\models;

use app\custom\CustomSearch;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrialLesson;
use yii\i18n\Formatter;

/**
 * TrialLessonSearch represents the model behind the search form about `app\models\TrialLesson`.
 */
class TrialLessonSearch extends TrialLesson
{
    /**
     * @inheritdoc
     */
    //public $date_start =  date('Y-m-d', time() + 3 * 60 * 60);
    public $startAvailableDate;

    public function rules()
    {
        return [
            [['trial_lesson_id', 'group_id', 'lecture_hall_id', 'teacher_id', 'duration', 'city_id', 'capacity', 'start'], 'integer'],
            [['course_date_start', 'date_start', 'time_start', 'num_trial', 'course_id'], 'safe'],
            //[['date_start'], 'date'],
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

        //if ($init) {
        //$params['TrialLessonSearch']['date_start'] = date('Y-m-d', time() + 3 * 60 * 60);
        //}
        $query = TrialLesson::find();

        //у авторизованных пользователей показываем данные только по их городу
        $query = \app\custom\CustomSearch::filterByUserCity($query);

        if ($productId = $params['TrialLessonSearch']['product_id']) {
            $query = CustomSearch::filterByProduct($query, $productId, 'trial_');
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //print_r($params);
        //die;
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // print_r($this->date_start);
        // die;
        $query->andFilterWhere([
            'trial_lesson_id' => $this->trial_lesson_id,
            'group_id' => $this->group_id,
            // 'lesson_id' => $this->lesson_id,
            'lecture_hall_id' => $this->lecture_hall_id,
            'course_id' => $this->course_id,
            'teacher_id' => $this->teacher_id,
            'duration' => $this->duration,
            'time_start' => $this->time_start,
            'course_date_start' => $this->course_date_start,
            'city_id' => $this->city_id,
            'capacity'=> $this->capacity,
            'start'=> $this->start
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
        $query->andFilterWhere(['like', 'num_trial', $this->num_trial]);

        return $dataProvider;
    }
}
