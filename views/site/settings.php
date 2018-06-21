<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        $items = [
            //['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'Преподаватели', 'url' => ['/teacher/index']],
            ['label' => 'Курсы', 'url' => ['/course/index']],
            ['label' => 'Площадки', 'url' => ['/lecture-hall/index']],
            ['label' => 'Группы учащихся', 'url' => ['/group/index']],
            ['label' => 'Продукты', 'url' => ['/product/index']],
        ];
        $identity = \Yii::$app->user->identity;
        if (!is_null($identity) && isset($identity->role)) {
            if ($identity->role === 'main_admin') {
                $items[] = ['label' => 'Города', 'url' => ['/city/index']];
                $items[] = ['label' => 'Пользователи', 'url' => ['/user/index']];
            }
        }
        echo Nav::widget([
            'options' => ['class' => 'nav-pills nav-stacked'],
            'items' => $items,
        ]);
    ?>
</div>
