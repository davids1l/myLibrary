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
                        'actions' => ['remover', 'adicionar'],
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
            //verifica o total de livros que o o utilizador tem em requsição, se este total for <= 5 então pode adicionar ao carrinho
            if($this->totalLivrosEmRequisicao() <= 5){
                //verifica se o carrinho está null ou definido
                if(isset($carrinho)){
                    //Limita o carrinho a um máximo de 5 livros
                    if(count($carrinho) < 5) {
                        //verifica se o livro a inserir já se encontra no array do carrinho
                        foreach ($carrinho as $obj_livro) {
                            if ($obj_livro->id_livro == $id_livro) {
                                $flag++;
                            }
                        }
                        //se estiver não permite a duplicação do mesmo, caso contrário o livro é adicionado à sessão
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
                    //se o carrinho não estiver definido ou estiver null então a sessão é criada e adicionado o livro
                    $session->open();
                    $_SESSION['carrinho'][] = $livro;
                    $session->setFlash('success', 'Livro adicionado ao seu carrinho!');
                    $session->close();
                }
            } else {
                $session->setFlash('error', 'Opss! Excedeu o limite de 5 livros em requisição.');
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

    /**
     * Através do id do utilizador com login efetuado determina a quantidade de livros que este tem em requisição
     * Se este nº exceder um total de 5, então o utilizador atingiu o limite de livros em requisição e é negado adicionar este ao carrinho/finalizar requisicao
     */
    public function totalLivrosEmRequisicao()
    {
        //subquery que obtem os dados relativos à requisicao em que se verifique => id utilizador = id utilizador logado e estado da requisicao terminada
        $subQuery = Requisicao::find()
            ->where(['id_utilizador' =>Yii::$app->user->id])
            ->andWhere(['!=', 'estado', 'Terminada']);

        //query responsável por obter a contagem de "requisicao_livro" onde se verfique subquery.id_requisicao = requiscao_livro.id_requisicao
        $totalReq = RequisicaoLivro::find()
            ->innerJoin(['sub' => $subQuery], 'requisicao_livro.id_requisicao = sub.id_requisicao')
            ->count();

        return $totalReq;
    }


}
