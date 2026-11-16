<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class PerfilUtilizador extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%perfil_utilizador}}';
    }

    public function rules(): array
    {
        return [
            [['id_user', 'nome', 'tipo'], 'required'],
            ['id_user', 'integer'],
            ['id_user', 'unique'],
            ['nome', 'string', 'max' => 150],
            ['tipo', 'string', 'max' => 50],
            ['id_user', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID Perfil',
            'id_user' => 'ID Utilizador',
            'nome' => 'Nome Completo',
            'tipo' => 'Tipo de Utilizador',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
