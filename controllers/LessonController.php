<?php

namespace app\controllers;


use Yii;
use app\models\Lesson;
use app\models\LessonSearch;

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
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends LessonTypeController
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
     * Lists all Lesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lesson model.
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
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $params = self::getLessonEntityParams($model);
            $params['link'] = Url::toRoute(['lesson/index', 'LessonSearch[lesson_id]' => $model->lesson_id], true);
            $result = GoogleCalendarHelper::createEvent($params);

            //для франшизы, добавление параметра город в соответствии с городом создающего пользователя, будет использоваться для фильтрации занятий по городу
            $userRole = User::getCurrentUserRole();
            if ($userRole === 'regional_admin') {
                $identity = Yii::$app->user->identity;
                if (isset($identity->city_id)) {
                    $model->city_id = $identity->city_id;
                }
            }

            $model->calendar_event_id = $result['eventId'];
            $model->save();
            /*echo('<pre>');
            print_r($result);
            echo('</pre>');
            die;*/
            return $this->redirect(['view', 'id' => $model->lesson_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $result = GoogleCalendarHelper::deleteEventById($model->calendar_event_id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        return $this->updateLessonTypeEntity($id, 'lesson');
        /*$model = $this->findModel($id);
        //$trialLesson = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->trial_lesson_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
    }

    public function actionDeleteSelected()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $ids = $request->post()['ids'];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $result = GoogleCalendarHelper::deleteEventById($model->calendar_event_id);
                    $model->delete();
                }
            }
        }
        return $this->redirect($request->post()['redirect']);
        /*foreach($ids as $id) {
             $this->findModel($id)->delete();
        }*/

        //return $this->redirect(['index']);
        //return $this->redirect([$request->absoluteUrl]);
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
                    $newModel = new Lesson();
                    $id = $newModel->lesson_id;

                    if (isset($data['calendar_event_id'])) {
                        unset($data['calendar_event_id']);
                    }

                    $newModel->setAttributes($data);
                    $newModel->lesson_id = $id;
                    $newModel->save();


                    $params = self::getLessonEntityParams($newModel);
                    $params['link'] = Url::toRoute(['lesson/index', 'LessonSearch[lesson_id]' => $newModel->lesson_id], true);
                    $result = GoogleCalendarHelper::callConsoleMethod('createEvent', $params);
                    $newModel->calendar_event_id = $result['eventId'];
                    $newModel->save();
                }
            }
        }
        return $this->redirect($request->post()['redirect']);
    }

}
