<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\City;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'username')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'password')->textarea(['rows' => 1]) ?>

     <?= $form->field($model, 'city_id')->dropdownList(
        //LectureHall::find()->select(['lecture_hall_id', 'lecture_hall_id'])->indexBy('lecture_hall_id')->column(),
        City::getAllCities(),
        ['prompt'=>'Выберите город']
    ) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 1]) ?>

    <?php /*= $form->field($model, 'auth_key')->textarea(['rows' => 1]) */ ?>

    <?php  /*echo( $form->field($model, 'access_token')->textarea(['rows' => 1]) )*/ ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
