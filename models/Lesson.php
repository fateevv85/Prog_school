<?php

namespace app\models;

use Yii;

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
class Lesson extends LessonTypeModel
{

    public $cnt;
    public $few_lesson_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['cost'], 'number'],
            [['group_id', 'lecture_hall_id', 'course_id', 'teacher_id', 'duration', 'city_id', 'capacity', 'start'], 'integer'],
            [['date_start'], 'date', 'format' => 'php:Y-m-d'],
            [['time_start', 'calendar_event_id'], 'safe'],
            [['lead_link'], 'string'],
            [['capacity'], 'required']
            //[['date_start', 'time_start'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => Yii::t('app', 'Lesson ID'),
            //'cost' => Yii::t('app', 'Cost'),
            'group_id' => Yii::t('app', 'Select Group'),
//            'lesson_id' => Yii::t('app', 'Lesson'),
            'lecture_hall_id' => Yii::t('app', 'Select Lecture Hall'),
            'course_id' => Yii::t('app', 'Select Course'),
            'teacher_id' => Yii::t('app', 'Select Teacher'),
            'date_start' => Yii::t('app', 'Date Start'),
            'time_start' => Yii::t('app', 'Time Start'),
            'duration' => Yii::t('app', 'Duration'),
            'lead_link' => Yii::t('app', 'Lead Link'),
            'cost' => Yii::t('app', 'Cost'),
            'city_id' => Yii::t('app', 'City ID'),
            'capacity' => Yii::t('app', 'Capacity'),
            'start' => Yii::t('app', 'Start'),
        ];
    }

    public function getCRMLeadsLink()
    {
        $studentGroupTitle = $this->getGroupName();
        // return "https://codabra.amocrm.ru/leads/list/?filter%5Bcf%5D%5B216568%5D=$studentGroupTitle";
        return "https://codabra.amocrm.ru/leads/list/?filter%5Bpipe%5D%5B592459%5D%5B%5D=142&filter%5Bpipe%5D%5B592459%5D%5B%5D=143&filter%5Bpipe%5D%5B592459%5D%5B%5D=14809111&filter%5Bpipe%5D%5B592459%5D%5B%5D=14809117&filter%5Bpipe%5D%5B592459%5D%5B%5D=15287200&filter%5Bpipe%5D%5B592459%5D%5B%5D=15289606&filter%5Bpipe%5D%5B592459%5D%5B%5D=16332649&filter%5Bpipe%5D%5B592459%5D%5B%5D=16356130&filter%5Bpipe%5D%5B592459%5D%5B%5D=16356133&filter%5Bpipe%5D%5B592459%5D%5B%5D=16356139&filter%5Bpipe%5D%5B592459%5D%5B%5D=18720111&filter%5Bpipe%5D%5B826213%5D%5B%5D=142&filter%5Bpipe%5D%5B826213%5D%5B%5D=143&filter%5Bpipe%5D%5B826213%5D%5B%5D=16953022&filter%5Bpipe%5D%5B826213%5D%5B%5D=16953025&filter%5Bpipe%5D%5B826213%5D%5B%5D=16953112&filter%5Bpipe%5D%5B826213%5D%5B%5D=16953190&filter%5Bpipe%5D%5B826213%5D%5B%5D=16953193&filter%5Bpipe%5D%5B826213%5D%5B%5D=16953196&filter%5Bpipe%5D%5B826213%5D%5B%5D=18125595&filter%5Bpipe%5D%5B826213%5D%5B%5D=18207111&filter%5Bpipe%5D%5B826213%5D%5B%5D=18545091&filter%5Bpipe%5D%5B826213%5D%5B%5D=18545097&filter%5Bpipe%5D%5B798337%5D%5B%5D=142&filter%5Bpipe%5D%5B798337%5D%5B%5D=143&filter%5Bpipe%5D%5B798337%5D%5B%5D=16608061&filter%5Bpipe%5D%5B798337%5D%5B%5D=16609885&filter%5Bpipe%5D%5B798337%5D%5B%5D=16948150&filter%5Bpipe%5D%5B798337%5D%5B%5D=19651740&filter%5Bpipe%5D%5B1239987%5D%5B%5D=142&filter%5Bpipe%5D%5B1239987%5D%5B%5D=143&filter%5Bpipe%5D%5B1239987%5D%5B%5D=20623464&filter%5Bpipe%5D%5B1239987%5D%5B%5D=20623467&filter%5Bpipe%5D%5B1239987%5D%5B%5D=20623470&filter%5Bpipe%5D%5B1239987%5D%5B%5D=20623473&filter%5Bpipe%5D%5B1239987%5D%5B%5D=20623476&filter%5Bpipe%5D%5B804619%5D%5B%5D=142&filter%5Bpipe%5D%5B804619%5D%5B%5D=143&filter%5Bpipe%5D%5B804619%5D%5B%5D=16663525&filter%5Bpipe%5D%5B804619%5D%5B%5D=16663528&filter%5Bpipe%5D%5B804619%5D%5B%5D=16663531&filter%5Bpipe%5D%5B804619%5D%5B%5D=16833331&filter%5Bpipe%5D%5B912136%5D%5B%5D=142&filter%5Bpipe%5D%5B912136%5D%5B%5D=143&filter%5Bpipe%5D%5B912136%5D%5B%5D=17726773&filter%5Bpipe%5D%5B912136%5D%5B%5D=17726776&filter%5Bpipe%5D%5B912136%5D%5B%5D=17726779&filter%5Bpipe%5D%5B912136%5D%5B%5D=17726794&filter%5Bpipe%5D%5B912136%5D%5B%5D=17726797&filter%5Bpipe%5D%5B912136%5D%5B%5D=17733709&filter%5Bpipe%5D%5B786508%5D%5B%5D=142&filter%5Bpipe%5D%5B786508%5D%5B%5D=143&filter%5Bpipe%5D%5B786508%5D%5B%5D=16504072&filter%5Bpipe%5D%5B786508%5D%5B%5D=16504075&filter%5Bpipe%5D%5B786508%5D%5B%5D=16504078&filter%5Bpipe%5D%5B818353%5D%5B%5D=142&filter%5Bpipe%5D%5B818353%5D%5B%5D=143&filter%5Bpipe%5D%5B818353%5D%5B%5D=16833436&filter%5Bpipe%5D%5B786568%5D%5B%5D=142&filter%5Bpipe%5D%5B786568%5D%5B%5D=143&filter%5Bpipe%5D%5B786568%5D%5B%5D=16504462&filter%5Bpipe%5D%5B786568%5D%5B%5D=16504465&filter%5Bpipe%5D%5B786568%5D%5B%5D=16504468&filter%5Bpipe%5D%5B655627%5D%5B%5D=142&filter%5Bpipe%5D%5B655627%5D%5B%5D=143&filter%5Bpipe%5D%5B655627%5D%5B%5D=15356545&filter%5Bpipe%5D%5B655627%5D%5B%5D=15356548&filter%5Bpipe%5D%5B655627%5D%5B%5D=15356551&filter%5Bpipe%5D%5B655627%5D%5B%5D=17717257&filter%5Bpipe%5D%5B655627%5D%5B%5D=17717260&filter%5Bpipe%5D%5B655627%5D%5B%5D=17717263&filter%5Bpipe%5D%5B655627%5D%5B%5D=18572217&filter%5Bpipe%5D%5B831186%5D%5B%5D=142&filter%5Bpipe%5D%5B831186%5D%5B%5D=143&filter%5Bpipe%5D%5B831186%5D%5B%5D=16997166&filter%5Bpipe%5D%5B831186%5D%5B%5D=16997169&filter%5Bpipe%5D%5B831186%5D%5B%5D=16997172&filter%5Bpipe%5D%5B831186%5D%5B%5D=16997190&filter%5Bpipe%5D%5B874927%5D%5B%5D=142&filter%5Bpipe%5D%5B874927%5D%5B%5D=143&filter%5Bpipe%5D%5B874927%5D%5B%5D=17413699&filter%5Bpipe%5D%5B874927%5D%5B%5D=17413702&filter%5Bpipe%5D%5B874927%5D%5B%5D=17413705&filter%5Bpipe%5D%5B874927%5D%5B%5D=17424856&filter%5Bpipe%5D%5B874927%5D%5B%5D=17424859&filter%5Bpipe%5D%5B874927%5D%5B%5D=17424862&filter%5Bpipe%5D%5B874927%5D%5B%5D=17424865&filter%5Bpipe%5D%5B997494%5D%5B%5D=142&filter%5Bpipe%5D%5B997494%5D%5B%5D=143&filter%5Bpipe%5D%5B997494%5D%5B%5D=18478746&filter%5Bpipe%5D%5B997494%5D%5B%5D=18478749&filter%5Bpipe%5D%5B997494%5D%5B%5D=18478752&filter%5Bpipe%5D%5B1005492%5D%5B%5D=142&filter%5Bpipe%5D%5B1005492%5D%5B%5D=143&filter%5Bpipe%5D%5B1005492%5D%5B%5D=18542856&filter%5Bpipe%5D%5B1005492%5D%5B%5D=18542859&filter%5Bpipe%5D%5B1005492%5D%5B%5D=18542862&filter%5Bpipe%5D%5B1005492%5D%5B%5D=19152009&filter%5Bpipe%5D%5B1110036%5D%5B%5D=142&filter%5Bpipe%5D%5B1110036%5D%5B%5D=143&filter%5Bpipe%5D%5B1110036%5D%5B%5D=19429188&filter%5Bpipe%5D%5B1110036%5D%5B%5D=19429191&filter%5Bpipe%5D%5B1110036%5D%5B%5D=19429194&filter%5Bpipe%5D%5B1110036%5D%5B%5D=19455462&filter%5Bpipe%5D%5B1134408%5D%5B%5D=142&filter%5Bpipe%5D%5B1134408%5D%5B%5D=143&filter%5Bpipe%5D%5B1134408%5D%5B%5D=19643877&filter%5Bpipe%5D%5B1134408%5D%5B%5D=19643880&filter%5Bpipe%5D%5B1134408%5D%5B%5D=19643883&filter%5Bpipe%5D%5B1162677%5D%5B%5D=142&filter%5Bpipe%5D%5B1162677%5D%5B%5D=143&filter%5Bpipe%5D%5B1162677%5D%5B%5D=19885704&filter%5Bpipe%5D%5B1162677%5D%5B%5D=19885707&filter%5Bpipe%5D%5B1162677%5D%5B%5D=19885710&filter%5Bcf%5D%5B216568%5D=$studentGroupTitle&filter%5Btags_logic%5D=or&useFilter=y";
    }

    public function getCourseCost()
    {
        $course = $this->course;
        return $course ? $course->cost : '';
    }

    public function fields()
    {
        return [
            'lesson_id',
            'date_start',
            'time_start',
            'group_id',
            'lecture_hall_id',
            'course_id',
            'teacher_id',
            'duration',
            'lead_link',
            'calendar_event_id',
            'capacity',
            'start'
        ];
    }

    public function extraFields()
    {
        return [
            'group',
            'lectureHall',
            'course',
            'teacher'
        ];
    }
}
