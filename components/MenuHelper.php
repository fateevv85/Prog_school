<?php

namespace app\components;


use app\models\CourseInCity;
use app\models\tables\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class MenuHelper
{
    public static function getItems()
    {
        $productIds = \app\custom\CustomSearch::filterByUserCity(CourseInCity::find())->andWhere(['not', ['product_id' => null]])
            ->asArray()->all();

        if($productIds) {
            foreach ($productIds as $item => $value) {
                $productArray[$item]['id'] = $value['product_id'];
                $productArray[$item]['name'] = Product::getProductName($value['product_id']);
            }

            $productArray = ArrayHelper::map($productArray, 'id', 'name');

            return $productArray;
        }

        return false;
    }

    public static function getMenu()
    {
        $result = [];

        if ($items = static::getItems()) {

            foreach ($items as $id => $name) {
                $result[] = [
                    'label' => $name,
                    'url' => Url::to(['lesson/index',
                        'LessonSearch[date_start]' => date('d.m.Y', time() + 3 * 60 * 60) . ' - ' . date('d.m.Y', time() + 364 * 24 * 60 * 60),
                        'LessonSearch[product_id]' => $id,
                    ]),
                    '<li class="divider"></li>',
                ];
            }
        }

        return $result;
    }

    public static function getDropDownList()
    {
        $result = [];

        if ($items = static::getItems()) {
            foreach ($items as $item) {
                $result[$item['id']] = $item['name'];
            }
        }

        return $result;
    }
}
