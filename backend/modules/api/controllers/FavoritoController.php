<?php

namespace app\modules\api\controllers;

use app\models\Livro;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class FavoritoController extends ActiveController
{

    public $modelClass = 'app\models\Favorito';


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

    public function actionUtilizadorFavs($id){
        $model = new $this->modelClass;
        $favs = $model->find()->where(['id_utilizador' => $id])->all();

        if($favs != null){
            return $favs;
        }

        return [["id_favorito" => "false"]];
    }

}
