<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ]) ?>
  </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'city_id',
                'value' => function ($data) {
                    return \app\models\City::getCityName($data->city_id);
                }
            ],
            [
                'label' => Yii::t('app', 'Show paid in AMO'),
                'format' => 'html',
                'value' => function ($data) {
                    if ($data->amo_paid_view == 1) {
                        return '</i><i class="fas fa-eye"></i> Да';
                    }
                    return '<i class="far fa-eye-slash"></i> Нет';
                }
            ],
            [
                'label' => Yii::t('app', 'Show trial in AMO'),
                'format' => 'html',
                'value' => function ($data) {
                    if ($data->amo_trial_view == 1) {
                        return '<i class="fas fa-eye"></i> Да';
                    }
                    return '<i class="far fa-eye-slash fa-size-5x"></i> Нет';
                }
            ],
        ],
    ]) ?>

    <?php

    $gridView = \yii\grid\GridView::widget([
        'dataProvider' => $courseDataProvider,
        'filterModel' => $courseSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'course_id',
            [
                'label' => 'Название',
                'content' => function ($data) {
                    return \app\models\Course::getCourseAttr('title', $data->course_id)['title'];
                }
            ],
            [
                'label' => 'Город',
                'content' => function ($data) {
                    return \app\models\City::getCityName($data->city_id);
                }
            ],
            [
                'label' => 'Описание',
                'content' => function ($data) {
                    return \app\models\Course::getCourseAttr('description', $data->course_id)['description'];
                }
            ],
//            'title:ntext',
            /*[
                'attribute' => 'description',
                'content' => function ($data) {
                    if ($desc = $data->description) {
                        return mb_substr($desc, 0, 50) . '...';
                    }
                },
            ],*/
            /*[
                'attribute' => 'synopses_link',
                'content' => function ($data) {
                    if (isset($data->synopses_link)) {
                        $link = HTML::encode($data->synopses_link);
                        if (!empty($link)) {
                            return '<a target="_blank" href="' . $link . '">Перейти</a>';
                        }
                    } else {
                        return '';
                    }
                },
            ],*/
//            'lessons_num',
//            'cost',
            /*[
                'attribute' => 'citiesString',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return $data->getCitiesString();
                },
                'headerOptions' => ['style' => 'white-space: normal;'],
                'options' => ['width' => '70']
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            str_ireplace('product', 'course', $url));
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            str_ireplace('product', 'course', $url));
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            str_ireplace('product', 'course', $url));
                    },
                ],

            ]
        ]
    ]);

    if ($courseDataProvider->totalCount) {
        echo "<h3>На продукт назначены курсы: </h3>";
        echo $gridView;
    } else {
        echo "<h3>На продукт не назначено ни одного курса, в списке Продуктов не отображается. </h3>";
    }

    ?>
</div>
