<?php

namespace app\controllers;

use Yii;
use app\models\TrialLesson;
use app\models\TrialLessonSearch;

use app\models\Lesson;
use app\models\Teacher;
use app\models\LectureHall;
use app\models\Group;
use app\models\Course;
use app\models\User;

use app\custom\GoogleCalendarHelper;

//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\helpers\Url;

/**
 * TrialLessonController implements the CRUD actions for TrialLesson model.
 */
class TrialLessonController extends LessonTypeController
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'dateChange', 'deleteSelected', 'copySelected', 'timeChange'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'deleteSelected', 'copySelected', 'dateChange', 'timeChange'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TrialLesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrialLessonSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDateChange()
    {
        $params = Yii::$app->request->post();
        $trialLesson = $this->findModel($params['id']);
        $trialLesson->date_start = $params['value'];
        $trialLesson->save();

        $request = Yii::$app->request;
        return $this->redirect($request->post()['redirect']);
    }

    public function actionTimeChange()
    {
        $params = Yii::$app->request->post();
        $trialLesson = $this->findModel($params['id']);
        $trialLesson->time_start = $params['value'];
        $trialLesson->save();

        $request = Yii::$app->request;
        return $this->redirect($request->post()['redirect']);
    }

    /**
     * Displays a single TrialLesson model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TrialLesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new TrialLesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $trialLesson->trial_lesson_id]);
            $params = self::getLessonEntityParams($model);
            $params['link'] = Url::toRoute(['trial-lesson/index', 'TrialLessonSearch[trial_lesson_id]' => $model->trial_lesson_id], true);
            $result = GoogleCalendarHelper::callConsoleMethod('createEvent', $params);
            //для франшизы, добавление параметра город в соответствии с городом создающего пользователя, будет использоваться для фильтрации занятий по городу
            $userRole = User::getCurrentUserRole();
            if ($userRole === 'regional_admin') {
                $identity = Yii::$app->user->identity;
                if (isset($identity->city_id)) {
                    $model->city_id = $identity->city_id;
                }
            }
            if (isset($result['eventId']) && !empty($result['eventId'])) {
                $model->calendar_event_id = $result['eventId'];
            }
            $model->save();
            return $this->redirect(['trial-lesson/index']);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing TrialLesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->updateLessonTypeEntity($id, 'trial-lesson');
    }

    /**
     * Deletes an existing TrialLesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteSelected()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $ids = $request->post()['ids'];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $params = array();
                    $params['calendarName'] = self::getLessonCalendarName($model);
                    $params['eventId'] = $model->calendar_event_id;
                    $result = GoogleCalendarHelper::deleteEventById($params);
                    $model->delete();
                }
            }
        }
        return $this->redirect($request->post()['redirect']);
    }

    public function actionCopySelected()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $ids = $request->post()['ids'];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $data = $model->attributes;
                    $newModel = new TrialLesson();
                    $id = $newModel->trial_lesson_id;

                    if (isset($data['calendar_event_id'])) {
                        unset($data['calendar_event_id']);
                    }

                    $newModel->setAttributes($data);
                    $newModel->trial_lesson_id = $id;
                    $newModel->save();

                    $params = self::getLessonEntityParams($newModel);
                    $params['link'] = Url::toRoute(['trial-lesson/index', 'TrialLessonSearch[trial_lesson_id]' => $newModel->trial_lesson_id], true);
                    $result = GoogleCalendarHelper::callConsoleMethod('createEvent', $params);
                    $newModel->calendar_event_id = $result['eventId'];
                    $newModel->save();
                }
            }
        }
        return $this->redirect($request->post()['redirect']);
    }

    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $result = GoogleCalendarHelper::deleteEventById($model->calendar_event_id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrialLesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrialLesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrialLesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
