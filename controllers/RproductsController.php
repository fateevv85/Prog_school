<?php

namespace app\controllers;

use app\models\tables\ProductSearch;
use Yii;

//use app\models\Group;

/**
 * CourseController implements the CRUD actions for Course model.
 */
//use yii\rest\ActiveController;

class RproductsController extends MyActiveController
{
    public $modelClass = 'app\models\tables\Product';

    public function prepareDataProvider()
    {
        $searchModel = new ProductSearch();
        return $searchModel->search(\Yii::$app->request->queryParams, 1);
    }

}
