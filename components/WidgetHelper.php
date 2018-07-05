<?php

namespace app\components;

use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

class WidgetHelper
{
    public static function widgetDate($label, $name, $date)
    {

        $preHtml = <<< HTML
    <!--<div class="col-sm-4">-->
    <div class="col-sm-3">
    <div class="form-group">
    <label class="control-label">{$label}</label>
    <div class="input-group drp-container">
HTML;

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
        return $preHtml . DateRangePicker::widget([
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
            ]) . $addon;
    }

    public static function widgetGridTeacher($dataProvider, $lessonIdColumn)
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
                    'label' => \Yii::t('app', 'Product'),
                    'content' => function ($data) {
                        return \app\models\Course::findOne(['course_id' => $data->course_id])->getProductName();
                    }
                ]
            ],
        ]);
    }

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
}