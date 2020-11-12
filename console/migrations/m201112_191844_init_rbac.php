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

        // TODO Criar permissões para ADMIN, BIBLIOTECARIO e LEITOR.
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
