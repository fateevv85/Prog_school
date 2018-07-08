<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;
use \app\components\WidgetHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?php
      if (!Yii::$app->user->isGuest) {
          echo(Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->teacher_id], ['class' => 'btn btn-primary']));
          echo(Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->teacher_id], [
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
            'teacher_id',
            'last_name:ntext',
            'first_name:ntext',
            'middle_name:ntext',
            'email:ntext',
            'resume:ntext',
            [
                'attribute' => 'photo',
                'format' => 'raw', // Возможные варианты: raw, html
                'value' => function ($data) {
                    if ($data->photo) {
                        return Html::a("Открыть <i class=\"fas fa-external-link-alt\"></i>", $data->photo, ['target' => '_blank']);
                    }
                    return 'Нет фотографии';
                },
            ],
        ],
    ]) ?>

    <?php
    $form = ActiveForm::begin([
        'id' => 'view_sum',
        //    'action' => [''],
        'method' => 'post',
        'options' => [
//            'class' => 'form-horizontal'
            'class' => 'form-vertical'
        ],
    ]);

    echo '<div class="row">';

    echo WidgetHelper::widgetDate('Начало периода:', 'dateStart', '01.01.2017') . $addon;

    echo WidgetHelper::widgetDate('Конец периода:', 'dateEnd', '31.07.2018') . $addon;

    echo '</div>';

    echo Html::tag('div',
        Html::label('Выбрать занятия:', null, [
            'class' => 'control-label col-xs-12',
            'style' => 'padding-left:0px'
        ]) .
        Html::checkboxList('lessons', null, [
            'paid' => 'платные',
            'trial' => 'пробные'
        ], [
//            'separator' => '<br>',
            'class' => 'btn-group',
            'data-toggle' => 'buttons',
            'unselect' => 'paid',
            'item' => function ($index, $label, $name, $checked, $value) {
                if ($value == 'paid') {
                    $active = 'active';
                    $checked = 'checked';
                }
                return "<label class='btn btn-default {$active}' style='font-weight: normal;'><input type='checkbox' name='{$name}' value='{$value}' $checked>{$label}</label>";
            }
        ]),
        ['class' => 'form-group']);

    echo Html::tag('div', Html::submitButton(\Yii::t('app', 'Show'),
        ['class' => 'btn btn-success']), ['class' => 'form-group']);

    $form::end();

    if ($dataProviderPaid) {
        echo "<h3>Платных занятий: {$dataProviderPaid->totalCount}</h3>";
        echo WidgetHelper::widgetGridTeacher($dataProviderPaid, 'lesson_id');
    }

    if ($dataProviderTrial) {
        echo "<h3>Пробных занятий: {$dataProviderTrial->totalCount}</h3>";
        echo WidgetHelper::widgetGridTeacher($dataProviderTrial, 'trial_lesson_id');
    }

    ?>

</div>
