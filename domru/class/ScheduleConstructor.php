<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 22.08.2015
 * Time: 16:00
 */

class ScheduleConstructor {

    private $fiveMinPixels = 60; //Количество пикселей 5 минут
    private $data; //Массив данных для построения программы
    private $dateNow; //Дата отстроенной программы
    private $dateNext; //Дата отстроенной программы - следующей
    private $datePrevious; //Дата отстроенной программы - предыдущей

    /**
     * Задаем данные для построения программы
     * @param $data
     */
    public function setDataProvider($data)
    {
        $this->data = $data;
    }

    /**
     * Дата на какую дату остроенна программа, следующая, предыдущая
     * @param $dateNow
     * @param $dateNext
     * @param $datePrevious
     */
    public function setDates($dateNow, $dateNext = null, $datePrevious = null)
    {
        $this->dateNow = $dateNow;
        $this->dateNext = $dateNext;
        $this->datePrevious = $datePrevious;
    }

    /**
     * Строим программу, если $drawToVariable = true, то html программы возвращаем в переменную
     * @param $drawToVariable
     * @return string
     */
    public function draw($drawToVariable = false)
    {
        $scheduleHtml = $this->buildSchedule();

        if($drawToVariable)
        {
            return $scheduleHtml;
        }else{
            echo $scheduleHtml;
        }
    }

    /**
     * Строим HTML программы
     * @return string
     */
    private function buildSchedule()
    {
        $scheduleHtml = "<div id='schedule'>";

        //Создание временой полосы
        for ($i = 0; $i < 24; $i++) {

            for ($y = 0; $y < 12; $y++) {
                $hours = $i;
                if ($i < 10) {
                    $hours = "0" . $hours;
                }

                $mins = $y*5;
                if($mins < 10)
                {
                    $mins = "0" . $mins;
                }

                $scheduleHtml .= "<div id='time'>".$hours .":".$mins."</div>";
            }
        }

        foreach ($this->data['channels'] as $key => $value) //цикл по каналам
        {
            $scheduleHtml .= "<div id='channel'><div id='channelLogo'>".$value['title']."</div>";

            foreach ($value['schedule'] as $key => $value) //цикл по передачам
            {

                $Hours = gmdate('H', $value['start']);
                $Minutes = gmdate('i', $value['start']);
                $paddingLeft = (($Hours*60) + ($Minutes))/5 * $this->fiveMinPixels + ($this->fiveMinPixels/2);
                $durationPixels = (($this->fiveMinPixels/5) * ($value['duration']/60));
                $scheduleHtml .= "<div id='program' style='width:".$durationPixels."px; left:".$paddingLeft."px'>".$value['title']."</div>";
            }

            $scheduleHtml .= "</div>";
        }

        if($this->dateNow == date("Y-m-d")) //Если дата отстроенной программы совпадает с сегодняшней датой
        {
            $Hours = date("H");
            $Minutes = date("i");
            $paddingLeftTimeLine = (($Hours*60) + ($Minutes))/5 * $this->fiveMinPixels + ($this->fiveMinPixels/2);
            $scheduleHtml .= "<div id='timeline'  style='margin-left: ".$paddingLeftTimeLine."px'></div>";
            $scheduleHtml .= "<script>
                                window.onload = function()
                                {
                                  scroll(".$paddingLeftTimeLine."-(window.innerWidth/2), 0);

                                };
                              </script>";
        }

        $scheduleHtml .= "</div>";
        $scheduleHtml .= "<div id='leftLink'><a href='?date=".$this->datePrevious."'>Вчера</a></div>
                          <div id='nowLink'><a href='?date=".date("Y-m-d")."'>Сейчас</a></div>
                          <div id='rightLink'><a href='?date=".$this->dateNext."'>Завтра</a></div>";

        return $scheduleHtml;
    }

}