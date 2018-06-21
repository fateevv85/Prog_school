<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->title = Yii::t('app', 'Календарь');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <iframe src="https://calendar.google.com/calendar/embed?src=codabra.dragon%40gmail.com&ctz=Europe%2FMoscow" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
</div>
