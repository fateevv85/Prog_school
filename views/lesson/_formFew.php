<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Teacher;
use app\models\Lesson;
use \app\components\FieldHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lesson-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropdownList(
        Lesson::getGroupsList(),
        ['prompt' => 'Выберите группу учащихся']
    ) ?>

    <?= $form->field($model, 'lecture_hall_id')->dropdownList(
        Lesson::getLectureHallsList(),
        ['prompt' => 'Выберите площадку']
    ) ?>

    <?= $form->field($model, 'course_id')->dropdownList(
    // Course::getCourses(),
        Lesson::getCoursesList(),
        ['prompt' => 'Выберите курс обучения']
    ) ?>

    <?= $form->field($model, 'teacher_id')->dropdownList(
        Teacher::getNames(),
        ['prompt' => 'Выберите преподавателя']
    ) ?>

    <?= $form->field($model, 'date_start')->textInput()->input('date'/*, ['placeholder' => "2017-10-23"]*/) ?>

    <?= $form->field($model, 'time_start')->textInput()->input('time'/*, ['placeholder' => "14:15"]*/) ?>

    <?= $form->field($model, 'duration')->input('number', ['min' => 0]) ?>

    <?= $form->field($model, 'capacity')->input('number', [
        'min' => 1,
    ]); ?>

    <?php

    echo FieldHelper::generateInput('lesson-count', 'Количество занятий');

    echo FieldHelper::generateInput('lesson-next', 'Интервал занятий');

    if (!$model->isNewRecord && Yii::$app->user->identity->role === 'main_admin') {
        echo(
        $form->field($model, 'city_id')->dropdownList(
            Lesson::getCitiesList(),
            ['prompt' => 'Выберите город']
        ));
    }

    \yii\bootstrap\Modal::begin([
        'header' => '<h4>Список занятий</h4>',
        'toggleButton' => [
            'label' => 'Предпросмотр дат',
            'tag' => 'button',
            'class' => 'btn btn-success',
            'id' => 'modal'
        ],
//        'footer' => 'Низ окна',
    ]);

    echo Html::tag('div', null, [
        'id' => 'result'
    ]);


    ?>
  <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
  </div>
    <?php
    \yii\bootstrap\Modal::end();
    ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile('@web/js/dataListForMulLes.js', ['depends' => 'yii\web\YiiAsset']);
?>
