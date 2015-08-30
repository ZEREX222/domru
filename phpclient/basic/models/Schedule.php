<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 27.08.2015
 * Time: 18:12
 */

namespace app\models;


use yii\base\Model;

class Schedule extends Model {

    private $data; //Данные телепрограммы
    private $dateBuild; //Данные на которые отстраивается модель

    /**
     * @return mixed
     */
    public function getDateBuild()
    {
        return $this->dateBuild;
    }

    /**
     * @param mixed $dateBuild
     */
    public function setDateBuild($dateBuild)
    {
        $this->dateBuild = $dateBuild;
    }

    /**
     * Задать данные модели телепрограммы
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Получить данные модели телепрограммы
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }



}