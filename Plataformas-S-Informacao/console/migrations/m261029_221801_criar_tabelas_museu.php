<?php

use yii\db\Migration;

class m261029_221801_criar_tabelas_museu extends Migration
{
    public function safeUp()
    {
        $t = 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

        // ---------- Tabelas base ----------
        $this->createTable('museu', [
            'id_museu' => $this->primaryKey(),
            'nome' => $this->string(100)->notNull(),
            'tipo' => $this->string(50),
            'descricao' => $this->text(),
            'morada' => $this->string(200),
            'preco' => $this->decimal(10, 2),
            'horario_abertura' => $this->time(),
            'horario_fecho' => $this->time(),
        ], $t);

        $this->createTable('desconto', [
            'id_desconto' => $this->primaryKey(),
            'descricao' => $this->string(150),
            'percentagem' => $this->decimal(5, 2),
            'data_inicio' => $this->date(),
            'data_fim' => $this->date(),
        ], $t);

        // ---------- Dependem de museu ----------
        $this->createTable('obra', [
            'id_obra' => $this->primaryKey(),
            'id_museu' => $this->integer()->notNull(),
            'nome' => $this->string(150)->notNull(),
            'descricao' => $this->text(),
            'ano' => $this->integer(),
        ], $t);
        $this->addForeignKey('fk_obra_museu', 'obra', 'id_museu', 'museu', 'id_museu', 'CASCADE');

        $this->createTable('localizacao', [
            'id_localizacao' => $this->primaryKey(),
            'id_museu' => $this->integer()->notNull(),
            'latitude' => $this->decimal(10, 7),
            'longitude' => $this->decimal(10, 7),
        ], $t);
        $this->addForeignKey('fk_localizacao_museu', 'localizacao', 'id_museu', 'museu', 'id_museu', 'CASCADE');

        $this->createTable('lembranca', [
            'id_lembranca' => $this->primaryKey(),
            'id_museu' => $this->integer()->notNull(),
            'nome' => $this->string(150)->notNull(),
            'descricao' => $this->text(),
            'preco' => $this->decimal(10, 2),
            'stock' => $this->integer()->defaultValue(0),
        ], $t);
        $this->addForeignKey('fk_lembranca_museu', 'lembranca', 'id_museu', 'museu', 'id_museu', 'CASCADE');

        $this->createTable('lotacao_hora', [
            'id_lotacao' => $this->primaryKey(),
            'id_museu' => $this->integer()->notNull(),
            'data' => $this->date()->notNull(),
            'hora' => $this->time()->notNull(),
            'lotacao_maxima' => $this->integer()->notNull(),
            'lugares_ocupados' => $this->integer()->defaultValue(0),
        ], $t);
        $this->addForeignKey('fk_lotacao_museu', 'lotacao_hora', 'id_museu', 'museu', 'id_museu', 'CASCADE');

        // ---------- Colaboradores ----------
        $this->createTable('colaborador', [
            'id_colaborador' => $this->primaryKey(),
            'id_museu' => $this->integer(),
            'nome' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull(),
            'password' => $this->string(255)->notNull(),
            'role' => $this->string(30),
        ], $t);
        $this->addForeignKey('fk_colaborador_museu', 'colaborador', 'id_museu', 'museu', 'id_museu', 'SET NULL');

        $this->createTable('turno', [
            'id_turno' => $this->primaryKey(),
            'id_colaborador' => $this->integer()->notNull(),
            'data' => $this->date()->notNull(),
            'hora_inicio' => $this->time(),
            'hora_fim' => $this->time(),
        ], $t);
        $this->addForeignKey('fk_turno_colaborador', 'turno', 'id_colaborador', 'colaborador', 'id_colaborador', 'CASCADE');

        $this->createTable('verificacao_diaria', [
            'id_verificacao' => $this->primaryKey(),
            'id_colaborador' => $this->integer()->notNull(),
            'id_museu' => $this->integer()->notNull(),
            'data' => $this->date()->notNull(),
            'descricao' => $this->text(),
            'estado' => $this->string(30),
        ], $t);
        $this->addForeignKey('fk_verificacao_colaborador', 'verificacao_diaria', 'id_colaborador', 'colaborador', 'id_colaborador', 'CASCADE');
        $this->addForeignKey('fk_verificacao_museu', 'verificacao_diaria', 'id_museu', 'museu', 'id_museu', 'CASCADE');

        // ---------- Bilhetes e visitas (ligados a user) ----------
        $this->createTable('bilhete', [
            'id_bilhete' => $this->primaryKey(),
            'id_utilizador' => $this->integer()->notNull(),
            'id_museu' => $this->integer()->notNull(),
            'id_desconto' => $this->integer(),
            'data_visita' => $this->date()->notNull(),
            'hora_visita' => $this->time(),
            'preco' => $this->decimal(10, 2),
            'estado' => $this->string(30),
        ], $t);
        $this->addForeignKey('fk_bilhete_user', 'bilhete', 'id_utilizador', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_bilhete_museu', 'bilhete', 'id_museu', 'museu', 'id_museu', 'CASCADE');
        $this->addForeignKey('fk_bilhete_desconto', 'bilhete', 'id_desconto', 'desconto', 'id_desconto', 'SET NULL');

        $this->createTable('visita', [
            'id_visita' => $this->primaryKey(),
            'id_utilizador' => $this->integer()->notNull(),
            'id_museu' => $this->integer()->notNull(),
            'id_bilhete' => $this->integer()->notNull(),
            'data_visita' => $this->date(),
        ], $t);
        $this->addForeignKey('fk_visita_user', 'visita', 'id_utilizador', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_visita_museu', 'visita', 'id_museu', 'museu', 'id_museu', 'CASCADE');
        $this->addForeignKey('fk_visita_bilhete', 'visita', 'id_bilhete', 'bilhete', 'id_bilhete', 'CASCADE');

        // ---------- Encomendas ----------
        $this->createTable('encomenda', [
            'id_encomenda' => $this->primaryKey(),
            'id_utilizador' => $this->integer()->notNull(),
            'data_encomenda' => $this->date(),
            'estado' => $this->string(30),
            'total' => $this->decimal(10, 2),
        ], $t);
        $this->addForeignKey('fk_encomenda_user', 'encomenda', 'id_utilizador', '{{%user}}', 'id', 'CASCADE');

        $this->createTable('encomenda_lembranca', [
            'id_encomenda' => $this->integer()->notNull(),
            'id_lembranca' => $this->integer()->notNull(),
            'quantidade' => $this->integer()->notNull()->defaultValue(1),
            'preco_unitario' => $this->decimal(10, 2),
        ], $t);
        $this->addPrimaryKey('pk_encomenda_lembranca', 'encomenda_lembranca', ['id_encomenda', 'id_lembranca']);
        $this->addForeignKey('fk_el_encomenda', 'encomenda_lembranca', 'id_encomenda', 'encomenda', 'id_encomenda', 'CASCADE');
        $this->addForeignKey('fk_el_lembranca', 'encomenda_lembranca', 'id_lembranca', 'lembranca', 'id_lembranca', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('encomenda_lembranca');
        $this->dropTable('encomenda');
        $this->dropTable('visita');
        $this->dropTable('bilhete');
        $this->dropTable('verificacao_diaria');
        $this->dropTable('turno');
        $this->dropTable('colaborador');
        $this->dropTable('lotacao_hora');
        $this->dropTable('lembranca');
        $this->dropTable('localizacao');
        $this->dropTable('obra');
        $this->dropTable('desconto');
        $this->dropTable('museu');
    }
}