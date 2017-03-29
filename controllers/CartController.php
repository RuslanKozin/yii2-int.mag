<?php

namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use Yii;

/*  Вид\ Массив корзины
    Array
    (
        [1] => Array
        (
            [qty] => qty
            [name] => NAME
            [price] => PRICE
            [img] => IMG
        )
        [10] => Array
        (
            [qty] => qty
            [name] => NAME
            [price] => PRICE
            [img] => IMG
        )
    )
        [qty] => QTY,
        [sum] => SUM
    );
*/

class CartController extends AppController {

    public function actionAdd() {       //Добавляем товар в корзину
        $id = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;        //Если в $qty 0, (?)тогда мы присвоим значение 1 по умолчанию (:) противном случае положим то, что ввел пользователь туда
        $product = Product::findOne($id);
        if(empty($product)) return false;       //Если $product пустая, то мы останавливаем программу
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        if( !Yii::$app->request->isAjax ) {     //Если мы получаем данные не методом ajax
            return $this->redirect(Yii::$app->request->referrer);   //то делаем редирект на ту страницу с которой пришел пользователь (в Yii::$app->request->referrer хранится url(адрес) с которого пришел наш пользователь)
        }
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear(){
        $session =Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem() {
        $id = Yii::$app->request->get('id');    //Получаем id товара
        $session =Yii::$app->session;           //Открываем сессию
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow() {
        $session =Yii::$app->session;           //Открываем сессию
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

}