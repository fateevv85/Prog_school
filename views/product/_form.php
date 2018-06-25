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

//    echo $form->field($model, 'city_id')->checkboxList($model->getCities(), ['separator' => '<br>']);

    echo $form->field($model, 'city_id')->radioList($model->getCities(), ['separator' => '<br>']) ?>

    <?= $form->field($model, 'amo_view')->checkbox(['label' => 'Отобразить в AMO', 'labelOptions' => []]) ?>

  <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
