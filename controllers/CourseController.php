<?php

namespace app\controllers;

use app\models\CourseInCity;
use Yii;
use yii\filters\AccessControl;
use app\models\Course;
use app\models\CourseSearch;
//use yii\web\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends MyAppController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
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
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();
        $post = Yii::$app->request->post();
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load($post) && $model->save()) {

            $citiesIds = $post['Course']['cities'];
            if (!is_array($citiesIds)) {
                $citiesIds = array();
            }

            $productsId = Yii::$app->request->post('Course')['products'];

            if (!is_array($productsId)) {
                $productsId = array();
            }

//            $model->cities = $citiesIds;
            $model->setCities($citiesIds, $productsId);
//            $model->products = $productsId;

            $model->save();
            return $this->redirect(['course/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->course_id]);
            $citiesIds = $post['Course']['cities'];
            if (!is_array($citiesIds)) {
                $citiesIds = array();
            }

            $productsId = Yii::$app->request->post('Course')['products'];

            if (!is_array($productsId)) {
                $productsId = array();
            }

//            $model->cities = $citiesIds;
            $model->setCities($citiesIds, $productsId);

            $model->save();
            return $this->redirect(['course/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$identity = \Yii::$app->user->identity;

        // может удалить только курс для своего города
        if ($identity->role === 'regional_admin') {
            CourseInCity::deleteAll(['and', "course_id={$id}", "city_id={$identity->city_id}"]);
            // удаляет курс целиком
        } elseif ($identity->role === 'main_admin') {
            $this->findModel($id)->delete();
            CourseInCity::deleteAll('course_id=:id', [':id' => $id]);
        }*/
		$this->findModel($id)->delete();
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
