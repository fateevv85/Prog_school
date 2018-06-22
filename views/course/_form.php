<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'synopses_link')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'lessons_num')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'cities')->checkboxList($model->citiesList) ?>

    <?= $form->field($model, 'product_id')->dropDownList(\app\components\MenuHelper::getDropDownList()) ?>

  <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
