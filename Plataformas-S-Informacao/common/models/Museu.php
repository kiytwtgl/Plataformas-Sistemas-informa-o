<?php

namespace common\models;

use yii\db\ActiveRecord;

class Museu extends ActiveRecord
{
    public static function tableName()
    {
        return 'museu';
    }

    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['horario_abertura', 'horario_fecho'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 50],
            [['morada'], 'string', 'max' => 200],
            [['telefone'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 120],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_museu' => 'ID',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'descricao' => 'Descrição',
            'morada' => 'Morada',
            'preco' => 'Preço',
            'horario_abertura' => 'Horário de abertura',
            'horario_fecho' => 'Horário de fecho',
            'telefone' => 'Telefone',
            'email' => 'Email',
        ];
    }
}
