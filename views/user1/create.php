<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User1 */

$this->title = Yii::t('app', 'Create User1');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User1s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
