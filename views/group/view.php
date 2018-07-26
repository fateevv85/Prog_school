<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->title;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?php
      if (!Yii::$app->user->isGuest) {
          echo(Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->group_id], ['class' => 'btn btn-primary']));
          echo ' ';
          echo(Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->group_id], [
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
            'group_id',
            'title:ntext',
            'participants_num',
//            'participants_num_max',
        ],
    ]) ?>

    <?php if ($dataProviderStudents) {
        echo "<h3>Список учеников: </h3>";
        echo GridView::widget([
            'dataProvider' => $dataProviderStudents,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'last_name',
                'first_name',
                'email'
            ]
        ]);
    } ?>
</div>
