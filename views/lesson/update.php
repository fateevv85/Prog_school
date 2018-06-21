<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */

/*$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Lesson',
]) . $model->lesson_id;*/
$this->title = 'Изменить платное занятие:' . $model->lesson_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lesson_id, 'url' => ['view', 'id' => $model->lesson_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
