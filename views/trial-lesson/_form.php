<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Teacher;
use app\models\TrialLesson;
use \kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TrialLesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trial-lesson-form">

    <?php $form = ActiveForm::begin(); ?>

    <? /*= $form->field($model, 'group_id')->dropdownList(
        TrialLesson::getGroupsList(),
        ['prompt' => 'Выберите группу учащихся']
    ) */ ?>

    <?= $form->field($model, 'group_id')->widget(Select2::classname(), [
        'data' => TrialLesson::getGroupsList(),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите группу учащихся'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'lecture_hall_id')->dropdownList(
        TrialLesson::getLectureHallsList(),
        ['prompt' => 'Выберите площадку']
    ) ?>

    <?= $form->field($model, 'course_id')->dropdownList(
        TrialLesson::getCoursesList(),
        ['prompt' => 'Выберите курс обучения']
    ) ?>

    <?= $form->field($model, 'teacher_id')->dropdownList(
        Teacher::getNames(),
        ['prompt' => 'Выберите преподавателя']
    ) ?>

    <?= $form->field($model, 'date_start')->textInput()->input('date'/*, ['placeholder' => "2017-10-23"]*/) ?>

    <?= $form->field($model, 'time_start')->textInput()->input('time'/*, ['placeholder' => "14:15"]*/) ?>

    <?= $form->field($model, 'duration')->input('number', ['min' => 0]) ?>

    <?= $form->field($model, 'num_trial')->input('number', ['min' => 0]) ?>

    <?= $form->field($model, 'course_date_start')->textInput()->input('date'/*, ['placeholder' => "2017-10-23"]*/) ?>

    <?= $form->field($model, 'lead_link')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'capacity')->input('number', [
        'min' => 1,
    ]) ?>

    <?= $form->field($model, 'start')->checkbox() ?>

    <?php
    if (!$model->isNewRecord && Yii::$app->user->identity->role === 'main_admin') {
        echo(
        $form->field($model, 'city_id')->dropdownList(
            TrialLesson::getCitiesList(),
            ['prompt' => 'Выберите город']
        )
        );
    }

    ?>
  <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
