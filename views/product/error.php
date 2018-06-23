<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

  <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->
  
  <h1>Ошибка</h1>

  <div class="alert alert-danger">
      <?php
      if ($message->errorInfo[0] === '23000') {
          echo 'Вы пытаетесь удалить продукт, к которому привязаны курсы.';
          echo "<br>";
          echo 'Сначала удалите курсы для продукта.';
      }
      ?>
  </div>

  <div class="alert alert-danger">
      <?= nl2br(Html::encode($message->errorInfo[2])) ?>
  </div>


</div>
