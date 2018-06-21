<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\City;
/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>
    <?php
        $id = \Yii::$app->user->id;
        if ( $id === 5) {
            echo($form->field($model, 'participants_num')->textInput() );
        } else {
            echo("<div> <label class='control-label'>Записано учеников: {$model->participants_num}</label></div>");
        }
    ?>

    <?= $form->field($model, 'participants_num_max')->textInput() ?>
    <?php 
    echo(
        $form->field($model, 'city_id')->dropdownList(
            //LectureHall::find()->select(['lecture_hall_id', 'lecture_hall_id'])->indexBy('lecture_hall_id')->column(),
            //City::getCities()
            City::getCitiesForCurrentUser()
            //['prompt'=>'Выберите город']
        )
    ) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
