<?php

namespace app\controllers;

use Yii;
use app\models\Group;
use app\models\GroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LectureHall;
use app\models\Teacher;

use app\custom\GoogleCalendarHelper;

use yii\httpclient\Client;
use yii\helpers\Url;

class MyAppController extends Controller
{
  
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
               // 'only' => ['*'],
                'rules' => [
                    [
                       // 'actions' => ['*'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        $request = Yii::$app->request;
        Yii::info( '---START---', 'my_request');
        Yii::info( ' userIP', 'my_request');
        Yii::info( $request->userIP, 'my_request' );
        Yii::info( 'beforeAction userHost', 'my_request');
        Yii::info( $request->userHost, 'my_request' );
        Yii::info( 'beforeAction absoluteUrl', 'my_request');
        Yii::info( $request->absoluteUrl, 'my_request' );
        Yii::info( 'beforeAction get', 'my_request');
        Yii::info( $request->get(), 'my_request' );
        Yii::info( 'beforeAction bodyParams', 'my_request');
        Yii::info( $request->bodyParams, 'my_request' );
        return parent::beforeAction($action);
    }
    
    /*public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/
    
    /*
    public function updateLessonTypeEntity($entityId, $entityType) {
        $model = $this->findModel($entityId);
        $old = self::getModelData($model);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $new = self::getModelData($model);
            $data = array(
                'id' => $entityId,
                'course-title' => $model->getCourseName(),
                'entity' => $entityType,
                'old' => $old,
                'new' => $new
            );

            $changes = self::getChangesArray($old, $new);
            if (!is_null($changes)) {
                $data['changes'] = $changes;
            }
            
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl('https://dev.introvert.bz/codabra/register-to-event-ts/dist/updater/index.php')
                ->setData($data)
                ->send();
 
            
            $params = self::getLessonEntityParams($model);
            $params['oldCalendarName'] = $old['google_calendar_name'];
            $params['eventId'] = $model->calendar_event_id;
            //какой-то баг. кеш чтоли. приходится обновлять параметр в ручную
            $params['place'] = LectureHall::getAddress(LectureHall::findOne($model->attributes['lecture_hall_id']));
            $params['guests'] = Teacher::findOne($model->attributes['teacher_id'])->email;
            //$params['eventId'] =  $model->calendar_event_id;

            $result = GoogleCalendarHelper::callConsoleMethod('updateEvent', $params);
            if ( isset($result['createResult']) && isset($result['createResult']['eventId']) && !empty($result['createResult']['eventId']) ) {
                $model->calendar_event_id = $result['createResult']['eventId'];
                $model->save();
            }

            
            //$result = GoogleCalendarHelper::callConsoleMethod('updateEventById', $params);
            return $this->redirect([$entityType . '/index']);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
        
    }
    public static function getModelData($model) {
        $data = array();
        $data['date_start'] = $model->date_start;
        $data['time_start'] = $model->time_start;
        $data['lecture_hall_id'] = $model->lecture_hall_id;
        $data['teacher_email'] = $model->getTeacherEmail();
        $data['lecture_hall_address'] = $model->getLectureHallAddress();
        $data['google_calendar_name'] = self::getLessonCalendarName($model);
        //$data['teacher_id'] = $model->teacher_id;
        //$data['course_id'] = $model->course_id;
        //$data['group_id'] = $model->group_id;
        return $data;
    }
    public static function getChangesArray($old, $new) {
        if (!is_array($old) || !is_array($new)) {
            return null;
        }
        $changes = array();
        foreach($old as $key=>$value) {
            if ( $old[$key] !=  $new[$key]) {
                $changes[$key] = true;
            } else {
                $changes[$key] = false;
            }
        }
        return $changes;
    }
    public static function getLessonCalendarName($model) { 
        if ($model->attributes['lecture_hall_id']) {
            $lectureHall = LectureHall::findOne($model->attributes['lecture_hall_id']);
            if ( is_string($lectureHall->title) && count($lectureHall->title) > 0 ) {
                return $lectureHall->title;
            }
        }
        return null;
    }
    public static function getLessonEntityParams($model) { 
        date_default_timezone_set('Europe/Moscow');
        $params = array();
        
        $params['calendarName'] = self::getLessonCalendarName($model);
        
        $params['title'] = $model->getCourseName() . ' ' . $model->getGroupName();
        
        $startDateTime = new \DateTime($model->date_start . ' ' . $model->time_start);
        $params['srartDateTime'] = $startDateTime->format('U') * 1000;
        if (!empty($model->duration)) {
            $interval = 'PT' . $model->duration . 'M';
        } else {
            $interval = 'PT1H';
        }
        $interval = new \DateInterval($interval);
        $params['endDateTime'] = $startDateTime->add($interval)->format('U') * 1000;
        
        $params['place'] = $model->getLectureHallAddress();
        $guests = array();
        
        $teacherEmail = $model->getTeacherEmail();
        if (!empty($teacherEmail)) {
            $guests[] = $teacherEmail;
        }
        $params['guests'] = implode(',', $guests);
        
        return $params;
    }
    */
}
