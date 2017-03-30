<?php

namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
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

    public function actionView() {
        $session = Yii::$app->session;           //Открываем сессию
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if($order->load(Yii::$app->request->post())) {  //Загружаем данные, которые пришли из формы
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if($order->save()) {        //Если заказ сохранен
                $this->saveOrderItems($session['cart'], $order->id);    //$session['cart'] - пережаем корзину | $order->id - id заказа
                Yii::$app->session->setFlash('success', 'Ваш заказ принят');    //Устанавливаем сообщение
                    /*   Очищаем корзину   */
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                    /*   Очищаем корзину   */
                return $this->refresh();        //Перезагружаем данную страницу
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа');    //Устанавливаем сообщение
            }
        
        }
        return $this->render('view', compact('session', 'order'));
    }

    protected function saveOrderItems($items, $order_id){       //Принимает $items - корзину и $order_id - id заказа
        foreach($items as $id => $item){
            $order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty'] * $item['price'];
            $order_items->save();
        }
    }

}