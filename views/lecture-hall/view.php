<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LectureHall */

$this->title = $model->lecture_hall_id;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecture Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecture-hall-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <?php
            if (!Yii::$app->user->isGuest) {
                echo(Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->lecture_hall_id], ['class' => 'btn btn-primary']));
                echo(Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->lecture_hall_id], [
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
            'lecture_hall_id',
            'title:ntext',
            'cityTitle:ntext',
            'metro_station:ntext',
            'place_description:ntext',
            'link_yandex_map:ntext',
            //'google_calendar_name:ntext',
        ],
    ]) ?>

</div>
