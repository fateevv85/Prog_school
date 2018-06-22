<?php

namespace app\components;


use app\models\tables\Product;
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
            $result[] = [
                'label' => $item['name'],
//                'url' => ['#'],
                'url' => Url::to(['course/index', 'CourseSearch[product_id]' => $item['id']]),
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
