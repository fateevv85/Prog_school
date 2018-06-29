<?php

namespace app\controllers;


/**
 * CourseController implements the CRUD actions for Course model.
 */
//use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class RlessonTypeController extends MyActiveController
{

    public function actions()
    {
        $actions = parent::actions();


        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        date_default_timezone_set('Europe/Moscow');
        $nowDate = date('Y-m-d');
        $nowTime = date('H:i:s');
        $modelClass = $this->modelClass;
        //return Lesson::find()->all();
        $query = $modelClass::find()->
            where(['=', 'date_start', $nowDate])->
            andWhere(['>=', 'time_start', $nowTime])->
            orWhere(['>=', 'date_start', $nowDate]);
        //у авторизованных пользователей показываем данные только по их городу
        $query = \app\custom\CustomSearch::filterByUserCity($query);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
   
}
