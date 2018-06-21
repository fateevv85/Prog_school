<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course_in_city".
 *
 * @property string $course_in_city_id
 * @property integer $course_id
 * @property string $city_id
 *
 * @property Course $course
 * @property City $city
 */
class CourseInCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_in_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'city_id'], 'integer'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_in_city_id' => Yii::t('app', 'Course In City ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    /**
     * @inheritdoc
     * @return CourseInCityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseInCityQuery(get_called_class());
    }
}
