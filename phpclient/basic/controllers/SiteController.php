<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Schedule;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [

        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $api = Yii::$app->scheduleAPI;
        $date = date("Y-m-d");

        $getDate = Yii::$app->request->get('date');
        if($getDate != "")
        {
            $scheduleData = $api->getScheduleArray(array("date" => $getDate)); //Получаем данные для построения программы
            $date = $getDate;
        }else{
            $scheduleData = $api->getScheduleArray(array("date" => $date));
        }

        $model = new Schedule();
        $model->setData($scheduleData);
        $model->setDateBuild($date);

        return $this->render('index', [
            'model' => $model,
        ]);
    }




}
