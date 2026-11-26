<?php

use yii\db\Migration;

class m261110_201300_adicionar_contactos_museu extends Migration
{
    public function safeUp(): void
    {
        $this->addColumn('museu', 'telefone', $this->string(30)->null());
        $this->addColumn('museu', 'email', $this->string(120)->null());
    }

    public function safeDown(): void
    {
        $this->dropColumn('museu', 'email');
        $this->dropColumn('museu', 'telefone');
    }
}
