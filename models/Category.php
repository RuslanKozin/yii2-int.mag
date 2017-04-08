<?php   //Модель для таблицы category

namespace app\models;
use yii\db\ActiveRecord;


class Category extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public static function tableName()  //Связываем модель с таблицей category
    {
        return 'category';
    }

    public function getProducts()       //Привязываем таблицу product
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);   //hasMany - отношение один ко многим
            /*category_id - поле в связываемой таблице product (ссылается на поле id таблицы category) */
    }
}