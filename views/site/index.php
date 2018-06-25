<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

$this->title = 'Codabra';
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 text-center">«Привет👋 и добро пожаловать в альфу системы 🐲 Dragon v. 0.7»
    </div>
    <div class="col-md-2">
      <ul class="nav nav-pills nav-stacked">
        <li>
          <a href="<?= Url::to(['trial-lesson/index', 'TrialLessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60)]) ?>">Пробные
            занятия</a></li>
        <li>
          <a href="<?= Url::to(['lesson/index', 'LessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60)]) ?>">Платные
            занятия</a></li>

          <?php
          /*          if (!Yii::$app->user->isGuest) {
                        echo('<li><a href="site/settings">Настройки</a></li>');
                    }
                    */
          ?>

        <!--li><a href="site/calendar">Календарь</a></li-->
      </ul>
    </div>

  </div>
</div>
