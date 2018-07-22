<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Group;

//use app\models\City;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

  <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
      <?php
      if (!Yii::$app->user->isGuest) {
          echo(Html::a(Yii::t('app', 'Create Group'), ['create'], ['class' => 'btn btn-success']));
      }
      ?>
  </p>
    <?php Pjax::begin(); ?>
    <?php
    $params = [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'group_id',
            [
                'attribute' => 'title',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return Html::a($data->title, ['group/view', 'id' => $data->group_id]);
                },
                'headerOptions' => ['style' => 'white-space: normal;'],
                'contentOptions' => ['style' => 'width: 100px;'],
            ],
            'participants_num',
//            'participants_num_max',
            [
                'attribute' => 'city_id',
                'label' => 'Город',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return $data->getCityTitle();
                },
                'filter' => Group::getCitiesList(),
                //'filter' => City::getCitiesForCurrentUser(),
                'headerOptions' => ['style' => 'white-space: normal;'],
                //'contentOptions'=>['style'=>'width: 200px;'],
            ],

        ],
    ];
    if (!Yii::$app->user->isGuest) {
        $params['columns'][] = ['class' => 'yii\grid\ActionColumn'];
    }
    echo(GridView::widget($params));
    ?>
    <?php Pjax::end(); ?></div>
