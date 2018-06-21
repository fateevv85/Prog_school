<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;

/**
 * CourseController implements the CRUD actions for Course model.
 */
//use yii\rest\ActiveController;

class RuserController extends MyActiveController
{
    public $modelClass = 'app\models\User';
    
    public function actions()
    {
        $actions = parent::actions();


        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }
    public function prepareDataProvider()
    {
        $query = $this->modelClass::find();
        //у авторизованных пользователей показываем данные только по их городу
        $query = \app\custom\CustomSearch::filterByUserCity($query);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
}
