<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->title;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if (!Yii::$app->user->isGuest) {
                echo(Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->course_id], ['class' => 'btn btn-primary']));
                echo(Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->course_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]));
            }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_id',
            /*[
                'attribute'=>'course_id',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->course_id;
                },
                'headerOptions'=>['style'=>'white-space: normal;'],
                'options' => ['width' => '70']
            ],*/
            'title:ntext',
            'description:ntext',
            'synopses_link:ntext',
            'lessons_num',
            /*[
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
            ],*/
            'cost',
        ],
    ]) ?>

</div>
