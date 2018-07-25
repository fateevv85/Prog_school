<?php

namespace app\controllers;

use app\components\LessonsExtraFields;
use app\models\Lesson;
use yii\data\ActiveDataProvider;


/**
 * CourseController implements the CRUD actions for Course model.
 */
class ReportController extends MyAppController
{
    public function actionIndex()
    {

        if ($get = \Yii::$app->request->get(1)) {
            $listType = $get['list_type'];
            $lessonType = ($get['lesson_type'] == 'paid') ? '' : 'trial_';
            $lessonId = $get['lesson_id'];

            $query = LessonsExtraFields::find()
                ->select(
                    [
//                        "{$lessonType}lesson_id as id",
                        "{$lessonType}lesson.group_id",
                        'group.title as group_title',
                        'date_start',
                        'time_start',
                        'students.last_name as student_ln',
                        'students.first_name as student_fn',
                        'students.lead_id as lead_id',
                        'students.p_last_name as p_last_name',
                        'students.p_first_name as p_first_name',
                        'students.p_mid_name as p_mid_name',
                        'students.budget as budget',
                        'students.notebook as notebook',
                        'students.email as email',

                    ])
                ->leftJoin('group', "`group`.group_id = {$lessonType}lesson.group_id")
                ->leftJoin('students', "students.group_id = {$lessonType}lesson.group_id")
                ->where("{$lessonType}lesson_id = {$lessonId}");
//                ->all();

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
//            $query->all();
        }

        return $this->render('index', [
            'query' => $query,
            'dataProvider' => $dataProvider,
            'listType' => $listType
        ]);
    }

}
