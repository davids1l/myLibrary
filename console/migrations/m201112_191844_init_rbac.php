<?php

use yii\db\Migration;

/**
 * Class m201112_191844_init_rbac
 */
class m201112_191844_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Permissões Autor

        $createAutor = $auth->createPermission('createAutor');
        $createAutor->description = 'Criar um Autor';
        $auth->add($createAutor);

        $updateAutor = $auth->createPermission('updateAutor');
        $updateAutor->description = 'Atualizar um Autor';
        $auth->add($updateAutor);

        $deleteAutor = $auth->createPermission('deleteAutor');
        $deleteAutor->description = 'Eliminar um Autor';
        $auth->add($deleteAutor);

        // Permissões Avaliação

        $createAvalicao = $auth->createPermission('createAvalicao');
        $createAvalicao->description = 'Criar uma Avaliação';
        $auth->add($createAvalicao);

        $updateAvaliacao = $auth->createPermission('updateAvaliacao');
        $updateAvaliacao->description = 'Atualizar uma Avaliação';
        $auth->add($updateAvaliacao);

        $deleteAvaliacao = $auth->createPermission('deleteAvaliacao');
        $deleteAvaliacao->description = 'Eliminar uma Avaliação';
        $auth->add($deleteAvaliacao);

        // Permissões Biblioteca

        $createBiblioteca = $auth->createPermission('createBiblioteca');
        $createBiblioteca->description = 'Criar uma Biblioteca';
        $auth->add($createBiblioteca);

        $updateBiblioteca = $auth->createPermission('updateBiblioteca');
        $updateBiblioteca->description = 'Atualizar uma Biblioteca';
        $auth->add($updateBiblioteca);

        $deleteBiblioteca = $auth->createPermission('deleteBiblioteca');
        $deleteBiblioteca->description = 'Eliminar uma Biblioteca';
        $auth->add($deleteBiblioteca);

        // Permissões Comentario

        $createComentario = $auth->createPermission('createComentario');
        $createComentario->description = 'Criar um Comentario';
        $auth->add($createComentario);

        $updateComentario = $auth->createPermission('updateComentario');
        $updateComentario->description = 'Atualizar um Comentario';
        $auth->add($updateComentario);

        $deleteComentario = $auth->createPermission('deleteComentario');
        $deleteComentario->description = 'Eliminar um Comentario';
        $auth->add($deleteComentario);

        // Permissões Editora

        $createEditora = $auth->createPermission('createEditora');
        $createEditora->description = 'Criar uma Editora';
        $auth->add($createEditora);

        $updateEditora = $auth->createPermission('updateEditora');
        $updateEditora->description = 'Atualizar uma Editora';
        $auth->add($updateEditora);

        $deleteEditora = $auth->createPermission('deleteEditora');
        $deleteEditora->description = 'Eliminar uma Editora';
        $auth->add($deleteEditora);

        // Permissões Favorito

        $createFavorito = $auth->createPermission('createFavorito');
        $createFavorito->description = 'Criar um Favorito';
        $auth->add($createFavorito);

        $updateFavorito = $auth->createPermission('updateFavorito');
        $updateFavorito->description = 'Atualizar um Favorito';
        $auth->add($updateFavorito);

        $deleteFavorito = $auth->createPermission('deleteFavorito');
        $deleteFavorito->description = 'Eliminar um Favorito';
        $auth->add($deleteFavorito);

        // Permissões Livro

        $createLivro = $auth->createPermission('createLivro');
        $createLivro->description = 'Criar um Livro';
        $auth->add($createLivro);

        $updateLivro = $auth->createPermission('updateLivro');
        $updateLivro->description = 'Atualizar um Livro';
        $auth->add($updateLivro);

        $deleteLivro = $auth->createPermission('deleteLivro');
        $deleteLivro->description = 'Eliminar um Livro';
        $auth->add($deleteLivro);

        // Permissões Multa

        $createMulta = $auth->createPermission('createMulta');
        $createMulta->description = 'Criar uma Multa';
        $auth->add($createMulta);

        $updateMulta = $auth->createPermission('updateMulta');
        $updateMulta->description = 'Atualizar uma Multa';
        $auth->add($updateMulta);

        $deleteMulta = $auth->createPermission('deleteMulta');
        $deleteMulta->description = 'Eliminar uma Multa';
        $auth->add($deleteMulta);

        // Permissões Pais

        $createPais = $auth->createPermission('createPais');
        $createPais->description = 'Criar um Pais';
        $auth->add($createPais);

        $updatePais = $auth->createPermission('updatePais');
        $updatePais->description = 'Atualizar um Pais';
        $auth->add($updatePais);

        $deletePais = $auth->createPermission('deletePais');
        $deletePais->description = 'Eliminar um Pais';
        $auth->add($deletePais);

        // Permissões Requisicao

        $createRequisicao = $auth->createPermission('createRequisicao');
        $createRequisicao->description = 'Criar uma Requisicao';
        $auth->add($createRequisicao);

        $updateRequisicao = $auth->createPermission('updateRequisicao');
        $updateRequisicao->description = 'Atualizar uma Requisicao';
        $auth->add($updateRequisicao);

        $deleteRequisicao = $auth->createPermission('deleteRequisicao');
        $deleteRequisicao->description = 'Eliminar uma Requisicao';
        $auth->add($deleteRequisicao);

        // Permissões RequisicaoMulta

        $createReqMulta = $auth->createPermission('createReqMulta');
        $createReqMulta->description = 'Criar uma Requisicao-Multa';
        $auth->add($createReqMulta);

        $updateReqMulta = $auth->createPermission('updateReqMulta');
        $updateReqMulta->description = 'Atualizar uma Requisicao-Multa';
        $auth->add($updateReqMulta);

        $deleteReqMulta = $auth->createPermission('deleteReqMulta');
        $deleteReqMulta->description = 'Eliminar uma Requisicao-Multa';
        $auth->add($deleteReqMulta);

        // Permissões Utilizador

        $createUtilizador = $auth->createPermission('createUtilizador');
        $createUtilizador->description = 'Criar um Utilizador';
        $auth->add($createUtilizador);

        $updateUtilizador = $auth->createPermission('updateUtilizador');
        $updateUtilizador->description = 'Atualizar um Utilizador';
        $auth->add($updateUtilizador);

        $deleteUtilizador = $auth->createPermission('deleteUtilizador');
        $deleteUtilizador->description = 'Eliminar um Utilizador';
        $auth->add($deleteUtilizador);

        // Permissões Leitor

        $updateLeitor = $auth->createPermission('updateLeitor');
        $updateLeitor->description = 'Atualizar um Leitor';
        $auth->add($updateLeitor);

        // Permissões Bibliotecario

        $updateBibliotecario = $auth->createPermission('updateBibliotecario');
        $updateBibliotecario->description = 'Atualizar um Bibliotecario';
        $auth->add($updateBibliotecario);


        // ROLES

        // Criação do Role Leitor e atribuição das respetivas permissões

        $leitor = $auth->createRole('leitor');
        $auth->add($leitor);

        $auth->addChild($leitor, $createAvalicao);
        $auth->addChild($leitor, $updateAvaliacao);
        $auth->addChild($leitor, $deleteAvaliacao);

        $auth->addChild($leitor, $createComentario);
        $auth->addChild($leitor, $updateComentario);
        $auth->addChild($leitor, $deleteComentario);

        $auth->addChild($leitor, $createFavorito);
        $auth->addChild($leitor, $updateFavorito);
        $auth->addChild($leitor, $deleteFavorito);

        $auth->addChild($leitor, $createUtilizador);
        $auth->addChild($leitor, $updateUtilizador);
        $auth->addChild($leitor, $deleteUtilizador);

        $auth->addChild($leitor, $createRequisicao);


        // Criação do Role Bibliotecario e atribuição das respetivas permissões
        $bibliotecario = $auth->createRole('bibliotecario');
        $auth->add($bibliotecario);

        $auth->addChild($bibliotecario, $createAutor);
        $auth->addChild($bibliotecario, $updateAutor);
        $auth->addChild($bibliotecario, $deleteAutor);

        $auth->addChild($bibliotecario, $createEditora);
        $auth->addChild($bibliotecario, $updateEditora);
        $auth->addChild($bibliotecario, $deleteEditora);

        $auth->addChild($bibliotecario, $createLivro);
        $auth->addChild($bibliotecario, $updateLivro);
        $auth->addChild($bibliotecario, $deleteLivro);

        $auth->addChild($bibliotecario, $createMulta);
        $auth->addChild($bibliotecario, $updateMulta);
        $auth->addChild($bibliotecario, $deleteMulta);

        $auth->addChild($bibliotecario, $createPais);
        $auth->addChild($bibliotecario, $updatePais);
        $auth->addChild($bibliotecario, $deletePais);

        $auth->addChild($bibliotecario, $createRequisicao);
        $auth->addChild($bibliotecario, $updateRequisicao);
        $auth->addChild($bibliotecario, $deleteRequisicao);

        $auth->addChild($bibliotecario, $createUtilizador);
        $auth->addChild($bibliotecario, $updateUtilizador);
        $auth->addChild($bibliotecario, $deleteUtilizador);

        $auth->addChild($bibliotecario, $updateLeitor);

        $auth->addChild($bibliotecario, $createReqMulta);
        $auth->addChild($bibliotecario, $updateReqMulta);
        $auth->addChild($bibliotecario, $deleteReqMulta);


        // Criação do Role Admin e atribuição das respetivas permissões

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin, $createAutor);
        $auth->addChild($admin, $updateAutor);
        $auth->addChild($admin, $deleteAutor);

        $auth->addChild($admin, $createBiblioteca);
        $auth->addChild($admin, $updateBiblioteca);
        $auth->addChild($admin, $deleteBiblioteca);

        $auth->addChild($admin, $createEditora);
        $auth->addChild($admin, $updateEditora);
        $auth->addChild($admin, $deleteEditora);

        $auth->addChild($admin, $createLivro);
        $auth->addChild($admin, $updateLivro);
        $auth->addChild($admin, $deleteLivro);

        $auth->addChild($admin, $createMulta);
        $auth->addChild($admin, $updateMulta);
        $auth->addChild($admin, $deleteMulta);

        $auth->addChild($admin, $createPais);
        $auth->addChild($admin, $updatePais);
        $auth->addChild($admin, $deletePais);

        $auth->addChild($admin, $createRequisicao);
        $auth->addChild($admin, $updateRequisicao);
        $auth->addChild($admin, $deleteRequisicao);

        $auth->addChild($admin, $createUtilizador);
        $auth->addChild($admin, $updateUtilizador);
        $auth->addChild($admin, $deleteUtilizador);

        $auth->addChild($admin, $updateLeitor);
        $auth->addChild($admin, $updateBibliotecario);

        $auth->addChild($admin, $createReqMulta);
        $auth->addChild($admin, $updateReqMulta);
        $auth->addChild($admin, $deleteReqMulta);



        // TODO Adicionar Role 'admin' ao ADMIN
        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.

        //$auth->assign($admin, 1);

        // Roles são atribuidos aos utilizadores do tipo Leitor e Bibliotecário, na criação da sua conta.

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201112_191844_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201112_191844_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
