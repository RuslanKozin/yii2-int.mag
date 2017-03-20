<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class CategoryController extends AppController {

    public function actionIndex() {     //Действие по умолчанию (для данной таблицы)
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER');
        return $this->render('index', compact('hits'));
    }

    public function actionView($id) {
        $id = Yii::$app->request->get('id');        //Получаем id категории
        $products = Product::find()->where(['category_id' => $id])->all();    //Получаем продукты по данному id
        $category = Category::findOne($id);         //Получаем id одной категории
        $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'category'));
    }

}