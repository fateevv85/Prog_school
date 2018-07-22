<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\City;
/**
 * This is the model class for table "group".
 *
 * @property integer $group_id
 * @property string $title
 * @property integer $participants_num
 * @property integer $participants_num_max
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['title', 'city_id', 'participants_num_max'], 'required'],
            [['title', 'city_id'], 'required'],
            [['title'], 'string'],
//            [['participants_num', 'participants_num_max'], 'integer'],
            [['participants_num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => Yii::t('app', 'Group ID'),
            'city_id' => Yii::t('app', 'Select City'),
            'title' => Yii::t('app', 'Title'),
            'participants_num' => Yii::t('app', 'Participants Num'),
//            'participants_num_max' => Yii::t('app', 'Participants Num Max'),
        ];
    }
    public static function getTitles()
    {
        $groups = self::find()
            ->all();
        $titles = array();
        foreach($groups as $key => $group) {
            $titles[$group['group_id']]  = $group->title;
        }
        return $titles;
    }
    public function getCityTitle()
    {
        $city = $this->city;
     
        return $city ? $city->title : '';
    }
    
    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }
    
    public static function getCitiesList()
    {
        //return City::getCitiesList();
        return City::getCitiesForCurrentUser();
    }
    
    public static function getAllGroups()
    {
        $groups = Group::find()
            ->all();
        return $groups;
    }
     public static function getGroupsForCurrentUser()
    {
        $identity = Yii::$app->user->identity;
        if ( is_null($identity) ) {
            return self::getAllGroups();
        }
        return self::getGroupsByIdentity($identity);
    }
    public static function getGroupsByIdentity($identity)
    {
        if ( $identity->role === 'main_admin' ) {
            return self::getAllGroups();
        } else if ($identity->role === 'regional_admin') {
            if ( is_numeric($identity->city_id) ) {
                $groups = self::find()->where(['city_id' => $identity->city_id])->all();
                return $groups;
            }
        } else {
            return array();
        }
    }
    
     /*public static function getAllG()
    {
        $cities = self::find()->
            all();
        $names = array();
        foreach($cities as $key => $city) {
            $names[$city['city_id']]  = $city->title;
        }
        return $names;
    }
    public static function getCitiesForCurrentUser()
    {
        $identity = Yii::$app->user->identity;
        if ( is_null($identity) ) {
            return self::getAllCities();
        }
        return self::getCitiesByIdentity($identity);
    }
    public static function getCitiesByIdentity($identity)
    {
        $cities = array();
        if ( $identity->role === 'main_admin' ) {
            $cities = self::getAllCities();
        } else if ($identity->role === 'regional_admin') {
            if ( is_numeric($identity->city_id) ) {
                $city = self::findOne($identity->city_id);
                $cities[ $city['city_id'] ] = $city['title'];
            }
        }
        return $cities;
        //print_r($identity->role);die;
    }*/
     /*public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && Yii::$app->user->city_id) {
                //автоматом ставим тот же город что и у создающего  пользователя
                $this->city_id = Yii::$app->user->city_id;
            }
            return true;
        }
        return false;
    }*/
}
