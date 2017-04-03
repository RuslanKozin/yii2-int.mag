<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;


class AppAdminController extends Controller{

    public function behaviors(){            //Поведение
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                        //Разрешаем все только для пользователей с ролью авторизованный пользователь
                    ]
                ]
            ]
        ];
    }

} 