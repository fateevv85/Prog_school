<?php

namespace app\components;


use app\models\tables\Product;

class MenuHelper
{
    public static function getMenu()
    {
        $items = \app\custom\CustomSearch::filterByUserCity(Product::find())
            ->asArray()
            ->all();

        $result = [];

        foreach ($items as $item) {
            $result[] = [
                'label' => $item['name'],
                'url' => ['#'],
                '<li class="divider"></li>',
            ];
        }
        return $result;
    }
}