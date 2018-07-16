<?php

namespace app\controllers;

use app\models\Course;
use app\models\CourseSearch;
use app\models\tables\ProductSearch;
use Yii;
use app\models\tables\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
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

    public function actionTest()
    {
        $query = Product::find()
            ->select(['product.name', 'lesson_id'])
//            ->select(['product.name', 'product.id', 'COUNT(*) as cnt'])
//            ->select(['product.name, COUNT(*) as cnt'])
            ->leftJoin('course', 'course.product_id = product.id')
            ->leftJoin('lesson', 'lesson.course_id = course.course_id')
            ->where(['amo_paid_view' => 1,
                'amo_trial_view' => 1])
//            ->groupBy(['product.name'])
            ->asArray()
            ->all();

        $products = array_keys(array_count_values(ArrayHelper::map($query, 'lesson_id', 'name')));
        $newArr = [];
        foreach ($products as $k=>$name) {
            foreach ($query as $key => $value) {
                if ($name == $value['name'] && isset($value['lesson_id'])) {
                    unset($value['name']);
                    $newArr[$name][] = $value['lesson_id'];
                }
            }
        }

        var_dump($newArr);
//        var_dump($query);
//        var_dump($result);
//        var_dump($products);
        exit;
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $courseSearchModel = new CourseSearch();
        $courseDataProvider = new ActiveDataProvider([
            'query' => Course::find()->where(['product_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'courseDataProvider' => $courseDataProvider,
            'courseSearchModel' => $courseSearchModel
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->city_id = Yii::$app->request->post('Product')['city_id'][0];
            $model->save();
//            return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(Url::to(['product/index']));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->city_id = Yii::$app->request->post('Product')['city_id'][0];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\yii\db\Exception $exception) {
//            var_dump($exception);
//            return $this->redirect(Url::to(['site/error']));
            return $this->render('error', [
                'message' => $exception,
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
