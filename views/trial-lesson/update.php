<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrialLesson */

/*$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Trial Lesson',
]) . $trialLesson->trial_lesson_id;*/
$this->title = 'Изменить пробное занятие: ' . $model->trial_lesson_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trial Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->trial_lesson_id, 'url' => ['view', 'id' => $model->trial_lesson_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="trial-lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
