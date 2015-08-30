<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 27.08.2015
 * Time: 20:12
 */

$data = $model->getData();
$dateNow = $model->getDateBuild();
$fiveMinPixels = 60;
$defaultPadding = 44;


$scheduleHtml = "<script>
$(document).ready(function(){

     $( '#timeline' ).height($( '#schedule' ).height()+100);

 });


</script>";

$maxWidth = ($fiveMinPixels*288);
$scheduleHtml .= "<div id='schedule' style='width:".$maxWidth."px; max-width:".$maxWidth."px'>";

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

        $scheduleHtml .= "<span id='time'>".$hours .":".$mins."</span>";
    }
}

foreach ($data['channels'] as $key => $value) //цикл по каналам
{
    $scheduleHtml .= "<div id='channel'><div class='channelLogo'>".$value['title']."</div>";
    $channelTitle=  $value['title'];

    foreach ($value['schedule'] as $key => $value) //цикл по передачам
    {

        $classProgram = "program";

        $StartHours = gmdate('H', $value['start']);
        $StartMinutes = gmdate('i', $value['start']);

        $EndHours = gmdate('H', $value['end']);
        $EndMinutes = gmdate('i', $value['end']);

        $NowHours = date("H");
        $NowMinutes = date("i");

        if($dateNow == date("Y-m-d"))
        {
            if(($StartHours*60+$StartMinutes)<= ($NowHours*60+$NowMinutes) && ($EndHours*60+$EndMinutes) >=($NowHours*60+$NowMinutes))
            {
                $classProgram = "programActive";
            }
        }

        //Если оканчивается программа позднее сегодняшней даты
        list($year,$month, $day) = explode('-', $dateNow);
        if(gmdate('d', $value['end']) > $day)
        {
            $value['duration'] = (((23 - $StartHours)*60) +  (60 - $StartMinutes))*60;
        }

        $paddingLeft = (($StartHours*60) + ($StartMinutes))/5 * $fiveMinPixels + ($fiveMinPixels/2);
        $durationPixels = (($fiveMinPixels/5) * ($value['duration']/60));
        $scheduleHtml .= "<span title='".$channelTitle."| ".$value['title']." начало: ".gmdate('H:i', $value['start']).", конец: ".gmdate('H:i', $value['end'])."' class='".$classProgram."' style='width:".$durationPixels."px; left:".($paddingLeft+$defaultPadding)."px'>".$value['title']."</span>";
    }

    $scheduleHtml .= "</div>";
}

if($dateNow == date("Y-m-d")) //Если дата отстроенной программы совпадает с сегодняшней датой
{
    $Hours = date("H");
    $Minutes = date("i");
    $paddingLeftTimeLine = (($Hours*60) + ($Minutes))/5 * $fiveMinPixels + ($fiveMinPixels/2);
    $scheduleHtml .= "<div id='timeline'  style='margin-left: ".$paddingLeftTimeLine."px'></div>";
    $scheduleHtml .= "<script>
                                    window.onload = function()
                                    {
                                      scroll(".$paddingLeftTimeLine."-(window.innerWidth/2), 0);


                                    };
                                  </script>";
}



echo $scheduleHtml;
