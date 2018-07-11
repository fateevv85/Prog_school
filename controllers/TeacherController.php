<?php

namespace app\controllers;

use app\components\WidgetHelper;
use app\models\Lesson;
use app\models\LessonTypeModel;
use app\models\TrialLesson;
use Yii;
use app\models\Teacher;
use app\models\TeacherSearch;
//use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * TeacherController implements the CRUD actions for Teacher model.
 */
class TeacherController extends MyAppController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Lists all Teacher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeacherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReport()
    {

        preg_match_all('#\d{2}\.\d{2}\.\d{4}#', $_GET['date_range'], $dates);
        $dateStart = WidgetHelper::convertDate($dates[0][0]);
        $dateEnd = WidgetHelper::convertDate($dates[0][1]);

        $dateValue = ($_GET['date_range']) ?: "01.01.2017 - " . date('d.m.Y');

        function createQuery($item, $fieldName)
        {
            if (count($item) > 1) {
                return ['in', $fieldName, $item];
            } elseif ($item) {
                return [$fieldName => $item];
            }
            return ['not', [$fieldName => null]];
        }

        $queryTeacher = createQuery($_GET['teacher_select'], 'teacher_id');

        $queryCity = createQuery($_GET['cities'], 'city_id');

        function getCount($lessonType, $dateStart, $dateEnd, $queryTeacher)
        {
            $query = $lessonType::find()
                ->select(['teacher_id', 'COUNT(*) AS cnt'])
                ->where($queryTeacher)
                ->andWhere(['between', 'date_start', $dateStart, $dateEnd])
                ->groupBy('teacher_id')
                ->asArray()
                ->all();

            return ArrayHelper::map($query, 'teacher_id', 'cnt');
        }

        if ($_GET['lessons']) {
            if (ArrayHelper::isIn('paid', $_GET) || ArrayHelper::isIn('paid', $_GET['lessons'])) {
                $countPaid = getCount(Lesson::className(), $dateStart, $dateEnd, $queryTeacher);
            }

            if (ArrayHelper::isIn('trial', $_GET['lessons'])) {
                $countTrial = getCount(TrialLesson::className(), $dateStart, $dateEnd, $queryTeacher);
            }

            $dataProviderTeacher = new ActiveDataProvider([
                'query' =>
                    Teacher::find()
                        ->where($queryTeacher)
                        ->andWhere($queryCity),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
        }

        return $this->render('report', [
            'dataProviderTeacher' => $dataProviderTeacher,
            'countPaid' => $countPaid,
            'countTrial' => $countTrial,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'dateValue' => $dateValue
        ]);
    }

    /**
     * Displays a single Teacher model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $dateStart = WidgetHelper::convertDate($_GET['dateStart']);
        $dateEnd = WidgetHelper::convertDate($_GET['dateEnd']);

        function options($id, $dateStart, $dateEnd, $lessonType)
        {
            return [
                'query' => $lessonType::find()->where(['teacher_id' => $id])->andWhere(['between', 'date_start', $dateStart, $dateEnd]),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ];
        }

        if ($_GET['lessons']) {
            if (ArrayHelper::isIn('paid', $_GET) || ArrayHelper::isIn('paid', $_GET['lessons'])) {
                $dataProviderPaid = new ActiveDataProvider(
                    options($id, $dateStart, $dateEnd, Lesson::className()));
            }

            if (ArrayHelper::isIn('trial', $_GET['lessons'])) {
                $dataProviderTrial = new ActiveDataProvider(
                    options($id, $dateStart, $dateEnd, TrialLesson::className()));
            }
        }

        /*if ($post = Yii::$app->request->post()) {

            $dateStart = $post['dateStart'];
            $dateEnd = $post['dateEnd'];

            function options($id, $dateStart, $dateEnd, $lessonType)
            {
                return [
                    'query' => $lessonType::find()->where(['teacher_id' => $id])->andWhere(['between', 'date_start', $dateStart, $dateEnd]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ];
            }

            if ($post['lessons']) {
                if (ArrayHelper::isIn('paid', $post) || ArrayHelper::isIn('paid', $post['lessons'])) {
                    $dataProviderPaid = new ActiveDataProvider(
                        options($id, $dateStart, $dateEnd, Lesson::className()));
                }

                if (ArrayHelper::isIn('trial', $post['lessons'])) {
                    $dataProviderTrial = new ActiveDataProvider(
                        options($id, $dateStart, $dateEnd, TrialLesson::className()));
                }
            }
        }*/

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProviderPaid' => $dataProviderPaid,
            'dataProviderTrial' => $dataProviderTrial
        ]);
    }

    public function actionSummary($id)
    {

        $post = Yii::$app->request->post();

        return $this->render('summary', [
            'model' => $this->findModel($id),
            'post' => $post
        ]);
    }

    /**
     * Creates a new Teacher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teacher();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->teacher_id]);
            return $this->redirect(['teacher/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Teacher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->teacher_id]);
            return $this->redirect(['teacher/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Teacher model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Teacher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teacher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Teacher::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
