<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LectureHall */

$this->title = Yii::t('app', 'Create Lecture Hall');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecture Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecture-hall-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
