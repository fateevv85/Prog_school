<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "city".
 *
 * @property integer $city_id
 * @property string $title
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => Yii::t('app', 'City ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    public static function getAllCities()
    {
        $cities = self::find()->
        all();
        $names = array();
        foreach ($cities as $key => $city) {
            $names[$city['city_id']] = $city->title;
        }
        return $names;
    }

    public static function getCitiesForCurrentUser()
    {
        $identity = Yii::$app->user->identity;
        if (is_null($identity)) {
            return self::getAllCities();
        }
        return self::getCitiesByIdentity($identity);
    }

    public static function getCitiesByIdentity($identity)
    {
        $cities = array();
        if ($identity->role === 'main_admin') {
            $cities = self::getAllCities();
        } else if ($identity->role === 'regional_admin') {
            if (is_numeric($identity->city_id)) {
                $city = self::findOne($identity->city_id);
                $cities[$city['city_id']] = $city['title'];
            }
        }
        return $cities;
    }

    public static function getCitiesList()
    {
        $cities = City::find()
            ->all();
        return ArrayHelper::map($cities, 'city_id', 'title');
    }
}
