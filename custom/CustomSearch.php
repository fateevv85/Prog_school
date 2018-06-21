<?php
namespace app\custom;
class CustomSearch {
    
    public static function filterByUserCity($query) {
        $identity = \Yii::$app->user->identity;
        if (!is_null($identity) && isset($identity->city_id) && !is_null($identity->city_id) && is_numeric($identity->city_id)) {
            if ($identity->role === 'regional_admin') {
                $query->andWhere(['city_id' => $identity->city_id]);
            }
        }
        return $query;
    }
}