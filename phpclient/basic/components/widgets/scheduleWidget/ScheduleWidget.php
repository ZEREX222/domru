<?php
/**
 * Created by PhpStorm.
 * User: ZEREX
 * Date: 27.08.2015
 * Time: 20:08
 */
namespace app\components\widgets\scheduleWidget;

use yii\base\Widget;

/**
 * Виджет программы передач
 * Class ScheduleWidget
 * @package app\components\widgets\scheduleWidget
 */
class ScheduleWidget extends Widget {

    public $model;

    public function init()
    {
        parent::init();
    }

    public function run(){
        echo $this->render( '@app/views/widget/scheduleWidget/view.php', [
            'model' => $this->model,
        ]);
    }


}