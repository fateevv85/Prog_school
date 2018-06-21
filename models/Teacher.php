<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property integer $teacher_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $resume
 * @property string $photo
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'last_name'], 'required'],
            [['first_name', 'middle_name', 'last_name', 'resume', 'photo'], 'string'],
            ['email', 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'resume' => Yii::t('app', 'Resume'),
            'photo' => Yii::t('app', 'Photo'),
            'email' => Yii::t('app', 'E-mail'),
            'city_id' => Yii::t('app', 'Select City'),
        ];
    }
    public static function getNames()
    {
        $teachers = self::getTeachersForCurrentUser();
        $names = array();
        foreach($teachers as $key => $teacher) {
            $names[$teacher['teacher_id']]  = self::getName($teacher);
        }
        return $names;
        /*$teachers = self::find()
            ->all();
        $names = array();
        foreach($teachers as $key => $teacher) {
            $names[$teacher['teacher_id']]  = self::getName($teacher);
        }
        return $names;
        */
    }
    public static function getAllTeachers()
    {
        
        $teachers = self::find()
            ->all();
        return $teachers;
    }
    public static function getTeachersForCurrentUser()
    {
        $identity = Yii::$app->user->identity;
        if ( is_null($identity) ) {
            return self::getAllTeachers();
        }
        return self::getTeachersByIdentity($identity);
    }
    public static function getTeachersByIdentity($identity)
    {
        if ( $identity->role === 'main_admin' ) {
            return self::getAllTeachers();
        } else if ($identity->role === 'regional_admin') {
            if ( is_numeric($identity->city_id) ) {
                $teachers = self::find()->where(['city_id' => $identity->city_id])->all();
                return $teachers;
            }
        } else {
            return array();
        }
    }
    public static function getName($teacher)
    {
        return $teacher ? ($teacher->last_name . ' ' . $teacher->first_name . ' ' . $teacher->middle_name) : '';
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
    
    /*public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && Yii::$app->user->city_id) {
                //автоматом ставим тот же город что и у создающего  пользователя
                $this->city_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }*/
}
/*class CommentQuery extends ActiveQuery
{
    public function names($state = true)
    {
        $teachers = $this->find()
            ->all();
        $names = array();
        foreach($teachers as $key => $teacher) {
            $names[$teacher['teacher_id']]  = $teacher->first_name . ' ' .  $teacher->middle_name . ' ' . $teacher->last_name;
        }
        return $names;
        //return $this->andWhere(['active' => $state]);
    }
}
*/