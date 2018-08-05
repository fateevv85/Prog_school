<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\depdrop\DepDrop;
use \kartik\select2\Select2;
use \yii\helpers\Url;
use \app\models\tables\Product;

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

    <table class="table">
        <?= $form->field($model, 'cities')->checkboxList($model->citiesList, [
            'item' => function ($index, $label, $name, $checked, $value) use ($model) {

                $checked = '';
                if (\Yii::$app->user->identity->role
                    === 'regional_admin' && $model->isNewRecord) {
                    $cityId = array_keys(\app\models\City::getCitiesForCurrentUser())[0];
                    if ($value == $cityId) {
                        $checked = 'checked';
                    }

                }

                foreach ($model->cities as $elem) {
                    if ($elem->city_id == $value) {
                        $checked = 'checked';
                    }
                }

                if (count(Product::getProductsForCity($value)) > 0) {
                    $selection = \app\models\CourseInCity::getProductByCourseAndCity(Yii::$app->request->get('id'), $value);
                    $content = Html::dropDownList("Course[products][$value]", $selection, Product::getProductsForCity($value), [
                        'class' => "form-control input-sm"
                    ]);
                    $disabled = '';
                } else {
                    $content = 'Нет продуктов для города';
                    $disabled = 'disabled';
                }
                $item = '<tr>
                  <td>
                  <label class="checkbox-inline" >
                  <input type="checkbox" value="' . $value . '" name="' . $name . '" ' . $checked . $disabled . '/>' . $label . '
                  </label>
                  </td>
                  <td>';
                $after = '</td></tr>';
                return $item . $content . $after;
            }
        ]) ?>
    </table>

      <?php
      /*var_dump($model->cities);
      var_dump(\app\models\tables\Product::getProductsForCity(3));
      var_dump($_GET);
      var_dump(\app\models\CourseInCity::getProductByCourseAndCity(63, 1));*/
      ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id' => 'submit-button'
        ]) ?>
    </div>

      <?php ActiveForm::end(); ?>

  </div>
<?php

$js = <<< JS

let checkbox = $('input[name^="Course[cities]"]');
let button = $("#submit-button");
button.attr("disabled", "true");
checkbox.each(function() {
      if($(this).is(':checked')) {
        button.removeAttr("disabled");
      }
    });

checkbox.change(function() {     // every time a checkbox changes
    button.attr("disabled", "true");   // start button disabled
    /*$("input:checkbox:checked").each(function() {
        $("#submit-button").removeAttr("disabled"); // if any checkbox checked, make button enabled
    });*/
    checkbox.each(function() {
      if($(this).is(':checked')) {
        button.removeAttr("disabled");
      }
    });
});

checkbox.each(function() {
  if ($(this).is(':not(:checked)')) {
    $(this).parents('td').next().find('select').prop('disabled', true);
  }
});

checkbox.click(function(){
  if ($(this).is(':checked')) {
    $(this).parents('td').next().find('select').prop('disabled', false);
  } else {
    $(this).parents('td').next().find('select').prop('disabled', true);
  }
});
JS;

$this->registerJs($js);
//['depends' => 'yii\web\YiiAsset']
?>