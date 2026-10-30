<?php

use yii\db\Migration;

class m261029_224655_criar_tabela_perfil extends Migration
{
    public function safeUp()
    {
        $this->createTable('perfil', [
            'id_perfil' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull()->unique(),
            'nome' => $this->string(100),
            'tipo' => $this->string(30)->notNull()->defaultValue('visitante_registado'),
            'numero_visitas' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk_perfil_user',
            'perfil',
            'id_user',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('perfil');
    }
}