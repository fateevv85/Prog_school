<?php

namespace app\models\tables;

use app\models\City;
use app\models\Course;
use app\models\Group;
use app\models\Lesson;
use app\models\TrialLesson;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
    /*public $lesson_id;
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
    }*/

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
        return static::find()->where(['id' => $id])->one()->getAttribute('name');
    }

    //Группы
    public static function getItemListByProduct($id, $item, $lessonType = null)
    {
        $modelType = ($lessonType) ? TrialLesson::className() : Lesson::className();

        $query = $modelType::find()
            ->select([
                'group.title as group_title',
                'group.group_id',
                'lecture_hall.place_description',
                "{$lessonType}lesson.lecture_hall_id",
                'course.course_id as course_id',
                'course.title as course_title',
                'teacher.teacher_id',
                "concat(teacher.last_name, ' ', teacher.first_name, ' ', teacher.middle_name) as FIO"
            ])
            ->leftJoin('course', "course.course_id = {$lessonType}lesson.course_id")
            ->leftJoin('group', "group.group_id = {$lessonType}lesson.group_id")
            ->leftJoin('lecture_hall', "lecture_hall.lecture_hall_id = {$lessonType}lesson.lecture_hall_id")
            ->leftJoin('teacher', "teacher.teacher_id = {$lessonType}lesson.teacher_id")
            ->where(['and',
                ['product_id' => $id],
                ["{$lessonType}lesson.city_id" => array_keys(City::getCitiesForCurrentUser())]
            ])
            ->andWhere(['>', 'date_start', new Expression('DATE(NOW())')])
            ->orderBy('group.title')
            ->asArray()
            ->all();

        if ($item == 'group') {
            return ArrayHelper::map($query, 'group_id', 'group_title');
        } elseif ($item == 'lecture_hall') {
            return ArrayHelper::map($query, "lecture_hall_id", 'place_description');
        } elseif ($item == 'course') {
            return ArrayHelper::map($query, "course_id", 'course_title');
        } elseif ($item == 'teacher') {
            return ArrayHelper::map($query, "teacher_id", 'FIO');
        }

    }

    public static function getProductsForCity($id)
    {
        return ArrayHelper::map(static::find()
            ->select([
                'id',
                'name'
            ])
            ->where(['city_id' => $id])
            ->asArray()
            ->all(), 'id', 'name');
    }

    public static function getProductsForCourseAndCity($courseId, $cityId)
    {
        $a = static::find()
            ->select('product.name')
            ->leftJoin('course_in_city', 'course_in_city.product_id = product.id')
            ->where(['course_id' => $courseId])
            ->andWhere(['in', 'product.city_id', $cityId])
            ->asArray()
            ->all();
        $a = ArrayHelper::getColumn($a, 'name');
        $b = implode(', ', $a);
        return $b;
    }
}
