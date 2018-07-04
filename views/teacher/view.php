<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\widgets\ActiveForm;
use kartik\builder\Form;
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
//                        return Html::a(" Открыть в новом окне", $data->photo, ['target' => '_blank', 'class' => 'fas fa-external-link-alt']);
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
                'showDropdowns' => true
            ],
            'options' => [
                'required' => true,
                'class' => 'form-control'
            ],
        ]);
    }

    echo '<div class="row">';

    echo preHtml('Дата с') . widgetDate('dateStart', '2017-01-01') . $addon;

    echo preHtml('Дата по') . widgetDate('dateEnd', '2018-07-31') . $addon;

    echo '</div>';


    echo Html::tag('div',
        Html::label('Показать занятия', null, [
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
//            'unselect' => 'paid',
            'item' => function ($index, $label, $name, $checked, $value) {
                if ($value == 'paid') {
                    $active = 'active';
                    $checked = 'checked';
                }
                return "<label class='btn btn-default {$active}' style='font-weight: normal;'><input type='checkbox' name='{$name}' value='{$value}' $checked>{$label}</label>";
            }
        ]),
        ['class' => 'form-group']);

    echo Html::submitButton(\Yii::t('app', 'Show'),
        ['class' => 'btn btn-success']);

    $form::end();


    //    var_dump($post);


    //    var_dump($dateStart);
    //    var_dump($dateEnd);


    /*$dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \app\models\Lesson::find()->where(['teacher_id' => 6]),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);*/

    /*if ($dataProviderPaid) {
        echo \yii\widgets\ListView::widget([
            'dataProvider' => $dataProviderPaid,
            'itemView' => '_list',
        ]);
    }*/

    function widgetGrid($dataProvider, $lessonIdColumn) {
      return \yii\grid\GridView::widget([
          'dataProvider' => $dataProvider,
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],
              'lesson_id',
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
          ],
      ]);
    }


    if ($dataProviderPaid) {
        echo "<h3>Платные уроки: {$dataProviderPaid->totalCount}</h3>";
        echo \yii\grid\GridView::widget([
            'dataProvider' => $dataProviderPaid,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'lesson_id',
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
            ],
        ]);
    }

    if ($dataProviderTrial) {
        echo "<h3>Пробные уроки: {$dataProviderTrial->totalCount}</h3>";
        echo \yii\grid\GridView::widget([
            'dataProvider' => $dataProviderTrial,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'trial_lesson_id',
                [
                    'attribute' => 'group_id',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return $data->getGroupName();
                    },
//                    'filter' => TrialLesson::getGroupsList(),
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
            ],
        ]);
    }

    //    var_dump($dataProviderPaid);
    ?>

</div>
