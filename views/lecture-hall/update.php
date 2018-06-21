<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LectureHall */

/*$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Lecture Hall',
]) . $model->lecture_hall_id;*/
$this->title = 'Изменить данные площадки';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecture Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lecture_hall_id, 'url' => ['view', 'id' => $model->lecture_hall_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="lecture-hall-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
