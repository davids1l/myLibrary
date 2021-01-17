<?php

namespace app\modules\api\controllers;

use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = ['class'=>HttpBasicAuth::className(),
            'auth'=>[$this, 'authf'],
        ];

        return $behaviors;
    }

    public function authf($email, $password){
        $user = User::findUserByEmail($email);

        if ($user && $user->validatePassword($password)){
            return $user;
        }
    }

    public function actionEditarEmail($id){

        $user = User::find()->where(['id' => $id])->one();

        $user->email = \Yii::$app->request->post('email');
        $password = \Yii::$app->request->post('password');

        if($user->validatePassword($password)){
            $user->save();
            return ['success' => true, 'token' => "Basic " . base64_encode($user->email . ":" . $password), 'email' => $user->email];
        }else{
            return ['success' => false];
        }

    }

}
