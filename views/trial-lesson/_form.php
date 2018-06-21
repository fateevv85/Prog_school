<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Teacher;
use app\models\LectureHall;
use app\models\Group;
use app\models\Course;
use app\models\TrialLesson;

/* @var $this yii\web\View */
/* @var $model app\models\TrialLesson */
/* @var $form yii\widgets\ActiveForm */
?>
 
<div class="trial-lesson-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropdownList(
        TrialLesson::getGroupsList(),
        ['prompt'=>'Выберите группу учащихся']
    ) ?>
    

    
    <?= $form->field($model, 'lecture_hall_id')->dropdownList(
        //LectureHall::find()->select(['lecture_hall_id', 'lecture_hall_id'])->indexBy('lecture_hall_id')->column(),
        TrialLesson::getLectureHallsList(),
        ['prompt'=>'Выберите площадку']
    ) ?>

    <?= $form->field($model, 'course_id')->dropdownList(
        TrialLesson::getCoursesList(),
        ['prompt'=>'Выберите курс обучения']
    ) ?>
    
    <?= $form->field($model, 'teacher_id')->dropdownList(
        Teacher::getNames(),
        ['prompt'=>'Выберите преподавателя']
    ) ?>

    <?= $form->field($model, 'date_start')->textInput()->input('date'/*, ['placeholder' => "2017-10-23"]*/) ?>

    <?= $form->field($model, 'time_start')->textInput()->input('time'/*, ['placeholder' => "14:15"]*/) ?>

    <?= $form->field($model, 'duration')->textarea(['rows' => 1]) ?>
    
    <?= $form->field($model, 'num_trial')->textarea(['rows' => 1]) ?>
    
    <?= $form->field($model, 'course_date_start')->textInput()->input('date'/*, ['placeholder' => "2017-10-23"]*/) ?>
    
    <?= $form->field($model, 'lead_link')->textarea(['rows' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
