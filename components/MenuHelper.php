<?php

namespace app\components;


use app\models\tables\Product;

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
                'url' => ['#'],
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
            $result[] = $item['name'];
        }

        return $result;
    }
}
