<?php

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;
use app\models\Lesson;
use app\models\Teacher;
use app\models\LectureHall;
use app\models\Group;
use app\models\Course;
use app\models\LessonTypeModel;

/**
 * This is the model class for table "trial_lesson".
 *
 * @property integer $trial_lesson_id
 * @property integer $group_id
 * @property integer $lesson_id
 * @property integer $lecture_hall_id
 * @property integer $course_id
 * @property integer $teacher_id
 * @property string $date_start
 * @property string $time_start
 * @property string $num_trial
 * @property string $lead_link
 */
class TrialLesson extends LessonTypeModel
{

    public $cnt;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trial_lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'/*, 'lesson_id'*/, 'lecture_hall_id', 'course_id', 'teacher_id', 'duration', 'city_id'], 'integer'],
            // [['date_start', 'time_start'], 'safe'],
            [['date_start', 'course_date_start'], 'date', 'format' => 'php:Y-m-d'],
            //[['course_date_start'], 'date', 'format' => 'php:Y-m-d'],
            //[['time_start'], 'time', 'format' => 'php:H:i'],
            [['time_start', 'calendar_event_id'], 'safe'],
            [['num_trial', 'lead_link'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trial_lesson_id' => Yii::t('app', 'Trial Lesson ID'),
            'group_id' => Yii::t('app', 'Select Group'),
            //'lesson_id' => Yii::t('app', 'Lesson'),
            'lecture_hall_id' => Yii::t('app', 'Select Lecture Hall'),
            'course_id' => Yii::t('app', 'Select Course'),
            'teacher_id' => Yii::t('app', 'Select Teacher'),
            'date_start' => Yii::t('app', 'Date Start'),
            'time_start' => Yii::t('app', 'Time Start'),
            'num_trial' => Yii::t('app', 'Num Trial'),
            'lead_link' => Yii::t('app', 'Lead Link'),
            'duration' => Yii::t('app', 'Duration'),
            'course_date_start' => Yii::t('app', 'Course Date Start'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    public function getCRMLeadsLink()
    {
        $studentGroupTitle = $this->getGroupName();
        return "https://codabra.amocrm.ru/leads/list/?filter%5Bcf%5D%5B216570%5D=$studentGroupTitle";
    }
    //Курсы
    /* public static function getCoursesList()
     {
         $courses = Course::find()
             ->all();

         return ArrayHelper::map($courses, 'course_id', 'title');
     }
     public static function getCoursesDescList()
     {
         $courses = Course::find()
             ->all();

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
         $teachers = Teacher::find()
             ->all();
         $teachersName = array();
         foreach($teachers as $key => $teacher) {
             $teachersName[$teacher['teacher_id']]  = $teacher->first_name . ' ' .  $teacher->middle_name . ' ' . $teacher->last_name;
         }
         return $teachersName;
         //return ArrayHelper::map($teachers, 'teacher_id', 'name');

     }
      public function getTeacher()
     {
         return $this->hasOne(Teacher::className(), ['teacher_id' => 'teacher_id']);
     }

     public function getTeacherName()
     {
         $teacher = $this->teacher;
         return $teacher ? ($teacher->first_name . ' ' .  $teacher->middle_name . ' ' . $teacher->last_name) : '';
         //return $teacher ? ($teacher->name) : '';
     }

     //Аудитории
     public static function getLectureHallsList()
     {
         return LectureHall::getAddresses();
         //return ArrayHelper::map($teachers, 'teacher_id', 'name');

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
         //return $teacher ? ($teacher->name) : '';
     }
     public function getLectureHallCity()
     {
         $lectureHall = $this->lectureHall;
         return $lectureHall ? $lectureHall->city : '';
         //return $teacher ? ($teacher->name) : '';
     }
     public function getLectureHallPlace()
     {
         $lectureHall = $this->lectureHall;
         return $lectureHall ? LectureHall::getPlace($lectureHall) : '';
         //return $teacher ? ($teacher->name) : '';
     }
     public function getLessonStart()
     {
         $lesson = $this->lesson;
         return $lesson ? $lesson->date_start : '';
         //return $teacher ? ($teacher->name) : '';
     }
     //Группы
     public static function getGroupsList()
     {
         $groups = Group::find()
             ->all();
        return ArrayHelper::map($groups, 'group_id', 'title');
         //return ArrayHelper::map($teachers, 'teacher_id', 'name');

     }
      public function getGroup()
     {
         return $this->hasOne(Group::className(), ['group_id' => 'group_id']);
     }

     public function getGroupName()
     {
         $group = $this->group;
         return $group ? $group->title : '';
         //return $teacher ? ($teacher->name) : '';
     }
     public function getParticipantsNum()
     {
         $group = $this->group;
         return $group ? $group->participants_num : '';
         //return $teacher ? ($teacher->name) : '';
     }
     public function getParticipantsNumMax()
     {
         $group = $this->group;
         return $group ? $group->participants_num_max : '';
         //return $teacher ? ($teacher->name) : '';
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

     //

     public function getDateStart()
     {
         if ($this->date_start) {
             $date = date('d.m.Y',strtotime($this->date_start));
         } else {
             $date = null;
         }


         return $date ? $date : '';
     }


     */
    public function getCourseDateStart()
    {
        if ($this->course_date_start) {
            $date = date('d.m.Y', strtotime($this->course_date_start));
        } else {
            $date = null;
        }


        return $date ? $date : '';
    }

    public function fields()
    {
        return ['trial_lesson_id', 'course_date_start', 'date_start', 'time_start', 'num_trial', 'group_id'/*, 'lesson_id'*/, 'lecture_hall_id', 'course_id', 'teacher_id', 'lead_link', 'calendar_event_id', 'duration'];
    }

    public function extraFields()
    {
        return ['group', 'lectureHall', 'course', 'teacher', 'lesson'];
    }
}
