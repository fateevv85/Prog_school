<?php

use kartik\depdrop\DepDrop;
use \yii\helpers\Url;
use \yii\helpers\Html;


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

echo \kartik\select2\Select2::widget([
    'name' => 'city_select',
    'data' => \app\models\City::getCitiesForCurrentUser(),
    'options' => [
        'multiple' => true,
        'id' => 'city-select',
    ],
//    'value' => $_GET['teacher_select'],
    'addon' => [
        'prepend' => [
            'content' => \kartik\helpers\Html::icon('user')
        ],
    ]
]);

echo '<br>';

echo DepDrop::widget([
    'name' => 'teachers',
    'type' => DepDrop::TYPE_SELECT2,
//    'data' => [2 => 'Tablets'],
    'options' => ['multiple'=>true],
//    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'depends' => ['city-select'],
        'url' => Url::to(['/teacher/subcat']),
    ]]);


echo Html::tag('div', Html::submitButton(\Yii::t('app', 'Show'),
    ['class' => 'btn btn-success']), ['class' => 'form-group']);

$form::end();
//var_dump(\app\models\City::getCitiesForCurrentUser());
//var_dump($_GET);
?>


