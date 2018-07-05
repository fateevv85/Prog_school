<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;

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

    //Виджет выбора даты с указанием даты начала и конца одновременно, фича- пред-выбранные периоды 'presetDropdown'=>true
    /*      $addon = <<< HTML
      <span class="input-group-addon">
          <i class="glyphicon glyphicon-calendar"></i>
      </span>
  HTML;

          echo '<div class="form-group">';
          echo '<label class="control-label">Выберите дату</label>';
          echo '<div class="input-group drp-container col-xs-4">';
          echo \kartik\daterange\DateRangePicker::widget([
                  'name' => 'date',
                  'attribute' => 'date_start',
      //            'convertFormat' => false,
                  //'presetDropdown'=>true,
                  'pluginOptions' => [
                      'opens' => 'right',
                      'locale' => [
                          'cancelLabel' => 'Отмена',
                          'applyLabel' => 'Готово',
                          'format' => 'YYYY-MM-DD',
      //                    'separator' => '-'
                      ],
                      //'format' => 'DD.MM.YYYY',
      //                'format' => 'YYYY-MM-DD',
                  ],
                  'options' => [
                      'required' => true,
                      'class' => 'form-control'
                  ],
                  'i18n' => [
                      'class' => 'yii\i18n\PhpMessageSource',
                      'basePath' => '@app/vendor/yiisoft/yii2/messages',
                      'forceTranslation' => true
                  ]
              ]) . $addon;
          echo '</div>';
          echo '</div>';*/

    $addon = <<< HTML
    <!--<span class="input-group-addon kv-date-remove" title="Clear field">
    <i class="glyphicon glyphicon-remove"></i>
    </span>-->
    <span class="input-group-addon">
        <i class="glyphicon glyphicon-calendar"></i>
    </span>
    </div>
    </div>
    </div>
HTML;

    function preHtml($label)
    {
        return <<< HTML
    <!--<div class="col-sm-4">-->
    <div class="col-sm-3">
    <div class="form-group">
    <label class="control-label">{$label}</label>
    <div class="input-group drp-container">
HTML;
    }

    function widgetDate($name, $date)
    {
        return \kartik\daterange\DateRangePicker::widget([
            'name' => $name,
            'value' => $date,
            'useWithAddon' => true,
//            'presetDropdown' => true,
            'pluginOptions' => [
                'singleDatePicker' => true,
                'showDropdowns' => true,
                'locale' => [
                    'format' => 'DD.MM.YYYY'
                ]
            ],
            'options' => [
                'required' => true,
                'class' => 'form-control'
            ],
        ]);
    }

    echo '<div class="row">';

    echo preHtml('Начало периода:') . widgetDate('dateStart', '01.01.2017') . $addon;

    echo preHtml('Конец периода:') . widgetDate('dateEnd', '31.07.2018') . $addon;

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

    function widgetGrid($dataProvider, $lessonIdColumn)
    {
        return \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                $lessonIdColumn,
                [
                    'attribute' => 'group_id',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return $data->getGroupName();
                    },
                    'headerOptions' => ['style' => 'white-space: normal;'],
                    'contentOptions' => ['style' => 'width: 100px;'],
                ],
                [
                    'attribute' => 'course_id',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return '<a href="' . Url::to(['course/view', 'id' => $data->course_id]) . '">' . $data->getCourseName() . '</a>';
                    },
                    'headerOptions' => ['style' => 'white-space: normal;'],
                    'contentOptions' => ['style' => 'width: 20%;'],
                ],
                'date_start',
                [
                    'attribute' => 'city_id',
                    'label' => 'Город',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return $data->getCityTitle();
                    },
                    'headerOptions' => ['style' => 'white-space: normal;'],
                ],
                [
                    'label' => Yii::t('app', 'Product'),
                    'content' => function ($data) {
          return \app\models\Course::findOne(['course_id'=>$data->course_id])->getProductName();
                    }
                ]
            ],
        ]);
    }

    if ($dataProviderPaid) {
        echo "<h3>Платные занятия: {$dataProviderPaid->totalCount}</h3>";
        echo widgetGrid($dataProviderPaid, 'lesson_id');
    }

    if ($dataProviderTrial) {
        echo "<h3>Пробные занятия: {$dataProviderTrial->totalCount}</h3>";
        echo widgetGrid($dataProviderTrial, 'trial_lesson_id');
    }


//    var_dump($dataProviderPaid);
    ?>

</div>
