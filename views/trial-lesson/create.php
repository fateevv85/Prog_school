<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrialLesson */

$this->title = Yii::t('app', 'Create Trial Lesson');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trial Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trial-lesson-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        /*'teacher' => $teacher,
        //'lesson' => $lesson,
        'lectureHall' => $lectureHall,
        'group' => $group,
        'course' => $course,*/
    ]) ?>

</div>
