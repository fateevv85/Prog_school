<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<?php
$course = \app\models\Course::find()->where(['course_id' => $model->course_id])->asArray()->one()

?>
<div>
  <h4>ID урока <?= Html::encode($model->lesson_id) ?></h4>
  <div>Дата старта <?= HtmlPurifier::process($model->date_start) ?></div>
  <div>Название
    курса: <?= HtmlPurifier::process($course['title']); ?></div>
  <div>Название
    продукта: <?= HtmlPurifier::process($course['product_id']); ?></div>


</div>