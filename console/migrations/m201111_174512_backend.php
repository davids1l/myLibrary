<?php

use yii\db\Migration;

/**
 * Class m201111_174512_backend
 */
class m201111_174512_backend extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Tabela biblioteca

        $this->createTable('biblioteca', [
            'id_biblioteca' => $this->primaryKey()->notNull()->unsigned(),
            'nome' => $this->string(120)->notNull(),
            'cod_postal' => $this->string(8)->notNull()
        ], $tableOptions);

        // Tabela utilizador
        $this->createTable('utilizador', [
            'id_utilizador' => $this->primaryKey()->notNull(),
            'primeiro_nome' => $this->string(50)->notNull(),
            'ultimo_nome' => $this->string(50)->notNull(),
            'numero' => $this->string(4)->notNull(),
            'bloqueado' => $this->smallInteger(1)->defaultValue(null),
            'dta_bloqueado' => $this->dateTime()->defaultValue(null),
            'dta_nascimento' => $this->date()->notNull(),
            'nif' => $this->integer(9)->notNull(),
            'num_telemovel' => $this->integer(9)->notNull(),
            'dta_registo' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'foto_perfil' => $this->string(400),
            'id_biblioteca' => $this->integer()->defaultValue(null)->unsigned(),
        ], $tableOptions);

        // Chave estrangeira

        $this->createIndex(
            'idx-utilizador-id_utilizador',
            'utilizador',
            'id_utilizador'
        );

        $this->addForeignKey(
            'fk-utilizador-id_utilizador',
            'utilizador',
            'id_utilizador',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-utilizador-id_biblioteca',
            'utilizador',
            'id_biblioteca'
        );

        $this->addForeignKey(
            'fk-utilizador-id_biblioteca',
            'utilizador',
            'id_biblioteca',
            'biblioteca',
            'id_biblioteca',
            'CASCADE',
            'CASCADE'
        );


        // Tabela pais
        $this->createTable('pais', [
            'id_pais' => $this->primaryKey()->notNull()->unsigned(),
            'designacao' => $this->string(50)->notNull()
        ], $tableOptions);


        //Preenche a tabela países com os dados que estão no ficheiro 'sql_paises'
        $sql = file_get_contents(__DIR__ . '/sql_paises');
        $command = Yii::$app->db->createCommand($sql);
        $command->execute();



       // Autor

        $this->createTable('autor', [
            'id_autor' => $this->primaryKey()->notNull()->unsigned(),
            'nome_autor' => $this->String(200)->notNull(),
            'id_pais' => $this->integer()->notNull()->unsigned()
        ], $tableOptions);

        // Chaves estrangeiras

        $this->createIndex(
            'idx-autor-id_pais',
            'autor',
            'id_pais'
        );


        $this->addForeignKey(
            'fk-autor-id_pais',
            'autor',
            'id_pais',
            'pais',
            'id_pais',
            'CASCADE',
            'CASCADE'
        );

        // Tabela editora

        $this->createTable('editora', [
            'id_editora' => $this->primaryKey()->notNull()->unsigned(),
            'designacao' => $this->string(80)->notNull(),
            'id_pais' => $this->integer()->notNull()->unsigned()
        ], $tableOptions);

        // Chaves estrangeiras

        $this->createIndex(
            'idx-editora-id_pais',
            'editora',
            'id_pais'
        );

        $this->addForeignKey(
            'fk-editora-id_pais',
            'editora',
            'id_pais',
            'pais',
            'id_pais',
            'CASCADE',
            'CASCADE'
        );

        // Tabela livro

        $this->createTable('livro', [
            'id_livro' => $this->primaryKey()->notNull()->unsigned(),
            'titulo' => $this->string(50)->notNull(),
            'isbn' => $this->integer(13)->notNull(),
            'ano' => $this->integer(4)->notNull(),
            'paginas' => $this->integer(11)->notNull(),
            'genero' => $this->string(80)->notNull(),
            'idioma' => $this->string(15)->notNull(),
            'formato' => $this->string(15)->notNull(),
            'capa' => $this->string(255)->notNull(),
            'sinopse' => $this->text()->notNull(),
            'id_editora' => $this->integer()->notNull()->unsigned(),
            'id_biblioteca' => $this->integer()->notNull()->unsigned(),
            'id_autor' => $this->integer()->notNull()->unsigned(),
        ], $tableOptions);

        // Chaves estrangeiras

        $this->createIndex(
            'idx-livro-id_editora',
            'livro',
            'id_editora'
        );

        $this->addForeignKey(
            'fk-livro-id_editora',
            'livro',
            'id_editora',
            'editora',
            'id_editora',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-livro-id_biblioteca',
            'livro',
            'id_biblioteca'
        );

        $this->addForeignKey(
            'fk-livro-id_biblioteca',
            'livro',
            'id_biblioteca',
            'biblioteca',
            'id_biblioteca',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-livro-id_autor',
            'livro',
            'id_autor'
        );

        $this->addForeignKey(
            'fk-livro-id_autor',
            'livro',
            'id_autor',
            'autor',
            'id_autor',
            'CASCADE',
            'CASCADE'
        );

        // Tabela avaliacao - Não utilizada

        /*$this->createTable('avaliacao', [
            'id_avaliacao' => $this->primaryKey()->notNull()->unsigned(),
            'dta_avaliacao' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'avaliacao' => $this->integer(5)->notNull(),
            'id_livro' => $this->integer()->notNull()->unsigned(),
            'id_utilizador' => $this->integer()->notNull(),
        ], $tableOptions);*/

        // Chaves estrangeiras

        $this->createIndex(
            'idx-avaliacao-id_livro',
            'avaliacao',
            'id_livro'
        );

        $this->addForeignKey(
            'fk-avaliacao-id_livro',
            'avaliacao',
            'id_livro',
            'livro',
            'id_livro',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-avaliacao-id_utilizador',
            'avaliacao',
            'id_utilizador'
        );

        $this->addForeignKey(
            'fk-avaliacao-id_utilizador',
            'avaliacao',
            'id_utilizador',
            'utilizador',
            'id_utilizador',
            'CASCADE',
            'CASCADE'
        );

        // Tabela comentario

        $this->createTable('comentario', [
            'id_comentario' => $this->primaryKey()->notNull()->unsigned(),
            'dta_comentario' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'comentario' => $this->string(245)->notNull(),
            'id_livro' => $this->integer()->notNull()->unsigned(),
            'id_utilizador' => $this->integer()->notNull(),
        ], $tableOptions);

        // Chaves estrangeiras

        $this->createIndex(
            'idx-comentario-id_livro',
            'comentario',
            'id_livro'
        );

        $this->addForeignKey(
            'fk-comentario-id_livro',
            'comentario',
            'id_livro',
            'livro',
            'id_livro',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-comentario-id_utilizador',
            'comentario',
            'id_utilizador'
        );

        $this->addForeignKey(
            'fk-comentario-id_utilizador',
            'comentario',
            'id_utilizador',
            'utilizador',
            'id_utilizador',
            'CASCADE',
            'CASCADE'
        );

        // Tabela favorito

        $this->createTable('favorito', [
            'id_favorito' => $this->primaryKey()->notNull()->unsigned(),
            'dta_favorito' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'id_livro' => $this->integer()->notNull()->unsigned(),
            'id_utilizador' => $this->integer()->notNull(),
        ], $tableOptions);

        // Chaves estrangeiras

        $this->createIndex(
            'idx-favorito-id_livro',
            'favorito',
            'id_livro'
        );

        $this->addForeignKey(
            'fk-favorito-id_livro',
            'favorito',
            'id_livro',
            'livro',
            'id_livro',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-favorito-id_utilizador',
            'favorito',
            'id_utilizador'
        );

        $this->addForeignKey(
            'fk-favorito-id_utilizador',
            'favorito',
            'id_utilizador',
            'utilizador',
            'id_utilizador',
            'CASCADE',
            'CASCADE'
        );

        // Tabela requisicao

        $this->createTable('requisicao', [
            'id_requisicao' => $this->primaryKey()->notNull()->unsigned(),
            'dta_levantamento' => $this->dateTime(),
            'dta_entrega' => $this->dateTime(),
            'estado' => $this->string(30)->notNull(),
            'id_utilizador' => $this->integer()->notNull(),
            'id_bib_levantamento' => $this->integer()->notNull()->unsigned(),
        ], $tableOptions);

        // Chaves estrangeiras

        /*$this->createIndex(
            'idx-requisicao-id_livro',
            'requisicao',
            'id_livro'
        );

        $this->addForeignKey(
            'fk-requisicao-id_livro',
            'requisicao',
            'id_livro',
            'livro',
            'id_livro',
            'CASCADE',
            'CASCADE'
        );*/

        $this->createIndex(
            'idx-requisicao-id_utilizador',
            'requisicao',
            'id_utilizador'
        );

        $this->addForeignKey(
            'fk-requisicao-id_utilizador',
            'requisicao',
            'id_utilizador',
            'utilizador',
            'id_utilizador',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-requisicao-id_bib_levantamento',
            'requisicao',
            'id_bib_levantamento'
        );

        $this->addForeignKey(
            'fk-requisicao-id_bib_levantamento',
            'requisicao',
            'id_bib_levantamento',
            'biblioteca',
            'id_biblioteca',
            'CASCADE',
            'CASCADE'
        );

        // Tabela Requisicao-Livros

        $this->createTable('requisicao_livro', [
            'id_livro' => $this->integer()->notNull()->unsigned(),
            'id_requisicao' => $this->integer()->notNull()->unsigned(),
            'PRIMARY KEY(id_livro, id_requisicao)',
        ], $tableOptions);

        // Chaves estrangeiras

        $this->createIndex(
            'idx-requisicao_livro-id_livro',
            'requisicao_livro',
            'id_livro'
        );

        $this->addForeignKey(
            'fk-requisicao_livro-id_livro',
            'requisicao_livro',
            'id_livro',
            'livro',
            'id_livro',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-requisicao_livro-id_requisicao',
            'requisicao_livro',
            'id_requisicao'
        );

        $this->addForeignKey(
            'fk-requisicao_livro-id_requisicao',
            'requisicao_livro',
            'id_requisicao',
            'requisicao',
            'id_requisicao',
            'CASCADE',
            'CASCADE'
        );



        // Tabela multa
        $this->createTable('multa', [
            'id_multa' => $this->primaryKey()->notNull()->unsigned(),
            'montante' => $this->float()->notNull(),
            'estado' => $this->string(30)->notNull(),
            'dta_multa' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'id_requisicao' => $this->integer()->notNull()->unsigned()
        ], $tableOptions);

        //Chaves estrangeiras
        $this->createIndex(
            'idx-multa-id_requisicao',
            'multa',
            'id_requisicao'
        );

        $this->addForeignKey(
            'idx-multa-id_requisicao',
            'multa',
            'id_requisicao',
            'requisicao',
            'id_requisicao',
            'NO ACTION',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201111_174512_backend cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201111_174512_backend cannot be reverted.\n";

        return false;
    }
    */
}
