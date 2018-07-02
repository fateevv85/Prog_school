<?php

namespace app\components;


use app\models\tables\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class MenuHelper
{
    private static function getItems()
    {
        return \app\custom\CustomSearch::filterByUserCity(Product::find());
    }

    public static function getMenu()
    {
        $items = static::getItems()
            ->asArray()
            ->all();

        $result = [];


        foreach ($items as $item) {
            $courses = ArrayHelper::getColumn(\app\models\Course::find()->where(['product_id' => $item['id']])->asArray()->all(), 'course_id');

            $result[] = [
                'label' => $item['name'],
                'url' => Url::to(['lesson/index',
                    'LessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60),
                    'LessonSearch[course_id]' => $courses
                ]),
                '<li class="divider"></li>',
            ];
        }


        return $result;
    }

    public static function getDropDownList()
    {
        $items = static::getItems()
            ->asArray()
            ->all();

        $result = [];

        foreach ($items as $item) {
            $result[$item['id']] = $item['name'];
        }

        return $result;
    }
}
