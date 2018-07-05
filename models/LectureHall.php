<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\City;

/**
 * This is the model class for table "lecture_hall".
 *
 * @property integer $lecture_hall_id
 * @property string $city
 * @property string $metro_station
 * @property string $street
 * @property string $address
 */
class LectureHall extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecture_hall';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'title'], 'required'],
            //[['title', 'metro_station', 'street', 'address'], 'string'],
            [['title', 'metro_station', 'place_description', 'link_yandex_map'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lecture_hall_id' => Yii::t('app', 'Lecture Hall ID'),
            'city_id' => Yii::t('app', 'Select City'),
            'title' => Yii::t('app', 'Title'),
            'metro_station' => Yii::t('app', 'Metro Station'),
            //'street' => Yii::t('app', 'Street'),
            'place_description' => Yii::t('app', 'Place Description'),
            //'google_calendar_name' => Yii::t('app', 'Google Calendar Name'),
            'cityTitle' => Yii::t('app', 'City Title'),
            'link_yandex_map' => Yii::t('app', 'link Yandex Map'),
        ];
    }

    public static function getAddresses()
    {
        $halls = self::find()
            ->all();
        $names = array();
        foreach ($halls as $key => $hall) {
            $names[$hall['lecture_hall_id']] = self::getAddress($hall);
            //$names[$hall['lecture_hall_id']]  = $hall->city . ', ' .  $hall->street . ' ' . $hall->address;
            /*$item = array();
            $item['teacher_id'] = $teacher['teacher_id'];
            $item['name']= $teacher->first_name . ' ' .  $teacher->middle_name . ' ' . $teacher->last_name;
            $names[] = $item;*/
        }
        return $names;
    }

    public static function getPlaces()
    {
        $halls = self::find()
            ->all();
        $names = array();
        foreach ($halls as $key => $hall) {
            $names[$hall['lecture_hall_id']] = self::getAddress($hall);
        }
        return $names;
    }

    public static function getCities()
    {
        $halls = self::find()
            ->all();
        $names = array();
        foreach ($halls as $key => $hall) {
            $names[$hall['lecture_hall_id']] = $hall->city;
        }
        return $names;
    }

    public static function getHallsForCurrentUser()
    {
        $identity = Yii::$app->user->identity;
        if (is_null($identity)) {
            return self::getPlaces();
        }
        return self::getHallsByIdentity($identity);
    }

    public static function getHallsByIdentity($identity)
    {
        $cities = array();
        if ($identity->role === 'main_admin') {
            return self::getPlaces();
        } else if ($identity->role === 'regional_admin') {
            if (is_numeric($identity->city_id)) {
                $halls = self::find()->where(['city_id' => $identity->city_id])->all();
                if (count($halls) > 0) {
                    $names = array();
                    foreach ($halls as $key => $hall) {
                        $names[$hall['lecture_hall_id']] = self::getAddress($hall);
                    }
                    return $names;
                    //$halls[ $hall['lecture_hall_id'] ] = self::getAddress($hall);
                }
            }
        }
        return $names;
        //print_r($identity->role);die;
    }

    public static function getAddress($hall)
    {
        $address = '';
        if ($hall) {
            if (!empty($hall->getCityTitle())) {
                $address .= $hall->getCityTitle();
            }
            /*if (isset($hall->metro_station)) {
                $address .= ', м. ' .  $hall->metro_station;
            }*/
            if (isset($hall->place_description)) {
                $address .= ', ' . $hall->place_description;
            }
        }
        return $address;
        //return $hall->getCityTitle() . ', м. ' .  $hall->metro_station .', ' .  $hall->place_description;
    }

    public static function getPlace($hall)
    {
        return $hall->place_description;
        //return  $hall->street . ', ' . $hall->address;
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    public function getCityTitle()
    {
        $city = $this->city;

        return $city ? $city->title : '';
    }

    /*public static function getCitiesList()
    {
        $cities = City::find()
            ->all();
        return ArrayHelper::map($cities, 'city_id', 'title');
    }*/
    public static function getCitiesList()
    {
        //return City::getCitiesList();
        return City::getCitiesForCurrentUser();
    }
}
