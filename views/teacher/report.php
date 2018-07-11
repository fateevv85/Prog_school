<?php

use \yii\helpers\Html;
use \kartik\select2\Select2;
use \kartik\daterange\DateRangePicker;
use \yii\helpers\ArrayHelper;

//$this->registerCssFile('../css/checkboxes.css');

$this->title = Yii::t('app', 'Report');
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'view_sum',
    'action' => [''],
//    'method' => 'post',
    'method' => 'get',
    'options' => [
//            'class' => 'form-horizontal'
        'class' => 'form-vertical'
    ],
]);
?>

<div class="form-group">
  <label class="control-label">Выберите город</label>
  <br>
    <?= Html::checkboxList('cities', ($_GET['cities']) ?: 1, \app\models\City::getCitiesForCurrentUser(), [
        'separator' => '<br>',
    ]);
    ?>
</div>

<?php
$preHtml = <<< HTML
<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label">%s</label>
HTML;

$afterHtml = <<< HTML
</div>
</div>
</div>
HTML;

echo sprintf($preHtml, 'Выберите диапазон дат');
echo '<div class="drp-container input-group">';
echo DateRangePicker::widget([
    'name' => 'date_range',
    'presetDropdown' => true,
    'value' => $dateValue,
    'hideInput' => false,
    'pluginOptions' => [
        'locale' => [
            'format' => 'DD.MM.YYYY'
        ],
    ],
    'options' => [
        'required' => true,
        'class' => 'form-control'
    ],
]);
echo '</div>';
echo $afterHtml;

echo sprintf($preHtml, 'Выберите преподавателей');
echo Select2::widget([
    'name' => 'teacher_select',
    'data' => \app\models\LessonTypeModel::getTeachersList(),
    'options' => [
//        'placeholder' => 'если не выбраны, поиск ведется по всем',
        'multiple' => true
    ],
    'value' => $_GET['teacher_select'],
//    'initValueText'=>
    'addon' => [
        'prepend' => [
            'content' => \kartik\helpers\Html::icon('user')
        ],
    ]
]);
echo $afterHtml;

echo Html::tag('div',
    Html::label('Выберите занятия:', null, [
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
            if ($lessons = $_GET['lessons']) {
                foreach ($lessons as $key => $type) {
                    if ($value == $type) {
                        $active = 'active';
                        $checked = 'checked';
                    }
                }
            } elseif ($value == 'paid') {
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

?>

<?php
if ($dataProviderTeacher) {
    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderTeacher,
        'rowOptions' => \app\components\WidgetHelper::stripeGrid(),
//        'emptyText'=>"<tbody>\n</tbody>",
//        'caption' => 'Table',
//    'showOnEmpty'=>false,
//    'emptyCell'=>'No',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'last_name',
                'format' => 'html', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return Html::a($data->last_name, ['teacher/view', 'id' => $data->teacher_id]);
                },
            ],
            'first_name:ntext',
            'middle_name:ntext',
            [
                'attribute' => 'city_id',
                'label' => 'Город',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return $data->getCityTitle();
                },
                'filter' => \app\models\Teacher::getCitiesList(),
                'headerOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'label' => Yii::t('app', 'Quantity paid'),
                'format' => 'text', // Возможные варианты: raw, html
                'visible' => (ArrayHelper::isIn('paid', $_GET['lessons'])),
                'content' => function ($data) use ($countPaid, $dateStart, $dateEnd) {
                    if ($countPaid && array_key_exists($data->teacher_id, $countPaid)) {
                        return Html::a("{$countPaid[$data->teacher_id]} <i class='fas fa-external-link-alt'></i>", ['teacher/view', 'id' => $data->teacher_id, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'lessons' => ['paid']], ['target' => '_blank', 'title' => 'Подробная информация']);
                    } else {
                        return Yii::t('app', 'No lessons');
                    }
                },
            ],
            [
                'label' => Yii::t('app', 'Quantity trial'),
                'format' => 'text', // Возможные варианты: raw, html
                'visible' => (ArrayHelper::isIn('trial', $_GET['lessons'])),
                'content' => function ($data) use ($countTrial, $dateStart, $dateEnd) {
                    if ($countTrial && array_key_exists($data->teacher_id, $countTrial)) {
                        return Html::a("{$countTrial[$data->teacher_id]} <i class='fas fa-external-link-alt'></i>", ['teacher/view', 'id' => $data->teacher_id, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'lessons' => ['trial']], ['target' => '_blank', 'title' => 'Подробная информация']);
                    } else {
                        return Yii::t('app', 'No lessons');
                    }
                },
            ],
            [
                'label' => Yii::t('app', 'Quantity total'),
                'format' => 'text', // Возможные варианты: raw, html
                'visible' => (ArrayHelper::isIn('trial', $_GET['lessons']) && ArrayHelper::isIn('paid', $_GET['lessons'])),
                'content' => function ($data) use ($countTrial, $countPaid, $dateStart, $dateEnd) {
                    if ($countTrial[$data->teacher_id] + $countPaid[$data->teacher_id]) {
                        return Html::a($countTrial[$data->teacher_id] + $countPaid[$data->teacher_id] . ' <i class=\'fas fa-external-link-alt\'></i>', ['teacher/view', 'id' => $data->teacher_id, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'lessons' => $_GET['lessons']], ['target' => '_blank', 'title' => 'Подробная информация']);
                    } else {
                        return Yii::t('app', 'No lessons');
                    }
                },
            ],
        ],
    ]);
}

?>
