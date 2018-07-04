<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

$this->title = Yii::t('app', 'Teachers');
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['teacher/index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Teacher summary');
?>

<h1><?= $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name; ?></h1>
<h5><?= \app\models\City::getCityName($model->city_id) ?></h5>
<h5><?= $model->email ?></h5>

<?php
$form = ActiveForm::begin([
    'id' => 'view_sum',
//    'action' => [''],
    'method' => 'post',
    'options' => [
        'class' => 'form-vertical'
    ],
]);

$addon = <<< HTML
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
        'convertFormat' => false,
        //'presetDropdown'=>true,
        'pluginOptions' => [
            'opens' => 'right',
            'locale' => [
                'cancelLabel' => 'Отмена',
                'applyLabel' => 'Готово',
                'format' => 'DD.MM.YYYY',
            ],
            //'format' => 'DD.MM.YYYY',
            //'format' => 'YYYY-MM-DD',
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
echo '</div>';

echo Html::tag('div',
    Html::label('Показать занятия', null, ['class' => 'control-label']) .
    Html::checkboxList('lessons', 0, ['платные', 'пробные'], ['separator' => '<br>',]),
    ['class' => 'form-group']);

echo Html::submitButton(\Yii::t('app', 'Show'),
    ['class' => 'btn btn-success']);

$form::end();

var_dump($post);


//var_dump($model);

?>
