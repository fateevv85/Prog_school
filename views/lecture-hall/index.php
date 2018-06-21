<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\LectureHall;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LectureHallSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lecture Halls');
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecture-hall-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            if (!Yii::$app->user->isGuest) {
                echo( Html::a(Yii::t('app', 'Create Lecture Hall'), ['create'], ['class' => 'btn btn-success']));
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

            'lecture_hall_id',
            'title:ntext',
            [
                'attribute'=>'city_id',
                'label'=>'Город',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getCityTitle();
                },
                'filter' => LectureHall::getCitiesList(),
                'headerOptions'=>['style'=>'white-space: normal;'],
                //'contentOptions'=>['style'=>'width: 200px;'],
            ],
            //'city:ntext',
            'metro_station:ntext',
            'place_description:ntext',
            //'link_yandex_map:ntext',
            [
                'attribute' => 'link_yandex_map',
                'content'=>function($data){
                    if ( isset($data->link_yandex_map)) {
                        $link = HTML::encode($data->link_yandex_map);
                        if ( !empty($link)/*BaseUrl::isRelative($link )*/ ) {
                            return '<a target="_blank" href="' . $link  . '">Перейти</a>';
                        }
                    } else {
                        return '';
                    }
                },
            ],
            //'google_calendar_name:ntext',
            //'street:ntext',
            //'address:ntext',
        ],
    ];
    if (!Yii::$app->user->isGuest) {
        $params['columns'][] = ['class' => 'yii\grid\ActionColumn'];
    }
    echo(GridView::widget($params)); 
?>
<?php Pjax::end(); ?></div>
