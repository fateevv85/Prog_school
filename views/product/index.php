<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tables\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

  <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
      <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
  </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'label' => Yii::t('app', 'City'),
//                'attribute' => 'city_id',
                'value' => function ($model) {
                    return $model->cityName->title;
                }
            ],
            [
                'label' =>Yii::t('app','Show paid in AMO'),
                'format'=>'html',
                'content' => function ($data) {
                    if ($data->amo_paid_view == 1) {
                        return '</i><i class="fas fa-eye"></i> Да';
                    }
                    return '<i class="far fa-eye-slash"></i> Нет';
                }
            ],
            [
                'label' =>Yii::t('app','Show trial in AMO'),
                'format'=>'html',
                'content' => function ($data) {
                    if ($data->amo_trial_view == 1) {
                        return '<i class="fas fa-eye"></i> Да';
                    }
                    return '<i class="far fa-eye-slash fa-size-5x"></i> Нет';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
