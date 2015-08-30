<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use app\components\widgets\scheduleWidget\ScheduleWidget;
use app\components\utils\Utils;

$dateNow = $model->getDateBuild(); //Дата на которую строится сетка
$this->title = 'My Yii Application';
?>


    <!-- Виджет программы передач, строит сетку -->
    <?= ScheduleWidget::widget(['model' => $model]) ?>


<?php

//Меню переключения туда сюда)
$buttons =  Html::a('<b>Вчера</b>',
    [null,'date'=>Utils::addDaysWithDate($dateNow, -1)],
    ['id' => 'leftLink']);

$buttons .= Html::a('<b>Сейчас</b>',
    [null,'date'=>date("Y-m-d")],
    ['id' => 'nowLink']);

$buttons .=  Html::a('<b>Завтра</b>',
    [null,'date'=>Utils::addDaysWithDate($dateNow, +1)],
    ['id' => 'rightLink']);
echo $buttons;
?>