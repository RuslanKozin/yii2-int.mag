<?php   //Модель для таблицы product

namespace app\models;
use yii\db\ActiveRecord;


class Product extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public static function tableName()  //Связываем модель с таблицей product
    {
        return 'product';
    }

    public function getCategory()       //Привязываем таблицу product
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);       //отношение один к одному
        /*id - поле в связываемой таблице category (ссылается на поле category_id таблицы product) */
    }
}