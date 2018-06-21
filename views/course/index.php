<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Courses');
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Course'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); 
    $params = [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'course_id',
            [
                'attribute'=>'course_id',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->course_id;
                },
                'headerOptions'=>['style'=>'white-space: normal;'],
                'options' => ['width' => '70']
            ],
            'title:ntext',
            'description:ntext',
            //'synopses_link:ntext',
            [
                'attribute' => 'synopses_link',
                'content'=>function($data){
                    if ( isset($data->synopses_link)) {
                        $link = HTML::encode($data->synopses_link);
                        if ( !empty($link)/*BaseUrl::isRelative($link )*/ ) {
                            return '<a target="_blank" href="' . $link  . '">Перейти</a>';
                        }
                    } else {
                        return '';
                    }
                },
            ],
            //'lessons_num',
            //'cost',
            [
                'attribute'=>'lessons_num',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->lessons_num;
                },
                'headerOptions'=>['style'=>'white-space: normal;'],
                'options' => ['width' => '70']
            ],
            [
                'attribute'=>'cost',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->cost;
                },
                'headerOptions'=>['style'=>'white-space: normal;'],
                'options' => ['width' => '70']
            ],
            [
                'attribute'=>'citiesString',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getCitiesString();
                },
                'headerOptions'=>['style'=>'white-space: normal;'],
                'options' => ['width' => '70']
            ]
        ],
    ];
    if (!Yii::$app->user->isGuest) {
        $params['columns'][] = ['class' => 'yii\grid\ActionColumn'];
    }
    echo(GridView::widget($params));
?>
<?php Pjax::end(); ?></div>
