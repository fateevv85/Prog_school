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

    <?= $form->field($model, 'duration')->textarea(['rows' => 1]) ?>

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
$js = <<<JS
$('#modal').click(()=>{
			const start = new Date ($('#lesson-date_start').val());
			const number = parseInt($('#lesson-count').val());
			const interval = parseInt($('#lesson-next').val());

			let dateList = [];
			let dayInt = 0;
			for (let i = 1; i <= number; i++) {

				let date = new Date();
				date.setDate(start.getDate()+ dayInt);
				dateList.push(date.getDate() + '.' + (date.getMonth()+1) + '.' + date.getFullYear());
				dayInt += interval;
			}

			$('#date-list').remove();
			
			let ul = $('<ul/>', {
			  id: 'date-list'
			});
			
			dateList.forEach((el,i)=>{
				let li = $('<li/>');
				let isStart = (i===0)?' стартовое':'';
				
				li.text('Занятие №'+ ++i + ': ' + el + isStart);
				ul.append(li);
			});
			
			$('#result').append(ul);
		});
JS;

$this->registerJs($js, yii\web\View::POS_READY);
?>
