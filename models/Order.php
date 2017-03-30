<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;        //Поведение
use yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $qty
 * @property double $sum
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),      //Объявляем нужный нам класс
                'attributes' => [                               //Указываем атрибуты
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],      //Перед вставкой новой записи 
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],        //Перед обновлением записи
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getOrderItems() {       //Связь с таблицей OrderItems
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);      //Отношение один ко многим 
    }

    /**
     * @inheritdoc
     */
    public function rules()         //Правила для валидации
    {
        return [
            [['name', 'email', 'phone', 'address'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['qty'], 'integer'],       // integer - целое число
            [['sum'], 'number'],        // number - просто число
            [['status'], 'boolean'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()           //Поля для формы
    {
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'address' => 'Адрес',
        ];
    }
}
