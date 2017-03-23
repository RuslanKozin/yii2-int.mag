<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController {

    public function actionView($id) {
        $id = Yii::$app->request->get('id');

            //Вариант с ленивой загрузкой
        $product = Product::findOne($id);   //findOne - т.е. нужен один объект по id
        if(empty($product)) {
            throw new \yii\web\HttpException(404, 'Такого товара нет');
        }

            //Вариант с жадной загрузкой
        /*$product = Product::find()->with('category')
                                  ->where(['id'=>$id])
                                  ->limit(1)
                                  ->one();*/

        $hits = Product::find()->where(['hit'=>'1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }

}