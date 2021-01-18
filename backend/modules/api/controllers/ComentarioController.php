<?php

namespace app\modules\api\controllers;

use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ComentarioController extends ActiveController
{

    public $modelClass = 'app\models\Comentario';


    //Basic Auth
    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = ['class'=>HttpBasicAuth::className(), 'auth'=>[$this, 'authf']];

        return $behaviors;
    }

    public function authf($email, $password){
        $user = User::findUserByEmail($email);

        if ($user && $user->validatePassword($password)){
            return $user;
        }
    }*/

    public function actionUtilizadorComents($id){
        $model = new $this->modelClass;
        $coments = $model->find()->where(['id_utilizador' => $id])->all();

        if($coments != null){
            return $coments;
        }

        return [["id_comentario" => "false"]];
    }
}
