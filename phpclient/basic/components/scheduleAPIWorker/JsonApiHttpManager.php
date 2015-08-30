<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 21.08.2015
 * Time: 15:07
 */

namespace app\components\scheduleAPIWorker;

class JsonApiHttpManager {


    /**
     * Вернуть ответ HTTP сервера
     * @param $url
     * @return mixed
     */
    private function returnHttpText($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Метод указывающий на то, жив ли API или нет
     * @param $url
     * @return bool
     */
    public function available($url)
    {
        $result = $this->returnHttpText($url);

        if($result == "living")
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Вернуть JSON из API
     * @param $url
     * @return mixed
     */
    public function getJsonArray($url)
    {
        $result = $this->returnHttpText($url);
        return json_decode($result, true);
    }



}