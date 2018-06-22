<?php

namespace app\models;

use app\models\tables\Product;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\CourseTypes;

/**
 * This is the model class for table "course".
 *
 * @property integer $course_id
 * @property string $title
 * @property string $description
 * @property string $synopses_link
 * @property integer $lessons_num
 * @property string $cost
 * @property string $city_id
 * @property integer $product_id
 *
 * @property City $city
 * @property CourseInCity[] $courseInCities
 */
class Course extends \yii\db\ActiveRecord
{
    public $citiesString;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'synopses_link'], 'string'],
            [['lessons_num', 'city_id'], 'integer'],
            [['cost'], 'number'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'city_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('app', 'Course ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'synopses_link' => Yii::t('app', 'Synopses Link'),
            'lessons_num' => Yii::t('app', 'Lessons Num'),
            'cost' => Yii::t('app', 'Cost'),
            'citiesString' => Yii::t('app', 'Cities'),
            'cities' => Yii::t('app', 'Cities'),
            'product_id' => Yii::t('app', 'Product')
            // 'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    public static function getCourses()
    {
        $courses = self::find()
            ->all();
        $names = array();
        foreach ($courses as $key => $course) {
            $names[$course['course_id']] = $course->title;
        }
        return $names;
    }

    public static function getAllCourses()
    {
        $courses = self::find()
            ->all();
        return $courses;
    }

    public static function getCoursesForCurrentUser()
    {
        $identity = Yii::$app->user->identity;
        if (is_null($identity)) {
            return self::getAllCourses();
        }
        return self::getCoursesByIdentity($identity);
    }

    public static function getCoursesByIdentity($identity)
    {
        if ($identity->role === 'main_admin') {
            return self::getAllCourses();
        } else if ($identity->role === 'regional_admin') {
            if (is_numeric($identity->city_id)) {
                $coursesInCity = self::getCoursesInCityById($identity->city_id);
                return $coursesInCity;
            }
        } else {
            return array();
        }
    }

    public static function getCoursesInCityById($cityId)
    {
        $coursesInCity = CourseInCity::find()->where(['city_id' => $cityId])->all();
        $coursesIds = array();
        foreach ($coursesInCity as $courseInCity) {
            if (isset($courseInCity->course_id)) {
                $coursesIds[] = $courseInCity->course_id;
            }
        }
        $courses = Course::find()->where(['course_id' => $coursesIds])->all();
        return $courses;
    }

    public function getCities()
    {
        return $this->hasMany(City::className(), ['city_id' => 'city_id'])
            ->viaTable('course_in_city', ['course_id' => 'course_id']);
    }

    public function getCitiesString()
    {
        $cities = $this->cities;
        $cities = ArrayHelper::toArray($cities);
        $citiesTitles = ArrayHelper::getColumn($cities, 'title');
        $citiesString = implode(', ', $citiesTitles);
        return $citiesString;

    }

    public function setCities($citiesIds)
    {


        $prevCities = $this->cities;
        $prevCitiesIds = array();
        if (is_array($prevCities) && count($prevCities) > 0) {
            foreach ($prevCities as $city) {
                $prevCitiesIds[] = $city->city_id;
            }
        }
        $toDelete = array_diff($prevCitiesIds, $citiesIds);
        $toAdd = array_diff($citiesIds, $prevCitiesIds);

        foreach ($toDelete as $id) {
            //$item = CourseTypeInPlace::find()->where(['course_type_id'])->one();
            $item = CourseInCity::findOne([
                'course_id' => $this->course_id,
                'city_id' => $id,
            ]);
            $item->delete();
        }
        foreach ($toAdd as $id) {
            $item = new CourseInCity();
            $item->city_id = $id;
            $item->course_id = $this->course_id;
            $item->save();
        }

        //региональному админу всегда доступны курсы с его городом
        $identity = \Yii::$app->user->identity;
        if (!is_null($identity) && isset($identity->city_id) && !is_null($identity->city_id) && is_numeric($identity->city_id)) {
            if ($identity->role === 'regional_admin') {
                $item = CourseInCity::findOne([
                    'course_id' => $this->course_id,
                    'city_id' => $identity->city_id,
                ]);
                if (!$item) {
                    $item = new CourseInCity();
                    $item->city_id = $identity->city_id;
                    $item->course_id = $this->course_id;
                    $item->save();
                }
            }
        }
        //

    }

    public function getCitiesList()
    {
        //return City::getCitiesList();
        return City::getCitiesForCurrentUser();
    }

    public function getProductName()
    {

        $product = Product::findOne($this->product_id);
        return $product->name;

    }

    /*
    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    public function getCourseInCities()
    {
        return $this->hasMany(CourseInCity::className(), ['course_id' => 'course_id']);
    }
    */

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}
