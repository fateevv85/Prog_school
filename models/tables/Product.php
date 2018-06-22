<?php

namespace app\models\tables;

use app\models\City;
use app\models\Course;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $city_id
 * @property int $amo_view
 *
 * @property Course[] $courses
 * @property City $city
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city_id'], 'required'],
            [['city_id', 'amo_view'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'city_id' => Yii::t('app', 'City ID'),
            'amo_view' => Yii::t('app', 'Show in AMO'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    public function getCityName()
    {
        return City::find()->where(['city_id' => $this->city_id]);
    }

    public function getCities()
    {
        return City::getCitiesForCurrentUser();
    }

    /*public function getCities()
    {
        return [1,2];
    }*/


}
