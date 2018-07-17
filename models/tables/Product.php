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
    public $lesson_id;
    public $trial_lesson_id;
    public $date_start;
    public $time_start;
    public $group_id;
    public $group_title;
    public $group_participants_num;
    public $course_id;
    public $course_title;
    public $teacher_id;
    public $lecture_hall_id;
    public $lecture_desc;

    public function fields()
    {
        return [
//            'id',
            'name',
            'city_id',
            'amo_paid_view',
            'amo_trial_view',
            'lesson' => function ($data) {
                $product = new Product($this);
                $reflect = new \ReflectionClass($product);
                $public = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
                foreach ($public as $prop) {
                    $arr[$prop->name] = $this->{$prop->name};
                }
                return $arr;
            }
        ];
    }

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
            [['city_id', 'amo_paid_view', 'amo_trial_view'], 'integer'],
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
            'amo_paid_view' => Yii::t('app', 'Show paid in AMO'),
            'amo_trial_view' => Yii::t('app', 'Show trial in AMO'),
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

    public static function getProductName($id)
    {
        return static::find()->where(['id' => $id])->one();
    }
}
