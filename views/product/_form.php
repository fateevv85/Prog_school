<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php

    $model->city_id = Yii::$app->user->identity->city_id;

    if (\Yii::$app->user->identity->role == 'main_admin') {
        $model->city_id = $model->getOldAttribute('city_id');
    }

    echo $form->field($model, 'city_id')->radioList($model->getCities(), ['separator' => '<br>']) ?>

  <label>Отобразить занятия в АМО:</label>

    <?= $form->field($model, 'amo_paid_view')->checkbox(['label' => 'платные', 'checked ' => true]) ?>

    <?= $form->field($model, 'amo_trial_view')->checkbox(['label' => 'пробные']) ?>

</div>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>
