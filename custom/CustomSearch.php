<?php

namespace app\custom;
class CustomSearch
{

    public static function filterByUserCity($query)
    {
        $identity = \Yii::$app->user->identity;
        if (!is_null($identity) && isset($identity->city_id) && !is_null($identity->city_id) && is_numeric($identity->city_id)) {
            if ($identity->role === 'regional_admin') {
                $query->andWhere(['city_id' => $identity->city_id]);
            }
        }
        return $query;
    }

    public static function filterByProduct($query, $productId, $lessonType = null)
    {
        /*return
            $query
                ->leftJoin('course', "course.course_id = {$lessonType}lesson.course_id")
                ->where(['product_id' => $productId]);*/
        return $query
            ->leftJoin('course_in_city', "course_in_city.course_id = {$lessonType}lesson.course_id")
            ->where(['product_id' => $productId]);
    }
}