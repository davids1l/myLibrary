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
                'only' => ['adicionar', 'remover', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['carrinho', 'remover', 'create', 'update', 'delete'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['adicionar', 'carrinho', 'remover', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Função responsavél por adicionar um livro à session do carrinho.
     */
    public function actionAdicionar($id_livro)
    {
        //query para encontrar o livro pelo $id
        $livro = Livro::findOne($id_livro);

        //define a variável da sessão
        $session = Yii::$app->session;
        $flag = 0;

        $carrinho = $session->get('carrinho');

        //verifica se o livro já se encontra requisitado
        if($this->verificarEmRequisicao($id_livro) == true){
            //verifica se o carrinho está null
            if(isset($carrinho)){
                //Limita o carrinho a um máximo de 5 livros
                if(count($carrinho) < 5) {
                    //verifica se o livro a inserir já se encontra no array do carrinho
                    foreach ($carrinho as $obj_livro) {
                        if ($obj_livro->id_livro == $id_livro) {
                            $flag++;
                        }
                    }
                    if ($flag == 0) {
                        $_SESSION['carrinho'][] = $livro;
                        $session->setFlash('success', 'Livro adicionado ao seu carrinho!');
                    } else {
                        $session->setFlash('error', 'Opss! Este livro já se encontra no seu carrinho.');
                    }
                } else {
                    $session->setFlash('error', 'Opss! Limite de livros no carrinho atingido.');
                }
            } else {
                $session->open();
                $_SESSION['carrinho'][] = $livro;
                $session->setFlash('success', 'Livro adicionado ao seu carrinho!');
                $session->close();
            }
        } else {
            $session->setFlash('error', 'Opss! Este livro já se encontra em requisição.');
        }

        return $this->redirect(['livro/detalhes', 'id' => $id_livro]);
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
                    $session->setFlash('success', 'Livro excluído do carrinho.');
                }
            }
        }

        return $this->redirect(['requisicao/finalizar']);

    }

    /**
     * @param $id_livro
     * @return bool
     * Recebe o id do livro e verifica se este se encontra em requisição e se o estado dessa requição é terminada
     *
     */
    public function verificarEmRequisicao($id_livro){

        $requisicoes = RequisicaoLivro::find()
            ->where(['id_livro' => $id_livro])
            ->all();

        $requisicoesTerminadas = [];
        foreach ($requisicoes as $requisicao){
            if($requisicao->requisicao->estado != 'Terminada'){
                array_push($requisicoesTerminadas, $requisicao);
            }
        }

        if(empty($requisicoes)) {
            $canAdicionarCarrinho = true;
        } else {
            //Se o livro não tiver nenhuma requisição com estado concluído é porque está requisitado
            if ($requisicoesTerminadas != null) {
                $canAdicionarCarrinho = false;
            } else {
                $canAdicionarCarrinho = true;
            }
        }
        return $canAdicionarCarrinho;
    }

}
