<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lesson */

$this->title = Yii::t('app', 'Create Lesson');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo 'Create few lessons';


    var_dump($_POST);

    /*$dateStart = '2018-07-25';

    $date = new \DateTime($dateStart);
    $date->add(new \DateInterval('P7D'));
    echo $date->format('Y-m-d') . "\n";*/
    var_dump($dates);
    var_dump($count);
    var_dump($interval);
    var_dump($test);

    ?>

    <?= $this->render('_formFew', [
        'model' => $model,
    ]) ?>



</div>
