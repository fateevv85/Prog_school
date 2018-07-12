<?php

namespace app\controllers;

use Yii;

/**
 * CourseController implements the CRUD actions for Course model.
 */

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\data\ActiveDataProvider;

class MyActiveController extends ActiveController
{

    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
            //'http://test1.example.com',
            //'http://test2.example.com',
        ];
    }

    public function behaviors()
    {

        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                ],
            ],
            'authenticator' => [
                'class' => QueryParamAuth::className(),
            ]

        ]);
    }

    public function beforeAction($action)
    {
        Yii::info('beforeAction get');
        Yii::info(Yii::$app->request->get(), 'my_request');
        Yii::info('beforeAction post');
        Yii::info(Yii::$app->request->post(), 'my_request');
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        date_default_timezone_set('Europe/Moscow');
        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
}
