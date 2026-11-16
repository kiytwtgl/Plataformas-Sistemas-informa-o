<?php

declare(strict_types=1);

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login do visitante com Email + Password (US35).
 */
class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public bool $rememberMe = true;

    private ?User $_user = null;
    private bool $_userLoaded = false;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required', 'message' => 'Preencha este campo.'],
            ['email', 'trim'],
            ['email', 'email', 'message' => 'Introduza um email válido.'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
            'rememberMe' => 'Manter sessão iniciada',
        ];
    }

    /**
     * Credenciais inválidas -> mensagem de erro (não revela qual dos campos falhou).
     */
    public function validatePassword(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if ($user === null || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Email ou password incorretos.');
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    protected function getUser(): ?User
    {
        if (!$this->_userLoaded) {
            $this->_user = User::findOne([
                'email' => strtolower(trim($this->email)),
                'status' => User::STATUS_ACTIVE,
            ]);
            $this->_userLoaded = true;
        }

        return $this->_user;
    }
}
