<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var \frontend\models\SignupForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Criar conta — InforMuseus';
$this->params['fullWidth'] = true;
$minLength = Yii::$app->params['user.passwordMinLength'] ?? 8;
?>
<section class="im-auth">
    <div class="im-container">
        <div class="im-auth-card">
            <aside class="im-auth-brand">
                <a class="im-brand" href="<?= Url::home() ?>">Infor<span>Museus</span></a>
                <div>
                    <h1>Crie a sua<br>conta.</h1>
                    <p>Junte-se ao InforMuseus e comece a explorar o património cultural de forma simples e organizada.</p>
                    <ul class="im-auth-points">
                        <li>Registo gratuito e rápido</li>
                        <li>Bilhetes sempre à mão</li>
                        <li>Recompensas e descontos nas visitas</li>
                    </ul>
                </div>
            </aside>

            <div class="im-auth-form">
                <p class="im-auth-kicker">NOVO UTILIZADOR</p>
                <h2>Criar conta</h2>
                <p class="im-auth-sub">Preencha os campos abaixo para se registar.</p>

                <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                    'options' => ['class' => 'im-form', 'novalidate' => true],
                    'errorCssClass' => 'im-has-error',
                    'successCssClass' => '',
                    'fieldConfig' => [
                        'options' => ['class' => 'im-field'],
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                        'labelOptions' => ['class' => 'im-label'],
                        'inputOptions' => ['class' => 'im-input'],
                        'errorOptions' => ['tag' => 'div', 'class' => 'im-error'],
                        'hintOptions' => ['tag' => 'div', 'class' => 'im-hint'],
                    ],
                ]); ?>

                <?= $form->field($model, 'nome')->textInput([
                    'autofocus' => true,
                    'autocomplete' => 'name',
                    'placeholder' => 'O seu nome completo',
                ])->label('Nome') ?>

                <?= $form->field($model, 'email')->textInput([
                    'type' => 'email',
                    'autocomplete' => 'email',
                    'placeholder' => 'nome@exemplo.pt',
                ])->label('Email') ?>

                <?= $form->field($model, 'telefone')->textInput([
                    'type' => 'tel',
                    'autocomplete' => 'tel',
                    'placeholder' => '912 345 678',
                ])->label('Nº de telefone') ?>

                <?= $form->field($model, 'password')->passwordInput([
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Crie uma password',
                ])->label('Password')->hint('Mínimo de ' . (int) $minLength . ' caracteres, com letras e números.') ?>

                <?= Html::submitButton('CRIAR CONTA <span aria-hidden="true">→</span>', [
                    'class' => 'im-button im-button-gold im-submit',
                    'name' => 'signup-button',
                ]) ?>

                <?php ActiveForm::end(); ?>

                <div class="im-auth-links im-auth-switch">
                    Já tem conta? <?= Html::a('Iniciar sessão', ['/site/login']) ?>
                </div>
            </div>
        </div>
    </div>
</section>
