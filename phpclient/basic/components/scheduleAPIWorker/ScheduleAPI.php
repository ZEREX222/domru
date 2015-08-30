<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 21.08.2015
 * Time: 14:57
 */

namespace app\components\scheduleAPIWorker;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\components\scheduleAPIWorker\JsonApiHttpManager;


class ScheduleAPI extends Component {

    private $urlApi;
    private $jsonHttpManager;

    public function init()
    {
        parent::init();
    }

    function __construct($params = null) {

        $this->jsonHttpManager = new JsonApiHttpManager();

        if($this->checkURL($params['urlApi'])) //Проверяем, доступен ли API
        {
            $this->urlApi = $params['urlApi'];
        }else{
            throw new Exception('API не отвечает!');
        }

        parent::__construct();

    }

    /**
     * Проверить URL API
     * @param $url
     * @return bool
     */
    private function checkURL($url)
    {
        if($this->jsonHttpManager->available($url))
            return true;
        else
            return false;
    }

    /**
     * Создает ссылку для запроса, обрабатывая параметры
     * @param $method
     * @param $params
     * @return string
     */
    private function makeUrlRequest($method,$params)
    {
        $returnUrl = $this->urlApi."/".$method;
        if($params != null && count($params) > 0)
        {
            $returnUrl .= "?";
            foreach ($params as $key => $value)
            {
                $returnUrl .= $key."=".$value."&";

            }

            $returnUrl = substr($returnUrl , 0, -1);
        }

        return $returnUrl;
    }

    /**
     * Возвращает массив для построения программы
     * @param $params
     * @return mixed
     */
    public function getScheduleArray($params = null)
    {
        return $this->jsonHttpManager->getJsonArray($this->makeUrlRequest("schedule", $params));

    }

}