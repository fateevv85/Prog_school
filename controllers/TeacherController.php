<?php

namespace app\controllers;

use app\models\Lesson;
use app\models\TrialLesson;
use Yii;
use app\models\Teacher;
use app\models\TeacherSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    /**
     * Displays a single Teacher model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($post = Yii::$app->request->post()) {

            $dateStart = $post['dateStart'];
            $dateEnd = $post['dateEnd'];

            if ($post['lessons']) {
                if (in_array('paid', $post['lessons'])) {
//                    $paid = Lesson::find()->where(['teacher_id' => $id])->andWhere(['between', 'date_start', $dateStart, $dateEnd])->all();
                    $dataProviderPaid = new \yii\data\ActiveDataProvider([
                        'query' => Lesson::find()->where(['teacher_id' => $id])->andWhere(['between', 'date_start', $dateStart, $dateEnd]),
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);
                }

                if (in_array('trial', $post['lessons'])) {
//                    $trial = TrialLesson::find()->where(['teacher_id' => $id])->all();
                    $dataProviderTrial = new \yii\data\ActiveDataProvider([
                        'query' => TrialLesson::find()->where(['teacher_id' => $id])->andWhere(['between', 'date_start', $dateStart, $dateEnd]),
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);
                }
            }
        }

//        $post = Yii::$app->request->post();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'post' => $post,
//            'paid' => $paid,
//            'trial' => $trial,
//            'dateStart' => $dateStart,
//            'dateEnd' => $dateEnd,
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
