<?php

namespace app\components;   //Подключаем пространство имен для виджета
use yii\base\Widget;



class MenuWidget extends Widget
{
    public $tpl;

    public function init()  //Метод
    {
        parent::init(); //Вызываем родительский метод
            //Смотрим, что пришло в качестве параметра
        if ($this->tpl === null)    /*Если данный параметр не передан, т.е. tpl пустой*/
        {
            $this->tpl = 'menu';    //тогда присваиваем по умолчанию
        }
        $this->tpl .= '.php';  //прикрепляем расширение
    }

    public function run()
    {
        return $this->tpl;  //Выводим, что попало в tpl
    }
}