<?php

namespace app\components;

use app\models\Lesson;
use kartik\checkbox\CheckboxX;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
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
//                $lessonIdColumn,
                [
                    'attribute' => $lessonIdColumn,
                    'format' => 'text',
                    'content' => function ($data) use ($lessonIdColumn) {
                        $url = ($lessonIdColumn == 'lesson_id') ? 'lesson/view' : 'trial-lesson/view';
                        return Html::a($data->$lessonIdColumn, [$url, 'id' => $data->$lessonIdColumn]);
                    },
                ],
                [
                    'attribute' => 'group_id',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return Html::a($data->getGroupName(), ['group/view', 'id' => $data->group_id]);
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
                [
                    'attribute' => 'date_start',
                    'content' => function ($data) {
                        return preg_replace('#(\d{4})\-(\d{2})\-(\d{2})#', '$3.$2.$1', $data->date_start);
                    }
                ],
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

    public static function widgetGridReport($dataProvider, $lessonIdColumn)
    {
        return \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//                $lessonIdColumn,
                [
                    'attribute' => 'teacher_id',
                    'label' => 'Преподаватель',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return $data->getTeacherName();
                    },
                    'filter' => Lesson::getTeachersList(),
                    'options' => ['width' => '150']
                ],
//                'date_start',
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

    public static function widgetGridList($type, $dataProvider, $lessonType)
    {

        $optionArr = [
            'dataProvider' => $dataProvider,
            'autoXlFormat' => true,
            'export' => [
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_SELF,
                'label' => 'Экспорт в Excel',
                'header' => ' '
            ],
            'exportConfig' => [
                GridView::EXCEL => [
                    'label' => 'Сохранить',
                    'icon' => 'floppy-disk',
                    'filename' => ($type == 'teacher') ? 'Отчет для преподавателя ' . date('Y-m-d') : 'Отчет для менеджера ' . date('Y-m-d'),
                    'showHeader' => true,
                    'showPageSummary' => true,
                    'showFooter' => true,
                    'showCaption' => true,
                    'options' => [
                        'title' => ' '
                    ],
                ],
            ],
            'pjax' => true,
            'striped' => true,
//        'showPageSummary' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => \Yii::t('app', $lessonType) . ' занятие'
            ]
        ];

        // options for teacher
        if ($type == 'teacher') {
            $columns = ['columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn',
//                    'format' => 'integer',
                    'header' => '№'
                ],
                [
                    'attribute' => 'group_title',
                    'format' => 'text',
                    'width' => '100px',
                    'content' => function ($data) {
                        return 'Группа: ' . "<strong>" . $data->group_title . "</strong>" . ' Дата: ' . "<strong>" . $data->date_start . ' ' . $data->time_start . "</strong>";
                    },
                    'group' => true,  // enable grouping,
                    'groupedRow' => true,                    // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row',
                ],
                [
                    'attribute' => 'p_last_name',
                    'label' => 'Фамилия',
                    'format' => 'text',
                    'width' => '100px',
                ],
                [
                    'attribute' => 'p_first_name',
                    'label' => 'Имя',
                    'format' => 'text',
                    'width' => '100px',
                ],
                [
                    'attribute' => 'email',
//                    'label' => 'Бюджет',
                    'format' => 'text',
                    'width' => '70px',
                ],
                [
                    'label' => 'Телефон',
                    'format' => 'text',
                    'width' => '100px',
                ],
                [
                    'label' => 'Ф ребенка',
                    /*'content' => function ($data) {
                        return $data->student_ln . ' ' . $data->student_fn;
                    },*/
                    'attribute' => 'student_ln',
                    'format' => 'text',
                    'width' => '150px',
                ],
                [
                    'label' => 'И ребенка',
                    /*'content' => function ($data) {
                        return $data->student_ln . ' ' . $data->student_fn;
                    },*/
                    'attribute' => 'student_fn',
                    'format' => 'text',
                    'width' => '150px',
                ],
                [
                    'attribute' => 'budget',
                    'label' => 'Бюджет',
                    'format' => 'integer',
                    'width' => '70px',
                ],
                [
                    'attribute' => 'notebook',
                    'label' => 'Ноутбук',
                    'format' => 'text',
                    'width' => '70px',
                ],
                [
                    'label' => 'Комментарии',
                    'format' => 'text',
                    'width' => '100px',
                ],

            ],
            ];
        } // options for manager
        elseif ($type == 'manager') {
            $columns = ['columns' =>
                [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'header' => '№'
                    ],
                    [
                        'attribute' => 'group_title',
                        'format' => 'text',
                        'width' => '100px',
                        'content' => function ($data) {
                            return 'Группа: ' . "<strong>" . $data->group_title . "</strong>" . ' Дата: ' . "<strong>" . $data->date_start . ' ' . $data->time_start . "</strong>";
                        },
                        'group' => true,  // enable grouping,
                        'groupedRow' => true,                    // move grouped column to a single grouped row
                        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                        'groupEvenCssClass' => 'kv-grouped-row',
                    ],
                    [
                        'attribute' => 'p_last_name',
                        'label' => 'Фамилия',
                        'format' => 'text',
                        'width' => '100px',
                    ],
                    [
                        'attribute' => 'p_first_name',
                        'label' => 'Имя',
                        'format' => 'text',
                        'width' => '100px',
                    ],
                    [
                        'attribute' => 'email',
//                    'label' => 'Бюджет',
                        'format' => 'text',
                        'width' => '70px',
                    ],
                    [
                        'label' => 'Телефон',
                        'format' => 'text',
                        'width' => '100px',
                    ],
                    [
                        'label' => 'Ф ребенка',
                        /*'content' => function ($data) {
                            return $data->student_ln . ' ' . $data->student_fn;
                        },*/
                        'attribute' => 'student_ln',
                        'format' => 'text',
                        'width' => '150px',
                    ],
                    [
                        'label' => 'И ребенка',
                        /*'content' => function ($data) {
                            return $data->student_ln . ' ' . $data->student_fn;
                        },*/
                        'attribute' => 'student_fn',
                        'format' => 'text',
                        'width' => '150px',
                    ],
                    [
                        'label' => 'Отметка',
                        'format' => 'text',
                        'width' => '70px',
                    ],
                    [
                        'label' => 'Комментарии',
                        'format' => 'text',
                        'width' => '100px',
                    ],
                ]
            ];
        }

        return array_merge($optionArr, $columns);
    }

    public static function stripeGrid()
    {
        return function ($data, $key, $index, $grid) {
            if ($index % 2 !== 0) {
                return ['style' => 'background-color:#E6E6E6;'];
            }
        };
    }

    public static function convertDate($date)
    {
        return preg_replace('#(\d{2})\.(\d{2})\.(\d{4})#', '$3-$2-$1', $date);
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