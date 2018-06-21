<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['site/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'user_id',
            'full_name:ntext',
            'username:ntext',
            'password:ntext',
            'access_token:ntext',
            [
                'attribute'=>'city_id',
                'label'=>'Город',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getCityTitle();
                },
                'filter' => User::getCitiesList(),
                'headerOptions'=>['style'=>'white-space: normal;'],
                //'contentOptions'=>['style'=>'width: 200px;'],
            ],
            // 'info:ntext',
            // 'auth_key:ntext',
            // 'access_token:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
