<?php

namespace frontend\controllers;

use app\models\Biblioteca;
use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use Yii;
use app\models\Requisicao;
use app\models\RequisicaoSearch;
use yii\db\Query;
use yii\debug\panels\DumpPanel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CarrinhoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['adicionar', 'remover'],
                'rules' => [
                    [
                        'actions' => ['remover', 'adicionar'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }

    /**
     * Função responsavél por adicionar um livro à session do carrinho.
     */
    public function actionAdicionar($id_livro)
    {
        //query que retorna o livro de acordo com o id_livro recebido por parametro
        $livro = Livro::findOne($id_livro);

        //define a variável da sessão
        $session = Yii::$app->session;
        $flag = 0;

        //obtem os dados armazenados na sessão "carrinho"
        $carrinho = $session->get('carrinho');

        //verifica se o livro já se encontra requisitado
        if($this->verificarEmRequisicao($id_livro) == true){

            //verifica se o carrinho está null ou definido
            if (isset($carrinho)) {
                //Limita o carrinho a um máximo de 5 livros
                if (count($carrinho) < 5) {
                    //verifica se o livro a inserir já se encontra no array do carrinho
                    foreach ($carrinho as $obj_livro) {
                        if ($obj_livro->id_livro == $id_livro) {
                            $flag++;
                        }
                    }
                    //se estiver não permite a duplicação do mesmo, caso contrário o livro é adicionado à sessão
                    if ($flag == 0) {
                        $_SESSION['carrinho'][] = $livro;
                        $session->setFlash('success', 'Livro adicionado ao seu cesto!');
                    } else {
                        $session->setFlash('error', 'Opss! Este livro já se encontra no seu cesto.');
                    }
                } else {
                    $session->setFlash('error', 'Opss! Limite de livros no cesto atingido.');
                }
            } else {
                //se o carrinho não estiver definido ou estiver null então a sessão é criada e adicionado o livro
                $session->open();
                $_SESSION['carrinho'][] = $livro;
                $session->setFlash('success', 'Livro adicionado ao seu cesto!');
                $session->close();
            }
        } else {
            $session->setFlash('error', 'Opss! Este livro já se encontra em requisição.');
        }

        //obter o url anterior
        $previousUrl = Yii::$app->request->referrer;

        //se o url anterior não for o da vista de detalhes então é feito o redrect para a página anterior
        if($previousUrl != ("localhost/mylibrary/frontend/web/index.php/livro/detalhes?id=".$id_livro)) {
            return $this->redirect($previousUrl);
        } else {
            return $this->redirect(['livro/detalhes', 'id' => $id_livro]);
        }
    }


    /**
     *  Função responsável por excluir um livro da session carrinho
     */
    public function actionRemover($id_livro){

        /*
         * 1- validar se a session está open e se contem informação.
         * 2- se true, então foreach em cada objeto do carrinho e validar se id_livro = id_livro
         * 3- se true, é feito um array_search para encontrar o index da posição do array 'carrinho' onde está o objeto
         * 4- com o index obtido é efetuado o unset no array carrinho de acordo com esse index (Remover)
         */

        $session = Yii::$app->session;
        $carrinho = $session->get('carrinho');

        if($session->isActive && $carrinho!=null){
            foreach ($carrinho as $obj_livro) {
                if ($obj_livro->id_livro == $id_livro) {
                    $index = array_search($obj_livro, $carrinho);
                    unset($_SESSION['carrinho'][$index]);
                    $session->setFlash('success', 'Livro excluído do cesto.');
                }
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
        //return null; //$this->redirect(['requisicao/finalizar']);

    }

    /**
     * @param $id_livro
     * @return bool
     * Recebe o id do livro e verifica se este se encontra em requisição e se o estado dessa requição é terminada
     *
     */
    public function verificarEmRequisicao($id_livro){

        //Obter os registos de requisicao_livros em que se verifique id_livro = id_livro recebido por post
        $subQuery = RequisicaoLivro::find()
            ->where(['id_livro' => $id_livro]);

        //Obter as requisições em que o estado seja diferente de "Terminada" e que se verifique que o id_requisicao = id_requesicao da subquery
        $query = Requisicao::find()
            ->where(['!=', 'estado', 'Terminada'])
            ->innerJoin(['sub' => $subQuery], 'requisicao.id_requisicao = sub.id_requisicao')
            ->all();

        //Se o livro não tiver nenhuma requisição com estado concluído implica estar requisitado
        if ($query != null) {
            $canAdicionarCarrinho = false;
        } else {
            $canAdicionarCarrinho = true;
        }

        return $canAdicionarCarrinho;
    }
}
