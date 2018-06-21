<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>

    <?php

    $model->city_id = Yii::$app->user->identity->city_id;

    echo $form->field($model, 'city_id')->checkboxList($model->getCities(), ['separator' => '<br>'])->label('Города') ?>

    <?= $form->field($model, 'amo_view')->checkbox(['label' => 'Отобразить в AMO', 'labelOptions' => []]) ?>

  <div class="form-group">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
