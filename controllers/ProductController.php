<?php

namespace app\controllers;

use app\models\City;
use app\models\Course;
use app\models\CourseSearch;
use app\models\tables\ProductSearch;
use app\models\User;
use Yii;
use app\models\tables\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
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

    public function actionResponse()
    {

        $request = Yii::$app->request->get('paid') == 1;
        /*$token = Yii::$app->request->get('access-token');
        $userId = User::findIdentityByAccessToken($token);
        $city = City::getCitiesByIdentity($userId);*/


        /*if (!$userId) {
            return Json::encode('Not authorized');
        }*/
//        var_dump($userId);
//        var_dump($city);
//        exit;
        $amo = ($request) ?
            'amo_paid_view' :
            'amo_trial_view';

        $lesson = ($request) ?
            'lesson' : 'trial_lesson';

        $query = Product::find()
            ->select(['product.id as product_id', 'product.name', 'product.city_id', 'product.amo_paid_view', 'product.amo_trial_view', "{$lesson}.{$lesson}_id"])
            ->leftJoin('course', 'course.product_id = product.id')
            ->leftJoin("{$lesson}", "{$lesson}.course_id = course.course_id")
            ->where([$amo => 1])
            ->andWhere('date_start > now()')
            ->asArray()
            ->all();
        /*$query = Product::find()
            ->select(['product.id as product_id', 'product.name', 'product.city_id', 'product.amo_paid_view', 'product.amo_trial_view', "{$lesson}.*", 'group.title AS group_title', 'group.participants_num AS group_participants_num', 'course.title AS course_title', 'lecture_hall.place_description as lecture_desc'])
            ->leftJoin('course', 'course.product_id = product.id')
            ->leftJoin("{$lesson}", "{$lesson}.course_id = course.course_id")
            ->leftJoin('group', "{$lesson}.group_id = group.group_id")
            ->leftJoin('lecture_hall', "{$lesson}.lecture_hall_id = lecture_hall.lecture_hall_id")
            ->where([$amo => 1])
            ->andWhere('date_start > now()')
            ->asArray()
            ->all();*/

        $products = array_keys(array_count_values(ArrayHelper::map($query, 'product_id', 'name')));
        $newArr = [];
        foreach ($products as $k => $name) {
            foreach ($query as $key => $value) {
                if ($name == $value['name'] && isset($value[$lesson . '_id'])) {
                    unset($value['name']);
                    $newArr[$name][$value[$lesson . '_id']] = $value;
                }
            }
        }

//        return Json::encode($newArr);
        var_dump($newArr);
        exit;
//        var_dump($query);
//        var_dump($result);
//        var_dump($products);
//        exit;
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
