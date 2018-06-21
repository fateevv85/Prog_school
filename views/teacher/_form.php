<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\City;
/* @var $this yii\web\View */
/* @var $model app\models\Teacher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'middle_name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'last_name')->textarea(['rows' => 1]) ?>
    
    <?= $form->field($model, 'city_id')->dropdownList(
        //LectureHall::find()->select(['lecture_hall_id', 'lecture_hall_id'])->indexBy('lecture_hall_id')->column(),
        //City::getCities(),
        City::getCitiesForCurrentUser()
    ) ?>
    
    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'resume')->textarea(['rows' => 1]) ?>
    

    <?= $form->field($model, 'photo')->textarea(['rows' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
