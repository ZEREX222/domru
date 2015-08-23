<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK href="main.css" rel="stylesheet" type="text/css">
<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 21.08.2015
 * Time: 14:55
 */
require_once('class/Utils.php'); //Полезные нужные мне утилиты
require_once('class/ScheduleAPI.php'); //Класс для работы с API
require_once('class/ScheduleConstructor.php'); //Класс для построения программы
date_default_timezone_set ("Etc/GMT-5"); //Часовой пояс

try {

    $api = new ScheduleAPI("http://127.0.0.1:5000"); //Подключаемся к Schedule Python API
    $date = date("Y-m-d");
    if(isset($_GET["date"]) && $_GET["date"] != "")
    {
        $scheduleData = $api->getScheduleArray(array("date" => $_GET["date"])); //Получаем данные для построения программы
        $date = $_GET["date"];
    }else{
        $scheduleData = $api->getScheduleArray(array("date" => $date));
    }


    $sConstructor = new ScheduleConstructor(); //Создаем объект класса строителя программы
    $sConstructor->setDates($date,Utils::addDayswithdate($date,+1),Utils::addDayswithdate($date,-1)); //Дата отстроения программы
    $sConstructor->setDataProvider($scheduleData); //Задаем данные для построения программы
    $sConstructor->draw(); //Строим программу


} catch (Exception $e) {
    echo 'Поймано исключение: ',  $e->getMessage(), "\n";
}

