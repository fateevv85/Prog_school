<?php

namespace app\controllers;
use Yii;
use app\models\Group;
/**
 * CourseController implements the CRUD actions for Course model.
 */
//use yii\rest\ActiveController;

class RgroupController extends MyActiveController
{
    public $modelClass = 'app\models\Group';
    
   /* public function actions()
    {
        $actions = parent::actions();
        $actions['decpnum'] = [$this, 'decpnum'];
        return $actions;
    }*/
    
    public function actionDecpnum()
    {
        $request = Yii::$app->request;
        $groupTitle = $request->post('groupTitle');
        $group = Group::find()->where(['title' => $groupTitle])->one();
        if ( isset($group->participants_num) && $group->participants_num > 0) {
            $group->participants_num = $group->participants_num - 1;
        }
        if ( !$group->save() ) {
            throw new \Exception('Ошибка валидации');
        }
        return 200; 
    }
}
