<?php

namespace app\models\tables;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tables\Product;
use yii\helpers\ArrayHelper;

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
//            [['cnt'], 'safe'],
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

    public function productSearch($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
//             $query->where('0=1');
            return $dataProvider;
        }

        $amoQuery = ($this->amo_paid_view) ?
            ['amo_paid_view' => $this->amo_paid_view] :
            ['amo_trial_view' => $this->amo_trial_view];

        // grid filtering conditions
        $query
//            ->select(['product.name', 'product.city_id', 'product.amo_paid_view', 'product.amo_trial_view', 'lesson.*'])
            ->select(['product.name', 'product.city_id', 'product.amo_paid_view', 'product.amo_trial_view', 'lesson.*', 'group.title AS group_title', 'group.participants_num AS group_participants_num', 'course.title AS course_title', 'lecture_hall.place_description as lecture_desc'])
//            ->select(['product.name','product.city_id','product.amo_paid_view','product.amo_trial_view','group_concat(lesson.lesson_id) as lesson_id'])
            ->leftJoin('course', 'course.product_id = product.id')
            ->leftJoin('lesson', 'lesson.course_id = course.course_id')
            ->leftJoin('group', 'lesson.group_id = group.group_id')
            ->leftJoin('lecture_hall', 'lesson.lecture_hall_id = lecture_hall.lecture_hall_id')
            /*->where(['amo_paid_view' => $this->amo_paid_view,
                'amo_trial_view' => $this->amo_trial_view]);*/
            ->where($amoQuery);

        return $dataProvider;
    }
}
