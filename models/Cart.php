<?php

namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord {

    public function addToCart($product, $qty = 1) {
        if(isset($_SESSION['cart'][$product->id])){     //Если в массиве session cart есть текущий элемент (товар) и свойство id
            $_SESSION['cart'][$product->id]['qty'] += $qty;     //то обратимся к текущему элементу (товару) к его свойству qty и добавим то кол-во, которое пришло к нам в $qty
        }else{
            $_SESSION['cart'][$product->id] = [     //Иначе создаем элемент (товар)
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $product->img
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;     //Если массив session cart.qty существует, тогда мы его возмем и прибавим к нему то кол-во, которое пришло к нам параметром, а если не существуеют, тогда мы сюда положим это количество
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;     //Если массив session cart.sum существует, тогда мы должны его взять, прибавить к нему кол-во, которое кладется в корзину умноженное на цену. Иначе мы должны взять количество этого товара умноженное на цену и получим итоговую сумму.
    }

    public function recalc($id) {       //Метод пересчета товаров и суммы при удалении товара с корзины
        if(!isset($_SESSION['cart'][$id])) return false;
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }

}