<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\City;
/* @var $this yii\web\View */
/* @var $model app\models\LectureHall */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lecture-hall-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>
    <?= $form->field($model, 'city_id')->dropdownList(
        //LectureHall::find()->select(['lecture_hall_id', 'lecture_hall_id'])->indexBy('lecture_hall_id')->column(),
        //City::getAllCities(),
        City::getCitiesForCurrentUser()
    ) ?>

    <?= $form->field($model, 'metro_station')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'place_description')->textarea(['rows' => 2]) ?>
    
    <?= $form->field($model, 'link_yandex_map')->textarea(['rows' => 3]) ?>
    


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
