<?php

use yii\db\Migration;

/**
 * Acrescenta Nome e Nº de telefone ao utilizador (registo de visitante).
 */
class m261110_120000_add_nome_telefone_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'nome', $this->string(100)->null()->after('username'));
        $this->addColumn('{{%user}}', 'telefone', $this->string(20)->null()->after('email'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'telefone');
        $this->dropColumn('{{%user}}', 'nome');
    }
}
