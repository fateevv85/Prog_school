<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\components\WidgetHelper;
use kartik\daterange\DateRangePicker;
use app\models\Lesson;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
  <div class="lesson-index">


      <?php // echo $this->render('_search', ['model' => $searchModel]);?>

      <?php if ($name = Yii::$app->request->get('product_name')) : ?>
        <div class="btn-group">
          <a href="#" class="btn btn-default active" role="button" aria-pressed="true">Платные занятия</a>
          <a href="<?= Url::to(['trial-lesson/index', 'TrialLessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60),
              'TrialLessonSearch[course_id]' => Yii::$app->request->get('LessonSearch')['course_id'],
              'product_name' => Yii::$app->request->get('product_name')]) ?>" class="btn btn-default" role="button"
             aria-pressed="true">Пробные
            занятия</a>
        </div>
        <h4> для продукта "<?= $name ?>" </h4>
      <?php else: ?>
        <h1><?= Html::encode($this->title) ?></h1>
      <?php endif; ?>

    <p class="controls-block">
        <?php
        if (!Yii::$app->user->isGuest) {
            echo(Html::a(Yii::t('app', 'Create Trial Lesson'), ['create'], ['class' => 'btn btn-success']));
            echo(Html::button(Yii::t('app', 'Copy Trial Lessons'), ['class' => 'btn btn-primary copy-selected']));
            echo(Html::button(Yii::t('app', 'Delete Trial Lessons'), ['class' => 'btn btn-danger delete-selected']));
        }
        ?>
    </p>

      <?php Pjax::begin(); ?>
      <?php
      $daterange = [
          'model' => $searchModel,
          'attribute' => 'date_start',
          'convertFormat' => false,
          //'presetDropdown'=>true,
          'pluginOptions' => [
              'opens' => 'right',
              'locale' => [
                  'cancelLabel' => 'Отмена',
                  'applyLabel' => 'Готово',
                  'format' => 'DD.MM.YYYY',
              ]
              //'format' => 'DD.MM.YYYY',
              //'format' => 'YYYY-MM-DD',
          ],
          'i18n' => [
              'class' => 'yii\i18n\PhpMessageSource',
              'basePath' => '@app/vendor/yiisoft/yii2/messages',
              'forceTranslation' => true
          ]
      ];
      $params = [
          'bordered' => true,
          'striped' => false,
          'condensed' => false,
          'responsive' => true,
          'responsiveWrap' => false,
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'autoXlFormat' => true,
          'export' => [
              'fontAwesome' => true,
              'showConfirmAlert' => false,
              'target' => GridView::TARGET_BLANK
          ],
          'toolbar' => [
              '{export}',
              [
                  'content' =>
                      Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['lesson/index'], [
                          'class' => 'btn btn-default',
                          'title' => Yii::t('app', 'Reset Grid')
                      ]),
              ],
              '{toggleData}',
              'toggleDataContainer' => ['class' => 'btn-group-sm'],
          ],
          /*'toolbar' =>  [
              '{export}',
              '{toggleData}',
          ],*/
          // set export properties
          /*'export' => [
              'fontAwesome' => true
          ],*/
          'panel' => [
              'type' => 'default',
              'heading' => $this->title
          ],
          //'panelHeadingTemplate'=> '{heading}',
          'resizableColumns' => true,
          'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
          'headerRowOptions' => ['class' => 'kartik-sheet-style'],
          'filterRowOptions' => ['class' => 'kartik-sheet-style'],
          'rowOptions' => WidgetHelper::stripeGrid(),
          'columns' => [
              [
                  'class' => 'kartik\grid\CheckboxColumn',
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 10px;'],
              ],
              [
                  'class' => 'yii\grid\SerialColumn',
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 10px;'],
              ],
//            'lesson_id',
              [
                  'attribute' => 'group_id',
                  'label' => 'Группа',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return Html::a($data->getGroupName(), ['group/view', 'id' => $data->group_id]);
                  },
                  'filter' => Lesson::getGroupsList(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 100px;'],
              ],
              [
                  'attribute' => 'lecture_hall_id',
                  'label' => 'Адрес',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      if ($string = $data->getLectureHallAddress()) {
                          $mapLink = preg_match('#(?P<link>http?s:\/\/.+)#', $string, $matches);
                          $address = preg_replace('#http?s:\/\/.+#', ' ', $string);
                          return $address .'<br>'. Html::a("Карта <i class=\"fas fa-external-link-alt\"></i>", $matches['link'], ['target' => '_blank']);
                      }
                  },
                  'filter' => Lesson::getLectureHallsList(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 20%;'],
              ],
              /*[
                  'attribute'=>'course_id',
                  'label'=>'Стоимость курса',
                  'format'=>'text', // Возможные варианты: raw, html
                  'content'=>function($data){
                      return $data->getCourseCost();
                  },
                  'headerOptions'=>['style'=>'white-space: normal;'],
                  'contentOptions'=>['style'=>'width: 100px;'],
              ],*/
              [
                  'attribute' => 'date_start',
                  'filter' => DateRangePicker::widget($daterange),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  //'contentOptions'=>['style'=>'width: 100px;', 'type' => 'date', 'class' => 'actionClick date'],
                  'contentOptions' => ['style' => 'width: 100px;', 'type' => 'date'],
                  'content' => function ($data) {
                      return $data->getDateStart();
                  },
              ],
              [
                  'attribute' => 'time_start',
                  'label' => 'Время',
                  'format' => ['date', 'HH:mm'],
                  //'contentOptions'=>['style'=>'width: 100;', 'class' => 'actionClick time'],
                  'contentOptions' => ['style' => 'width: 100;'],
                  'options' => ['width' => '100'],
                  'filterInputOptions' => ['class' => 'form-control', 'type' => 'time']
              ],
              [
                  'attribute' => 'duration',
                  'label' => 'Продолжи- тельность (минуты)',
                  //'contentOptions'=>['style'=>'width: 100;', 'class' => 'actionClick time'],
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 100;'],
                  'options' => ['width' => '100']
              ],
              [
                  'attribute' => 'participants_num',
                  'label' => 'Записано учеников',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getParticipantsNum();
                  },
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 50px;'],
                  'filter' => Lesson::getParticipantsNumsList()
              ],
              [
                  'attribute' => 'participants_num_max',
                  'label' => 'Вмести- мость',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getParticipantsNumMax();
                  },
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 50px;'],
                  'filter' => Lesson::getParticipantsNumsMaxList()
              ],


              [
                  'attribute' => 'course_id',
                  'label' => 'Курс',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return '<a href="' . Url::to(['course/view', 'id' => $data->course_id]) . '">' . $data->getCourseName() . '</a>';
                  },
                  'filter' => Lesson::getCoursesList(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 20%;'],
              ],
              [
                  'attribute' => 'teacher_id',
                  'label' => 'Преподаватель',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getTeacherName();
                  },
                  'filter' => Lesson::getTeachersList(),
                  'options' => ['width' => '150']
              ],
              /* [
                   'attribute' => 'lead_link',
                   'content'=>function($data){
                       $link = HTML::encode($data->lead_link);
                       if ( !empty($link) ) {
                           return '<a target="_blank" href="' . $link  . '">Перейти</a>';
                       }
                   },
               ],*/
              [
                  'attribute' => 'lead_link',
                  //'hAlign'=>'left',
                  'label' => 'Сделки',
                  //'vAlign'=>'middle',
                  'content' => function ($data) {
                      $link = HTML::encode($data->getCRMLeadsLink());
                      if (!empty($link)/*BaseUrl::isRelative($link )*/) {
                          return '<a target="_blank" href="' . $link . '">Перейти</a>';
                      } else {
                          return 'Не удалось получить ссылку' . $link;
                      }
                  },
              ],
              [
                  'attribute' => 'city_id',
                  'label' => 'Город',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getCityTitle();
                  },
                  'filter' => Lesson::getCitiesList(),
                  //'filter' => City::getCitiesForCurrentUser(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  //'contentOptions'=>['style'=>'width: 200px;'],
              ],
          ],
      ];
      if (!Yii::$app->user->isGuest) {
          $params['columns'][] = ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'];
      }

      echo(GridView::widget($params)); ?>
      <?php Pjax::end(); ?></div>

<?php
if (!Yii::$app->user->isGuest) {
    $this->registerJsFile('/web/js/lessonPaid.js', ['depends' => 'yii\web\YiiAsset']);
}
