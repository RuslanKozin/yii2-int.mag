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

            //Вариант с жадной загрузкой
        /*$product = Product::find()->with('category')
                                  ->where(['id'=>$id])
                                  ->limit(1)
                                  ->one();*/

        return $this->render('view', compact('product'));
    }

}