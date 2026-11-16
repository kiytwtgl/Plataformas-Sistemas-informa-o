<?php

declare(strict_types=1);

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Registo de visitante: Nome, Email, Nº de telefone e Password.
 * A conta fica ativa e o utilizador é autenticado logo a seguir (ver SiteController::actionSignup).
 */
class SignupForm extends Model
{
    public string $nome = '';
    public string $email = '';
    public string $telefone = '';
    public string $password = '';

    public function rules(): array
    {
        $min = (int) (Yii::$app->params['user.passwordMinLength'] ?? 8);

        return [
            [['nome', 'email', 'telefone', 'password'], 'required', 'message' => 'Preencha este campo.'],

            ['nome', 'trim'],
            ['nome', 'string', 'min' => 2, 'max' => 100, 'tooShort' => 'O nome deve ter pelo menos {min} caracteres.', 'tooLong' => 'O nome é demasiado longo.'],

            ['email', 'trim'],
            ['email', 'filter', 'filter' => 'strtolower'],
            ['email', 'email', 'message' => 'Introduza um email válido.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Este email já está registado.'],

            ['telefone', 'trim'],
            ['telefone', 'match', 'pattern' => '/^\+?[0-9 ]{9,15}$/', 'message' => 'Introduza um número de telefone válido.'],

            ['password', 'string', 'min' => $min, 'tooShort' => 'A password deve ter pelo menos {min} caracteres.'],
            ['password', 'match', 'pattern' => '/^(?=.*[A-Za-z])(?=.*\d).+$/', 'message' => 'A password deve incluir letras e números.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'nome' => 'Nome',
            'email' => 'Email',
            'telefone' => 'Nº de telefone',
            'password' => 'Password',
        ];
    }

    /**
     * Cria o utilizador (ativo) e devolve-o, ou null se a validação/gravação falhar.
     */
    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->email; // o username interno é o email (único)
        $user->nome = $this->nome;
        $user->email = $this->email;
        $user->telefone = preg_replace('/\s+/', '', $this->telefone);
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
