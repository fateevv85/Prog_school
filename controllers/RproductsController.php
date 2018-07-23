<?php

namespace app\controllers;

use app\models\tables\Product;
use app\models\tables\ProductSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

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
        /*$searchModel = new ProductSearch();

        return $searchModel->productSearch(\Yii::$app->request->queryParams);*/

        $request = Yii::$app->request->get('paid') == 1;

        $amo = ($request) ?
            'amo_paid_view' :
            'amo_trial_view';

        $lesson = ($request) ?
            'lesson' : 'trial_lesson';

        $query = Product::find()
            ->select([
                'product.id as product_id',
                'product.name',
                'product.city_id',
                'product.amo_paid_view',
                'product.amo_trial_view',
                "{$lesson}.{$lesson}_id",
                "{$lesson}.start",
                "{$lesson}.capacity"
            ])
            ->leftJoin('course', 'course.product_id = product.id')
            ->leftJoin("{$lesson}", "{$lesson}.course_id = course.course_id")
            ->where([$amo => 1])
            ->andWhere("{$lesson}.start = 1")
            ->andWhere('date_start > now()')
            ->asArray()
            ->all();
        /*$query = Product::find()
            ->select([
                'product.id as product_id',
                'product.name as product_name',
                'product.city_id',
                'product.amo_paid_view',
                'product.amo_trial_view',
                "{$lesson}.*", 'group.title AS group_title',
                'group.participants_num AS group_participants_num',
                'group.participants_num_max AS group_participants_num_max',
                'course.title AS course_title',
                'course.synopses_link AS course_synopses_link',
                'lecture_hall.place_description as lecture_desc',
                'concat(teacher.last_name," ",teacher.first_name," ",teacher.middle_name) as `teacher_name`'
            ])
            ->leftJoin('course', 'course.product_id = product.id')
            ->leftJoin("{$lesson}", "{$lesson}.course_id = course.course_id")
            ->leftJoin('group', "{$lesson}.group_id = group.group_id")
            ->leftJoin('lecture_hall', "{$lesson}.lecture_hall_id = lecture_hall.lecture_hall_id")
            ->leftJoin( 'teacher', "{$lesson}.teacher_id = teacher.teacher_id")
            ->where([$amo => 1])
            ->andWhere('date_start > now()')
            ->asArray()
            ->all();*/

        $products = array_keys(array_count_values(ArrayHelper::map($query, 'product_id', 'name')));
        $newArr = [];
        foreach ($products as $k => $name) {
            foreach ($query as $key => $value) {
                if ($name == $value['name'] && isset($value[$lesson . '_id'])) {
//                    unset($value['name']);
                    $newArr[$name][$value[$lesson . '_id']] = $value;
                }
            }
        }

//        return Json::encode($newArr);
        return $newArr;
    }
}
