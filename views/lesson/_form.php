<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Teacher;
use app\models\Lesson;
use \kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(); ?>


    <?/*= $form->field($model, 'group_id')->dropdownList(
    // Group::getTitles(),
        Lesson::getGroupsList(),
        ['prompt' => 'Выберите группу учащихся']
    ) */?>

  <?=
  $form->field($model, 'group_id')->widget(Select2::classname(), [
      'data' => Lesson::getGroupsList(),
      'language' => 'ru',
      'options' => ['placeholder' => 'Выберите группу учащихся'],
      'pluginOptions' => [
          'allowClear' => true
      ],
  ]);
  ?>

    <?= $form->field($model, 'lecture_hall_id')->dropdownList(
    //LectureHall::find()->select(['lecture_hall_id', 'lecture_hall_id'])->indexBy('lecture_hall_id')->column(),
    // LectureHall::getAddresses(),
        Lesson::getLectureHallsList(),
        ['prompt' => 'Выберите площадку']
    ) ?>

    <? /*= $form->field($model, 'course_id')->dropdownList(
        Lesson::getCoursesList(),
        ['prompt' => 'Выберите курс обучения']
    ) */ ?>

    <?=
    $form->field($model, 'course_id')->widget(Select2::classname(), [
        'data' => Lesson::getCoursesList(),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите курс обучения'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'teacher_id')->dropdownList(
        Teacher::getNames(),
        ['prompt' => 'Выберите преподавателя']
    ) ?>

    <?= $form->field($model, 'date_start')->textInput()->input('date'/*, ['placeholder' => "2017-10-23"]*/) ?>

    <?= $form->field($model, 'time_start')->textInput()->input('time'/*, ['placeholder' => "14:15"]*/) ?>

    <?= $form->field($model, 'duration')->input('number', ['min' => 0]) ?>

    <?= $form->field($model, 'capacity')->input('number', [
        'min' => 1,
    ]) ?>

    <?= $form->field($model, 'start')->checkbox() ?>

    <?php
    if (!$model->isNewRecord && Yii::$app->user->identity->role === 'main_admin') {
        echo(
        $form->field($model, 'city_id')->dropdownList(
            Lesson::getCitiesList(),
            ['prompt' => 'Выберите город']
        ));
    }
    ?>

  <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
