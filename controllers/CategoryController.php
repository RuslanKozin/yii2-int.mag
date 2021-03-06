<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController {

    public function actionIndex() {     //Действие по умолчанию (для данной таблицы)
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER');
        return $this->render('index', compact('hits'));
    }

    public function actionView($id) {           //Получаем id параметром (из route | config/web.php) 1-й вариант
        //$id = Yii::$app->request->get('id');    //Получаем id категории (из массива get - адресной строки) 2-й вариант

        $category = Category::findOne($id);         //Получаем id одной категории
        if(empty($category)) {
            throw new \yii\web\HttpException(404, 'Такой категории нет');
        }

        //$products = Product::find()->where(['category_id' => $id])->all();    //Получаем продукты по данному id
            //Пагинация
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 
                                 'pageSize' => 3, 
                                 'pageSizeParam' => false, 
                                 'forcePageParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
                    //offset - с какой записи начинать выборку
            //Пагинация
        $category = Category::findOne($id);         //Получаем id одной категории
        $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pages', 'category'));
    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));
        $this->setMeta('E-SHOPPER | Поиск: ' . $q);
        if(!$q) {       //Если $q пустая, т.е пользователь ничего не ввел
            return $this->render('search');
        }
        $query = Product::find()->where(['like', 'name', $q]);
        $pages = new Pagination(['totalCount' => $query->count(), 
                                 'pageSize' => 3, 
                                 'pageSizeParam' => false, 
                                 'forcePageParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search', compact('products', 'pages', 'q'));
    }

}