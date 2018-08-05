<?php

namespace app\controllers;
use Yii;
use app\models\tables\Students;
//use app\models\Group;

/**
 * CourseController implements the CRUD actions for Course model.
 */
//use yii\rest\ActiveController;

class RstudentsController extends MyActiveController
{
    public $modelClass = 'app\models\tables\Students';

    public function prepareDataProvider()
    {
        if ($controlS = Yii::$app->request->get('deleteControlSum')) {
            Students::deleteAll(['control_sum' => $controlS]);

            return 'Delete is complete ' . $controlS;
        }

        return parent::prepareDataProvider();
    }
}
