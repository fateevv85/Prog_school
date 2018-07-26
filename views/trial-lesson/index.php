<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use app\models\TrialLesson;
use app\components\WidgetHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrialLessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Trial Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>

  <div class="trial-lesson-index">

      <?php // echo $this->render('_search', ['model' => $searchModel]);
      $this->registerCss(".my-options {
      top: 33px;
      min-width: 151px; }"
      );
      $panelHeader = ($name = Yii::$app->request->get('product_name')) ? ' для продукта "' . $name . '"' : '';
      ?>

      <?php /*if ($name = Yii::$app->request->get('product_name')) : */ ?><!--
        <div class="btn-group">
          <a href="<? /*= Url::to(['lesson/index', 'LessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60),
              'LessonSearch[course_id]' => Yii::$app->request->get('TrialLessonSearch')['course_id'],
              'product_name' => Yii::$app->request->get('product_name')]) */ ?>" class="btn btn-default" role="button"
             aria-pressed="true">Платные занятия</a>
          <a href="#" class="btn btn-default active" role="button"
             aria-pressed="true">Пробные
            занятия</a>
        </div>
        <h4> для продукта "<? /*= $name */ ?>" </h4>-->
      <?php /*else: */ ?>
    <h1><?= Html::encode($this->title) ?></h1>
      <?php /*endif; */ ?>

    <p class="controls-block">
        <?php
        if (!Yii::$app->user->isGuest) {
            echo(Html::a(Yii::t('app', 'Create Trial Lesson'), ['create'], ['class' => 'btn btn-success']));
            echo(Html::button(Yii::t('app', 'Copy Trial Lessons'), ['class' => 'btn btn-primary copy-selected']));
            echo(Html::button(Yii::t('app', 'Delete Trial Lessons'), ['class' => 'btn btn-danger delete-selected']));
        }
        ?>
    </p>

    <!--      --><?php //Pjax::begin(); ?>
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
              [
                  'content' =>
                      Html::beginTag('div', ['class' => 'dropdown']) .
                      Html::button('Демо занятия <span class="caret"></span></button>',
                          ['type' => 'button', 'class' => 'btn btn-default', 'data-toggle' => 'dropdown'])
                      . \kartik\dropdown\DropdownX::widget([
                          'options' => [
                              'class' => 'my-options',
                              'id' => 'drop-down-type'
                          ],
                          'items' => [
                              ['label' => 'Платные занятия', 'url' => Url::to(['lesson/index', 'LessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60),
                                  'LessonSearch[course_id]' => Yii::$app->request->get('TrialLessonSearch')['course_id'],
                                  'product_name' => Yii::$app->request->get('product_name')])
                              ],
                          ],
                      ])
                      . Html::endTag('div')
              ],
              '{export}',
              [
                  'content' =>
                      Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['trial-lesson/index'], [
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
          'panel' => [
              'type' => 'default',
              'heading' => $this->title . $panelHeader
          ],
          //'panelHeadingTemplate'=> '{heading}',
          'resizableColumns' => true,
          'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
          'headerRowOptions' => ['class' => 'kartik-sheet-style'],
          'filterRowOptions' => ['class' => 'kartik-sheet-style'],
          //'emptyCell' => Yii::t('app','not set'),
          //'persistResize'=>false,
          'rowOptions' => WidgetHelper::stripeGrid(),
          'columns' => [
              //['class' => 'yii\grid\CheckboxColumn'],
              /* [
                   'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
                       return ['value' => $model->trial_lesson_id];
                   },
               ],*/

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
              //['class' => 'yii\grid\SerialColumn'],


              //'trial_lesson_id',
              //'group_id',
              [
                  'attribute' => 'group_id',
                  'label' => 'Группа',
                  'format' => 'html', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return Html::a($data->getGroupName(), ['group/view', 'id' => $data->group_id]);
                  },
                  'filter' => TrialLesson::getGroupsList(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 100px;'],
              ],
              [
                  'attribute' => 'num_trial',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->num_trial;
                  },
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'options' => ['width' => '70']
              ],
              [
                  'attribute' => 'lecture_hall_id',
                  'label' => 'Адрес',
                  'format' => 'html', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      if ($string = $data->getLectureHallAddress()) {
                          $mapLink = preg_match('#(?P<link>http?s:\/\/.+)#', $string, $matches);
                          $address = preg_replace('#http?s:\/\/.+#', "\n ", $string);
                          return $address . '<br>' . Html::a("Карта <i class=\"fas fa-external-link-alt\"></i>", $matches['link'], ['target' => '_blank']);
                      }
                  },
                  'filter' => TrialLesson::getLectureHallsList(),

                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 20%;'],
              ],
              /*[
                  'attribute'=>'date_start',
                  'label'=>'Дата',
                  //'format' => ['date'],
                  'headerOptions'=>['style'=>'white-space: normal;'],
                  'contentOptions'=>['style'=>'width: 100px;', 'type' => 'date', 'class' => 'actionClick date'],
                  //'format'=> ['date', 'php:d.m.Y'], // Возможные варианты: raw, html
                  'content'=>function($data){
                      return $data->getDateStart();
                  },
                  'filterInputOptions' => ['class' => 'form-control', 'type' => 'date']
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
              /*[
                  'attribute' => 'date_start',
                  'label'=>'Дата',
                  'format' =>  ['date', 'dd-MM-YYYY'],
                  'options' => ['width' => '200']
              ],*/
              [
                  'attribute' => 'time_start',
                  'label' => 'Время',
                  'format' => ['date', 'HH:mm'],
                  //'contentOptions'=>['style'=>'width: 100;', 'class' => 'actionClick time'],
                  'contentOptions' => ['style' => 'width: 50px;'],
                  'options' => ['width' => '50'],
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
                  'filter' => TrialLesson::getParticipantsNumsList()
              ],
              /*[
                  'attribute' => 'participants_num_max',
                  'label' => 'Вмести- мость',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getParticipantsNumMax();
                  },
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 50px;'],
                  'filter' => TrialLesson::getParticipantsNumsMaxList()
              ],*/
              'capacity',
              [
                  'attribute' => 'course_id',
                  'label' => 'Курс',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      //return '<a href="http://207.154.239.87/index.php?r=course%2Fview&id=' . $data->course_id . '">' .$data->getCourseName() . '</a>';
                      return '<a href="' . Url::to(['course/view', 'id' => $data->course_id]) . '">' . $data->getCourseName() . '</a>';
                  },
                  'filter' => TrialLesson::getCoursesList(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  'contentOptions' => ['style' => 'width: 20%;'],
              ],
              // 'teacher_id',
              //'date_start:date',
              [
                  'attribute' => 'teacher_id',
                  'label' => 'Преподаватель',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getTeacherName();
                  },
                  'filter' => TrialLesson::getTeachersList(),
                  'options' => ['width' => '150']
              ],
              [
                  'attribute' => 'course_date_start',
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  //'contentOptions'=>['style'=>'width: 100px;', 'type' => 'date', 'class' => 'actionClick date'],
                  'contentOptions' => ['style' => 'width: 100px;', 'type' => 'date'],
                  'content' => function ($data) {
                      return $data->getCourseDateStart();
                  },
              ],
              /*[
                  'attribute' => 'lesson_start',
                  'label'=>'Дата старта полного курса',
                  'format'=>'text', // Возможные варианты: raw, html
                  'content'=>function($data){
                      return $data->getLessonStart();
                  },
                  'headerOptions'=>['style'=>'white-space: normal;'],
                  'options' => ['width' => '100'],
                  //'filter' => TrialLesson::getTeachersList()
              ],*/
              /*[
                  'attribute' => 'lead_link',
                  'content'=>function($data){
                      if (isset($data->lead_link)) {
                          $link = HTML::encode($data->lead_link);
                          if ( !empty($link) ) {
                              return '<a target="_blank" href="' . $link  . '">Перейти</a>';
                          }
                      } else {
                          return '';
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
                  'label' => 'Списки',
                  'content' => function ($data) {
                      if ($data->start == 1) {
                          return
                              Html::a('Преподавателю', ['report/index', ['lesson_id' => $data->trial_lesson_id, 'lesson_type' => 'trial', 'list_type' => 'teacher']], ['target' => '_blank']) .
                              "<br>" .
                              Html::a('Менеджеру', ['report/index', ['lesson_id' => $data->trial_lesson_id, 'lesson_type' => 'trial', 'list_type' => 'manager']], ['target' => '_blank']);
                      }
                  }
              ],
              [
                  'attribute' => 'city_id',
                  'label' => 'Город',
                  'format' => 'text', // Возможные варианты: raw, html
                  'content' => function ($data) {
                      return $data->getCityTitle();
                  },
                  'filter' => TrialLesson::getCitiesList(),
                  //'filter' => City::getCitiesForCurrentUser(),
                  'headerOptions' => ['style' => 'white-space: normal;'],
                  //'contentOptions'=>['style'=>'width: 200px;'],
              ],
              [
                  'attribute' => 'start',
                  'content' => function ($data) {
                      if ($data->start == 1) {
                          return 'Да';
                      }
                      return 'Нет';
                  },
                  'filter' => [1 => 'Да',
                      0 => 'Нет']
              ]
              //'lead_link:ntext',

              // 'num_trial:ntext',

          ],
      ];
      if (!Yii::$app->user->isGuest) {
          $params['columns'][] = ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'];
      }

      echo(GridView::widget($params)); ?>
    <!--      --><?php //Pjax::end(); ?>
  </div>

<?php
if (!Yii::$app->user->isGuest) {
    $this->registerJsFile('@web/js/lessonTrial.js', ['depends' => 'yii\web\YiiAsset']);
}
?>