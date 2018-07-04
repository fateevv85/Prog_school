<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Teacher;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Teachers');
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">

  <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
      <?php
      if (!Yii::$app->user->isGuest) {
          echo(Html::a(Yii::t('app', 'Create Teacher'), ['create'], ['class' => 'btn btn-success']));
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

            'teacher_id',
//            'last_name:ntext',
            [
                'attribute' => 'last_name',
                'format' => 'html', // Возможные варианты: raw, html
                'content' => function ($data) {
//                    return Html::a($data->last_name, ['teacher/summary', 'id' => $data->teacher_id]);
                    return Html::a($data->last_name, ['teacher/view', 'id' => $data->teacher_id]);
                },
            ],
            'middle_name:ntext',
            'first_name:ntext',
            [
                'attribute' => 'city_id',
                'label' => 'Город',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return $data->getCityTitle();
                },
                'filter' => Teacher::getCitiesList(),
                'headerOptions' => ['style' => 'white-space: normal;'],
                //'contentOptions'=>['style'=>'width: 200px;'],
            ],
            'email:ntext',
            'resume:ntext',
            // 'photo:ntext',
        ],
    ];
    if (!Yii::$app->user->isGuest) {
        $params['columns'][] = ['class' => 'yii\grid\ActionColumn'];
    }
    echo(GridView::widget($params));
    ?>

    <?php Pjax::end(); ?></div>
