<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User1 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'login')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'password')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
