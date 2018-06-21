<?php

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;
use app\models\Lesson;
use app\models\Teacher;
use app\models\LectureHall;
use app\models\Group;
use app\models\Course;
/**
 * This is the model class for table "lesson".
 *
 * @property integer $lesson_id
 * @property string $cost
 * @property integer $group_id
 * @property integer $lecture_hall_id
 * @property integer $course_id
 * @property integer $teacher_id
 * @property string $date_start
 * @property string $time_start
 */
class LessonTypeModel extends \yii\db\ActiveRecord
{
   
  
  
    //Курсы
    public static function getCoursesList()
    {
        /*$courses = Course::find()
            ->all();*/
        $courses = Course::getCoursesForCurrentUser();
        return ArrayHelper::map($courses, 'course_id', 'title');
    }
    public static function getCoursesDescList()
    {
        /*$courses = Course::find()
            ->all();*/
        $courses = Course::getCoursesForCurrentUser();
        return ArrayHelper::map($courses, 'course_id', 'description');
    }
     public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }
     
    public function getCourseName()
    {
        $course = $this->course;
     
        return $course ? $course->title : '';
    }
    public function getCourseDescription()
    {
        $course = $this->course;
     
        return $course ? $course->description : '';
    }
    //Преподы
    public static function getTeachersList()
    {
        return Teacher::getNames();
    }
     public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['teacher_id' => 'teacher_id']);
    }
     
    public function getTeacherName()
    {
        $teacher = $this->teacher;
        return Teacher::getName($teacher);
    }
    public function getTeacherEmail()
    {
        $teacher = $this->teacher;
        return $teacher ? $teacher->email : '';
    }
    public function getCourseCost()
    {
        $course = $this->course;
        return $course ? $course->cost : '';
    }
    
    //Аудитории
    public static function getLectureHallsList()
    {
        //return LectureHall::getAddresses();
        return LectureHall::getHallsForCurrentUser();  
    }
    public static function getLectureHallsPlaceList()
    {
        return LectureHall::getPlaces();
    }
     public function getLectureHall()
    {
        return $this->hasOne(LectureHall::className(), ['lecture_hall_id' => 'lecture_hall_id']);
    }
     public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['lesson_id' => 'lesson_id']);
    }
     
    public function getLectureHallAddress()
    {
        $lectureHall = $this->lectureHall;
        return $lectureHall ? LectureHall::getAddress($lectureHall) : '';
    }
    public function getLectureHallCity()
    {
        $lectureHall = $this->lectureHall;
        return $lectureHall ? $lectureHall->city : '';
    }
    public function getLectureHallPlace()
    {
        $lectureHall = $this->lectureHall;
        return $lectureHall ? LectureHall::getPlace($lectureHall) : '';
    }
    public function getLessonStart()
    {
        $lesson = $this->lesson;
        return $lesson ? $lesson->date_start : '';
    }
    //Группы
    public static function getGroupsList()
    {
        /*$groups = Group::find()
            ->all();
       return ArrayHelper::map($groups, 'group_id', 'title');*/
       $groups = Group::getGroupsForCurrentUser();
       //$groups = ArrayHelper::multisort($groups, ['title'], [SORT_ASC]);
       $groups = ArrayHelper::map($groups, 'group_id', 'title');
       return $groups;
    }
     public function getGroup()
    {
        return $this->hasOne(Group::className(), ['group_id' => 'group_id']);
    }
     public function getGroupParticipantsNum()
    {
        $group = $this->group;
        return $group ? $group->participants_num : null;
    }
    public function getGroupName()
    {
        $group = $this->group;
        return $group ? $group->title : '';
    }
    public function getParticipantsNum()
    {
        $group = $this->group;
        return $group ? $group->participants_num : '';
    }
    public function getParticipantsNumMax()
    {
        $group = $this->group;
        return $group ? $group->participants_num_max : '';
    }
    public static function getParticipantsNumsList()
    {
        $groups = Group::find()
            ->all();
       return ArrayHelper::map($groups, 'group_id', 'participants_num');
    }
    public static function getParticipantsNumsMaxList()
    {
        $groups = Group::find()
            ->all();
       return ArrayHelper::map($groups, 'group_id', 'participants_num_max');
    }
     
    public function getDateStart()
    {
        if ($this->date_start) {
            $date = date('d.m.Y',strtotime($this->date_start));
        } else {
            $date = null;
        }
       

        return $date ? $date : '';
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

}
