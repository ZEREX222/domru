<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 23.08.2015
 * Time: 17:39
 */

class Utils {

    /**
     * Функция прибовления, вычитания даты
     * @param $date
     * @param $days
     * @return bool|string
     */
     public static function addDaysWithDate($date,$days){

        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);

    }

}