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
        $product = Product::findOne($id);
        if(empty($product)) return false;       //Если $product пустая, то мы останавливаем программу
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

}