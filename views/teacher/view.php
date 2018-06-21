<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = $model->teacher_id;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if (!Yii::$app->user->isGuest) {
                echo(Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->teacher_id], ['class' => 'btn btn-primary']));
                echo( Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->teacher_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]));
            }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'teacher_id',
            'first_name:ntext',
            'middle_name:ntext',
            'last_name:ntext',
            'email:ntext',
            'resume:ntext',
            'photo:ntext',
        ],
    ]) ?>

</div>
