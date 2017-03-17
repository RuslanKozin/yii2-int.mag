<?php

namespace app\components;   //Подключаем пространство имен для виджета
use app\models\Category;
use yii\base\Widget;



class MenuWidget extends Widget
{
    public $tpl;        //параметр для виджета категорий, которое выдает меню состоящее из (ul и li)
    public $data;       //Свойство в котором будет хранится все данные категорий из базы данных(массив)
    public $tree;       //Результат работы $date. (строит массив дерева категории по подгруппам)
    public $menuHtml;   //Готовый html-код меню

    public function init()  //Метод
    {
        parent::init();     //Вызываем родительский метод
        
            //Смотрим, что пришло в качестве параметра
        if ($this->tpl === null)    /*Если данный параметр не передан, т.е. tpl пустой*/
        {
            $this->tpl = 'menu';    //тогда присваиваем по умолчанию
        }
        $this->tpl .= '.php';  //прикрепляем расширение шаблона
    }

    public function run()       //Метод run чаще всего используется для вывода данных
    {
        $this->data = Category::find()->indexBy('id')->asArray()->all();   /*Метод asArray - вернет результат ввиде массива-массива
            Метод indexBy - позволяет указать какое поле/колонку таблицы использовать для индексирования массивов(ключи совпадают с id)*/
        $this->tree = $this->getTree();  //Строем дерево
        $this->menuHtml = $this->getMenuHtml($this->tree);      //Строем html-код
        return $this->menuHtml;  //Выводим, что попало в tpl
    }

    protected function getTree()   /*Метод getTree проходится в цикле по массиву и из обычного одномерного массива
                                        строит дерево*/
    {
        $tree = [];
        foreach ($this->data as $id=>&$node)
        {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree)   /*Метод getMenuHtml принимает в себя параметр, в нашем случае дерево, */
    {
        $str = '';      // в данную переменную будет помешаться готовый html-код
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category);
        }
        return $str;    /* В итоге пройдясь в цикле по всему дереву формируем нужный html-код, который возвращает метод getMenuHtml  */
    }

    protected function catToTemplate($category)      //Метод catToTemplate возвращает буферизированный вывод в $str
    {
        ob_start();         //Фукнция ob_start буферизирует вывод, а затем его возвращает не выводя при этом на экран и возвращает в $str
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}