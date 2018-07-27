<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */

$this->title = $model->lesson_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->lesson_id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->lesson_id], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
              'method' => 'post',
          ],
      ]) ?>
  </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => Yii::t('app', 'Lecture Hall'),
                'value' => $model->getLectureHallAddress(),
            ],
            [
                'label' => Yii::t('app', 'Course'),
                'value' => $model->getCourseName(),
            ],
            [
                'attribute' => 'group_id',
                'value' => $model->getGroupName()
            ],
            [
                'label' => Yii::t('app', 'Teacher'),
                'value' => $model->getTeacherName(),
            ],
            [
                'label' => Yii::t('app', 'Date Start'),
                'value' => $model->getDateStart(),
            ],
            'cost',
            'date_start',
            'time_start',
            'duration:ntext',
            'capacity',
            'start'
        ],
    ]) ?>

</div>
